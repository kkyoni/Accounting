<?php
namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DataTables,Notify,Str,Storage;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Html\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Auth;
use App\Models\Country;
use Event;

class CountryController extends Controller{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * * * Create a new controller instance.
     * * *
     * * * @return void
     * * */
    public function __construct(){
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.country.';
        $this->middleware('auth');
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function Index Page
    ---------------------------------------------------------------------------------- */
    public function index(Builder $builder, Request $request){
        $country = Country::orderBy('id','desc');
        if (request()->ajax()) {
            return DataTables::of($country->get())
            ->addIndexColumn()
            ->editColumn('action', function (Country $country) {
                $action  = '';
                $action .= '<a class="btn btn-warning btn-circle btn-sm" href='.route('admin.country.edit',[$country->id]).'><i class="fa fa-pencil" data-toggle="tooltip" title="Edit"></i></a>';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'NO','width'=>'5%',"orderable" => false, "searchable" => false],
            ['data' => 'country_name', 'name' => 'country_name', 'title' => 'COUNTRY NAME','width'=>'10%'],
            ['data' => 'action', 'name' => 'action', 'title' => 'ACTION','width'=>'10%',"orderable" => false, "searchable" => false],
        ])
        ->parameters([ 'order' =>[] ]);
        return view($this->pageLayout.'index',compact('html'));
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Create Country
    ---------------------------------------------------------------------------------- */
    public function create(){
        return view($this->pageLayout.'create');
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Store Country
    ---------------------------------------------------------------------------------- */
    public function store(Request $request){
        $validatedData = Validator::make($request->all(),[
            'country_name' => 'required|unique:country,country_name',
        ]);
        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try{
            Country::create([
                'country_name'             => @$request->get('country_name'),
            ]);
            Notify::success('Country Created Successfully..!');
            return redirect()->route('admin.country.index');
        }catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Edit Country
    ---------------------------------------------------------------------------------- */
    public function edit($id){
        $country = Country::where('id',$id)->first();
        if(!empty($country)){
            return view($this->pageLayout.'edit',compact('country'));
        }else{
            return redirect()->route('admin.country.index');
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Update Country
    ---------------------------------------------------------------------------------- */
    public function update(Request $request,$id){
        $validatedData = $request->validate([
            'country_name'      => 'required|min:1|max:60|unique:country,country_name,'.$id
        ]);
        try{
            Country::where('id',$id)->update([
                'country_name'              => @$request->get('country_name')
            ]);
            Notify::success('Country Updated Successfully..!');
            return redirect()->route('admin.country.index');
        } catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }
}
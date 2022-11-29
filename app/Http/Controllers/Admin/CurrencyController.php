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
use App\Models\Currency;
use Event;

class CurrencyController extends Controller{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * * * Create a new controller instance.
     * * *
     * * * @return void
     * * */
    public function __construct(){
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.currency.';
        $this->middleware('auth');
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function Index Page
    ---------------------------------------------------------------------------------- */
    public function index(Builder $builder, Request $request){
        $currency = Currency::orderBy('id','desc');
        if (request()->ajax()) {
            return DataTables::of($currency->get())
            ->addIndexColumn()
            ->editColumn('action', function (Currency $currency) {
                $action  = '';
                $action .= '<a class="btn btn-warning btn-circle btn-sm" href='.route('admin.currency.edit',[$currency->id]).'><i class="fa fa-pencil" data-toggle="tooltip" title="Edit"></i></a>';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'NO','width'=>'5%',"orderable" => false, "searchable" => false],
            ['data' => 'currency', 'name' => 'currency', 'title' => 'CURRENCY','width'=>'10%'],
            ['data' => 'action', 'name' => 'action', 'title' => 'ACTION','width'=>'10%',"orderable" => false, "searchable" => false],
        ])
        ->parameters([ 'order' =>[] ]);
        return view($this->pageLayout.'index',compact('html'));
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Create Currency
    ---------------------------------------------------------------------------------- */
    public function create(){
        return view($this->pageLayout.'create');
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Store Currency
    ---------------------------------------------------------------------------------- */
    public function store(Request $request){
        $validatedData = Validator::make($request->all(),[
            'currency' => 'required|unique:currency,currency',
        ]);
        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try{
            Currency::create([
                'currency'             => @$request->get('currency'),
            ]);
            Notify::success('Currency Created Successfully..!');
            return redirect()->route('admin.currency.index');
        }catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Edit Currency
    ---------------------------------------------------------------------------------- */
    public function edit($id){
        $currency = Currency::where('id',$id)->first();
        if(!empty($currency)){
            return view($this->pageLayout.'edit',compact('currency'));
        }else{
            return redirect()->route('admin.currency.index');
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Update Currency
    ---------------------------------------------------------------------------------- */
    public function update(Request $request,$id){
        $validatedData = $request->validate([
            'currency'      => 'required|min:1|max:60|unique:currency,currency,'.$id
        ]);
        try{
            Currency::where('id',$id)->update([
                'currency'              => @$request->get('currency')
            ]);
            Notify::success('Currency Updated Successfully..!');
            return redirect()->route('admin.currency.index');
        } catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }
}
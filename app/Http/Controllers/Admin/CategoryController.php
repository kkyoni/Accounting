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
use App\Models\Category;
use Event;

class CategoryController extends Controller{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * * * * Create a new controller instance.
     * * * *
     * * * @return void
     * * */
    public function __construct(){
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.category.';
        $this->middleware('auth');
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function Index Page
    ---------------------------------------------------------------------------------- */
    public function index(Builder $builder, Request $request){
        $category = Category::orderBy('id','desc');
        if (request()->ajax()) {
            return DataTables::of($category->get())
            ->addIndexColumn()
            ->editColumn('action', function (Category $category) {
                $action  = '';
                $action .= '<a class="btn btn-warning btn-circle btn-sm" href='.route('admin.category.edit',[$category->id]).'><i class="fa fa-pencil" data-toggle="tooltip" title="Edit"></i></a>';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'NO','width'=>'5%',"orderable" => false, "searchable" => false],
            ['data' => 'category_name', 'name' => 'category_name', 'title' => 'CATEGORY NAME','width'=>'10%'],
            ['data' => 'action', 'name' => 'action', 'title' => 'ACTION','width'=>'10%',"orderable" => false, "searchable" => false],
        ])
        ->parameters([ 'order' =>[] ]);
        return view($this->pageLayout.'index',compact('html'));
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Create Category
    ---------------------------------------------------------------------------------- */
    public function create(){
        return view($this->pageLayout.'create');
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Store Category
    ---------------------------------------------------------------------------------- */
    public function store(Request $request){
        $validatedData = Validator::make($request->all(),[
            'category_name' => 'required|unique:category,category_name',
        ]);
        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try{
            Category::create(['category_name' => @$request->get('category_name'),]);
            Notify::success('Category Created Successfully..!');
            return redirect()->route('admin.category.index');
        }catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }

    /* ----------------------------------------------------------------------------------@Description: Function for Edit Category
    ---------------------------------------------------------------------------------- */
    public function edit($id){
        $category = Category::where('id',$id)->first();
        if(!empty($category)){
            return view($this->pageLayout.'edit',compact('category'));
        }else{
            return redirect()->route('admin.category.index');
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Update Category
    ---------------------------------------------------------------------------------- */
    public function update(Request $request,$id){
        $validatedData = $request->validate([
            'category_name'      => 'required|min:1|max:60|unique:category,category_name,'.$id
        ]);
        try{
            Category::where('id',$id)->update(['category_name' => @$request->get('category_name')]);
            Notify::success('Category Updated Successfully..!');
            return redirect()->route('admin.category.index');
        } catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }
}
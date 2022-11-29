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
use App\Models\SubCategory;
use Event;

class SubCategoryController extends Controller{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * * * Create a new controller instance.
     * * *
     * * * @return void
     * * */
    public function __construct(){
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.subcategory.';
        $this->middleware('auth');
    }
    /* ----------------------------------------------------------------------------------
    @Description: Function Index Page
    ---------------------------------------------------------------------------------- */
    public function index(Builder $builder, Request $request){
        $sub_category = SubCategory::orderBy('id','desc');
        if (request()->ajax()) {
            return DataTables::of($sub_category->get())
            ->addIndexColumn()
            ->editColumn('category_id', function (SubCategory $sub_category) {
                return $sub_category->category_list->category_name;
            })
            ->editColumn('action', function (SubCategory $sub_category) {
                $action  = '';
                $action .= '<a class="btn btn-warning btn-circle btn-sm" href='.route('admin.subcategory.edit',[$sub_category->id]).'><i class="fa fa-pencil" data-toggle="tooltip" title="Edit"></i></a>';
                return $action;
            })
            ->rawColumns(['action','category_id'])
            ->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'NO','width'=>'5%',"orderable" => false, "searchable" => false],
            ['data' => 'category_id', 'name' => 'category_id', 'title' => 'CATEGORY NAME','width'=>'10%'],
            ['data' => 'sub_category_name', 'name' => 'sub_category_name', 'title' => 'SUB CATEGORY NAME','width'=>'10%'],
            ['data' => 'action', 'name' => 'action', 'title' => 'ACTION','width'=>'10%',"orderable" => false, "searchable" => false],
        ])
        ->parameters(['order' =>[] ]);
        return view($this->pageLayout.'index',compact('html'));
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Create Sub Category
    ---------------------------------------------------------------------------------- */
    public function create(){
        $category = Category::pluck('category_name','id');
        return view($this->pageLayout.'create',compact('category'));
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Store Sub Category
    ---------------------------------------------------------------------------------- */
    public function store(Request $request){
        $customMessages = [
            'category_id.required' => 'Category Name is Required',
            'sub_category_name.required' => 'Sub Category Name is Required',
        ];
        $validatedData = Validator::make($request->all(),[
            'category_id'   => 'required',
            'sub_category_name'   => 'required',
        ],$customMessages);
        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try{
            SubCategory::create(['sub_category_name' => @$request->get('sub_category_name'), 'category_id'  => @$request->get('category_id'),]);
            Notify::success('Sub Category Created Successfully..!');
            return redirect()->route('admin.subcategory.index');
        }catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Edit Sub Category
    ---------------------------------------------------------------------------------- */
    public function edit($id){
        $subcategory = SubCategory::where('id',$id)->first();
        $category = Category::pluck('category_name','id');
        if(!empty($subcategory)){
            return view($this->pageLayout.'edit',compact('subcategory','category'));
        }else{
            return redirect()->route('admin.subcategory.index');
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Update Sub Category
    ---------------------------------------------------------------------------------- */
    public function update(Request $request,$id){
        $customMessages = [
            'category_id.required' => 'Category Name is Required',
            'sub_category_name.required' => 'Sub Category Name is Required',
        ];
        $validatedData = Validator::make($request->all(),[
            'category_id' => 'required',
            'sub_category_name' => 'required',
        ],$customMessages);
        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try{
            SubCategory::where('id',$id)->update([
                'sub_category_name' => @$request->get('sub_category_name'),
                'category_id'  => @$request->get('category_id')
            ]);
            Notify::success('Sub Category Updated Successfully..!');
            return redirect()->route('admin.subcategory.index');
        } catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }
}
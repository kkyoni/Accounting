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
use Event;
use App\Models\Setting;
use DB;
use Log;

class SettingsController extends Controller{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.setting.';
        $this->middleware('auth');
    }

    /* ------------------------------------------------------------------------------------
    @Description: Function Index Page
    ------------------------------------------------------------------------------------ */
    public function index(Builder $builder, Request $request){
        $setting = Setting::orderBy('id','desc');
        if (request()->ajax()) {
            return DataTables::of($setting->get())
            ->addIndexColumn()
            ->editColumn('hidden', function (Setting $setting) {
                    if($setting->hidden == "0"){
                        return '<span class="label label-success">Active</span>';
                    } else{
                        return '<span class="label label-danger">Block</span>';
                    }
                })
           ->editColumn('action', function (Setting $setting) {
                $action  = '';
                
                $action .= '<a class="btn btn-warning btn-circle btn-sm" href='.route('admin.setting.edit',[$setting->id]).'><i class="fa fa-pencil" data-toggle="tooltip" title="Edit"></i></a>';

                if($setting->hidden == "0"){
                        $action .= '<a href="javascript:void(0)" data-value="1" data-toggle="tooltip" title="Active" class="btn btn-sm btn-dark  m-l-10 btn-circle changeStatusRecord ml-1 mr-1" data-id="'.$setting->id.'" href="javascript:void(0)"><i class="fa fa-unlock"></i></a>';
                    }else{
                        $action .= '<a href="javascript:void(0)" data-value="0"  data-toggle="tooltip" title="Block" class="btn btn-sm btn-dark m-l-10 btn-circle changeStatusRecord ml-1 mr-1" data-id="'.$setting->id.'" href="javascript:void(0)"><i class="fa fa-lock"></i></a>';
                    }
                return $action;
            })
            
            ->rawColumns(['action','hidden'])
            ->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'Sr no','width'=>'3%',"orderable" => false, "searchable" => false],
            ['data' => 'code', 'name' => 'code', 'title' => 'code','width'=>'3%'],
            ['data' => 'type', 'name' => 'type', 'title' => 'Type','width'=>'3%'],
            ['data' => 'label', 'name' => 'label', 'title' => 'label','width'=>'3%'],
            ['data' => 'value', 'name' => 'value', 'title' => 'value','width'=>'3%'],
            ['data' => 'hidden', 'name' => 'hidden', 'title' => 'Status','width'=>'3%'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action','width'=>'15%',"orderable" => false, "searchable" => false],
            ])
        ->parameters([ 'order' =>[] ]);
        return view($this->pageLayout.'index',compact('html'));
    }


    /* ------------------------------------------------------------------------------------
    @Description: Function for Edit Setting
    ----------------------------------------------------------------------------------- */
    public function edit($id){
        $setting = Setting::where('id',$id)->first();
        if(!empty($setting)){
            return view($this->pageLayout.'edit',compact('setting','id'));
        }else{
            return redirect()->route('admin.setting.index');
        }
    }


    /* ------------------------------------------------------------------------------------
    @Description: Function for Update Setting
    ------------------------------------------------------------------------------------ */
    public function update(Request $request,$id){
        $customMessages = [
            'hidden.required' => 'Hidden is Required',
        ];
        $validatedData = Validator::make($request->all(),[
            'hidden'        => 'required',
        ],$customMessages);
        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try{
            $oldDetails = Setting::find($id);
            if(!empty($request->check)){
                if($request->hasFile('value')){
                    $file = $request->file('value');
                    $extension = $file->getClientOriginalExtension();
                    $filename = Str::random(10).'.'.$extension;
                    \Storage::disk('public')->putFileAs('setting', $file,$filename);
                }else{
                    if($oldDetails->value !== null){
                        $filename = $oldDetails->value;
                    }else{
                        $filename = 'default.png';
                    }
                }
            } else {
                $filename = $request->value;
            }
            Setting::where('id',$id)->update([
                'hidden'         => @$request->get('hidden'),
                'value'               => @$filename
            ]);
            Notify::success('Setting Updated Successfully..!');
            return redirect()->route('admin.setting.index');
        } catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }

    /* ------------------------------------------------------------------------------------
    @Description: Function for Change Setting Status
    ------------------------------------------------------------------------------------ */
    public function change_status(Request $request){
        try{
            $setting = Setting::where('id',$request->id)->first();
            if($setting === null){
                return redirect()->back()->with([
                    'status'    => 'warning',
                    'title'     => 'Warning!!',
                    'message'   => 'Setting not found !!'
                ]);
            }else{
                if($setting->hidden == "0"){
                    Setting::where('id',$request->id)->update([
                        'hidden' => "1",
                    ]);
                }
                if($setting->hidden == "1"){
                    Setting::where('id',$request->id)->update([
                        'hidden'=> "0",
                    ]);
                }
            }
            Notify::success('Setting status Updated Successfully..!');
            return response()->json([
                'status'    => 'success',
                'title'     => 'Success!!',
                'message'   => 'Setting Status Updated Successfully..!'
            ]);
        }catch (Exception $e){
            return response()->json([
                'status'    => 'error',
                'title'     => 'Error!!',
                'message'   => $e->getMessage()
            ]);
        }
    }
}
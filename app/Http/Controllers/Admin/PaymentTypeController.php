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
use App\Models\PaymentType;
use Event;

class PaymentTypeController extends Controller{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * * * * * Create a new controller instance.
     * * * * *
     * * * * @return void
     * * * */
    public function __construct(){
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.paymenttype.';
        $this->middleware('auth');
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function Index Page
    ---------------------------------------------------------------------------------- */
    public function index(Builder $builder, Request $request){
        $paymenttype = PaymentType::orderBy('id','desc');
        if (request()->ajax()) {
            return DataTables::of($paymenttype->get())
            ->addIndexColumn()
            ->editColumn('action', function (PaymentType $paymenttype) {
                $action  = '';
                $action .= '<a class="btn btn-warning btn-circle btn-sm" href='.route('admin.paymenttype.edit',[$paymenttype->id]).'><i class="fa fa-pencil" data-toggle="tooltip" title="Edit"></i></a>';
                return $action;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'NO','width'=>'5%',"orderable" => false, "searchable" => false],
            ['data' => 'payment_name', 'name' => 'payment_name', 'title' => 'PAYMENT NAME','width'=>'10%'],
            ['data' => 'action', 'name' => 'action', 'title' => 'ACTION','width'=>'10%',"orderable" => false, "searchable" => false],
        ])
        ->parameters([ 'order' =>[] ]);
        return view($this->pageLayout.'index',compact('html'));
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Create Payment Type
    ---------------------------------------------------------------------------------- */
    public function create(){
        return view($this->pageLayout.'create');
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Store Payment Type
    ---------------------------------------------------------------------------------- */
    public function store(Request $request){
        $validatedData = Validator::make($request->all(),[
            'payment_name' => 'required|unique:payment,payment_name',
        ]);
        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try{
            PaymentType::create(['payment_name' => @$request->get('payment_name'),]);
            Notify::success('Payment Type Created Successfully..!');
            return redirect()->route('admin.paymenttype.index');
        }catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Edit Payment Type
    ---------------------------------------------------------------------------------- */
    public function edit($id){
        $paymenttype = PaymentType::where('id',$id)->first();
        if(!empty($paymenttype)){
            return view($this->pageLayout.'edit',compact('paymenttype'));
        }else{
            return redirect()->route('admin.paymenttype.index');
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Update Payment Type
    ---------------------------------------------------------------------------------- */
    public function update(Request $request,$id){
        $validatedData = $request->validate([
            'payment_name'      => 'required|min:1|max:60|unique:payment,payment_name,'.$id
        ]);
        try{
            PaymentType::where('id',$id)->update(['payment_name' => @$request->get('payment_name')]);
            Notify::success('Payment Type Updated Successfully..!');
            return redirect()->route('admin.paymenttype.index');
        } catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }
}
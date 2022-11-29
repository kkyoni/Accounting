<?php
namespace App\Http\Controllers\Admin;
use Carbon\Carbon;
use App\DataTables\TrancationDatatable;
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
use App\Models\Transaction;
use App\Models\Currency;
use App\Models\Country;
use App\Models\User;
use Event;
use DB;
use Log;

class ReportController extends Controller{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * * * Create a new controller instance.
     * * *
     * * * @return void
     * * */
    public function __construct(){
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.report.';
        $this->middleware('auth');
    }

    /*-----------------------------------------------------------------------------------
    @Description: Function Index Page
    ---------------------------------------------------------------------------------- */
    public function index(Builder $builder, Request $request){
        $country_list = Country::pluck('country_name','id');
        $transaction = Transaction::orderBy('id','desc');
        if (isset($request->date) || ($request->remitter_name) || ($request->bank_account) || ($request->amount) || ($request->beneficairy_name) || ($request->country_id) || ($request->client)){
            $date = $request->date;
            $remitter_name = $request->remitter_name;
            $bank_account = $request->bank_account;
            $amount = $request->amount;
            $beneficairy_name = $request->beneficairy_name;
            $country_id = $request->country_id;
            $client = $request->client;
            $transaction->orWhere('date',$date)->orWhere('remitter_name',$remitter_name)->orWhere('bank_account',$bank_account)->orWhere('amount',$amount)->orWhere('beneficairy_name',$beneficairy_name)->orWhere('country_id',$country_id)->orWhere('client',$client);
        }
        if (request()->ajax()) {
            return DataTables::of($transaction->get())
            ->addIndexColumn()
            ->editColumn('date', function (Transaction $transaction) {
                if(!empty($transaction->date)){
                    return date("d M Y", strtotime($transaction->date));
                } else {
                    return "N/A";
                }
            })

            ->editColumn('status', function (Transaction $transaction) {
                if(!empty($transaction->status)){
                    return $transaction->status; 
                    // if($transaction->status == "received" || $transaction->status == "RECEIVED"){
                    //     return '<span class="label label-primary">RECEIVED</span>';
                    // } elseif($transaction->status == "retrun_fund" || $transaction->status == "RETRUNFUND") {
                    //     return '<span class="label label-default">RETURN FUND</span>';
                    // } elseif($transaction->status == "cancle" || "CANCEL") {
                    //     return '<span class="label label-danger">CANCEL</span>';
                    // } elseif($transaction->status == "expecting" || "EXPECTING") {
                    //     return '<span class="label label-info">EXPECTING</span>';
                    // } elseif($transaction->status == "paid" || "PAID") {
                    //     return '<span class="label label-success">PAID</span>';
                    // } elseif($transaction->status == "hold" || "HOLD" || "ON HOLD") {
                    //     return '<span class="label label-warning">HOLD</span>';
                    // }else {
                    //     return "N/A";
                    // }
                } else {
                    return "N/A";
                }
            })

            ->editColumn('currency_id', function (Transaction $transaction) {
                if(!empty($transaction->currency_list->currency)){
                    return $transaction->currency_list->currency;
                } else {
                    return "N/A";
                }
            })

            ->editColumn('amount', function (Transaction $transaction) {
                if(!empty($transaction->amount)){
                    return $transaction->amount;
                } else {
                    return "N/A";
                }
            })

            ->editColumn('client', function (Transaction $transaction) {
                if(!empty($transaction->client)){
                    return $transaction->client;
                } else {
                    return "N/A";
                }
            })

            ->editColumn('remitter_name', function (Transaction $transaction) {
                if(!empty($transaction->remitter_name)){
                    return $transaction->remitter_name;
                } else {
                    return "N/A";
                }
            })

            ->editColumn('beneficairy_name', function (Transaction $transaction) {
                if(!empty($transaction->beneficairy_name)){
                    return $transaction->beneficairy_name;
                } else {
                    return "N/A";
                }
            })

            ->editColumn('bank_name', function (Transaction $transaction) {
                if(!empty($transaction->bank_name)){
                    return $transaction->bank_name;
                } else {
                    return "N/A";
                }
            })

            ->editColumn('country_id', function (Transaction $transaction) {
                if(!empty($transaction->country_list->country_name)){
                    return $transaction->country_list->country_name;
                } else {
                    return "N/A";
                }
            })

            ->editColumn('category_id', function (Transaction $transaction) {
                if(!empty($transaction->category_list->category_name)){
                    return $transaction->category_list->category_name;
                } else {
                    return "N/A";
                }
            })

            ->editColumn('sub_category_id', function (Transaction $transaction) {
                if(!empty($transaction->subcategory_list->sub_category_name)){
                    return $transaction->subcategory_list->sub_category_name;
                } else {
                    return "N/A";
                }
            })

            ->editColumn('invoice_number', function (Transaction $transaction) {
                if(!empty($transaction->invoice_number)){
                    return $transaction->invoice_number;
                } else {
                    return "N/A";
                }
            })

            ->editColumn('invoice_status', function (Transaction $transaction) {
                if(!empty($transaction->invoice_status)){
                    if($transaction->invoice_status == "yes" || $transaction->invoice_status == "YES"){
                        return '<span class="label label-success">YES</span>';
                    } elseif($transaction->invoice_status == "no" || $transaction->invoice_status == "NO"){
                        return '<span class="label label-danger">NO</span>';
                    } else {
                        return "N/A";
                    } 
                } else {
                    return "N/A";
                }
            })

            ->editColumn('remarks', function (Transaction $transaction) {
                if(!empty($transaction->remarks)){
                    return $transaction->remarks;
                } else {
                    return "N/A";
                }
            })

            ->rawColumns(['date','status','currency_id','amount','client','remitter_name','beneficairy_name','bank_name','country_id','category_id','sub_category_id','invoice_number','invoice_status','remarks'])
            ->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'NO','width'=>'5%',"orderable" => false, "searchable" => false],
            ['data' => 'date', 'name' => 'date', 'title' => 'DATE','width'=>'5%'],
            ['data' => 'status', 'name' => 'status', 'title' => 'STATUS','width'=>'5%'],
            ['data' => 'currency_id', 'name' => 'currency_id', 'title' => 'CURRENCY','width'=>'5%'],
            ['data' => 'amount', 'name' => 'amount', 'title' => 'AMOUNT','width'=>'5%'],
            ['data' => 'client', 'name' => 'client', 'title' => 'CLIENT','width'=>'5%'],
            ['data' => 'remitter_name', 'name' => 'remitter_name', 'title' => 'REMITTER NAME','width'=>'5%'],
            ['data' => 'beneficairy_name', 'name' => 'beneficairy_name', 'title' => 'BENEFICAIRY NAME','width'=>'5%'],
            ['data' => 'bank_name', 'name' => 'bank_name', 'title' => 'BANK NAME','width'=>'5%'],
            ['data' => 'country_id', 'name' => 'country_id', 'title' => 'COUNTRY','width'=>'5%'],
            ['data' => 'category_id', 'name' => 'category_id', 'title' => 'MAIN CATEGORY','width'=>'5%'],
            ['data' => 'sub_category_id', 'name' => 'sub_category_id', 'title' => 'SUB CATEGORY','width'=>'5%'],
            ['data' => 'invoice_number', 'name' => 'invoice_number', 'title' => 'INVOICE NUMBER','width'=>'5%'],
            ['data' => 'invoice_status', 'name' => 'invoice_status', 'title' => 'INVOICE STATUS','width'=>'5%'],
            ['data' => 'remarks', 'name' => 'remarks', 'title' => 'REMARKS','width'=>'5%'],
        ])
        ->ajax([
            'url' => route('admin.report.filter_by_button'),
            'type' => 'POST',
            'data' => 'function(d) { 
                d._token = "'.csrf_token().'";
                d.date = $("#date").val();
                d.remitter_name = $("#remitter_name").val();
                d.bank_account = $("#bank_account").val();
                d.amount = $("#amount").val();
                d.beneficairy_name = $("#beneficairy_name").val();
                d.country_id = $("#country_id").val();
                d.client = $("#client").val();
            }',
        ])
        ->parameters([ 'order' =>[] ]);
        return view($this->pageLayout.'index',compact('html','country_list'));
    }
}
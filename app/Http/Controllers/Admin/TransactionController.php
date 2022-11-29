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
use App\Models\Transaction;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Companies;
use App\Models\Clients;
use App\Models\Bank;
use Event;
use DB;

class TransactionController extends Controller{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * * * Create a new controller instance.
     * * *
     * * * @return void
     * * */
    public function __construct(){
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.transaction.';
        $this->middleware('auth');
    }
    /* ----------------------------------------------------------------------------------
    @Description: Function Index Page
    ---------------------------------------------------------------------------------- */
    public function index(Builder $builder, Request $request){
        $country_list = Country::pluck('country_name','id');
        $select_raw = "cu.`currency`, SUM(COALESCE(CASE WHEN transaction.`type` = 'outward' THEN transaction.amount END,0)) total_outword , SUM(COALESCE(CASE WHEN transaction.`type`= 'inward' THEN transaction.amount END,0)) total_inword , SUM(COALESCE(CASE WHEN transaction.`type`= 'inward' THEN transaction.amount END,0)) - SUM(COALESCE(CASE WHEN transaction.`type`= 'outward' THEN transaction.amount END,0)) as balance";
        $transaction_balance = Transaction::selectRaw($select_raw)->from('transaction', 'transaction')->leftJoin('currency as cu','cu.id','=','transaction.currency_id')->groupBy('transaction.currency_id')->get();
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
                if($transaction->type == "inward"){
                    if($transaction->status==='RECEIVED') {
                        return '<span class="label label-success">RECEIVED</span>';
                    }
                    if($transaction->status==='RETURN FUND') {
                        return '<span class="label label-success">RETURN FUND</span>';
                    }
                    $html = '<select class="form-control" id="changeStatus" data-id='.$transaction->id.'>';
                    if($transaction->status=='RECEIVED') {
                        $html .='<option value="RECEIVED" selected>RECEIVED</oprion>';
                    }else{
                        $html .='<option value="RECEIVED">RECEIVED</oprion>';
                    }
                    if($transaction->status=='RETURN FUND') {
                        $html .='<option value="RETURN FUND" selected>RETURN FUND</oprion>';
                    }else{
                        $html .='<option value="RETURN FUND">RETURN FUND</oprion>';
                    }
                    if($transaction->status=='CANCELLED') {
                        $html .='<option value="CANCELLED" selected>CANCELLED</oprion>';
                    }else{
                        $html .='<option value="CANCELLED">CANCELLED</oprion>';
                    }
                    if($transaction->status=='EXPECTED') {
                        $html .='<option value="EXPECTED" selected>EXPECTED</oprion>';
                    }else{
                        $html .='<option value="EXPECTED">EXPECTED</oprion>';
                    }
                    $html .= '</select>';
                    return $html;
                }elseif($transaction->type == "outward"){
                    if($transaction->status==='PAID') {
                        return '<span class="label label-success">PAID</span>';
                    }
                    $html = '<select class="form-control" id="changeStatus" data-id='.$transaction->id.'>';
                    if($transaction->status=='PAID') {
                        $html .='<option value="PAID" selected>PAID</oprion>';
                    }else{
                        $html .='<option value="PAID">PAID</oprion>';
                    }
                    if($transaction->status=='HOLD') {
                        $html .='<option value="HOLD" selected>HOLD</oprion>';
                    }else{
                        $html .='<option value="HOLD">HOLD</oprion>';
                    }
                    if($transaction->status=='CANCELLED') {
                        $html .='<option value="CANCELLED" selected>CANCELLED</oprion>';
                    }else{
                        $html .='<option value="CANCELLED">CANCELLED</oprion>';
                    }
                    $html .= '</select>';
                    return $html;

                }else{
                    return $transaction->status;
                }
                // if(!empty($transaction->status)){
                //     return $transaction->status; 
                // } else {
                //     return "N/A";
                // }
            })
            // ->editColumn('status', function (Transaction $transaction) {
            //     if(!empty($transaction->status)){
            //         return $transaction->status; 
            //         // if($transaction->status == "received" || $transaction->status == "RECEIVED"){
            //         //     return '<span class="label label-primary">RECEIVED</span>';
            //         // } elseif($transaction->status == "retrun_fund" || $transaction->status == "RETRUNFUND") {
            //         //     return '<span class="label label-default">RETURN FUND</span>';
            //         // } elseif($transaction->status == "cancle" || "CANCEL") {
            //         //     return '<span class="label label-danger">CANCEL</span>';
            //         // } elseif($transaction->status == "expecting" || "EXPECTING") {
            //         //     return '<span class="label label-info">EXPECTING</span>';
            //         // } elseif($transaction->status == "paid" || "PAID") {
            //         //     return '<span class="label label-success">PAID</span>';
            //         // } elseif($transaction->status == "hold" || "HOLD" || "ON HOLD") {
            //         //     return '<span class="label label-warning">HOLD</span>';
            //         // }else {
            //         //     return "N/A";
            //         // }
            //     } else {
            //         return "N/A";
            //     }
            // })

            // ->editColumn('status', function (Transaction $transaction) {
            //     if($transaction->status==='PAID') {
            //         return '<span class="label label-success">PAID</span>';
            //     }
            //     $html = '<select class="form-control" id="changeStatus" data-id='.$transaction->id.'>';

            //     if($transaction->status=='PAID') {
            //         $html .='<option value="PAID" selected>PAID</oprion>';
            //     }else{
            //         $html .='<option value="PAID">PAID</oprion>';
            //     }
            //     if($transaction->status=='HOLD') {
            //         $html .='<option value="HOLD" selected>HOLD</oprion>';
            //     }else{
            //         $html .='<option value="HOLD">HOLD</oprion>';
            //     }
            //     if($transaction->status=='CANCELLED') {
            //         $html .='<option value="CANCELLED" selected>CANCELLED</oprion>';
            //     }else{
            //         $html .='<option value="CANCELLED">CANCELLED</oprion>';
            //     }
            //     if($transaction->status=='RECEIVED') {
            //         $html .='<option value="RECEIVED" selected>RECEIVED</oprion>';
            //     }else{
            //         $html .='<option value="RECEIVED">RECEIVED</oprion>';
            //     }                
            //     if($transaction->status=='RETURN FUND') {
            //         $html .='<option value="RETURN FUND" selected>RETURN FUND</oprion>';
            //     }else{
            //         $html .='<option value="RETURN FUND">RETURN FUND</oprion>';
            //     }
            //     if($transaction->status=='EXPECTED') {
            //         $html .='<option value="EXPECTED" selected>EXPECTED</oprion>';
            //     }else{
            //         $html .='<option value="EXPECTED">EXPECTED</oprion>';
            //     }
            //     $html .= '</select>';
            //     return $html;
            // })


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

            ->editColumn('action', function (Transaction $transaction) {
                $action  = '';

                $action .='<a class="btn btn-danger btn-circle btn-sm deletetransaction" data-id ="'.$transaction->id.'" href="javascript:void(0)" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';

                $action .= '<a href="javascript:void(0)" class="btn btn-primary btn-circle btn-sm Showtransaction" data-id="'.$transaction->id.'" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>';
                return $action;
            })
            ->rawColumns(['date','status','currency_id','amount','client','remitter_name','beneficairy_name','bank_name','country_id','category_id','sub_category_id','invoice_number','invoice_status','remarks','action'])
            ->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'NO','width'=>'2%',"orderable" => false, "searchable" => false],
            ['data' => 'date', 'name' => 'date', 'title' => 'DATE','width'=>'10%'],
            ['data' => 'status', 'name' => 'status', 'title' => 'STATUS','width'=>'15%'],
            ['data' => 'currency_id', 'name' => 'currency_id', 'title' => 'CURRENCY','width'=>'5%'],
            ['data' => 'amount', 'name' => 'amount', 'title' => 'AMOUNT','width'=>'5%'],
            ['data' => 'client', 'name' => 'client', 'title' => 'CLIENT','width'=>'5%'],
            ['data' => 'remitter_name', 'name' => 'remitter_name', 'title' => 'REMITTER NAME','width'=>'5%'],
            ['data' => 'beneficairy_name', 'name' => 'beneficairy_name', 'title' => 'BENEFICAIRY NAME','width'=>'5%'],
            ['data' => 'bank_name', 'name' => 'bank_name', 'title' => 'BANK NAME','width'=>'5%'],
            ['data' => 'country_id', 'name' => 'country_id', 'title' => 'COUNTRY','width'=>'5%'],
            ['data' => 'category_id', 'name' => 'category_id', 'title' => 'MAIN Category','width'=>'5%'],
            ['data' => 'sub_category_id', 'name' => 'sub_category_id', 'title' => 'SUB CATEGORY','width'=>'5%'],
            ['data' => 'invoice_number', 'name' => 'invoice_number', 'title' => 'INVOICE NUMBER','width'=>'5%'],
            ['data' => 'invoice_status', 'name' => 'invoice_status', 'title' => 'INVOICE STATUS','width'=>'5%'],
            ['data' => 'remarks', 'name' => 'remarks', 'title' => 'REMARKS','width'=>'5%'],
            ['data' => 'action', 'name' => 'action', 'title' => 'ACTION','width'=>'10%',"orderable" => false, "searchable" => false],
        ])
        ->ajax([
            'url' => route('admin.transaction.filter_by_button'),
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
        ->parameters([
            'order' =>[],
            'paging'      => true,
            'info'        => true,
            'searchDelay' => 350,
            'dom'         => 'lBfrtip',
            'buttons'     => [
                ['extend' => 'print','title' => "Transaction Report", 'text' => '<i class="fa fa-print" aria-hidden="true" style="font-size:16px"></i>','exportOptions' => ['columns'=> [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]]],
                ['extend' => 'excel','title' => "Transaction Report", 'text' => '<i class="fa fa-file-excel-o" aria-hidden="true" style="font-size:16px"></i>','exportOptions' => ['columns'=> [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]]],
                ['extend' => 'pdf','title' => "Transaction Report", 'text' => '<i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:16px"></i>','exportOptions' => ['columns'=> [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]]],
            ],
            'searching'   => true,
        ]);
        return view($this->pageLayout.'index',compact('html','transaction_balance','country_list'));
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Create Transaction
    ---------------------------------------------------------------------------------- */
    public function change_status(Request $request){
        try{
            $transaction = Transaction::where('id',$request->id)->first();
            if($transaction === null){
                return redirect()->back()->with([
                    'status'    => 'warning',
                    'title'     => 'Warning!!',
                    'message'   => 'Status not found !!'
                ]);
            }else{
                if($transaction->type == "inward"){
                    if($transaction->status == "EXPECTED"){
                        if(!empty($transaction->company_uid)){
                            $companies_check = Companies::where('company_uid',$transaction->company_uid)->first();
                            if(!empty($companies_check)){
                                $total_balance = $companies_check->balance + $transaction->amount;
                                Companies::where('id',$companies_check->id)->update([
                                    'balance' => $total_balance
                                ]);
                            } else {
                                Companies::create([
                                    'company_uid' => @$transaction->company_uid,
                                    'balance' => @$transaction->amount,
                                ]);
                            }
                        }
                        
                        if(!empty($transaction->bank_uid)){
                            $bank_check = Bank::where('bank_uid',$transaction->bank_uid)->first();
                            if(!empty($bank_check)){
                                $total_balance = $bank_check->balance + $transaction->amount;
                                Bank::where('id',$bank_check->id)->update([
                                    'balance' => $total_balance
                                ]);
                            } else {
                                Bank::create([
                                    'bank_uid' => @$transaction->bank_uid,
                                    'balance' => @$transaction->amount,
                                ]);
                            }
                        }    
                    }else{
                        Transaction::where('id',$request->id)->update(['status' => $request->status]);
                    }

                }elseif($transaction->type == "outward"){
                    if($transaction->status == "PAID"){
                        if(!empty($transaction->company_uid)){
                            $companies_check = Companies::where('company_uid',$transaction->company_uid)->first();
                            if(!empty($companies_check)){
                                $total_balance = $companies_check->balance - $transaction->amount;
                                Companies::where('id',$companies_check->id)->update([
                                    'balance' => $total_balance
                                ]);
                            } else {
                                Companies::create([
                                    'company_uid' => @$transaction->company_uid,
                                    'balance' => @$transaction->amount,
                                ]);
                            }
                        }
                        
                        if(!empty($transaction->bank_uid)){
                            $bank_check = Bank::where('bank_uid',$transaction->bank_uid)->first();
                            if(!empty($bank_check)){
                                $total_balance = $bank_check->balance - $transaction->amount;
                                Bank::where('id',$bank_check->id)->update([
                                    'balance' => $total_balance
                                ]);
                            } else {
                                Bank::create([
                                    'bank_uid' => @$transaction->bank_uid,
                                    'balance' => @$transaction->amount,
                                ]);
                            }
                        }    
                    } else{
                        Transaction::where('id',$request->id)->update(['status' => $request->status]);
                    }
                } else {
                    Transaction::where('id',$request->id)->update(['status' => $request->status]);
                }
            }
            Notify::success('status updated successfully !!');
            return response()->json([
                'status'    => 'success',
                'title'     => 'Success!!',
                'message'   => 'status updated successfully.'
            ]);
        }catch (Exception $e){
            return response()->json([
                'status'    => 'error',
                'title'     => 'Error!!',
                'message'   => $e->getMessage()
            ]);
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Create Transaction
    ---------------------------------------------------------------------------------- */
    public function create(){
        $category = Category::pluck('category_name','id');
        $currency_list = Currency::pluck('currency','id');
        $country_list = Country::pluck('country_name','id');
        $sub_category_list = [];
        return view($this->pageLayout.'create',compact('category','currency_list','country_list','sub_category_list'));
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Store Transaction
    ---------------------------------------------------------------------------------- */
    public function store(Request $request){
    // $customMessages = [
    //     'date.required'              => 'Date is Required',
    //     'status.required'            => 'Status is Required',
    //     'type.required'              => 'Type is Required',
    //     'currency_id.required'       => 'Currency Date is Required',
    //     'amount.required'            => 'Amount is Required',
    //     'client.required'            => 'Client is Required',
    //     'remitter_name.required'     => 'Remitter Name is Required',
    //     'beneficairy_name.required'  => 'Beneficairy Name is Required',
    //     'bank_name.required'         => 'Bank Name is Required',
    //     'country_id.required'        => 'Country is Required',
    //     'category_id.required'       => 'Category is Required',
    //     'sub_category_id.required'   => 'Sub Category is Required',
    //     'invoice_number.required'    => 'Invoice Number is Required',
    //     'invoice_status.required'    => 'Invoice Status is Required',
    //     'remarks.required'           => 'Remarks is Required',
    // ];
    // $validatedData = Validator::make($request->all(),[
    //     'date'             => 'required',
    //     'status'           => 'required',
    //     'type'             => 'required',
    //     'currency_id'      => 'required',
    //     'amount'           => 'required',
    //     'client'           => 'required',
    //     'remitter_name'    => 'required',
    //     'beneficairy_name' => 'required',
    //     'bank_name'        => 'required',
    //     'country_id'       => 'required',
    //     'category_id'      => 'required',
    //     'sub_category_id'  => 'required',
    //     'invoice_number'   => 'required',
    //     'invoice_status'   => 'required',
    //     'remarks'          => 'required',
    // ],$customMessages);
    // if($validatedData->fails()){
    //     return redirect()->back()->withErrors($validatedData)->withInput();
    // }
        try{
            $TransactionDetail = Transaction::create([
                'date'               => @$request->get('date'),
                'status'             => @$request->get('status'),
                'type'               => @$request->get('type'),
                'currency_id'        => @$request->get('currency_id'),
                'amount'             => @$request->get('amount'),
                'client'             => @$request->get('client'),
                'remitter_name'      => @$request->get('remitter_name'),
                'beneficairy_name'   => @$request->get('beneficairy_name'),
                'bank_name'          => @$request->get('bank_name'),
                'bank_holder'        => @$request->get('bank_holder'),
                'bank_account'       => @$request->get('bank_account'),
                'country_id'         => @$request->get('country_id'),
                'category_id'        => @$request->get('category_id'),
                'sub_category_id'    => @$request->get('sub_category_id'),
                'invoice_number'     => @$request->get('invoice_number'),
                'invoice_status'     => @$request->get('invoice_status'),
                'remarks'            => @$request->get('remarks'),
            ]);
            if($TransactionDetail->type != "other"){
                if(!empty($TransactionDetail->beneficairy_name)){
                    $companies_check = Companies::where('companies_name',$TransactionDetail->beneficairy_name)->first();
                    if(!empty($companies_check)){
                        if($TransactionDetail->type == "inward"){
                            $total_balance = $companies_check->balance + $TransactionDetail->amount;
                        } else {
                            $total_balance = $companies_check->balance - $TransactionDetail->amount;
                        }
                        Companies::where('id',$companies_check->id)->update([
                            'balance' => $total_balance
                        ]);
                    } else {
                        Companies::create([
                            'companies_name' => @$TransactionDetail->beneficairy_name,
                            'balance' => @$TransactionDetail->amount,
                        ]);
                    }
                }
                if(!empty($TransactionDetail->client)){
                    $clients_check = Clients::where('clients_name',$TransactionDetail->client)->first();
                    if(!empty($clients_check)){
                        if($TransactionDetail->type == "inward"){
                            $total_balance = $clients_check->balance + $TransactionDetail->amount;
                        } else {
                            $total_balance = $clients_check->balance - $TransactionDetail->amount;
                        }
                        Clients::where('id',$clients_check->id)->update([
                            'balance' => $total_balance
                        ]);
                    } else {
                        Clients::create([
                            'clients_name' => @$TransactionDetail->client,
                            'balance' => @$TransactionDetail->amount,
                        ]);
                    }
                }
            }
            Notify::success('Transaction Created Successfully..!');
            return redirect()->route('admin.transaction.index');
        }catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Edit Transaction
    ---------------------------------------------------------------------------------- */
    public function edit($id){
        $transaction = Transaction::where('id',$id)->first();
        $category = Category::pluck('category_name','id');
        $currency_list = Currency::pluck('currency','id');
        $country_list = Country::pluck('country_name','id');
        $sub_category_list = SubCategory::pluck('sub_category_name','id');
        if(!empty($transaction)){
            return view($this->pageLayout.'edit',compact('transaction','category','currency_list','country_list','sub_category_list'));
        }else{
            return redirect()->route('admin.transaction.index');
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Update Transaction
    ---------------------------------------------------------------------------------- */
    public function update(Request $request,$id){
    // $customMessages = [
    //     'date.required'              => 'Date is Required',
    //     'status.required'            => 'Status is Required',
    //     'type.required'              => 'Type is Required',
    //     'currency_id.required'       => 'Currency Date is Required',
    //     'amount.required'            => 'Amount is Required',
    //     'client.required'            => 'Client is Required',
    //     'remitter_name.required'     => 'Remitter Name is Required',
    //     'beneficairy_name.required'  => 'Beneficairy Name is Required',
    //     'bank_name.required'         => 'Bank Name is Required',
    //     'country_id.required'        => 'Country is Required',
    //     'category_id.required'       => 'Category is Required',
    //     'sub_category_id.required'   => 'Sub Category is Required',
    //     'invoice_number.required'    => 'Invoice Number is Required',
    //     'invoice_status.required'    => 'Invoice Status is Required',
    //     'remarks.required'           => 'Remarks is Required',
    // ];
    // $validatedData = Validator::make($request->all(),[
    //     'date'             => 'required',
    //     'status'           => 'required',
    //     'type'             => 'required',
    //     'currency_id'      => 'required',
    //     'amount'           => 'required',
    //     'client'           => 'required',
    //     'remitter_name'    => 'required',
    //     'beneficairy_name' => 'required',
    //     'bank_name'        => 'required',
    //     'country_id'       => 'required',
    //     'category_id'      => 'required',
    //     'sub_category_id'  => 'required',
    //     'invoice_number'   => 'required',
    //     'invoice_status'   => 'required',
    //     'remarks'          => 'required',
    // ],$customMessages);
    // if($validatedData->fails()){
    //     return redirect()->back()->withErrors($validatedData)->withInput();
    // }
        try{
            Transaction::where('id',$id)->update([
                'date'               => @$request->get('date'),
                'status'             => @$request->get('status'),
                'type'               => @$request->get('type'),
                'currency_id'        => @$request->get('currency_id'),
                'amount'             => @$request->get('amount'),
                'client'             => @$request->get('client'),
                'remitter_name'      => @$request->get('remitter_name'),
                'beneficairy_name'   => @$request->get('beneficairy_name'),
                'bank_name'          => @$request->get('bank_name'),
                'bank_holder'        => @$request->get('bank_holder'),
                'bank_account'       => @$request->get('bank_account'),
                'country_id'         => @$request->get('country_id'),
                'category_id'        => @$request->get('category_id'),
                'sub_category_id'    => @$request->get('sub_category_id'),
                'invoice_number'     => @$request->get('invoice_number'),
                'invoice_status'     => @$request->get('invoice_status'),
                'remarks'            => @$request->get('remarks')
            ]);
            Notify::success('Transaction Updated Successfully..!');
            return redirect()->route('admin.transaction.index');
        } catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }

    /* ---------------------------------------------------------------------------------
    @Description: Function for Delete Transaction
    ---------------------------------------------------------------------------------- */
    public function delete($id){
        try{
            $transaction = Transaction::where('id',$id)->first();
            $transaction->delete();
            Notify::success('Transaction Deleted Successfully..!');
            return response()->json([
                'status'    => 'success',
                'title'     => 'Success!!',
                'message'   => 'transaction Deleted Successfully..!'
            ]);
        }catch(\Exception $e){
            return back()->with([
                'alert-type'    => 'danger',
                'message'       => $e->getMessage()
            ]);
        }
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for show Transaction
    ---------------------------------------------------------------------------------- */
    public function show(Request $request) {
        $transaction = Transaction::find($request->id);
        return view($this->pageLayout.'show',compact('transaction'));
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Category Get Sub Category
    ---------------------------------------------------------------------------------- */
    public function get_sub_category(Request $request){
        $data['sub_category'] = SubCategory::where("category_id",$request->category_id)->get(["sub_category_name","id"]);
        return response()->json($data);
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Import Excel
    ---------------------------------------------------------------------------------- */
    public function importshow(Request $request) {
        return view($this->pageLayout.'importshow');
    }

    /* ----------------------------------------------------------------------------------
    @Description: Function for Import Excel Store
    ---------------------------------------------------------------------------------- */
    public function importdata(Request $request){
        $customMessages = [
            'type.required'           => 'Remarks is Required',
        ];
        $validatedData = Validator::make($request->all(),[
            'type'          => 'required',
        ],$customMessages);
        if($validatedData->fails()){
            return redirect()->back()->withErrors($validatedData)->withInput();
        }
        try {
            if ($request->hasFile('test')) {
                $file = $request->file('test');
                $parsed_array = \Excel::toArray([], $file);
                $imported_data = array_splice($parsed_array[0], 1);
                if($request->type == "inward"){
                    foreach($imported_data as $data){
                    $Date = $data[0];
                    $Status = $data[1];
                    $Currency = $data[2];
                    $Amount = $data[3];
                    $Client = $data[4];
                    $RemitterName = $data[6];
                    $BeneficairyName = $data[5];
                    $CompanyUid =$data[7];
                    $BankName = $data[8];
                    $BankUid =$data[9];
                    $Country = $data[10];
                    $MainCategory = $data[11];
                    $SubCategory = $data[12];
                    $InvoiceNumber = $data[13];
                    $InvoiceStatus = $data[14];
                    $Remarks = $data[15];

                    if(!empty($Date)) {
                        $new_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Date)->format('Y-m-d');
                        if(!empty($new_date)){
                            $date = $new_date;
                        } else {
                            $date = NULL;
                        }
                    } else {
                        $date = NULL;
                    }

                    if(!empty($Status)) {
                            $status = $Status;
                        } else {
                            $status = NULL;
                        }

                    if(!empty($Currency)) {
                            $currency_list = Currency::where('currency',$Currency)->first();
                            if(!empty($currency_list)){
                                $currency_id = $currency_list->id;
                            } else { 
                                $currency_id = NULL;
                            }
                        } else {
                            $currency_id = NULL;
                        }

                    if(!empty($Amount)) {
                            $amount = $Amount;
                        } else {
                            $amount = NULL;
                        }
                    if(!empty($Client)) {
                            $client = $Client;
                        } else {
                            $client = NULL;
                        }
                    if(!empty($BeneficairyName)) {
                            $beneficairy_name = $BeneficairyName;
                        } else {
                            $beneficairy_name = NULL;
                        }
                    if(!empty($RemitterName)) {
                            $remitter_name = $RemitterName;
                        } else {
                            $remitter_name = NULL;
                        }
                    if(!empty($CompanyUid)) {
                            $company_uid = $CompanyUid;
                        } else {
                            $company_uid = NULL;
                        }
                    if(!empty($BankName)) {
                            $bank_name = $BankName;
                        } else {
                            $bank_name = NULL;
                        }
                    if(!empty($BankUid)) {
                            $bank_uid = $BankUid;
                        } else {
                            $bank_uid = NULL;
                        }
                    if(!empty($Country)) {
                            $country_list = Country::where('country_name',$Country)->first();
                            if(!empty($country_list)){
                                $country_id = $country_list->id;
                            } else {
                                $country_id = NULL;
                            }
                        } else {
                            $country_id = NULL;
                        }
                    if(!empty($MainCategory)) {
                            $category_list = Category::where('category_name',$MainCategory)->first();
                            if(!empty($category_list)){
                                $category_id = $category_list->id;
                            } else {
                                $category_id = NULL;
                            }
                        } else {
                            $category_id = NULL;
                        }
                    if(!empty($SubCategory)) {
                            $subcategory_list = SubCategory::where('sub_category_name',$SubCategory)->first();
                            if(!empty($subcategory_list)){
                                $sub_category_id = $subcategory_list->id;
                            } else {
                                $sub_category_id = NULL;
                            }
                        } else {
                            $sub_category_id = NULL;
                        }
                    if(!empty($InvoiceNumber)) {
                            $invoice_number = $InvoiceNumber;
                        } else {
                            $invoice_number = NULL;
                        }
                        if(!empty($InvoiceStatus)) {
                            $invoice_status = $InvoiceStatus;
                        } else {
                            $invoice_status = NULL;
                        }
                    if(!empty($Remarks)) { 
                            $remarks = $Remarks;
                        } else {
                            $remarks = NULL;
                        }
                    $insert=array('type'=>"inward",'date'=>$date,'status' => $status,'currency_id'=>$currency_id,'amount' => $amount,'client' => $client,'beneficairy_name' => $beneficairy_name,'remitter_name' => $remitter_name,'company_uid' => $company_uid,'bank_name' => $bank_name,'bank_uid' => $bank_uid,'country_id' => $country_id,'category_id'=> $category_id,'sub_category_id'=>$sub_category_id,'invoice_number'=>$invoice_number,'invoice_status' => $invoice_status,'remarks' => $remarks);
                    $TransactionDetail = Transaction::create($insert);

                    if($TransactionDetail->status == "RECEIVED" || $TransactionDetail->status == "RETURN FUND"){
                        if(!empty($TransactionDetail->company_uid)){
                            $companies_check = Companies::where('company_uid',$TransactionDetail->company_uid)->first();
                            if(!empty($companies_check)){
                                $total_balance = $companies_check->balance + $TransactionDetail->amount;
                                Companies::where('id',$companies_check->id)->update([
                                    'balance' => $total_balance
                                ]);
                            } else {
                                Companies::create([
                                    'company_uid' => @$TransactionDetail->company_uid,
                                    'balance' => @$TransactionDetail->amount,
                                ]);
                            }
                        }
                        
                        if(!empty($TransactionDetail->bank_uid)){
                            $bank_check = Bank::where('bank_uid',$TransactionDetail->bank_uid)->first();
                            if(!empty($bank_check)){
                                $total_balance = $bank_check->balance + $TransactionDetail->amount;
                                Bank::where('id',$bank_check->id)->update([
                                    'balance' => $total_balance
                                ]);
                            } else {
                                Bank::create([
                                    'bank_uid' => @$TransactionDetail->bank_uid,
                                    'balance' => @$TransactionDetail->amount,
                                ]);
                            }
                        }    
                    }
                }
                }elseif($request->type == "outward"){
                    foreach($imported_data as $data){
                    $Date = $data[0];
                    $Status = $data[1];
                    $Currency = $data[2];
                    $Amount = $data[3];
                    $Client = $data[4];
                    $BeneficairyName = $data[5];
                    $RemitterName = $data[6];
                    $CompanyUid =$data[7];
                    $BankName = $data[8];
                    $BankUid =$data[9];
                    $Country = $data[10];
                    $MainCategory = $data[11];
                    $SubCategory = $data[12];
                    $InvoiceStatus = $data[13];
                    $Remarks = $data[14];
                    if(!empty($Date)) {
                        $new_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Date)->format('Y-m-d');
                        if(!empty($new_date)){
                            $date = $new_date;
                        } else {
                            $date = NULL;
                        }
                    } else {
                        $date = NULL;
                    }

                    if(!empty($Status)) {
                            $status = $Status;
                        } else {
                            $status = NULL;
                        }

                    if(!empty($Currency)) {
                            $currency_list = Currency::where('currency',$Currency)->first();
                            if(!empty($currency_list)){
                                $currency_id = $currency_list->id;
                            } else { 
                                $currency_id = NULL;
                            }
                        } else {
                            $currency_id = NULL;
                        }

                    if(!empty($Amount)) {
                            $amount = $Amount;
                        } else {
                            $amount = NULL;
                        }
                    if(!empty($Client)) {
                            $client = $Client;
                        } else {
                            $client = NULL;
                        }
                    if(!empty($BeneficairyName)) {
                            $beneficairy_name = $BeneficairyName;
                        } else {
                            $beneficairy_name = NULL;
                        }
                    if(!empty($RemitterName)) {
                            $remitter_name = $RemitterName;
                        } else {
                            $remitter_name = NULL;
                        }
                    if(!empty($CompanyUid)) {
                            $company_uid = $CompanyUid;
                        } else {
                            $company_uid = NULL;
                        }
                    if(!empty($BankName)) {
                            $bank_name = $BankName;
                        } else {
                            $bank_name = NULL;
                        }
                    if(!empty($BankUid)) {
                            $bank_uid = $BankUid;
                        } else {
                            $bank_uid = NULL;
                        }
                    if(!empty($Country)) {
                            $country_list = Country::where('country_name',$Country)->first();
                            if(!empty($country_list)){
                                $country_id = $country_list->id;
                            } else {
                                $country_id = NULL;
                            }
                        } else {
                            $country_id = NULL;
                        }
                    if(!empty($MainCategory)) {
                            $category_list = Category::where('category_name',$MainCategory)->first();
                            if(!empty($category_list)){
                                $category_id = $category_list->id;
                            } else {
                                $category_id = NULL;
                            }
                        } else {
                            $category_id = NULL;
                        }
                    if(!empty($SubCategory)) {
                            $subcategory_list = SubCategory::where('sub_category_name',$SubCategory)->first();
                            if(!empty($subcategory_list)){
                                $sub_category_id = $subcategory_list->id;
                            } else {
                                $sub_category_id = NULL;
                            }
                        } else {
                            $sub_category_id = NULL;
                        }
                    if(!empty($InvoiceStatus)) {
                            $invoice_status = $InvoiceStatus;
                        } else {
                            $invoice_status = NULL;
                        }
                    if(!empty($Remarks)) { 
                            $remarks = $Remarks;
                        } else {
                            $remarks = NULL;
                        }
                    $insert=array('type'=>"outward",'date'=>$date,'status' => $status,'currency_id'=>$currency_id,'amount' => $amount,'client' => $client,'beneficairy_name' => $beneficairy_name,'remitter_name' => $remitter_name,'company_uid' => $company_uid,'bank_name' => $bank_name,'bank_uid' => $bank_uid,'country_id' => $country_id,'category_id'=> $category_id,'sub_category_id'=>$sub_category_id,'invoice_status' => $invoice_status,'remarks' => $remarks);
                    $TransactionDetail = Transaction::create($insert);

                    if($TransactionDetail->status == "PAID"){
                        if(!empty($TransactionDetail->company_uid)){
                            $companies_check = Companies::where('company_uid',$TransactionDetail->company_uid)->first();
                            if(!empty($companies_check)){
                                $total_balance = $companies_check->balance - $TransactionDetail->amount;
                                Companies::where('id',$companies_check->id)->update([
                                    'balance' => $total_balance
                                ]);
                            } else {
                                Companies::create([
                                    'company_uid' => @$TransactionDetail->company_uid,
                                    'balance' => @$TransactionDetail->amount,
                                ]);
                            }
                        }
                        
                        if(!empty($TransactionDetail->bank_uid)){
                            $bank_check = Bank::where('bank_uid',$TransactionDetail->bank_uid)->first();
                            if(!empty($bank_check)){
                                $total_balance = $bank_check->balance - $TransactionDetail->amount;
                                Bank::where('id',$bank_check->id)->update([
                                    'balance' => $total_balance
                                ]);
                            } else {
                                Bank::create([
                                    'bank_uid' => @$TransactionDetail->bank_uid,
                                    'balance' => @$TransactionDetail->amount,
                                ]);
                            }
                        }    
                    }
                    

                    
                }
                } elseif($request->type == "daily_balance_tracker"){
                    dd("daily_balance_tracker");
                }else {
                    foreach($imported_data as $data){
                        $Date = $data[0];
                        $Currency = $data[1];
                        $Amount = $data[2];
                        $Description = $data[3];
                        $CompanyUid =$data[4];
                        if(!empty($Date)) {
                            $new_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($Date)->format('Y-m-d');
                            if(!empty($new_date)){
                                $date = $new_date;
                            } else {
                                $date = NULL;
                            }
                        } else {
                            $date = NULL;
                        }

                        if(!empty($Currency)) {
                            $currency_list = Currency::where('currency',$Currency)->first();
                            if(!empty($currency_list)){
                                $currency_id = $currency_list->id;
                            } else { 
                                $currency_id = NULL;
                            }
                        } else {
                            $currency_id = NULL;
                        }
                        if(!empty($Amount)) {
                            $amount = $Amount;
                        } else {
                            $amount = NULL;
                        }
                        if(!empty($Description)) {
                            $description = $Description;
                        } else {
                            $description = NULL;
                        }
                        if(!empty($CompanyUid)) {
                            $bank_uid = $CompanyUid;
                        } else {
                            $bank_uid = NULL;
                        }
                        $insert=array('type'=>"other",'date'=>$date,'status'=>'PAID','currency_id'=>$currency_id,'amount' => $amount,'description' => $description,'bank_uid' => $company_uid);
                        $TransactionDetail = Transaction::create($insert);
                        if($TransactionDetail->status == "PAID"){
                            if(!empty($TransactionDetail->bank_uid)){
                            $bank_check = Bank::where('bank_uid',$TransactionDetail->bank_uid)->first();
                            if(!empty($bank_check)){
                                $total_balance = $bank_check->balance - $TransactionDetail->amount;
                                Bank::where('id',$bank_check->id)->update([
                                    'balance' => $total_balance
                                ]);
                            } else {
                                Bank::create([
                                    'bank_uid' => @$TransactionDetail->bank_uid,
                                    'balance' => @$TransactionDetail->amount,
                                ]);
                            }
                        }
                        }
                    }
                }
                return ["status"=>'success',"message"=>'Imported Successfully.'];
            } else {
                return ["status"=>'error',"message"=>'Not Imported Record Successfully.'];
            }
        }catch(\Exception $e){
            return ["status"=>'error',"message"=>$e->getMessage()];
        }
    }

    // public function importdata(Request $request){
    //     $customMessages = [
    //         'type.required'           => 'Remarks is Required',
    //     ];
    //     $validatedData = Validator::make($request->all(),[
    //         'type'          => 'required',
    //     ],$customMessages);
    //     if($validatedData->fails()){
    //         return redirect()->back()->withErrors($validatedData)->withInput();
    //     }
    //     try {
    //         if ($request->hasFile('test')) {
    //             $file = $request->file('test');
    //             $parsed_array = \Excel::toArray([], $file);
    //             $imported_data = array_splice($parsed_array[0], 1);
    //             if($request->type == "inward"){
    //                 dd("inward");
    //             }elseif($request->type == "outward"){
    //                 dd("outward");
    //             } elseif($request->type == "daily_balance_tracker"){
    //                 dd("daily_balance_tracker");
    //             }else {
    //                dd("other");
    //             }
    //             return ["status"=>'success',"message"=>'Imported Successfully.'];
    //         } else {
    //             return ["status"=>'error',"message"=>'Not Imported Record Successfully.'];
    //         }
    //     }catch(\Exception $e){
    //         return ["status"=>'error',"message"=>$e->getMessage()];
    //     }
    // }
}
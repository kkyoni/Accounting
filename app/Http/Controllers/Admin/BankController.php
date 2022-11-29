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
use App\Models\Bank;
use Event;

class BankController extends Controller{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * * * * * Create a new controller instance.
     * * * * *
     * * * * @return void
     * * * */
    public function __construct(){
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.bank.';
        $this->middleware('auth');
    }

    /*-------------------------------------------------------------------------------
    @Description: Function Index Bank
    -------------------------------------------------------------------------------*/
    public function index(Builder $builder, Request $request){
        $bank = Bank::orderBy('id','desc');
        if (request()->ajax()) {
            return DataTables::of($bank->get())
            ->addIndexColumn()
            ->rawColumns([''])
            ->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'NO','width'=>'5%',"orderable" => false, "searchable" => false],
            ['data' => 'bank_uid', 'name' => 'bank_uid', 'title' => 'BANK UID','width'=>'10%'],
            ['data' => 'balance', 'name' => 'balance', 'title' => 'BALANCE','width'=>'10%'],
        ])
        ->parameters([ 'order' =>[] ]);
        return view($this->pageLayout.'index',compact('html'));
    }
}
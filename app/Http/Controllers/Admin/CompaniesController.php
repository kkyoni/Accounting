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
use App\Models\Companies;
use App\Models\Clients;
use Event;

class CompaniesController extends Controller{
    protected $authLayout = '';
    protected $pageLayout = '';
    /**
     * * * * * Create a new controller instance.
     * * * * *
     * * * * @return void
     * * * */
    public function __construct(){
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.companies.';
        $this->middleware('auth');
    }

    /*-------------------------------------------------------------------------------
    @Description: Function Index Companies Page
    ------------------------------------------------------------------------------ */
    public function index(Builder $builder, Request $request){
        $companies = Companies::orderBy('id','desc');
        if (request()->ajax()) {
            return DataTables::of($companies->get())
            ->addIndexColumn()
            ->rawColumns([''])
            ->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'NO','width'=>'5%',"orderable" => false, "searchable" => false],
            ['data' => 'company_uid', 'name' => 'company_uid', 'title' => 'COMPANIES UID','width'=>'10%'],
            ['data' => 'balance', 'name' => 'balance', 'title' => 'BALANCE','width'=>'10%'],
        ])
        ->parameters([ 'order' =>[] ]);
        return view($this->pageLayout.'index',compact('html'));
    }

    /*-------------------------------------------------------------------------------
    @Description: Function Index Client Page
    ------------------------------------------------------------------------------ */
    public function index_clients(Builder $builder, Request $request){
        $clients = Clients::orderBy('id','desc');
        if (request()->ajax()) {
            return DataTables::of($clients->get())->addIndexColumn()->rawColumns([''])->make(true);
        }
        $html = $builder->columns([
            ['data' => 'DT_RowIndex', 'name' => '', 'title' => 'NO','width'=>'5%',"orderable" => false, "searchable" => false],
            ['data' => 'clients_name', 'name' => 'clients_name', 'title' => 'CLIENTS NAME','width'=>'10%'],
            ['data' => 'balance', 'name' => 'balance', 'title' => 'BALANCE','width'=>'10%'],
        ])
        ->parameters([ 'order' =>[] ]);
        return view($this->pageLayout.'index_client',compact('html'));
    }
}
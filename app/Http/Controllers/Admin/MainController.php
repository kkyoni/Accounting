<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Companies;
use App\Models\Clients;
use Carbon\Carbon;
use Response;
use DB;

class MainController extends Controller{
    protected $authLayout = '';
    protected $pageLayout = 'admin.pages.';
    /**
     * * * * Create a new controller instance.
     * * * *
     * * * @return void
     * * */
    public function __construct(){
        $this->authLayout = 'admin.auth.';
        $this->pageLayout = 'admin.pages.';
        $this->middleware('auth');
    }

    /* -----------------------------------------------------------------------------------
    @Description: Function Index Page
    ----------------------------------------------------------------------------------- */
    public function index(){
        return view('front.auth.login');
    }

    /* -----------------------------------------------------------------------------------
    @Description: Function Dashboard Page
    ----------------------------------------------------------------------------------- */
    public function dashboard(){
        $totalCurrency = Currency::count();
        $totalCategory = Category::count();
        $totalTransactionInward = Transaction::where('type','inward')->count();
        $totalTransactionOutward = Transaction::where('type','outward')->count();
        $totalTransactionOther = Transaction::where('type','other')->count();
        $TotalCompanies = Companies::count();
        $TotalClient = Clients::count();
        $CompaniesBalance = Companies::get();
        return view('admin.pages.dashboard',compact('totalCurrency','totalCategory','totalTransactionInward','totalTransactionOutward','TotalClient','TotalCompanies','CompaniesBalance','totalTransactionOther'));
    }
}
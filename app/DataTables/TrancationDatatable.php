<?php
namespace App\DataTables;

use App\Models\Transaction;
use Yajra\DataTables\Services\DataTable;

class TrancationDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
        ->addIndexColumn()
        ->editColumn('date', function ($query) {
                return date("d M Y", strtotime($query->date));
            })
        ->editColumn('status', function ($query) {
                    if($query->status == "received"){
                        return 'RECEIVED';
                    } elseif($query->status == "retrun_fund") {
                        return 'RETURN FUND';
                    } elseif($query->status == "cancle") {
                        return 'CANCEL';
                    } elseif($query->status == "expecting") {
                        return 'EXPECTING';
                    } elseif($query->status == "paid") {
                        return 'PAID';
                    } else {
                        return 'HOLD';
                    }
                })
        ->editColumn('type', function (Transaction $transaction) {
                if($transaction->type == "inward"){
                    return "InWard";    
                } else {
                    return "OutWard";    
                }
                
            })
        ->editColumn('currency_id', function (Transaction $transaction) {
                return $transaction->currency_list->currency;
            })
            ->editColumn('country_id', function (Transaction $transaction) {
                return $transaction->country_list->country_name;
            })
            ->editColumn('category_id', function (Transaction $transaction) {
                return $transaction->category_list->category_name;
            })
            ->editColumn('sub_category_id', function (Transaction $transaction) {
                return $transaction->subcategory_list->sub_category_name;
            })
            ->filter(function ($query){
                if(request()->has("date") && !empty(request()->get("date"))) {
                    $query->where('transaction.date','>=',request()->get("date"));
                }
                if(request()->has("remitter_name") && !empty(request()->get("remitter_name"))) {
                    $query->where('transaction.remitter_name','like','%'.request()->get("remitter_name").'%');
                }
                if(request()->has("bank_account") && !empty(request()->get("bank_account"))) {
                    $query->where('transaction.bank_account','like','%'.request()->get("bank_account").'%');
                }
                if(request()->has("amount") && !empty(request()->get("amount"))) {
                    $query->where('transaction.amount','like','%'.request()->get("amount").'%');
                }
                if(request()->has("beneficairy_name") && !empty(request()->get("beneficairy_name"))) {
                    $query->where('transaction.beneficairy_name','like','%'.request()->get("beneficairy_name").'%');
                }
                if(request()->has("client") && !empty(request()->get("client"))) {
                    $query->where('transaction.client','like','%'.request()->get("client").'%');
                }
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param Transaction $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Transaction $model){
        return $model->newQuery()->select('transaction.*')->orderBy('id');
    }

    public function view(){
        return $this->ajax();
    }
}

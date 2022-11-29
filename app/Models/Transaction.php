<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'transaction';
    protected $fillable = ['date','status','type','currency_id','amount','client','remitter_name','company_uid','beneficairy_name','bank_name','bank_uid','bank_holder','bank_account','country_id','category_id','sub_category_id','invoice_number','invoice_status','remarks','consignee','address','description'];
    public function currency_list(){
        return $this->hasOne('App\Models\Currency','id','currency_id');
    }
    public function country_list(){
        return $this->hasOne('App\Models\Country','id','country_id');
    }
    public function category_list(){
        return $this->hasOne('App\Models\Category','id','category_id');
    }
    public function subcategory_list(){
        return $this->hasOne('App\Models\SubCategory','id','sub_category_id');
    }
    public function type_list(){
        return $this->hasOne('App\Models\Type','id','type_id');
    }
}
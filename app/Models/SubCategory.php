<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'subcategory';
    protected $fillable = ['category_id','sub_category_name'];
    public function category_list(){
        return $this->hasOne('App\Models\Category','id','category_id');
    }
}
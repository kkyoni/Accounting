<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Category extends Model{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'category';
    protected $fillable = ['category_name'];
}
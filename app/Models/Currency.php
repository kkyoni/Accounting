<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'currency';
    protected $fillable = ['currency'];
}
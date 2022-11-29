<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Country extends Model{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'country';
    protected $fillable = ['country_name'];
}
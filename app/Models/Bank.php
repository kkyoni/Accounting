<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'bank';
    protected $fillable = ['bank_uid','balance'];
}

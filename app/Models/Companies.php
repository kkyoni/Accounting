<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Companies extends Model{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'companies';
    protected $fillable = ['company_uid','balance'];
}
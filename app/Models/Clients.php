<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'clients';
    protected $fillable = ['clients_name','balance'];
}
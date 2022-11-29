<?php
namespace App\Models;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model{
    use Notifiable;
    use SoftDeletes;
    protected $table = 'payment';
    protected $fillable = ['payment_name'];
}
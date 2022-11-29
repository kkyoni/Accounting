<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrencyTable extends Migration{
/**
* Run the migrations.
*
* @return void
*/
public function up(){
    Schema::create('currency', function (Blueprint $table) {
        $table->id();
        $table->string('currency')->length(255)->nullable();
        $table->timestamps();
        $table->softDeletes();
    });
}
/**
* Reverse the migrations.
*
* @return void
*/
public function down(){
    Schema::dropIfExists('currency');
}
}
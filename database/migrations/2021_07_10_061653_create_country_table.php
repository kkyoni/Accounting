<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountryTable extends Migration{
/**
* Run the migrations.
*
* @return void
*/
public function up(){
    Schema::create('country', function (Blueprint $table) {
        $table->id();
        $table->string('country_name')->length(255)->nullable();
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
    Schema::dropIfExists('country');
}
}
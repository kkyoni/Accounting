<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration{
/**
* Run the migrations.
*
* @return void
*/
public function up(){
    Schema::create('clients', function (Blueprint $table) {
        $table->id();
        $table->string('clients_name')->length(255)->nullable();
        $table->string('balance')->length(255)->nullable();
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
    Schema::dropIfExists('clients');
}
}
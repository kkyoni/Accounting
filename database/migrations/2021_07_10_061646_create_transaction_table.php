<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionTable extends Migration{
/**
* Run the migrations.
*
* @return void
*/
public function up(){
    Schema::create('transaction', function (Blueprint $table) {
        $table->id();
        $table->string('date')->length(255)->nullable();
        $table->string('status')->length(255)->nullable();
        $table->string('type')->length(255)->nullable();
        $table->string('currency_id')->length(255)->nullable();
        $table->string('amount')->length(255)->nullable();
        $table->string('client')->length(255)->nullable();
        $table->string('remitter_name')->length(255)->nullable();
        $table->string('company_uid')->length(255)->nullable();
        $table->string('beneficairy_name')->length(255)->nullable();
        $table->string('bank_name')->length(255)->nullable();
        $table->string('bank_uid')->length(255)->nullable();
        $table->string('bank_holder')->length(255)->nullable();
        $table->string('bank_account')->length(255)->nullable();
        $table->string('country_id')->length(255)->nullable();
        $table->string('category_id')->length(255)->nullable();
        $table->string('sub_category_id')->length(255)->nullable();
        $table->string('invoice_number')->length(255)->nullable();
        $table->string('invoice_status')->length(255)->nullable();
        $table->string('remarks')->length(255)->nullable();
        $table->string('consignee')->length(255)->nullable();
        $table->string('address')->length(255)->nullable();
        $table->string('description')->length(255)->nullable();
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
    Schema::dropIfExists('transaction');
}
}
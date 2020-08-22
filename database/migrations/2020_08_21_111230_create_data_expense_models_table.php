<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataExpenseModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index('user_id')->nullable();
            $table->integer('amount');//Stored in cents
            $table->text('description');
            $table->timestamps();
        });

        Schema::table('data_expenses', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('data_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('data_expenses', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('data_expenses');
    }
}

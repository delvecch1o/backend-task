<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->text('terms');
            $table->enum('status', ['new', 'in_progress','terminated']);
            $table->boolean('active')->nullable()->default(false);
            
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('contractor_id');
            $table->timestamps();

            $table->foreign('client_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('contractor_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}

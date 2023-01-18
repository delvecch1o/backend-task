<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->decimal('price');
            $table->boolean('paid')->default(false);
            $table->date('payment_date')->nullable();
            $table->boolean('active')->nullable()->default(false);

            $table->unsignedBigInteger('contractor_id');
            $table->unsignedBigInteger('contract_id');
            $table->timestamps();

            $table->foreign('contractor_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('contract_id')->references('id')->on('contracts')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
}

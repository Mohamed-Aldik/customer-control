<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEndServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('end_services', function (Blueprint $table) {
            $table->id();
            $table->date('termination_date');
            $table->decimal('end_service_reward');
            $table->decimal('compensation');
            $table->decimal('benefit');
            $table->decimal('debets')->default(0);
            $table->integer('reason');
            $table->integer('years');
            $table->integer('months');
            $table->integer('days');
            $table->double('available_balance');
            $table->decimal('late_notify');
            $table->decimal('total');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('end_services');
    }
}

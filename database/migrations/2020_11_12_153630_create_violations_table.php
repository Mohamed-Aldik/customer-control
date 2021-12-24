<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViolationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('violations', function (Blueprint $table) {
            $table->id();
            $table->string('reason_in_arabic');
            $table->string('reason_in_english');
            $table->string('panel1');
            $table->string('panel2')->nullable();
            $table->string('panel3')->nullable();
            $table->string('panel4')->nullable();
            $table->string('panel5')->nullable(); //added by abdo
            $table->text('message_en'); //added by abdo
            $table->text('message_ar'); //added by abdo
            $table->string('addition_to')->nullable();
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
        Schema::dropIfExists('violations');
    }
}

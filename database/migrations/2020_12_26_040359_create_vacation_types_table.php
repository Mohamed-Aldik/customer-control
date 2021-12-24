<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacation_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('name_ar');
            $table->string('name_en');
            $table->enum('type', ['general', 'custom'])->default('custom');
            
            //$table->integer('num_of_days', false, true)->default(0); // removed by abdo
            $table->integer('min_num')->default(0); // added by abdo
            $table->integer('max_num')->default(0); // added by abdo
            $table->timestamps();

            $table->unique(['company_id', 'name_ar']);
            $table->unique(['company_id', 'name_en']);

            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacation_types');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferenceValueTempInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reference_value_temp_insurance', function (Blueprint $table) {
            $table->unsignedBigInteger('reference_value_id');
            $table->foreign('reference_value_id')->references('id')->on('reference_values')->onDelete('cascade');

            $table->unsignedBigInteger('temp_insurance_id');
            $table->foreign('temp_insurance_id')->references('id')->on('temp_insurances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reference_value_temp_insurance');
    }
}

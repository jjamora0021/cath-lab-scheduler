<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->integer('age');
            $table->decimal('pt_ptt');
            $table->decimal('weight');
            $table->string('height');
            $table->string('room_number');
            $table->string('bed_number');
            $table->json('allergies');
            $table->string('diagnosis');
            $table->string('operation');
            $table->date('date');
            $table->time('time');
            $table->string('anesthesiologist');
            $table->string('surgeon');
            $table->enum('urgency', ['elective', 'emergency']);
            $table->enum('status', ['pending', 'approved', 'decline'])->default('pending');
            $table->string('approved_by')->nullable();
            $table->timestamp('date_approved')->nullable();
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
        Schema::dropIfExists('patient_info');
    }
}

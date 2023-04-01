<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            // doctor sheet
            $table->longText('medicines')->nullable();
            $table->string('doctor_name')->nullable();
            $table->string('bed_number')->nullable();
            $table->longText('name_of_nurse')->nullable();
            $table->longText('progress_notes')->nullable();
            $table->longText('doctors_order')->nullable();
            $table->string('remarks')->nullable();
            $table->string('prepared_by')->nullable();

            // medical history
            $table->longText('medical_history')->nullable();
            $table->longText('medications')->nullable();
            $table->longText('restricted_drugs')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn([
                'medicines',
                'name_of_nurse',
                'progress_notes',
                'doctors_order',
                'remarks',
                'prepared_by',
                'medical_history',
                'medications',
                'restricted_drugs',
                'doctor_name',
            ]);
        });
    }
};

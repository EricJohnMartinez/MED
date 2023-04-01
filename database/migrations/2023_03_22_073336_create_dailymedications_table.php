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
        Schema::create('dailymedications', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('medicine')->nullable();
            $table->string('requested')->nullable();
            $table->string('dispensed')->nullable();
            $table->string('nurse')->nullable();
            $table->string('pharmacist')->nullable();
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('dailymedications');
    }
};

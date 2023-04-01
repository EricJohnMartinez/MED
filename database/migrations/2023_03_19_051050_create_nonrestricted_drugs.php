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
        Schema::create('nonrestrictedDrugs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->integer('ward')->nullable();
            $table->string('drug')->nullable();
            $table->string('dosege')->nullable();
            $table->string('total')->nullable();
            $table->string('nurse')->nullable();
            $table->string('pharmacist')->nullable();
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
        Schema::dropIfExists('nonrestrictedDrugs');
    }
};

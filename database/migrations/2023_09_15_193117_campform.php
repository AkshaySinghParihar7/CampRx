<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('campforms', function (Blueprint $table) {
            $table->id();
            $table->string('tmName');
            $table->string('doctorName');
            $table->string('campType');
            $table->string('speciality');
            $table->string('POB'); // Changed from text to string
            $table->integer('noOfPatientScreened'); // Corrected the name and changed to integer
            $table->integer('onOfRxnGenerated'); // Corrected the name and changed to integer
            $table->datetime('campDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

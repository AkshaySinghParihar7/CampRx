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
        Schema::create('_employee', function (Blueprint $table) {
            $table->id();
            $table->string('zone')->nullable();
            $table->string('state')->nullable();
            $table->string('division')->nullable();
            $table->string('TerrCode')->nullable();
            $table->string('TerrName')->nullable();
            $table->string('EMPCODE')->nullable();
            $table->string('POSCODE')->nullable();
            $table->string('STATUS')->nullable();
            $table->string('EMPNAME')->nullable();
            $table->string('DOJ')->nullable();
            $table->string('BIRTHDATE')->nullable();
            $table->string('DESIGNATION')->nullable();
            $table->string('DesignMIS')->nullable();
            $table->string('HEADQ')->nullable();
            $table->string('EmailJbpharma')->nullable();
            $table->string('EMAILIDPERSONAL')->nullable();
            $table->string('MOBILENO')->nullable();
            $table->string('AMTerrCode')->nullable();
            $table->string('AMEmpCode')->nullable();
            $table->string('AMName')->nullable();
            $table->string('AMHQ')->nullable();
            $table->string('AMEmail')->nullable();
            $table->string('RMTerrCode')->nullable();
            $table->string('RMEmpCode')->nullable();
            $table->string('RMName')->nullable();
            $table->string('RMHQ')->nullable();
            $table->string('RMEmailID')->nullable();
            $table->string('DSMTerrCode')->nullable();
            $table->string('DSMEmpCode')->nullable();
            $table->string('DSMName')->nullable();
            $table->string('DSMHQ')->nullable();
            $table->string('DSMEmail')->nullable();
            $table->string('SMTerrCode')->nullable();
            $table->string('SMEmpCode')->nullable();
            $table->string('SMName')->nullable();
            $table->string('SMHQ')->nullable();
            $table->string('SMEmail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('_employee');
    }
};

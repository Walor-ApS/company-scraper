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
        Schema::create('company_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            
            $table->integer('year')->nullable();
            $table->tinyInteger('month')->nullable();
            $table->tinyInteger('week')->nullable();
            $table->integer('employees')->nullable();
            $table->string('employees_range')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {            
        Schema::dropIfExists('company_employees');
    }
};

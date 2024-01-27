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
        Schema::create('competitor_companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('page_url');
            $table->string('competitor');
            $table->string('website')->nullable();
            $table->string('state')->default("New");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitor_companies');
    }
};

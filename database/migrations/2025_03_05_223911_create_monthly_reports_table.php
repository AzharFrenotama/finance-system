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
        Schema::create('monthly_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id');
            $table->integer('month'); 
            $table->integer('year'); 
            $table->decimal('total_incomes', 15, 2)->default(0); 
            $table->decimal('total_expenses', 15, 2)->default(0); 
            $table->decimal('balance', 15, 2)->default(0); 
            $table->timestamps();

            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');

            $table->unique(['profile_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_reports');
    }
};

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
        Schema::create('tbl_match', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_club_id')->constrained('tbl_klub');
            $table->integer('home_club_goal')->default(0);
            $table->foreignId('away_club_id')->constrained('tbl_klub');
            $table->integer('away_club_goal')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_match');
    }
};

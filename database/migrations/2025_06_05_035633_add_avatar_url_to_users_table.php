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
        Schema::table('users', function (Blueprint $table) {
            $table->string(config('filament-edit-profile.avatar_column', 'avatar_url'))->nullable();
        });
        Schema::table('factories', function (Blueprint $table) {
            $table->string(config('filament-edit-profile.avatar_column', 'avatar_url'))->nullable();
        });
        Schema::table('designers', function (Blueprint $table) {
            $table->string(config('filament-edit-profile.avatar_column', 'avatar_url'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(config('filament-edit-profile.avatar_column', 'avatar_url'));
        });
        Schema::table('factories', function (Blueprint $table) {
            $table->dropColumn(config('filament-edit-profile.avatar_column', 'avatar_url'));
        });
        Schema::table('designers', function (Blueprint $table) {
            $table->dropColumn(config('filament-edit-profile.avatar_column', 'avatar_url'));
        });
    }
};

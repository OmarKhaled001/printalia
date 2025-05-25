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
        Schema::create('designers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('national_id')->nullable();
            $table->string('address')->nullable();
            $table->string('password');
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_active')->default(false);
            $table->string('profile')->nullable();
            $table->text('attachments')->nullable();
            $table->boolean('has_active_subscription')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('designers');
    }
};

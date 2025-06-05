<?php

use App\Models\BankAccount;
use App\Models\Plan;
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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Plan::class)->nullable();
            $table->foreignIdFor(BankAccount::class)->nullable();
            $table->morphs('subscribable');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('active');
            $table->string('receipt')->nullable();
            $table->decimal('amount', 10, 2);
            $table->boolean('is_approved')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};

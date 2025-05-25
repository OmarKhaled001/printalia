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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->morphs('subscribable'); // designer or factory
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default('active'); // active - pending - cancelled
            $table->string('receipt')->nullable(); // إيصال الدفع
            $table->boolean('is_approved')->default(false); // مراجعة الإيصال
            $table->text('notes')->nullable(); // ملاحظات
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

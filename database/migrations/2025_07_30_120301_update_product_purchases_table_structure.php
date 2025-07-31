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
        Schema::table('product_purchases', function (Blueprint $table) {
            // Drop columns that are not needed
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropForeign(['payment_method_id']);
            $table->dropColumn('payment_method_id');
            $table->dropColumn('page_name');
            $table->dropColumn('transaction_id');
            $table->dropColumn('payment_status');
            
            // Add status column
            $table->enum('status', ['pending', 'success', 'failed', 'challenge'])->default('pending')->after('total_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_purchases', function (Blueprint $table) {
            // Re-add dropped columns
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained()->onDelete('cascade');
            $table->string('page_name');
            $table->string('transaction_id')->nullable();
            $table->enum('payment_status', ['pending', 'success', 'failed'])->default('pending');
            
            // Drop status column
            $table->dropColumn('status');
        });
    }
}; 
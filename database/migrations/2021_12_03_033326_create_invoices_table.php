<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('payment_method_id')->nullable();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onUpdate('cascade')->onDelete('cascade');
            $table->string('order_id', 255)->nullable();
            $table->string('transaction_id', 255)->nullable();
            $table->string('information_id', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->tinyInteger('type')->nullable()->default(0);
            $table->string('payment_type', 50)->nullable();
            $table->double('gross_amount');
            $table->string('status', 25);
            $table->string('notes', 255)->nullable();
            $table->string('link', 255)->nullable();
            $table->dateTime('due_date')->nullable();
            $table->dateTime('date_canceled')->nullable();
            $table->dateTime('date_paid')->nullable();
            $table->string('pg_fee', 10)->nullable();
            $table->double('pg_amount')->nullable();
            $table->string('platform_fee', 10)->nullable();
            $table->double('platform_amount')->nullable();
            $table->double('creator_amount')->nullable();
            $table->dateTime('date_active')->nullable();
            $table->tinyInteger('is_amount_active')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}

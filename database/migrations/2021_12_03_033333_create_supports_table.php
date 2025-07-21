<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->unsignedBigInteger('supporter_id')->nullable();
            $table->unsignedBigInteger('content_id')->nullable();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('goal_id')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->text('message')->nullable();
            $table->unsignedTinyInteger('is_anonim')->nullable()->default(0);
            $table->unsignedTinyInteger('is_private')->nullable()->default(0);
            $table->unsignedTinyInteger('type')->nullable()->default(0);
            $table->unsignedTinyInteger('status')->nullable()->default(0);
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->timestamps();

            $table->foreign('creator_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('supporter_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('content_id')->references('id')->on('contents')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('goal_id')->references('id')->on('goals')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('supports');
    }
}

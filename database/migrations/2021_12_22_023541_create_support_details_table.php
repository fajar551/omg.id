<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('support_id');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->double('price')->default(0);
            $table->unsignedInteger('qty')->default(0);
            $table->double('total')->default(0);
            $table->timestamps();
            
            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('support_id')->references('id')->on('supports')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('support_details');
    }
}

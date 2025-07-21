<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('image', 255);
            $table->tinyInteger('category');
            $table->unsignedDouble('price')->default(0);
            $table->string('directory_name', 255);
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
        Schema::dropIfExists('pages_templates');
    }
}

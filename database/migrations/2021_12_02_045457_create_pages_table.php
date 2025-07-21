<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name', 50)->nullable();
            $table->string('avatar', 255)->nullable();
            $table->string('cover_image', 255)->nullable();
            $table->string('page_url', 255);
            $table->string('video', 255)->nullable();
            $table->text('bio')->nullable();
            $table->text('summary')->nullable();
            $table->unsignedBigInteger('info_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('template_id')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->default(0);
            $table->unsignedTinyInteger('sensitive_content')->nullable()->default(0);
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('info_id')->references('id')->on('user_infos')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('pages_categories')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('template_id')->references('id')->on('pages_templates')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->string('thumbnail', 255)->nullable(true)->change();
            $table->text('content')->nullable(true)->change();
            $table->json('body')->nullable(true)->after('content');
            $table->boolean('sensitive_content')->default(0)->change();

            $table->dropForeign(['category_id']);
            $table->dropForeign(['item_id']);
            $table->foreign('category_id')->references('id')->on('content_categories')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contents', function (Blueprint $table) {
            $table->string('thumbnail', 255)->nullable(true)->change();
            $table->text('content')->nullable(true)->change();
            $table->boolean('sensitive_content')->nullable(false)->change();
            $table->dropColumn(['body']);

            $table->dropForeign(['category_id']);
            $table->dropForeign(['item_id']);
            $table->foreign('category_id')->references('id')->on('content_categories')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade')->onDelete('cascade');
        });
    }
}

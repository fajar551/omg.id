<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTypeToProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('type')->default('digital')->after('is_hidden');
            $table->integer('stock')->default(0)->after('type');
            $table->string('ecourse_url')->nullable()->after('stock');
            $table->integer('ecourse_duration')->nullable()->after('ecourse_url');
            $table->string('ebook_file')->nullable()->after('ecourse_duration');
            $table->integer('ebook_pages')->nullable()->after('ebook_file');
            $table->string('digital_file')->nullable()->after('ebook_pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['type', 'stock', 'ecourse_url', 'ecourse_duration', 'ebook_file', 'ebook_pages', 'digital_file']);
        });
    }
}

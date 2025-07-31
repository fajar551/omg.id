<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->tinyInteger('visibility')->after("setting")->default(1)->nullable();
            $table->text('description')->nullable()->change();
            $table->dropColumn('setting');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('goals', function (Blueprint $table) {
            $table->tinyInteger('setting')->after('visibility');
            $table->string('description', 255)->nullable()->change();
            $table->dropColumn('visibility');
        });
    }
}

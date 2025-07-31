<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(["name", "type", "value"]);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->after("id")->nullable();
            $table->string('name', 100)->after("user_id");
            $table->tinyInteger('type')->unsigned()->default(0)->after("name");
            $table->text('value')->nullable()->after("type");

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropForeign(["user_id"]);
            $table->dropColumn(["name", "type", "value", "user_id"]);
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->string('name', 50)->after("id");
            $table->tinyInteger('type')->after("name");
            $table->string('value', 255)->after("type");
        });
    }
}

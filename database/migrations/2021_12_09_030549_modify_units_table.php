<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('units', function (Blueprint $table) {
            $table->renameColumn('unit_icon', 'icon');
        });

        Schema::table('users_units', function (Blueprint $table) {
            $table->renameColumn('unit_id', 'item_id');
        });

        Schema::rename('units', 'items');
        Schema::rename('users_units', 'user_items');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->renameColumn('icon', 'unit_icon');
        });

        Schema::table('user_items', function (Blueprint $table) {
            $table->renameColumn('item_id', 'unit_id');
        });

        Schema::rename('items', 'units');
        Schema::rename('user_items', 'users_units');
    }
}

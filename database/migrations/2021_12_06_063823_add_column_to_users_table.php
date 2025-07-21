<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string("username")->after("name")->nullable()->unique();
            $table->string("gender", 12)->after("password")->nullable();
            $table->string("profile_picture", 255)->after("gender")->nullable();
            $table->text("address")->after("profile_picture")->nullable();
            $table->text("address_city")->after("address")->nullable();
            $table->text("address_province")->after("address_city")->nullable();
            $table->text("address_district")->after("address_province")->nullable();
            $table->tinyInteger("status")->after("address_district")->nullable()->unsigned()->default(0);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn([
                'status', 
                'address_district', 
                'address_province',
                'address_city',
                'address',
                'profile_picture',
                'gender',
                'username',
            ]);
        });
    }
}

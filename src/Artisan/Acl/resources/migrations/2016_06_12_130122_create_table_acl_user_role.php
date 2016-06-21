<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAclUserRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl_user_role', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->comment('用户id')->default(0);
            $table->integer('role_id')->comment('角色id')->default(0);
            $table->unique(['user_id', 'role_id']);

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
        Schema::drop('acl_user_role');
    }
}

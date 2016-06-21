<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAclRolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl_role_permission', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('role_id')->default(0)->comment('角色id');
            $table->integer('permission_id')->default(0)->comment('权限id');

            $table->unique(['role_id', 'permission_id']);

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
        Schema::drop('acl_role_permission');
    }
}

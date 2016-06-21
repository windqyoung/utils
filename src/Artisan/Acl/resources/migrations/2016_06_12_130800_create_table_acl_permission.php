<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAclPermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acl_permission', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title')->unique()->comment('权限的名字, 因为使用name容易和route_name混, 改名叫title');
            $table->string('comment')->default('')->comment('具体说明');
            $table->string('permission')->default('')->comment('一个特殊的权限字符串');
            $table->string('route_name')->default('')->comment('路由里面的名字, 比如 site.index, ...');
            $table->string('method')->default('')->comment('http请求方法, GET, POST, ...');
            $table->string('uri_pattern')->default('')->comment('使用str_is来比较当前uri');
            $table->string('unique_tag')->unique()->default('')->comment('一个标识, 查询一个权限是否已添加时, 使用这字段来判断');

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
        Schema::drop('acl_permission');
    }
}

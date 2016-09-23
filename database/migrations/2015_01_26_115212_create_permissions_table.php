<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->string('model')->nullable();
            $table->unsignedInteger('parent_id')->comment('父级id');
            $table->unsignedTinyInteger('is_show')->comment('是否显示');
            $table->string('url')->comment('跳转地址');
            $table->string('icon')->comment('图标');
            $table->unsignedInteger('sort_order')->comment('排序');
            $table->unsignedTinyInteger('is_admin')->comment('管理员专用');
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
        Schema::drop('permissions');
    }
}

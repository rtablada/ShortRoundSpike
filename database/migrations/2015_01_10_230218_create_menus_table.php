<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('position')->nullable();
            $table->string('url')->nullable();
            $table->string('slug');
            $table->string('name');
            $table->integer('parent_id')->nullable();
            $table->string('base_url')->nullable();
            $table->string('class')->nullable();
            $table->string('regex')->nullable();
            $table->string('target')->default('_self');
            $table->boolean('active')->default(1);

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
		Schema::drop('menus');
	}

}

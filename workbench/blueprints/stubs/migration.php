<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Create{{ modelUpperPlural }}Table extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('{{ tableName }}', function(Blueprint $table)
        {
            {% if increments %}$table->increments('{{ increments }}'); {% endif %}


            {% for column in columns %}$table->{{ column.type }}('{{ column.name }}'{% if column.arg1 %}, {{ column.arg1 }}{% if column.arg2 %}, {{ column.arg2 }}{% endif %}{% endif %}){% if column.nullable %}->nullable(){% endif %}{% if column.unique %}->unique(){% endif %}{% if column.default is not null %}->default({{ column.default }}){% endif %}{% if column.unsigned %}->unsigned(){% endif %};
            {% endfor %}


            {% for attachment in attachments %}$table->string('{{ attachment.name }}_file_name')->nullable();
            $table->integer('{{ attachment.name }}_file_size')->nullable();
            $table->string('{{ attachment.name }}_content_type')->nullable();
            $table->timestamp('{{ attachment.name }}_updated_at')->nullable();
            {% endfor %}

            {% if position %}$table->integer('position')->nullable();{% endif %}

            {% if rememberToken %}$table->rememberToken();{% endif %}

            {% if timestamps %}$table->timestamps();{% endif %}

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('{{ tableName }}');
    }

}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Добавление таблицы `operation`.
 */
class CreateOperationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amount')->nullable(false);
            $table->tinyInteger('status')->nullable(false);
            $table->unsignedInteger('user_id')->nullable(false);
            $table->date('action_at')->nullable(false);
            $table->text('description');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('user')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('operation');
    }
}

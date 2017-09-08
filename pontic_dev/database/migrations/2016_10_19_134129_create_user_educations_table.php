<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserEducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_education', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('qualification');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('location');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('user_education');
    }
}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserExperienceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_exprience', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('office_name');
            $table->string('position');
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
        Schema::drop('user_exprience');
    }
}

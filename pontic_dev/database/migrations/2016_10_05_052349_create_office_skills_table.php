<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeSkillsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('office_skills', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id');
            $table->integer('skill_id');
            $table->bigInteger('create_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('office_skills');
    }

}

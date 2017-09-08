<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeOpeningHoursTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('office_opening_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id');
            $table->string('day');
            $table->string('start_time');
            $table->string('end_time');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('office_opening_hours');
    }

}

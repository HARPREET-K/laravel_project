<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type_id');
            $table->string('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('hourly_rate');
            $table->string('estimated_cost');
            $table->string('description');
            $table->enum('is_completed', ['0', '1', '2', '3']);
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
        Schema::drop('jobs');
    }

}

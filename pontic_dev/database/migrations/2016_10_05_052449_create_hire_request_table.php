<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHireRequestTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('hire_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('office_id');
            $table->integer('job_id');
            $table->string('attachment_url');
            $table->string('additional_information');
            $table->enum('is_accepted', ['0', '1', '2']);
            $table->enum('is_requested', ['0', '1']);
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
        Schema::drop('hire_request');
    }

}

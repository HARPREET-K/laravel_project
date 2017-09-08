<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCertificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('user_certifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('certification');
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
        Schema::drop('user_certifications');
    }
}

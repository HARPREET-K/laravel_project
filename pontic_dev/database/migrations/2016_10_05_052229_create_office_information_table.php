<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeInformationTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('office_information', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email');
            $table->string('website');
            $table->string('office_speciality');
            $table->string('contact_person_name');
            $table->string('job_position');
            $table->string('street');
            $table->string('city');
            $table->string('zipcode');
            $table->string('phone_number');
            $table->string('aditional_number');
            $table->string('note');
            $table->bigInteger('created_at');
            $table->bigInteger('updated_at');
            $table->enum('email_notifications', ['0', '1']);
            $table->enum('make_private', ['0', '1']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('office_information');
    }

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeDentistsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('office_dentists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id');
            $table->string('name');
            $table->string('titile');
            $table->string('credential');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('office_dentists');
    }

}

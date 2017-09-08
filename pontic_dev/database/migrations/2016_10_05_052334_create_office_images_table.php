<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficeImagesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void 
     */
    public function up() {
        Schema::create('office_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('office_id');
            $table->string('image_url');
            $table->bigInteger('create_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('office_images');
    }

}

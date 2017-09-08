<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSettingsToUsers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('users', function ($table) {
            $table->dropColumn([ 'created_at', 'updated_at']);
        });
        Schema::table('users', function ($table) {
            $table->string('profile_image');
            $table->string('title');
            $table->integer('user_type_id');
            $table->string('experience');
            $table->string('expected_pay');
            $table->string('state_license');
            $table->string('mobile_number');
            $table->string('aditional_number');
            $table->string('street');
            $table->integer('city');
            $table->integer('state');
            $table->string('zipcode');
            $table->string('user_note');
            $table->integer('email_notifications');
            $table->integer('make_private');
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
        //
    }

}

<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_profile', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->string('password', 60);
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->primary('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admins_profile');
    }
}

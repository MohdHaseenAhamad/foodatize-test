<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name','100')->unique()->nullable();
            $table->string('phone_number','25')->nullable();
            $table->string('phone_otp','10')->nullable();
            $table->dateTime('phone_otp_time')->nullable()->default(NULL);
            $table->tinyInteger('phone_status')->nullable()->default(0);
            $table->string('email','100')->unique()->nullable();
            $table->string('email_otp','10')->nullable();
            $table->dateTime('email_otp_time')->nullable()->default(NULL);
            $table->tinyInteger('email_status')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

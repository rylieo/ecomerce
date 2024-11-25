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
            $table->id(); // Kolom id auto-increment
            $table->string('name'); // Nama pengguna
            $table->string('email')->unique(); // Alamat email unik
            $table->string('password'); // Kata sandi pengguna
            $table->string('verification_token')->nullable(); // Token verifikasi acak
            $table->timestamp('email_verified_at')->nullable(); // Tanggal verifikasi email
            $table->rememberToken(); // Token untuk "remember me"
            $table->timestamps(); // Tanggal pembuatan dan pembaruan
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('verification_token');
            });
    }
}

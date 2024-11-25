<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::table('categories', function (Blueprint $table) {
        $table->string('color')->default('#ffffff'); // menambahkan kolom warna
    });
}

public function down()
{
    Schema::table('categories', function (Blueprint $table) {
        $table->dropColumn('color'); // menghapus kolom warna jika rollback
    });
}

};

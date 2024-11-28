<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('id_member')->change(); // Ubah tipe data id_member di tabel user menjadi string
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('id_member')->change(); // Kembalikan ke integer. awalnya memang integer tetapi tidak bisa mneyimpan 0 didepan, jd ganti menjadi string
        });    
    }
};

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
        Schema::create('pengajuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_buku");
            $table->unsignedBigInteger("id_user");
            $table->date("tanggal_peminjaman");
            $table->date("tanggal_pengembalian");
            $table->enum("status", ["pending", "approved", "rejected", "returned"])->default("pending");
            $table->timestamps();
            $table->foreign('id_buku')->references('id')->on('buku')->onDelete("CASCADE")->onUpdate("CASCADE");
            $table->foreign('id_user')->references('id')->on('users')->onDelete("CASCADE")->onUpdate("CASCADE");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan');
    }
};

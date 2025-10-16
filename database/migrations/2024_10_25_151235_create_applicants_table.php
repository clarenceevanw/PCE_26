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
        Schema::create('applicants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_lengkap');
            $table->string('nrp')->unique();
            $table->integer('angkatan');
            $table->string('prodi');
            $table->string('line_id');
            $table->string('no_hp');
            $table->uuid('division_choice1');
            $table->foreign('division_choice1')->references('id')->on('divisions')->onDelete('cascade');
            $table->uuid('division_choice2');
            $table->foreign('division_choice2')->references('id')->on('divisions')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

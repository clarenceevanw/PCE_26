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
        Schema::create('admins', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('division_id');
            $table->string('nrp');
            $table->string('name');
            $table->string('anonymous_name');
            $table->string('id_line')->nullable();
            $table->string('link_gmeet')->nullable();
            $table->string('location')->nullable();
            $table->foreign('division_id')->references('id')->on('divisions');
            $table->string('position');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};

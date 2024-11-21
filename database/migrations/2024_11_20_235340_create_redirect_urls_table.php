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
        Schema::create('redirect_urls', function (Blueprint $table) {
            $table->id();
            $table->string('code', 255);
            $table->string('url', 255);
            $table->string('title', 255)->nullable();
            $table->integer('hits')->default(0);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->string('banner_image')->nullable();
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('redirect_urls');
    }
};
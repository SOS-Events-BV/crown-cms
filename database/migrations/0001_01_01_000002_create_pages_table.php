<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique(); // Unique slug for page, can be with slashes

            // Content
            $table->json('content');

            // Settings
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};

<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();

            $table->string('reservation_hash')->unique();
            $table->string('firstname');
            $table->string('lastname')->nullable();
            $table->integer('stars');
            $table->text('review')->nullable();
            $table->text('reaction')->nullable();
            $table->string('language', 10);
            $table->timestamp('review_placed'); // Review placed in the review tool
            $table->json('extra_attributes')->nullable();
            $table->boolean('is_visible')->default(true);

            // Added / updated in the website
            $table->timestamps();
        });
    }
};

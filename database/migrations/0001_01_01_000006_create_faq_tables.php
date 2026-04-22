<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Categories for questions
        Schema::create('faq_page_categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->text('description')->nullable();

            $table->timestamps();
        });

        // Questions, with a category
        Schema::create('faq_page_questions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('faq_page_category_id')->constrained()->onDelete('cascade');
            $table->string('question');
            $table->text('answer');

            $table->timestamps();
        });
    }
};

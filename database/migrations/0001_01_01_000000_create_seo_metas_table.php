<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_metas', function (Blueprint $table) {
            $table->id();

            $table->morphs('seoable'); // Polymorphic relationship (view Laravel docs for more info)

            // SEO
            $table->string('page_title')->comment('HTML title tag');
            $table->string('page_description', 255)->comment('HTML meta description tag');
            $table->string('page_keywords', 255)->comment('HTML meta keywords tag')->nullable();

            // OG
            $table->string('og_title')->comment('HTML meta og:title tag')->nullable();
            $table->string('og_description', 255)->comment('HTML meta og:description tag')->nullable();
            $table->string('og_image')->comment('HTML meta og:image tag')->nullable();

            $table->timestamps();
        });
    }
};

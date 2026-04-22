<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('page_id')
                ->comment('The page this event belongs to. If null, there is no page or more info button to a page.')
                ->nullable()
                ->constrained()
                ->nullOnDelete();
            $table->string('name');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->text('summary')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }
};

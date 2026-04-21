<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();

            $table->string('name', 50)->comment('Euro, US Dollar, British Pound e.g.');
            $table->string('code', 3)->comment('EUR, USD, GBP e.g.');
            $table->string('symbol', 3)->comment('€, $, £ e.g.');
            $table->decimal('exchange_rate', 10, 5)->comment('From EUR to currency');

            $table->timestamps();
        });
    }
};

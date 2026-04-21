<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Categories page and category for products
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->comment('Rich editable');
            $table->json('example_time_schemes')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });

        // Products page
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Product
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('summary')->comment('Small text for products page')->nullable();
            $table->text('description')->nullable();
            $table->enum('book_option', ['book_now', 'forward', 'quotation'])
                ->comment('How to book the product: book_now, forward, quotation')
                ->default('book_now');

            // If book_option is forward, we need to know where to forward to and what to display on the forward modal
            $table->text('forward_url')
                ->comment('URL to forward to, if `book_option` is forward')->nullable();
            $table->string("forward_title")
                ->comment("Title to display on the forward modal.")->nullable();
            $table->string("forward_description")
                ->comment("Description to display on the forward modal.")->nullable();

            // LeisureKing values
            $table->string('leisureking_id')->nullable();
            $table->string('leisureking_bookingmodule_hash')->nullable();
            $table->json('excluded_fields_lk_sync')
                ->comment('Fields to exclude from syncing with LeisureKing.')
                ->nullable();

            // Package fields (if is_package is true)
            $table->json('time_schemes')->nullable();

            // Optional fields
            $table->string('location')->nullable();
            $table->integer('min_persons')->nullable();
            $table->integer('max_persons')->nullable();
            $table->json('faqs')->nullable();

            // Settings
            $table->boolean('is_package')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });

        // Multiple prices per product, per currency
        Schema::create('product_prices', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('currency_id')->constrained('currencies')->cascadeOnDelete();

            // Price
            $table->decimal('amount', 8, 2)->nullable();
            $table->boolean('includes_vat')->default(true);
            $table->string('label')->nullable(); // Volwassenentarief, kindertarief e.g.
            $table->time('from_time')->nullable();
            $table->time('to_time')->nullable();
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });

        // Pivot table for linking category and product
        Schema::create('category_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }
};

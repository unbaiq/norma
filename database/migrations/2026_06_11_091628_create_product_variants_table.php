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
        Schema::create('product_variants', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Product Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Variant Information
            |--------------------------------------------------------------------------
            */

            $table->string('variant_code')
                ->unique();

            $table->string('name');

            $table->string('sku')
                ->unique();

            $table->string('barcode')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Variant Attributes
            |--------------------------------------------------------------------------
            */

            $table->string('size')
                ->nullable();

            $table->string('color')
                ->nullable();

            $table->string('material')
                ->nullable();

            $table->string('model')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            $table->decimal('cost_price', 12, 2)
                ->default(0);

            $table->decimal('mrp', 12, 2)
                ->default(0);

            $table->decimal('selling_price', 12, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Inventory
            |--------------------------------------------------------------------------
            */

            $table->integer('stock_quantity')
                ->default(0);

            $table->integer('minimum_stock')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Physical Attributes
            |--------------------------------------------------------------------------
            */

            $table->decimal('weight', 10, 2)
                ->nullable();

            $table->decimal('length', 10, 2)
                ->nullable();

            $table->decimal('width', 10, 2)
                ->nullable();

            $table->decimal('height', 10, 2)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Images
            |--------------------------------------------------------------------------
            */

            $table->string('image')
                ->nullable();

            $table->json('gallery')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_default')
                ->default(false);

            $table->boolean('is_active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Additional Data
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('product_id');
            $table->index('variant_code');
            $table->index('sku');
            $table->index('size');
            $table->index('is_active');
            $table->index('is_default');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
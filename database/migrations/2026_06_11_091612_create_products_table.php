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
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Product Information
            |--------------------------------------------------------------------------
            */

            $table->string('product_code')->unique();

            $table->foreignId('product_category_id')
                ->constrained('product_categories')
                ->cascadeOnDelete();

            $table->string('name');

            $table->string('slug')->unique();

            $table->string('sku')->unique();

            $table->string('barcode')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Product Details
            |--------------------------------------------------------------------------
            */

            $table->text('short_description')->nullable();

            $table->longText('description')->nullable();

            $table->longText('features')->nullable();

            $table->longText('benefits')->nullable();

            $table->longText('usage_instructions')->nullable();

            $table->longText('contraindications')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Healthcare Mapping
            |--------------------------------------------------------------------------
            */

            $table->string('problem_category')->nullable();

            $table->string('affected_area')->nullable();

            $table->string('medical_condition')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Product Images
            |--------------------------------------------------------------------------
            */

            $table->string('thumbnail')->nullable();

            $table->string('image')->nullable();

            $table->json('gallery')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            $table->decimal('cost_price', 12, 2)->default(0);

            $table->decimal('mrp', 12, 2)->default(0);

            $table->decimal('selling_price', 12, 2)->default(0);

            $table->decimal('tax_percentage', 5, 2)->default(0);

            /*
            |--------------------------------------------------------------------------
            | Inventory
            |--------------------------------------------------------------------------
            */

            $table->integer('stock_quantity')->default(0);

            $table->integer('minimum_stock')->default(0);

            $table->integer('maximum_stock')->default(0);

            /*
            |--------------------------------------------------------------------------
            | Physical Attributes
            |--------------------------------------------------------------------------
            */

            $table->decimal('weight', 10, 2)->nullable();

            $table->decimal('length', 10, 2)->nullable();

            $table->decimal('width', 10, 2)->nullable();

            $table->decimal('height', 10, 2)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Product Type
            |--------------------------------------------------------------------------
            */

            $table->enum('product_type', [
                'simple',
                'variable',
                'bundle',
                'custom'
            ])->default('simple');

            /*
            |--------------------------------------------------------------------------
            | Product Lifecycle
            |--------------------------------------------------------------------------
            */

            $table->integer('warranty_days')->nullable();

            $table->integer('replacement_days')->nullable();

            $table->integer('expected_lifespan_days')->nullable();

            /*
            |--------------------------------------------------------------------------
            | AI Recommendation
            |--------------------------------------------------------------------------
            */

            $table->boolean('ai_recommendable')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Visibility
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_featured')
                ->default(false);

            $table->boolean('is_active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | SEO
            |--------------------------------------------------------------------------
            */

            $table->string('meta_title')->nullable();

            $table->text('meta_description')->nullable();

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

            $table->json('meta')->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('product_code');
            $table->index('product_category_id');
            $table->index('sku');
            $table->index('barcode');
            $table->index('problem_category');
            $table->index('affected_area');
            $table->index('is_active');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
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
        Schema::create('order_items', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Order Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Product Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('product_id')
                ->constrained('products')
                ->restrictOnDelete();

            $table->foreignId('product_variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Recommendation Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('product_recommendation_id')
                ->nullable()
                ->constrained('product_recommendations')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Product Snapshot
            |--------------------------------------------------------------------------
            */

            $table->string('product_name');

            $table->string('product_code')
                ->nullable();

            $table->string('sku')
                ->nullable();

            $table->string('variant_name')
                ->nullable();

            $table->string('size')
                ->nullable();

            $table->string('color')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Quantity
            |--------------------------------------------------------------------------
            */

            $table->integer('quantity')
                ->default(1);

            /*
            |--------------------------------------------------------------------------
            | Pricing Snapshot
            |--------------------------------------------------------------------------
            */

            $table->decimal('unit_cost_price', 12, 2)
                ->default(0);

            $table->decimal('unit_mrp', 12, 2)
                ->default(0);

            $table->decimal('unit_price', 12, 2)
                ->default(0);

            $table->decimal('discount_amount', 12, 2)
                ->default(0);

            $table->decimal('tax_amount', 12, 2)
                ->default(0);

            $table->decimal('line_total', 12, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Measurement Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('measurement_id')
                ->nullable()
                ->constrained('measurements')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Delivery Tracking
            |--------------------------------------------------------------------------
            */

            $table->integer('delivered_quantity')
                ->default(0);

            $table->integer('returned_quantity')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Item Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'confirmed',
                'processing',
                'packed',
                'dispatched',
                'delivered',
                'cancelled',
                'returned',
                'replaced'
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Warranty
            |--------------------------------------------------------------------------
            */

            $table->date('warranty_start_date')
                ->nullable();

            $table->date('warranty_end_date')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Product Lifecycle
            |--------------------------------------------------------------------------
            */

            $table->date('replacement_due_date')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Customer Feedback
            |--------------------------------------------------------------------------
            */

            $table->decimal('rating', 3, 2)
                ->nullable();

            $table->text('review')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            $table->longText('notes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Metadata
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

            $table->index('order_id');
            $table->index('product_id');
            $table->index('product_variant_id');
            $table->index('product_recommendation_id');
            $table->index('measurement_id');
            $table->index('status');
            $table->index('replacement_due_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
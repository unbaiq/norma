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
        Schema::create('inventories', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Product Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('product_variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Inventory Owner
            |--------------------------------------------------------------------------
            */

            $table->enum('owner_type', [
                'warehouse',
                'distributor',
                'chemist',
                'store',
                'transit'
            ]);

            $table->unsignedBigInteger('owner_id');

            /*
            |--------------------------------------------------------------------------
            | Stock Information
            |--------------------------------------------------------------------------
            */

            $table->integer('opening_stock')
                ->default(0);

            $table->integer('available_stock')
                ->default(0);

            $table->integer('reserved_stock')
                ->default(0);

            $table->integer('damaged_stock')
                ->default(0);

            $table->integer('returned_stock')
                ->default(0);

            $table->integer('in_transit_stock')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Reorder
            |--------------------------------------------------------------------------
            */

            $table->integer('minimum_stock')
                ->default(0);

            $table->integer('maximum_stock')
                ->default(0);

            $table->integer('reorder_level')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Batch Information
            |--------------------------------------------------------------------------
            */

            $table->string('batch_number')
                ->nullable();

            $table->date('manufacturing_date')
                ->nullable();

            $table->date('expiry_date')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Costing
            |--------------------------------------------------------------------------
            */

            $table->decimal('purchase_price', 12, 2)
                ->default(0);

            $table->decimal('selling_price', 12, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'low_stock',
                'out_of_stock',
                'expired',
                'blocked'
            ])->default('active');

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
            | Unique Inventory Record
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'product_id',
                'product_variant_id',
                'owner_type',
                'owner_id',
                'batch_number'
            ], 'inventory_unique_record');

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('product_id');
            $table->index('product_variant_id');
            $table->index('owner_type');
            $table->index('owner_id');
            $table->index('status');
            $table->index('expiry_date');
            $table->index('batch_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
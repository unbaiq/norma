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
        Schema::create('stock_movements', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Movement Information
            |--------------------------------------------------------------------------
            */

            $table->string('movement_number')->unique();

            $table->enum('movement_type', [
                'warehouse_to_warehouse',
                'warehouse_to_distributor',
                'distributor_to_chemist',
                'warehouse_to_customer',
                'return',
                'replacement',
                'transfer',
                'adjustment'
            ]);

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
            | Inventory Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('inventory_id')
                ->nullable()
                ->constrained('inventories')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Source
            |--------------------------------------------------------------------------
            */

            $table->string('source_type');

            $table->unsignedBigInteger('source_id');

            /*
            |--------------------------------------------------------------------------
            | Destination
            |--------------------------------------------------------------------------
            */

            $table->string('destination_type');

            $table->unsignedBigInteger('destination_id');

            /*
            |--------------------------------------------------------------------------
            | Quantity
            |--------------------------------------------------------------------------
            */

            $table->integer('quantity');

            $table->integer('received_quantity')
                ->default(0);

            $table->integer('damaged_quantity')
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
            | Related References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            $table->foreignId('order_item_id')
                ->nullable()
                ->constrained('order_items')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Logistics
            |--------------------------------------------------------------------------
            */

            $table->string('vehicle_number')
                ->nullable();

            $table->string('driver_name')
                ->nullable();

            $table->string('driver_mobile')
                ->nullable();

            $table->string('tracking_number')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'pending',
                'in_transit',
                'received',
                'partially_received',
                'cancelled',
                'completed'
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Dates
            |--------------------------------------------------------------------------
            */

            $table->timestamp('dispatched_at')
                ->nullable();

            $table->timestamp('received_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->foreignId('received_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

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

            $table->index('movement_number');
            $table->index('movement_type');
            $table->index('product_id');
            $table->index('product_variant_id');
            $table->index('inventory_id');
            $table->index('order_id');
            $table->index('status');
            $table->index('tracking_number');
            $table->index('dispatched_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};
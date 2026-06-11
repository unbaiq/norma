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
        Schema::create('inventory_transactions', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Transaction Information
            |--------------------------------------------------------------------------
            */

            $table->string('transaction_number')
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | Inventory
            |--------------------------------------------------------------------------
            */

            $table->foreignId('inventory_id')
                ->constrained('inventories')
                ->cascadeOnDelete();

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('product_variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Transaction Type
            |--------------------------------------------------------------------------
            */

            $table->enum('transaction_type', [
                'opening_stock',
                'purchase',
                'stock_in',
                'stock_out',
                'order_reserved',
                'order_dispatched',
                'order_delivered',
                'return_in',
                'return_out',
                'damage',
                'expiry',
                'adjustment',
                'transfer_in',
                'transfer_out'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Quantity
            |--------------------------------------------------------------------------
            */

            $table->integer('quantity');

            $table->integer('previous_stock');

            $table->integer('current_stock');

            /*
            |--------------------------------------------------------------------------
            | Cost Information
            |--------------------------------------------------------------------------
            */

            $table->decimal('unit_cost', 12, 2)
                ->default(0);

            $table->decimal('total_cost', 12, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Reference Information
            |--------------------------------------------------------------------------
            */

            $table->string('reference_type')
                ->nullable();

            $table->unsignedBigInteger('reference_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Order References
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
            | Transfer Information
            |--------------------------------------------------------------------------
            */

            $table->string('source_owner_type')
                ->nullable();

            $table->unsignedBigInteger('source_owner_id')
                ->nullable();

            $table->string('destination_owner_type')
                ->nullable();

            $table->unsignedBigInteger('destination_owner_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Batch Information
            |--------------------------------------------------------------------------
            */

            $table->string('batch_number')
                ->nullable();

            $table->date('expiry_date')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Reason
            |--------------------------------------------------------------------------
            */

            $table->string('reason')
                ->nullable();

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'completed',
                'cancelled'
            ])->default('completed');

            /*
            |--------------------------------------------------------------------------
            | Performed By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('performed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Transaction Date
            |--------------------------------------------------------------------------
            */

            $table->timestamp('transaction_date');

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('transaction_number');
            $table->index('inventory_id');
            $table->index('product_id');
            $table->index('product_variant_id');
            $table->index('transaction_type');
            $table->index('order_id');
            $table->index('order_item_id');
            $table->index('transaction_date');

            $table->index([
                'reference_type',
                'reference_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
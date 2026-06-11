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
        Schema::create('inventory_adjustments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Adjustment Information
            |--------------------------------------------------------------------------
            */

            $table->string('adjustment_number')
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | Inventory Reference
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
            | Owner Information
            |--------------------------------------------------------------------------
            */

            $table->string('owner_type');

            $table->unsignedBigInteger('owner_id');

            /*
            |--------------------------------------------------------------------------
            | Adjustment Type
            |--------------------------------------------------------------------------
            */

            $table->enum('adjustment_type', [
                'stock_count',
                'damage',
                'expiry',
                'loss',
                'theft',
                'system_correction',
                'warehouse_correction',
                'chemist_correction',
                'distributor_correction',
                'other'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Stock Details
            |--------------------------------------------------------------------------
            */

            $table->integer('system_stock');

            $table->integer('physical_stock');

            $table->integer('adjustment_quantity');

            /*
            |--------------------------------------------------------------------------
            | Adjustment Direction
            |--------------------------------------------------------------------------
            */

            $table->enum('adjustment_direction', [
                'increase',
                'decrease'
            ]);

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

            $table->string('reason');

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Supporting Documents
            |--------------------------------------------------------------------------
            */

            $table->string('document')
                ->nullable();

            $table->string('photo')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Approval Workflow
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'pending',
                'approved',
                'rejected',
                'completed'
            ])->default('pending');

            $table->foreignId('requested_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Transaction Link
            |--------------------------------------------------------------------------
            */

            $table->foreignId('inventory_transaction_id')
                ->nullable()
                ->constrained('inventory_transactions')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->timestamp('adjustment_date');

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('adjustment_number');
            $table->index('inventory_id');
            $table->index('product_id');
            $table->index('product_variant_id');
            $table->index('owner_type');
            $table->index('owner_id');
            $table->index('adjustment_type');
            $table->index('status');
            $table->index('adjustment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_adjustments');
    }
};
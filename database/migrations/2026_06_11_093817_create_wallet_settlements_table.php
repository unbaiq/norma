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
        Schema::create('wallet_settlements', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Settlement Information
            |--------------------------------------------------------------------------
            */

            $table->string('settlement_number')->unique();

            $table->enum('settlement_type', [
                'commission',
                'bonus',
                'withdrawal',
                'bulk_payout',
                'monthly',
                'quarterly',
                'annual',
                'adjustment'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Wallet Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->cascadeOnDelete();

            $table->string('owner_type');

            $table->unsignedBigInteger('owner_id');

            /*
            |--------------------------------------------------------------------------
            | Settlement Period
            |--------------------------------------------------------------------------
            */

            $table->date('period_start');

            $table->date('period_end');

            /*
            |--------------------------------------------------------------------------
            | Amount Information
            |--------------------------------------------------------------------------
            */

            $table->decimal('gross_amount', 15, 2)
                ->default(0);

            $table->decimal('commission_amount', 15, 2)
                ->default(0);

            $table->decimal('bonus_amount', 15, 2)
                ->default(0);

            $table->decimal('adjustment_amount', 15, 2)
                ->default(0);

            $table->decimal('deduction_amount', 15, 2)
                ->default(0);

            $table->decimal('tds_amount', 15, 2)
                ->default(0);

            $table->decimal('processing_fee', 15, 2)
                ->default(0);

            $table->decimal('net_amount', 15, 2);

            /*
            |--------------------------------------------------------------------------
            | Settlement Statistics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_transactions')
                ->default(0);

            $table->integer('total_orders')
                ->default(0);

            $table->integer('total_deliveries')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Bank Details
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_bank_account_id')
                ->nullable()
                ->constrained('user_bank_accounts')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Payment Information
            |--------------------------------------------------------------------------
            */

            $table->string('payment_method')
                ->nullable();

            $table->string('payment_reference')
                ->nullable();

            $table->string('utr_number')
                ->nullable();

            $table->string('bank_reference')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'pending',
                'approved',
                'processing',
                'settled',
                'failed',
                'cancelled'
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Approval Workflow
            |--------------------------------------------------------------------------
            */

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Settlement Dates
            |--------------------------------------------------------------------------
            */

            $table->timestamp('settled_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            $table->longText('remarks')
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

            $table->index('settlement_number');
            $table->index('wallet_id');
            $table->index('owner_type');
            $table->index('owner_id');
            $table->index('settlement_type');
            $table->index('status');
            $table->index('period_start');
            $table->index('period_end');
            $table->index('settled_at');
            $table->index('utr_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_settlements');
    }
};
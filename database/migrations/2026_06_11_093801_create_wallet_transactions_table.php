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
        Schema::create('wallet_transactions', function (Blueprint $table) {

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
            | Wallet Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('wallet_id')
                ->constrained('wallets')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Owner Information
            |--------------------------------------------------------------------------
            */

            $table->string('owner_type');

            $table->unsignedBigInteger('owner_id');

            /*
            |--------------------------------------------------------------------------
            | Transaction Type
            |--------------------------------------------------------------------------
            */

            $table->enum('transaction_type', [
                'commission_credit',
                'bonus_credit',
                'manual_credit',
                'withdrawal_request',
                'withdrawal_approved',
                'withdrawal_rejected',
                'withdrawal_paid',
                'refund',
                'adjustment',
                'penalty',
                'reversal',
                'debit'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Credit / Debit
            |--------------------------------------------------------------------------
            */

            $table->enum('entry_type', [
                'credit',
                'debit'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Amount Information
            |--------------------------------------------------------------------------
            */

            $table->decimal('amount', 15, 2);

            $table->decimal('opening_balance', 15, 2)
                ->default(0);

            $table->decimal('closing_balance', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Related References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('commission_id')
                ->nullable()
                ->constrained('commissions')
                ->nullOnDelete();

            $table->foreignId('bonus_commission_id')
                ->nullable()
                ->constrained('bonus_commissions')
                ->nullOnDelete();

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            $table->foreignId('delivery_id')
                ->nullable()
                ->constrained('deliveries')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Generic Reference
            |--------------------------------------------------------------------------
            */

            $table->string('reference_type')
                ->nullable();

            $table->unsignedBigInteger('reference_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Payment Information
            |--------------------------------------------------------------------------
            */

            $table->string('payment_reference')
                ->nullable();

            $table->string('utr_number')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'cancelled',
                'reversed'
            ])->default('completed');

            /*
            |--------------------------------------------------------------------------
            | Description
            |--------------------------------------------------------------------------
            */

            $table->string('title')
                ->nullable();

            $table->text('description')
                ->nullable();

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Processing
            |--------------------------------------------------------------------------
            */

            $table->foreignId('processed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('processed_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Transaction Date
            |--------------------------------------------------------------------------
            */

            $table->timestamp('transaction_date');

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

            $table->index('transaction_number');
            $table->index('wallet_id');
            $table->index('owner_type');
            $table->index('owner_id');
            $table->index('transaction_type');
            $table->index('entry_type');
            $table->index('commission_id');
            $table->index('bonus_commission_id');
            $table->index('order_id');
            $table->index('delivery_id');
            $table->index('status');
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
        Schema::dropIfExists('wallet_transactions');
    }
};
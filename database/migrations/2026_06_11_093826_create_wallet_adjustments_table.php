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
        Schema::create('wallet_adjustments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Adjustment Information
            |--------------------------------------------------------------------------
            */

            $table->string('adjustment_number')->unique();

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
            | Adjustment Type
            |--------------------------------------------------------------------------
            */

            $table->enum('adjustment_type', [
                'credit',
                'debit',
                'refund',
                'penalty',
                'commission_correction',
                'bonus_correction',
                'withdrawal_correction',
                'settlement_correction',
                'fraud_recovery',
                'system_correction',
                'manual_adjustment'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Financial Information
            |--------------------------------------------------------------------------
            */

            $table->decimal('amount', 15, 2);

            $table->decimal('opening_balance', 15, 2)
                ->default(0);

            $table->decimal('closing_balance', 15, 2)
                ->default(0);

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

            $table->foreignId('wallet_transaction_id')
                ->nullable()
                ->constrained('wallet_transactions')
                ->nullOnDelete();

            $table->foreignId('wallet_withdrawal_id')
                ->nullable()
                ->constrained('wallet_withdrawals')
                ->nullOnDelete();

            $table->foreignId('wallet_settlement_id')
                ->nullable()
                ->constrained('wallet_settlements')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Supporting Documents
            |--------------------------------------------------------------------------
            */

            $table->string('document')
                ->nullable();

            $table->string('attachment')
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
                'processed',
                'cancelled'
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
            | Adjustment Date
            |--------------------------------------------------------------------------
            */

            $table->timestamp('adjustment_date');

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

            $table->index('adjustment_number');
            $table->index('wallet_id');
            $table->index('owner_type');
            $table->index('owner_id');
            $table->index('adjustment_type');
            $table->index('status');
            $table->index('adjustment_date');
            $table->index('requested_by');
            $table->index('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_adjustments');
    }
};
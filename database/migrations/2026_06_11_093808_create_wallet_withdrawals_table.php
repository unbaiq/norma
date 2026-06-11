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
        Schema::create('wallet_withdrawals', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Withdrawal Information
            |--------------------------------------------------------------------------
            */

            $table->string('withdrawal_number')->unique();

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
            | Bank Account
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_bank_account_id')
                ->nullable()
                ->constrained('user_bank_accounts')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Amount Details
            |--------------------------------------------------------------------------
            */

            $table->decimal('requested_amount', 15, 2);

            $table->decimal('processing_fee', 15, 2)
                ->default(0);

            $table->decimal('tds_amount', 15, 2)
                ->default(0);

            $table->decimal('net_amount', 15, 2);

            /*
            |--------------------------------------------------------------------------
            | Wallet Snapshot
            |--------------------------------------------------------------------------
            */

            $table->decimal('wallet_balance', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'under_review',
                'approved',
                'processing',
                'completed',
                'rejected',
                'cancelled',
                'failed'
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

            $table->text('rejection_reason')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Payment Processing
            |--------------------------------------------------------------------------
            */

            $table->string('payment_method')
                ->nullable();

            $table->string('transaction_reference')
                ->nullable();

            $table->string('utr_number')
                ->nullable();

            $table->string('bank_reference')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Transaction References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('wallet_transaction_id')
                ->nullable()
                ->constrained('wallet_transactions')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Dates
            |--------------------------------------------------------------------------
            */

            $table->timestamp('requested_at');

            $table->timestamp('processed_at')
                ->nullable();

            $table->timestamp('completed_at')
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

            $table->index('withdrawal_number');
            $table->index('wallet_id');
            $table->index('owner_type');
            $table->index('owner_id');
            $table->index('user_bank_account_id');
            $table->index('status');
            $table->index('requested_at');
            $table->index('approved_at');
            $table->index('completed_at');
            $table->index('utr_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_withdrawals');
    }
};
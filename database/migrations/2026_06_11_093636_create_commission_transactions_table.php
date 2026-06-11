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
        Schema::create('commission_transactions', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Transaction Information
            |--------------------------------------------------------------------------
            */

            $table->string('transaction_number')->unique();

            /*
            |--------------------------------------------------------------------------
            | Commission Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('commission_id')
                ->constrained('commissions')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Wallet Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('wallet_id')
                ->nullable()
                ->constrained('wallets')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Beneficiary
            |--------------------------------------------------------------------------
            */

            $table->string('beneficiary_type');

            $table->unsignedBigInteger('beneficiary_id');

            /*
            |--------------------------------------------------------------------------
            | Transaction Type
            |--------------------------------------------------------------------------
            */

            $table->enum('transaction_type', [
                'generated',
                'approved',
                'credited',
                'debit',
                'withdrawal_request',
                'withdrawal_approved',
                'withdrawal_paid',
                'reversed',
                'cancelled',
                'adjustment'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Financial Details
            |--------------------------------------------------------------------------
            */

            $table->decimal('amount', 15, 2);

            $table->decimal('opening_balance', 15, 2)
                ->default(0);

            $table->decimal('closing_balance', 15, 2)
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
            | Order Reference
            |--------------------------------------------------------------------------
            */

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
            | Withdrawal Reference
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('withdrawal_request_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'completed',
                'failed',
                'cancelled'
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
            $table->index('commission_id');
            $table->index('wallet_id');
            $table->index('beneficiary_type');
            $table->index('beneficiary_id');
            $table->index('transaction_type');
            $table->index('order_id');
            $table->index('delivery_id');
            $table->index('status');

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
        Schema::dropIfExists('commission_transactions');
    }
};
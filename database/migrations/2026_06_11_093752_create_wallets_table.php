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
        Schema::create('wallets', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Wallet Information
            |--------------------------------------------------------------------------
            */

            $table->string('wallet_number')->unique();

            /*
            |--------------------------------------------------------------------------
            | Wallet Owner
            |--------------------------------------------------------------------------
            */

            $table->string('owner_type');

            $table->unsignedBigInteger('owner_id');

            /*
            |--------------------------------------------------------------------------
            | Wallet Balance
            |--------------------------------------------------------------------------
            */

            $table->decimal('available_balance', 15, 2)
                ->default(0);

            $table->decimal('pending_balance', 15, 2)
                ->default(0);

            $table->decimal('hold_balance', 15, 2)
                ->default(0);

            $table->decimal('withdrawn_amount', 15, 2)
                ->default(0);

            $table->decimal('lifetime_earnings', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Wallet Type
            |--------------------------------------------------------------------------
            */

            $table->enum('wallet_type', [
                'chemist',
                'distributor',
                'field_executive',
                'calling_agent',
                'territory_manager',
                'partner'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'inactive',
                'suspended',
                'blocked'
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_verified')
                ->default(false);

            $table->timestamp('verified_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Withdrawal Settings
            |--------------------------------------------------------------------------
            */

            $table->decimal('minimum_withdrawal_amount', 15, 2)
                ->default(500);

            $table->boolean('withdrawal_enabled')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Last Activity
            |--------------------------------------------------------------------------
            */

            $table->timestamp('last_transaction_at')
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

            $table->foreignId('updated_by')
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
            | Constraints
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'owner_type',
                'owner_id'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('wallet_number');
            $table->index('owner_type');
            $table->index('owner_id');
            $table->index('wallet_type');
            $table->index('status');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
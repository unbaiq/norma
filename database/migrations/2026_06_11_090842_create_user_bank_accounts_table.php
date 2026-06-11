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
        Schema::create('user_bank_accounts', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Account Information
            |--------------------------------------------------------------------------
            */

            $table->string('account_holder_name');

            $table->string('bank_name');

            $table->string('branch_name')->nullable();

            $table->string('account_number');

            $table->string('ifsc_code');

            $table->string('account_type')
                ->default('savings');

            /*
            |--------------------------------------------------------------------------
            | UPI Information
            |--------------------------------------------------------------------------
            */

            $table->string('upi_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_verified')
                ->default(false);

            $table->timestamp('verified_at')
                ->nullable();

            $table->string('verification_reference')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Documents
            |--------------------------------------------------------------------------
            */

            $table->string('cancelled_cheque')
                ->nullable();

            $table->string('passbook_copy')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Usage
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_primary')
                ->default(false);

            $table->boolean('is_payout_account')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Wallet & Settlement
            |--------------------------------------------------------------------------
            */

            $table->decimal('total_received_amount', 15, 2)
                ->default(0);

            $table->decimal('total_withdrawn_amount', 15, 2)
                ->default(0);

            $table->timestamp('last_payout_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'active',
                'inactive',
                'blocked'
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('approved_by')
                ->nullable();

            $table->timestamp('approved_at')
                ->nullable();

            $table->text('remarks')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('user_id');
            $table->index('account_number');
            $table->index('ifsc_code');
            $table->index('upi_id');
            $table->index('status');
            $table->index('is_primary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_bank_accounts');
    }
};
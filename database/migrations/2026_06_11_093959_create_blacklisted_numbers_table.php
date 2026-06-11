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
        Schema::create('blacklisted_numbers', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Mobile Number
            |--------------------------------------------------------------------------
            */

            $table->string('country_code', 10)
                ->default('+91');

            $table->string('mobile_number', 20);

            $table->string('full_number')
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | Blacklist Information
            |--------------------------------------------------------------------------
            */

            $table->enum('blacklist_type', [
                'fraud',
                'spam',
                'abuse',
                'duplicate_account',
                'fake_lead',
                'fake_order',
                'commission_fraud',
                'referral_fraud',
                'dnc',
                'manual_block',
                'system_block'
            ]);

            $table->enum('severity', [
                'low',
                'medium',
                'high',
                'critical'
            ])->default('medium');

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

            $table->foreignId('fraud_case_id')
                ->nullable()
                ->constrained('fraud_cases')
                ->nullOnDelete();

            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('leads')
                ->nullOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);

            $table->boolean('is_permanent')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Expiry
            |--------------------------------------------------------------------------
            */

            $table->timestamp('blocked_until')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->foreignId('blocked_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('unblocked_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('blocked_at')
                ->useCurrent();

            $table->timestamp('unblocked_at')
                ->nullable();

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

            $table->unique([
                'country_code',
                'mobile_number'
            ]);

            $table->index('full_number');
            $table->index('blacklist_type');
            $table->index('severity');
            $table->index('is_active');
            $table->index('is_permanent');
            $table->index('blocked_until');
            $table->index('fraud_case_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blacklisted_numbers');
    }
};
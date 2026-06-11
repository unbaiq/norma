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
        Schema::create('fraud_cases', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Case Information
            |--------------------------------------------------------------------------
            */

            $table->string('case_number')->unique();

            $table->string('title');

            $table->longText('description');

            /*
            |--------------------------------------------------------------------------
            | Fraud Category
            |--------------------------------------------------------------------------
            */

            $table->enum('fraud_type', [
                'fake_order',
                'fake_delivery',
                'fake_measurement',
                'commission_fraud',
                'wallet_abuse',
                'duplicate_account',
                'identity_fraud',
                'referral_fraud',
                'payment_fraud',
                'distributor_fraud',
                'employee_misconduct',
                'other'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Severity
            |--------------------------------------------------------------------------
            */

            $table->enum('severity', [
                'low',
                'medium',
                'high',
                'critical'
            ])->default('medium');

            /*
            |--------------------------------------------------------------------------
            | Suspect Information
            |--------------------------------------------------------------------------
            */

            $table->string('suspect_type');

            $table->unsignedBigInteger('suspect_id');

            /*
            |--------------------------------------------------------------------------
            | Reporter Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('reported_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Related References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('leads')
                ->nullOnDelete();

            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained('appointments')
                ->nullOnDelete();

            $table->foreignId('measurement_id')
                ->nullable()
                ->constrained('measurements')
                ->nullOnDelete();

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            $table->foreignId('delivery_id')
                ->nullable()
                ->constrained('deliveries')
                ->nullOnDelete();

            $table->foreignId('commission_id')
                ->nullable()
                ->constrained('commissions')
                ->nullOnDelete();

            $table->foreignId('wallet_id')
                ->nullable()
                ->constrained('wallets')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Financial Impact
            |--------------------------------------------------------------------------
            */

            $table->decimal('estimated_loss', 15, 2)
                ->default(0);

            $table->decimal('recovered_amount', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Investigation
            |--------------------------------------------------------------------------
            */

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('assigned_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'reported',
                'under_review',
                'investigating',
                'confirmed',
                'resolved',
                'closed',
                'rejected'
            ])->default('reported');

            /*
            |--------------------------------------------------------------------------
            | Resolution
            |--------------------------------------------------------------------------
            */

            $table->longText('resolution')
                ->nullable();

            $table->timestamp('resolved_at')
                ->nullable();

            $table->foreignId('resolved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Evidence
            |--------------------------------------------------------------------------
            */

            $table->json('evidence_files')
                ->nullable();

            $table->json('evidence_data')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Risk Score
            |--------------------------------------------------------------------------
            */

            $table->integer('risk_score')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Action Taken
            |--------------------------------------------------------------------------
            */

            $table->boolean('account_suspended')
                ->default(false);

            $table->boolean('wallet_frozen')
                ->default(false);

            $table->boolean('commission_reversed')
                ->default(false);

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

            $table->index('case_number');
            $table->index('fraud_type');
            $table->index('severity');
            $table->index('suspect_type');
            $table->index('suspect_id');
            $table->index('status');
            $table->index('assigned_to');
            $table->index('risk_score');
            $table->index('reported_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fraud_cases');
    }
};
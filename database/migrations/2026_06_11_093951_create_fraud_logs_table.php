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
        Schema::create('fraud_logs', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Fraud Rule Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('fraud_rule_id')
                ->nullable()
                ->constrained('fraud_rules')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Fraud Case Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('fraud_case_id')
                ->nullable()
                ->constrained('fraud_cases')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Entity Evaluated
            |--------------------------------------------------------------------------
            */

            $table->string('entity_type');

            $table->unsignedBigInteger('entity_id');

            /*
            |--------------------------------------------------------------------------
            | Detection Result
            |--------------------------------------------------------------------------
            */

            $table->enum('result', [
                'passed',
                'warning',
                'flagged',
                'blocked'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Risk Assessment
            |--------------------------------------------------------------------------
            */

            $table->integer('risk_score')
                ->default(0);

            $table->enum('risk_level', [
                'low',
                'medium',
                'high',
                'critical'
            ])->default('low');

            /*
            |--------------------------------------------------------------------------
            | Rule Data
            |--------------------------------------------------------------------------
            */

            $table->json('rule_conditions')
                ->nullable();

            $table->json('evaluation_data')
                ->nullable();

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

            $table->foreignId('wallet_id')
                ->nullable()
                ->constrained('wallets')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Actions Taken
            |--------------------------------------------------------------------------
            */

            $table->boolean('case_created')
                ->default(false);

            $table->boolean('notification_sent')
                ->default(false);

            $table->boolean('account_blocked')
                ->default(false);

            $table->boolean('wallet_frozen')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Processing
            |--------------------------------------------------------------------------
            */

            $table->timestamp('executed_at');

            $table->string('execution_source')
                ->nullable(); // cron, api, system, manual

            /*
            |--------------------------------------------------------------------------
            | Remarks
            |--------------------------------------------------------------------------
            */

            $table->text('remarks')
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

            $table->index('fraud_rule_id');
            $table->index('fraud_case_id');
            $table->index('entity_type');
            $table->index('entity_id');
            $table->index('result');
            $table->index('risk_score');
            $table->index('risk_level');
            $table->index('executed_at');

            $table->index([
                'entity_type',
                'entity_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fraud_logs');
    }
};
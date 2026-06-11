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
        Schema::create('fraud_rules', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Rule Information
            |--------------------------------------------------------------------------
            */

            $table->string('rule_code')->unique();

            $table->string('name');

            $table->text('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Rule Category
            |--------------------------------------------------------------------------
            */

            $table->enum('category', [
                'account',
                'lead',
                'appointment',
                'measurement',
                'order',
                'delivery',
                'commission',
                'wallet',
                'withdrawal',
                'device',
                'location',
                'referral',
                'system'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Rule Type
            |--------------------------------------------------------------------------
            */

            $table->enum('rule_type', [
                'threshold',
                'duplicate',
                'frequency',
                'velocity',
                'amount',
                'location',
                'device',
                'custom'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Risk Configuration
            |--------------------------------------------------------------------------
            */

            $table->integer('risk_score')
                ->default(10);

            $table->enum('severity', [
                'low',
                'medium',
                'high',
                'critical'
            ])->default('medium');

            /*
            |--------------------------------------------------------------------------
            | Rule Conditions
            |--------------------------------------------------------------------------
            */

            $table->json('conditions');

            /*
            |--------------------------------------------------------------------------
            | Trigger Action
            |--------------------------------------------------------------------------
            */

            $table->json('actions')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Auto Action
            |--------------------------------------------------------------------------
            */

            $table->boolean('auto_block')
                ->default(false);

            $table->boolean('auto_suspend')
                ->default(false);

            $table->boolean('auto_create_case')
                ->default(true);

            $table->boolean('auto_notify')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Execution Settings
            |--------------------------------------------------------------------------
            */

            $table->integer('priority')
                ->default(1);

            $table->integer('cooldown_minutes')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('trigger_count')
                ->default(0);

            $table->timestamp('last_triggered_at')
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
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('rule_code');
            $table->index('category');
            $table->index('rule_type');
            $table->index('severity');
            $table->index('risk_score');
            $table->index('is_active');
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fraud_rules');
    }
};
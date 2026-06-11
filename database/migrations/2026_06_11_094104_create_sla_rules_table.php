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
        Schema::create('sla_rules', function (Blueprint $table) {

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
            | Module
            |--------------------------------------------------------------------------
            */

            $table->enum('module', [
                'lead',
                'appointment',
                'measurement',
                'order',
                'delivery',
                'wallet',
                'withdrawal',
                'ticket',
                'commission',
                'fraud'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Event
            |--------------------------------------------------------------------------
            */

            $table->string('trigger_event');

            /*
            |--------------------------------------------------------------------------
            | SLA Type
            |--------------------------------------------------------------------------
            */

            $table->enum('sla_type', [
                'response',
                'resolution',
                'completion',
                'approval'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Time Configuration
            |--------------------------------------------------------------------------
            */

            $table->integer('target_minutes');

            $table->integer('warning_before_minutes')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Business Hours
            |--------------------------------------------------------------------------
            */

            $table->boolean('business_hours_only')
                ->default(false);

            $table->boolean('exclude_holidays')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Priority
            |--------------------------------------------------------------------------
            */

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'critical'
            ])->default('medium');

            /*
            |--------------------------------------------------------------------------
            | Escalation
            |--------------------------------------------------------------------------
            */

            $table->boolean('auto_escalate')
                ->default(true);

            $table->integer('escalation_after_minutes')
                ->nullable();

            $table->foreignId('escalate_to_role_id')
                ->nullable()
                ->constrained('roles')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Notifications
            |--------------------------------------------------------------------------
            */

            $table->boolean('send_warning_notification')
                ->default(true);

            $table->boolean('send_breach_notification')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Conditions
            |--------------------------------------------------------------------------
            */

            $table->json('conditions')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('breach_count')
                ->default(0);

            $table->timestamp('last_breached_at')
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
            $table->index('module');
            $table->index('trigger_event');
            $table->index('sla_type');
            $table->index('priority');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sla_rules');
    }
};
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
        Schema::create('automation_logs', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Automation Details
            |--------------------------------------------------------------------------
            */

            $table->string('automation_code')->nullable();

            $table->string('automation_name');

            $table->enum('automation_type', [
                'workflow',
                'scheduler',
                'notification',
                'sla',
                'fraud',
                'commission',
                'wallet',
                'assignment',
                'report',
                'kpi',
                'system'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Related Rule
            |--------------------------------------------------------------------------
            */

            $table->foreignId('workflow_rule_id')
                ->nullable()
                ->constrained('workflow_rules')
                ->nullOnDelete();

            $table->foreignId('sla_rule_id')
                ->nullable()
                ->constrained('sla_rules')
                ->nullOnDelete();

            $table->foreignId('fraud_rule_id')
                ->nullable()
                ->constrained('fraud_rules')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Related Entity
            |--------------------------------------------------------------------------
            */

            $table->string('entity_type')
                ->nullable();

            $table->unsignedBigInteger('entity_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Execution
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'queued',
                'processing',
                'success',
                'failed',
                'cancelled',
                'skipped'
            ])->default('queued');

            $table->integer('attempts')
                ->default(0);

            $table->integer('max_attempts')
                ->default(3);

            /*
            |--------------------------------------------------------------------------
            | Timing
            |--------------------------------------------------------------------------
            */

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            $table->integer('execution_time_ms')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Result
            |--------------------------------------------------------------------------
            */

            $table->text('message')
                ->nullable();

            $table->longText('error_message')
                ->nullable();

            $table->json('request_payload')
                ->nullable();

            $table->json('response_payload')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Queue Information
            |--------------------------------------------------------------------------
            */

            $table->string('queue_name')
                ->nullable();

            $table->string('job_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Trigger Source
            |--------------------------------------------------------------------------
            */

            $table->enum('trigger_source', [
                'system',
                'cron',
                'queue',
                'workflow',
                'manual',
                'api'
            ])->default('system');

            /*
            |--------------------------------------------------------------------------
            | User Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('triggered_by')
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

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('automation_type');
            $table->index('status');
            $table->index('job_id');
            $table->index('queue_name');
            $table->index('trigger_source');
            $table->index('started_at');
            $table->index('completed_at');

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
        Schema::dropIfExists('automation_logs');
    }
};
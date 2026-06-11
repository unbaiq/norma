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
        Schema::create('followup_schedules', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Lead Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('lead_id')
                ->constrained('leads')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Related Followup
            |--------------------------------------------------------------------------
            */

            $table->foreignId('lead_followup_id')
                ->nullable()
                ->constrained('lead_followups')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Assigned User
            |--------------------------------------------------------------------------
            */

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Schedule Information
            |--------------------------------------------------------------------------
            */

            $table->string('schedule_code')
                ->unique();

            $table->string('title');

            $table->text('description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Followup Type
            |--------------------------------------------------------------------------
            */

            $table->enum('followup_type', [
                'call',
                'whatsapp',
                'sms',
                'email',
                'appointment_confirmation',
                'appointment_reminder',
                'measurement_followup',
                'delivery_followup',
                'feedback_call',
                'other'
            ])->default('call');

            /*
            |--------------------------------------------------------------------------
            | Schedule Date & Time
            |--------------------------------------------------------------------------
            */

            $table->timestamp('scheduled_at');

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Reminder Settings
            |--------------------------------------------------------------------------
            */

            $table->boolean('send_reminder')
                ->default(true);

            $table->integer('reminder_before_minutes')
                ->default(30);

            /*
            |--------------------------------------------------------------------------
            | Priority
            |--------------------------------------------------------------------------
            */

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'urgent'
            ])->default('medium');

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'scheduled',
                'in_progress',
                'completed',
                'missed',
                'cancelled',
                'rescheduled'
            ])->default('scheduled');

            /*
            |--------------------------------------------------------------------------
            | Completion Details
            |--------------------------------------------------------------------------
            */

            $table->text('completion_notes')
                ->nullable();

            $table->boolean('followup_completed')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Auto Escalation
            |--------------------------------------------------------------------------
            */

            $table->boolean('auto_escalate')
                ->default(false);

            $table->integer('escalation_after_minutes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | SLA Tracking
            |--------------------------------------------------------------------------
            */

            $table->integer('sla_minutes')
                ->nullable();

            $table->integer('actual_completion_minutes')
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

            $table->index('lead_id');
            $table->index('lead_followup_id');
            $table->index('assigned_to');
            $table->index('scheduled_at');
            $table->index('status');
            $table->index('priority');
            $table->index('followup_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('followup_schedules');
    }
};
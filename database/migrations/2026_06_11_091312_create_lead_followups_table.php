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
        Schema::create('lead_followups', function (Blueprint $table) {

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
            | Followup By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

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
                'appointment',
                'visit',
                'system_reminder',
                'other'
            ])->default('call');

            /*
            |--------------------------------------------------------------------------
            | Followup Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'scheduled',
                'completed',
                'missed',
                'cancelled',
                'rescheduled'
            ])->default('scheduled');

            /*
            |--------------------------------------------------------------------------
            | Customer Response
            |--------------------------------------------------------------------------
            */

            $table->enum('customer_response', [
                'interested',
                'not_interested',
                'callback_requested',
                'busy',
                'switched_off',
                'no_answer',
                'wrong_number',
                'appointment_confirmed',
                'converted',
                'other'
            ])->nullable();

            /*
            |--------------------------------------------------------------------------
            | Followup Schedule
            |--------------------------------------------------------------------------
            */

            $table->timestamp('scheduled_at');

            $table->timestamp('completed_at')
                ->nullable();

            $table->timestamp('next_followup_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Outcome
            |--------------------------------------------------------------------------
            */

            $table->string('outcome')
                ->nullable();

            $table->longText('remarks')
                ->nullable();

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
            | Appointment Conversion
            |--------------------------------------------------------------------------
            */

            $table->boolean('appointment_booked')
                ->default(false);

            $table->date('appointment_date')
                ->nullable();

            $table->time('appointment_time')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Lead Conversion
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_converted')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Call Details
            |--------------------------------------------------------------------------
            */

            $table->integer('call_duration')
                ->nullable()
                ->comment('Duration in seconds');

            $table->string('call_recording')
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
            $table->index('user_id');
            $table->index('status');
            $table->index('followup_type');
            $table->index('customer_response');
            $table->index('scheduled_at');
            $table->index('next_followup_at');
            $table->index('appointment_booked');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_followups');
    }
};
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
        Schema::create('call_logs', function (Blueprint $table) {

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
            | Agent Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('calling_agent_id')
                ->nullable()
                ->constrained('calling_agents')
                ->nullOnDelete();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Call Information
            |--------------------------------------------------------------------------
            */

            $table->string('call_reference')
                ->unique()
                ->nullable();

            $table->string('customer_mobile', 20);

            $table->string('dialed_number', 20)
                ->nullable();

            $table->enum('call_type', [
                'outgoing',
                'incoming',
                'missed',
                'callback'
            ])->default('outgoing');

            /*
            |--------------------------------------------------------------------------
            | Call Status
            |--------------------------------------------------------------------------
            */

            $table->enum('call_status', [
                'initiated',
                'ringing',
                'answered',
                'busy',
                'no_answer',
                'switched_off',
                'failed',
                'completed',
                'cancelled'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Call Outcome
            |--------------------------------------------------------------------------
            */

            $table->enum('call_outcome', [
                'interested',
                'not_interested',
                'callback_requested',
                'appointment_booked',
                'converted',
                'wrong_number',
                'duplicate_lead',
                'followup_required',
                'unreachable',
                'other'
            ])->nullable();

            /*
            |--------------------------------------------------------------------------
            | Duration
            |--------------------------------------------------------------------------
            */

            $table->integer('ring_duration')
                ->default(0)
                ->comment('seconds');

            $table->integer('talk_duration')
                ->default(0)
                ->comment('seconds');

            $table->integer('total_duration')
                ->default(0)
                ->comment('seconds');

            /*
            |--------------------------------------------------------------------------
            | Call Recording
            |--------------------------------------------------------------------------
            */

            $table->string('recording_url')
                ->nullable();

            $table->string('recording_file')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Follow-up
            |--------------------------------------------------------------------------
            */

            $table->boolean('followup_required')
                ->default(false);

            $table->timestamp('next_followup_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Appointment
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
            | Notes
            |--------------------------------------------------------------------------
            */

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Telephony Integration
            |--------------------------------------------------------------------------
            */

            $table->string('provider')
                ->nullable();

            $table->string('provider_call_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Timestamps
            |--------------------------------------------------------------------------
            */

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('ended_at')
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
            $table->index('calling_agent_id');
            $table->index('user_id');
            $table->index('call_status');
            $table->index('call_outcome');
            $table->index('customer_mobile');
            $table->index('started_at');
            $table->index('appointment_booked');
            $table->index('is_converted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_logs');
    }
};
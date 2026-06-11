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
        Schema::create('call_attempts', function (Blueprint $table) {

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
            | Related Call Log
            |--------------------------------------------------------------------------
            */

            $table->foreignId('call_log_id')
                ->nullable()
                ->constrained('call_logs')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Attempt Information
            |--------------------------------------------------------------------------
            */

            $table->integer('attempt_no')
                ->default(1);

            $table->string('mobile_number', 20);

            $table->enum('attempt_type', [
                'manual',
                'auto_dialer',
                'callback',
                'scheduled_followup'
            ])->default('manual');

            /*
            |--------------------------------------------------------------------------
            | Attempt Result
            |--------------------------------------------------------------------------
            */

            $table->enum('attempt_status', [
                'initiated',
                'ringing',
                'answered',
                'busy',
                'no_answer',
                'switched_off',
                'invalid_number',
                'failed',
                'cancelled'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Duration
            |--------------------------------------------------------------------------
            */

            $table->integer('ring_duration')
                ->default(0);

            $table->integer('talk_duration')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Outcome
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_connected')
                ->default(false);

            $table->boolean('call_log_created')
                ->default(false);

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
            | Telephony Integration
            |--------------------------------------------------------------------------
            */

            $table->string('provider')
                ->nullable();

            $table->string('provider_call_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Remarks
            |--------------------------------------------------------------------------
            */

            $table->text('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Timing
            |--------------------------------------------------------------------------
            */

            $table->timestamp('attempted_at');

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
            $table->index('call_log_id');
            $table->index('attempt_no');
            $table->index('attempt_status');
            $table->index('attempted_at');
            $table->index('is_connected');
            $table->index('mobile_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_attempts');
    }
};
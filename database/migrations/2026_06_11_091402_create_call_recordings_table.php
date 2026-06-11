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
        Schema::create('call_recordings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Call Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('call_log_id')
                ->constrained('call_logs')
                ->cascadeOnDelete();

            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('leads')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Agent Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('calling_agent_id')
                ->nullable()
                ->constrained('calling_agents')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Recording Information
            |--------------------------------------------------------------------------
            */

            $table->string('recording_code')
                ->unique();

            $table->string('recording_name')
                ->nullable();

            $table->string('file_name');

            $table->string('file_path');

            $table->string('file_url')
                ->nullable();

            $table->string('file_extension')
                ->nullable();

            $table->string('mime_type')
                ->nullable();

            $table->unsignedBigInteger('file_size')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Audio Information
            |--------------------------------------------------------------------------
            */

            $table->integer('duration_seconds')
                ->default(0);

            $table->string('audio_format')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Provider Information
            |--------------------------------------------------------------------------
            */

            $table->string('provider')
                ->nullable();

            $table->string('provider_recording_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | AI Transcription
            |--------------------------------------------------------------------------
            */

            $table->longText('transcript')
                ->nullable();

            $table->boolean('transcription_completed')
                ->default(false);

            $table->timestamp('transcribed_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | AI Analysis
            |--------------------------------------------------------------------------
            */

            $table->decimal('sentiment_score', 8, 2)
                ->nullable();

            $table->decimal('quality_score', 8, 2)
                ->nullable();

            $table->boolean('customer_interested')
                ->default(false);

            $table->boolean('appointment_discussed')
                ->default(false);

            $table->boolean('followup_required')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Compliance Review
            |--------------------------------------------------------------------------
            */

            $table->boolean('reviewed')
                ->default(false);

            $table->foreignId('reviewed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('reviewed_at')
                ->nullable();

            $table->text('review_notes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'uploaded',
                'processing',
                'transcribed',
                'reviewed',
                'archived',
                'deleted'
            ])->default('uploaded');

            /*
            |--------------------------------------------------------------------------
            | Security
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_sensitive')
                ->default(true);

            $table->boolean('is_public')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            $table->timestamp('recorded_at')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('call_log_id');
            $table->index('lead_id');
            $table->index('calling_agent_id');
            $table->index('recording_code');
            $table->index('provider_recording_id');
            $table->index('status');
            $table->index('reviewed');
            $table->index('recorded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_recordings');
    }
};
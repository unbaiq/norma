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
        Schema::create('measurements', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | System Information
            |--------------------------------------------------------------------------
            */

            $table->string('measurement_code')
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('leads')
                ->nullOnDelete();

            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained('appointments')
                ->nullOnDelete();

            $table->foreignId('visit_log_id')
                ->nullable()
                ->constrained('visit_logs')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Executive
            |--------------------------------------------------------------------------
            */

            $table->foreignId('field_executive_id')
                ->nullable()
                ->constrained('field_executives')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Measurement Type
            |--------------------------------------------------------------------------
            */

            $table->enum('measurement_type', [
                'knee_support',
                'back_support',
                'cervical_support',
                'shoulder_support',
                'ankle_support',
                'wrist_support',
                'orthopedic',
                'prosthetic',
                'rehabilitation',
                'custom_product',
                'other'
            ])->default('orthopedic');

            /*
            |--------------------------------------------------------------------------
            | Customer Health Information
            |--------------------------------------------------------------------------
            */

            $table->integer('age')
                ->nullable();

            $table->decimal('height', 8, 2)
                ->nullable();

            $table->decimal('weight', 8, 2)
                ->nullable();

            $table->string('pain_level')
                ->nullable();

            $table->text('medical_notes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Measurement Summary
            |--------------------------------------------------------------------------
            */

            $table->text('measurement_summary')
                ->nullable();

            $table->longText('observation_notes')
                ->nullable();

            $table->longText('recommendation_notes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Customer Condition
            |--------------------------------------------------------------------------
            */

            $table->string('problem_category')
                ->nullable();

            $table->string('affected_area')
                ->nullable();

            $table->boolean('post_surgery')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'in_progress',
                'completed',
                'approved',
                'rejected'
            ])->default('draft');

            /*
            |--------------------------------------------------------------------------
            | Approval
            |--------------------------------------------------------------------------
            */

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | GPS Verification
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Completion
            |--------------------------------------------------------------------------
            */

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('completed_at')
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

            $table->index('measurement_code');
            $table->index('customer_id');
            $table->index('lead_id');
            $table->index('appointment_id');
            $table->index('visit_log_id');
            $table->index('field_executive_id');
            $table->index('measurement_type');
            $table->index('status');
            $table->index('completed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
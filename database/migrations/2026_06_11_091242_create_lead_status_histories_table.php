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
        Schema::create('lead_status_histories', function (Blueprint $table) {

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
            | Status Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('lead_status_id')
                ->constrained('lead_statuses')
                ->cascadeOnDelete();

            $table->string('status_code');

            $table->string('status_name');

            /*
            |--------------------------------------------------------------------------
            | Previous Status
            |--------------------------------------------------------------------------
            */

            $table->foreignId('previous_status_id')
                ->nullable()
                ->constrained('lead_statuses')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Changed By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('changed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Assignment Tracking
            |--------------------------------------------------------------------------
            */

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Remarks
            |--------------------------------------------------------------------------
            */

            $table->text('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Rejection / Cancellation
            |--------------------------------------------------------------------------
            */

            $table->string('reason')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Follow Up
            |--------------------------------------------------------------------------
            */

            $table->timestamp('next_followup_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Appointment Details
            |--------------------------------------------------------------------------
            */

            $table->date('appointment_date')
                ->nullable();

            $table->time('appointment_time')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | SLA Tracking
            |--------------------------------------------------------------------------
            */

            $table->integer('time_spent_minutes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status Change Date
            |--------------------------------------------------------------------------
            */

            $table->timestamp('status_changed_at');

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

            $table->index('lead_id');
            $table->index('lead_status_id');
            $table->index('previous_status_id');
            $table->index('changed_by');
            $table->index('assigned_to');
            $table->index('status_changed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_status_histories');
    }
};
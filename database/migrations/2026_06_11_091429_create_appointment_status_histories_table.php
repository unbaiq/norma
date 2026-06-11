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
        Schema::create('appointment_status_histories', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Appointment
            |--------------------------------------------------------------------------
            */

            $table->foreignId('appointment_id')
                ->constrained('appointments')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Status Information
            |--------------------------------------------------------------------------
            */

            $table->string('from_status')
                ->nullable();

            $table->string('to_status');

            /*
            |--------------------------------------------------------------------------
            | User Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('changed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Executive Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('field_executive_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Reason
            |--------------------------------------------------------------------------
            */

            $table->string('reason')
                ->nullable();

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Reschedule Information
            |--------------------------------------------------------------------------
            */

            $table->date('old_appointment_date')
                ->nullable();

            $table->time('old_appointment_time')
                ->nullable();

            $table->date('new_appointment_date')
                ->nullable();

            $table->time('new_appointment_time')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Cancellation
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_cancelled')
                ->default(false);

            $table->string('cancellation_reason')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | SLA Tracking
            |--------------------------------------------------------------------------
            */

            $table->integer('time_in_previous_status_minutes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | GPS Tracking
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status Change Time
            |--------------------------------------------------------------------------
            */

            $table->timestamp('status_changed_at');

            /*
            |--------------------------------------------------------------------------
            | Additional Data
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

            $table->index('appointment_id');
            $table->index('from_status');
            $table->index('to_status');
            $table->index('changed_by');
            $table->index('field_executive_id');
            $table->index('status_changed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_status_histories');
    }
};
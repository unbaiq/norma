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
        Schema::create('appointment_reschedules', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Appointment Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('appointment_id')
                ->constrained('appointments')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Requested By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('requested_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Approved By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Previous Schedule
            |--------------------------------------------------------------------------
            */

            $table->date('old_appointment_date');

            $table->time('old_appointment_time');

            /*
            |--------------------------------------------------------------------------
            | New Schedule
            |--------------------------------------------------------------------------
            */

            $table->date('new_appointment_date');

            $table->time('new_appointment_time');

            /*
            |--------------------------------------------------------------------------
            | Reschedule Details
            |--------------------------------------------------------------------------
            */

            $table->integer('reschedule_count')
                ->default(1);

            $table->enum('reschedule_type', [
                'customer_request',
                'executive_request',
                'system_reschedule',
                'weather',
                'operational_issue',
                'other'
            ])->default('customer_request');

            $table->string('reason');

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'approved',
                'rejected',
                'completed'
            ])->default('approved');

            /*
            |--------------------------------------------------------------------------
            | SLA Impact
            |--------------------------------------------------------------------------
            */

            $table->boolean('sla_breached')
                ->default(false);

            $table->integer('delay_hours')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Notification
            |--------------------------------------------------------------------------
            */

            $table->boolean('customer_notified')
                ->default(false);

            $table->boolean('executive_notified')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Tracking
            |--------------------------------------------------------------------------
            */

            $table->timestamp('requested_at');

            $table->timestamp('approved_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Additional Data
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

            $table->index('appointment_id');
            $table->index('requested_by');
            $table->index('approved_by');
            $table->index('status');
            $table->index('requested_at');
            $table->index('new_appointment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_reschedules');
    }
};
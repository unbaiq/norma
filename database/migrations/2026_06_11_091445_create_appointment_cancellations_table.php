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
        Schema::create('appointment_cancellations', function (Blueprint $table) {

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
            | Customer & Lead
            |--------------------------------------------------------------------------
            */

            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('leads')
                ->nullOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Cancelled By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('cancelled_by')
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
            | Cancellation Details
            |--------------------------------------------------------------------------
            */

            $table->enum('cancellation_type', [
                'customer_request',
                'executive_request',
                'system_cancelled',
                'admin_cancelled',
                'duplicate_booking',
                'service_unavailable',
                'other'
            ]);

            $table->enum('cancellation_reason', [
                'customer_not_available',
                'customer_not_interested',
                'wrong_address',
                'duplicate_booking',
                'medical_not_eligible',
                'executive_unavailable',
                'territory_not_serviceable',
                'outside_service_area',
                'product_not_available',
                'operational_issue',
                'weather_issue',
                'other'
            ]);

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Recovery Opportunity
            |--------------------------------------------------------------------------
            */

            $table->boolean('can_reschedule')
                ->default(true);

            $table->timestamp('reschedule_before')
                ->nullable();

            $table->boolean('followup_required')
                ->default(false);

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
            | Notification Tracking
            |--------------------------------------------------------------------------
            */

            $table->boolean('customer_notified')
                ->default(false);

            $table->boolean('executive_notified')
                ->default(false);

            $table->boolean('crm_notified')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Refund Information
            |--------------------------------------------------------------------------
            */

            $table->boolean('refund_required')
                ->default(false);

            $table->decimal('refund_amount', 12, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Cancellation Time
            |--------------------------------------------------------------------------
            */

            $table->timestamp('cancelled_at');

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

            $table->index('appointment_id');
            $table->index('lead_id');
            $table->index('customer_id');
            $table->index('cancelled_by');
            $table->index('field_executive_id');
            $table->index('cancellation_type');
            $table->index('cancellation_reason');
            $table->index('cancelled_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointment_cancellations');
    }
};
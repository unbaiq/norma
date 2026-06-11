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
        Schema::create('visit_logs', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Visit Information
            |--------------------------------------------------------------------------
            */

            $table->string('visit_code')->unique();

            $table->foreignId('field_executive_id')
                ->constrained('field_executives')
                ->cascadeOnDelete();

            $table->foreignId('executive_assignment_id')
                ->nullable()
                ->constrained('executive_assignments')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Customer References
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

            /*
            |--------------------------------------------------------------------------
            | Visit Type
            |--------------------------------------------------------------------------
            */

            $table->enum('visit_type', [
                'appointment',
                'measurement',
                'followup',
                'delivery',
                'installation',
                'service',
                'product_demo',
                'survey'
            ])->default('appointment');

            /*
            |--------------------------------------------------------------------------
            | Visit Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'scheduled',
                'on_the_way',
                'checked_in',
                'in_progress',
                'completed',
                'cancelled',
                'customer_unavailable',
                'no_show'
            ])->default('scheduled');

            /*
            |--------------------------------------------------------------------------
            | Schedule
            |--------------------------------------------------------------------------
            */

            $table->timestamp('scheduled_at')
                ->nullable();

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Check-In Location
            |--------------------------------------------------------------------------
            */

            $table->decimal('checkin_latitude', 10, 8)
                ->nullable();

            $table->decimal('checkin_longitude', 11, 8)
                ->nullable();

            $table->timestamp('checked_in_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Check-Out Location
            |--------------------------------------------------------------------------
            */

            $table->decimal('checkout_latitude', 10, 8)
                ->nullable();

            $table->decimal('checkout_longitude', 11, 8)
                ->nullable();

            $table->timestamp('checked_out_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Customer Verification
            |--------------------------------------------------------------------------
            */

            $table->string('customer_name')
                ->nullable();

            $table->string('customer_mobile', 20)
                ->nullable();

            $table->boolean('customer_verified')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Visit Outcome
            |--------------------------------------------------------------------------
            */

            $table->enum('visit_outcome', [
                'measurement_completed',
                'appointment_completed',
                'order_generated',
                'followup_required',
                'customer_not_available',
                'service_completed',
                'cancelled',
                'other'
            ])->nullable();

            /*
            |--------------------------------------------------------------------------
            | Visit Notes
            |--------------------------------------------------------------------------
            */

            $table->longText('visit_notes')
                ->nullable();

            $table->text('recommendations')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Customer Feedback
            |--------------------------------------------------------------------------
            */

            $table->decimal('customer_rating', 3, 2)
                ->nullable();

            $table->text('customer_feedback')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Photos
            |--------------------------------------------------------------------------
            */

            $table->integer('photo_count')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Duration
            |--------------------------------------------------------------------------
            */

            $table->integer('visit_duration_minutes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Territory
            |--------------------------------------------------------------------------
            */

            $table->foreignId('territory_id')
                ->nullable()
                ->constrained('territories')
                ->nullOnDelete();

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

            $table->index('visit_code');
            $table->index('field_executive_id');
            $table->index('lead_id');
            $table->index('customer_id');
            $table->index('appointment_id');
            $table->index('visit_type');
            $table->index('status');
            $table->index('scheduled_at');
            $table->index('territory_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visit_logs');
    }
};
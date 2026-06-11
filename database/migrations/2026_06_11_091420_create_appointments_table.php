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
        Schema::create('appointments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | System Information
            |--------------------------------------------------------------------------
            */

            $table->string('appointment_code')->unique();

            /*
            |--------------------------------------------------------------------------
            | Lead Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('lead_id')
                ->constrained('leads')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Assigned Executive
            |--------------------------------------------------------------------------
            */

            $table->foreignId('field_executive_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Appointment Type
            |--------------------------------------------------------------------------
            */

            $table->enum('appointment_type', [
                'home_visit',
                'clinic_visit',
                'measurement',
                'consultation',
                'followup_visit'
            ])->default('measurement');

            /*
            |--------------------------------------------------------------------------
            | Problem Category
            |--------------------------------------------------------------------------
            */

            $table->string('problem_category')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Schedule Information
            |--------------------------------------------------------------------------
            */

            $table->date('appointment_date');

            $table->time('appointment_time');

            $table->timestamp('scheduled_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Customer Address
            |--------------------------------------------------------------------------
            */

            $table->text('address');

            $table->foreignId('country_id')
                ->nullable()
                ->constrained('countries')
                ->nullOnDelete();

            $table->foreignId('state_id')
                ->nullable()
                ->constrained('states')
                ->nullOnDelete();

            $table->foreignId('city_id')
                ->nullable()
                ->constrained('cities')
                ->nullOnDelete();

            $table->foreignId('area_id')
                ->nullable()
                ->constrained('areas')
                ->nullOnDelete();

            $table->foreignId('pincode_id')
                ->nullable()
                ->constrained('pincodes')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'booked',
                'assigned',
                'confirmed',
                'rescheduled',
                'executive_assigned',
                'on_the_way',
                'started',
                'completed',
                'cancelled',
                'no_show'
            ])->default('booked');

            /*
            |--------------------------------------------------------------------------
            | Visit Tracking
            |--------------------------------------------------------------------------
            */

            $table->timestamp('confirmed_at')
                ->nullable();

            $table->timestamp('executive_assigned_at')
                ->nullable();

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Reschedule
            |--------------------------------------------------------------------------
            */

            $table->integer('reschedule_count')
                ->default(0);

            $table->text('reschedule_reason')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Cancellation
            |--------------------------------------------------------------------------
            */

            $table->text('cancellation_reason')
                ->nullable();

            $table->foreignId('cancelled_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | SLA
            |--------------------------------------------------------------------------
            */

            $table->integer('sla_hours')
                ->default(24);

            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            $table->longText('notes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('appointment_code');
            $table->index('lead_id');
            $table->index('customer_id');
            $table->index('field_executive_id');
            $table->index('appointment_date');
            $table->index('status');
            $table->index('pincode_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
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
        Schema::create('field_executives', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | User & Staff Mapping
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('staff_profile_id')
                ->nullable()
                ->constrained('staff_profiles')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Executive Information
            |--------------------------------------------------------------------------
            */

            $table->string('executive_code')
                ->unique();

            $table->string('employee_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Reporting Structure
            |--------------------------------------------------------------------------
            */

            $table->foreignId('manager_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('supervisor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Territory Assignment
            |--------------------------------------------------------------------------
            */

            $table->foreignId('territory_id')
                ->nullable()
                ->constrained('territories')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Vehicle Information
            |--------------------------------------------------------------------------
            */

            $table->string('vehicle_type')
                ->nullable();

            $table->string('vehicle_number')
                ->nullable();

            $table->string('driving_license_number')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Skills & Certification
            |--------------------------------------------------------------------------
            */

            $table->text('specialization')
                ->nullable();

            $table->text('certifications')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Performance Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_appointments')
                ->default(0);

            $table->integer('completed_appointments')
                ->default(0);

            $table->integer('total_measurements')
                ->default(0);

            $table->integer('successful_orders')
                ->default(0);

            $table->integer('customer_visits')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | KPI
            |--------------------------------------------------------------------------
            */

            $table->decimal('completion_rate', 8, 2)
                ->default(0);

            $table->decimal('customer_rating', 5, 2)
                ->default(0);

            $table->decimal('performance_score', 8, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Daily Targets
            |--------------------------------------------------------------------------
            */

            $table->integer('daily_visit_target')
                ->default(5);

            $table->integer('monthly_order_target')
                ->default(20);

            /*
            |--------------------------------------------------------------------------
            | Live Tracking
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_available')
                ->default(true);

            $table->boolean('is_online')
                ->default(false);

            $table->timestamp('last_location_update')
                ->nullable();

            $table->decimal('current_latitude', 10, 8)
                ->nullable();

            $table->decimal('current_longitude', 11, 8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Attendance
            |--------------------------------------------------------------------------
            */

            $table->timestamp('last_checkin_at')
                ->nullable();

            $table->timestamp('last_checkout_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'inactive',
                'on_leave',
                'suspended',
                'terminated'
            ])->default('active');

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
            | Additional Data
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            $table->text('remarks')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('executive_code');
            $table->index('territory_id');
            $table->index('status');
            $table->index('is_available');
            $table->index('is_online');
            $table->index('performance_score');
            $table->index('customer_rating');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_executives');
    }
};
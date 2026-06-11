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
        Schema::create('staff_profiles', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Employee Information
            |--------------------------------------------------------------------------
            */

            $table->string('employee_code')->unique();

            $table->string('employee_id')->unique()->nullable();

            $table->string('employee_name');

            $table->string('department');

            $table->string('designation');

            $table->enum('employment_type', [
                'full_time',
                'part_time',
                'contract',
                'intern'
            ])->default('full_time');

            /*
            |--------------------------------------------------------------------------
            | Reporting Structure
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('manager_id')->nullable();

            $table->unsignedBigInteger('team_lead_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Joining Information
            |--------------------------------------------------------------------------
            */

            $table->date('joining_date');

            $table->date('confirmation_date')->nullable();

            $table->date('exit_date')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Territory Assignment
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('country_id')->nullable();

            $table->unsignedBigInteger('state_id')->nullable();

            $table->unsignedBigInteger('city_id')->nullable();

            $table->unsignedBigInteger('area_id')->nullable();

            $table->unsignedBigInteger('territory_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Address Information
            |--------------------------------------------------------------------------
            */

            $table->text('address')->nullable();

            $table->string('pincode')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Identity Information
            |--------------------------------------------------------------------------
            */

            $table->string('pan_number')->nullable();

            $table->string('aadhaar_number')->nullable();

            $table->string('employee_photo')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Banking Information
            |--------------------------------------------------------------------------
            */

            $table->string('account_holder_name')->nullable();

            $table->string('bank_name')->nullable();

            $table->string('account_number')->nullable();

            $table->string('ifsc_code')->nullable();

            $table->string('upi_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Performance Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('assigned_leads')->default(0);

            $table->integer('completed_leads')->default(0);

            $table->integer('appointments_completed')->default(0);

            $table->integer('orders_processed')->default(0);

            $table->decimal('performance_score', 8, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Attendance
            |--------------------------------------------------------------------------
            */

            $table->date('last_attendance_date')->nullable();

            $table->timestamp('last_check_in_at')->nullable();

            $table->timestamp('last_check_out_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->boolean('documents_verified')
                ->default(false);

            $table->timestamp('documents_verified_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'active',
                'inactive',
                'on_leave',
                'suspended',
                'terminated'
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Approval
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('approved_by')->nullable();

            $table->timestamp('approved_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Last Activity
            |--------------------------------------------------------------------------
            */

            $table->timestamp('last_login_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Remarks
            |--------------------------------------------------------------------------
            */

            $table->text('remarks')->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('employee_code');
            $table->index('department');
            $table->index('designation');
            $table->index('territory_id');
            $table->index('status');
            $table->index('joining_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_profiles');
    }
};
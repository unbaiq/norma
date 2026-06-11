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
        Schema::create('calling_agents', function (Blueprint $table) {

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
            | Agent Information
            |--------------------------------------------------------------------------
            */

            $table->string('agent_code')
                ->unique();

            $table->string('employee_id')
                ->nullable();

            $table->string('extension_number')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Reporting Structure
            |--------------------------------------------------------------------------
            */

            $table->foreignId('team_lead_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('manager_id')
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
            | CRM Configuration
            |--------------------------------------------------------------------------
            */

            $table->integer('daily_lead_limit')
                ->default(100);

            $table->integer('max_pending_followups')
                ->default(50);

            /*
            |--------------------------------------------------------------------------
            | Performance Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_leads_assigned')
                ->default(0);

            $table->integer('total_calls_made')
                ->default(0);

            $table->integer('successful_calls')
                ->default(0);

            $table->integer('followups_created')
                ->default(0);

            $table->integer('appointments_booked')
                ->default(0);

            $table->integer('converted_leads')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | KPI Scores
            |--------------------------------------------------------------------------
            */

            $table->decimal('conversion_rate', 8, 2)
                ->default(0);

            $table->decimal('call_success_rate', 8, 2)
                ->default(0);

            $table->decimal('performance_score', 8, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Targets
            |--------------------------------------------------------------------------
            */

            $table->integer('daily_call_target')
                ->default(50);

            $table->integer('monthly_conversion_target')
                ->default(20);

            /*
            |--------------------------------------------------------------------------
            | Availability
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_available')
                ->default(true);

            $table->timestamp('last_active_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Login Tracking
            |--------------------------------------------------------------------------
            */

            $table->timestamp('last_login_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'inactive',
                'suspended',
                'on_leave'
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

            $table->index('agent_code');
            $table->index('territory_id');
            $table->index('status');
            $table->index('is_available');
            $table->index('performance_score');
            $table->index('conversion_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calling_agents');
    }
};
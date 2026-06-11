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
        Schema::create('leads', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | System Information
            |--------------------------------------------------------------------------
            */

            $table->string('lead_code')->unique();

            /*
            |--------------------------------------------------------------------------
            | Lead Source
            |--------------------------------------------------------------------------
            */

            $table->foreignId('chemist_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->enum('lead_source', [
                'chemist',
                'customer_app',
                'website',
                'crm',
                'call_center',
                'referral',
                'walkin'
            ])->default('chemist');

            /*
            |--------------------------------------------------------------------------
            | Patient Information
            |--------------------------------------------------------------------------
            */

            $table->string('patient_name');

            $table->string('mobile',20);

            $table->string('alternate_mobile',20)
                ->nullable();

            $table->enum('gender',[
                'male',
                'female',
                'other'
            ])->nullable();

            $table->integer('age')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Problem Information
            |--------------------------------------------------------------------------
            */

            $table->enum('problem_category',[
                'knee_pain',
                'back_pain',
                'cervical_pain',
                'shoulder_pain',
                'post_surgery',
                'arthritis',
                'orthopedic_support',
                'mobility_support',
                'elder_care',
                'other'
            ]);

            $table->text('problem_description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Address Information
            |--------------------------------------------------------------------------
            */

            $table->text('address')
                ->nullable();

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

            $table->foreignId('territory_id')
                ->nullable()
                ->constrained('territories')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | GPS Location
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude',10,8)
                ->nullable();

            $table->decimal('longitude',11,8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Assignment
            |--------------------------------------------------------------------------
            */

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('calling_agent_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('field_executive_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Lead Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status',[
                'new_lead',
                'assigned',
                'called',
                'follow_up',
                'confirmed',
                'appointment_booked',
                'measurement_done',
                'order_created',
                'delivered',
                'commission_credited',
                'rejected',
                'cancelled'
            ])->default('new_lead');

            /*
            |--------------------------------------------------------------------------
            | Appointment
            |--------------------------------------------------------------------------
            */

            $table->date('appointment_date')
                ->nullable();

            $table->time('appointment_time')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Conversion Tracking
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_converted')
                ->default(false);

            $table->timestamp('converted_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Duplicate Detection
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_duplicate')
                ->default(false);

            $table->unsignedBigInteger('duplicate_lead_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Fraud Detection
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_blacklisted')
                ->default(false);

            $table->boolean('is_suspicious')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Commission
            |--------------------------------------------------------------------------
            */

            $table->decimal('commission_amount',12,2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Priority
            |--------------------------------------------------------------------------
            */

            $table->enum('priority',[
                'low',
                'medium',
                'high',
                'urgent'
            ])->default('medium');

            /*
            |--------------------------------------------------------------------------
            | Follow-up
            |--------------------------------------------------------------------------
            */

            $table->timestamp('next_followup_at')
                ->nullable();

            $table->timestamp('last_followup_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            $table->longText('notes')
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

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('lead_code');
            $table->index('mobile');
            $table->index('status');
            $table->index('chemist_id');
            $table->index('territory_id');
            $table->index('assigned_to');
            $table->index('calling_agent_id');
            $table->index('field_executive_id');
            $table->index('appointment_date');
            $table->index('is_converted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
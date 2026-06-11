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
        Schema::create('customer_profiles', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            // System Generated
            $table->string('customer_code')->unique();

            // Personal Information
            $table->string('customer_type')
                ->default('customer');

            $table->string('emergency_contact_name')
                ->nullable();

            $table->string('emergency_contact_mobile', 20)
                ->nullable();

            $table->string('relationship')
                ->nullable();

            // Healthcare Information
            $table->text('medical_notes')
                ->nullable();

            $table->text('allergies')
                ->nullable();

            $table->text('existing_conditions')
                ->nullable();

            $table->text('medications')
                ->nullable();

            // Customer Journey
            $table->integer('total_bookings')
                ->default(0);

            $table->integer('completed_bookings')
                ->default(0);

            $table->integer('total_orders')
                ->default(0);

            $table->decimal('total_spent', 12, 2)
                ->default(0);

            // Customer Scoring
            $table->decimal('customer_score', 5, 2)
                ->default(0);

            $table->decimal('satisfaction_score', 5, 2)
                ->default(0);

            // Product Lifecycle
            $table->date('last_followup_date')
                ->nullable();

            $table->date('next_followup_date')
                ->nullable();

            $table->date('last_order_date')
                ->nullable();

            // Referral Tracking
            $table->string('referral_source')
                ->nullable();

            $table->unsignedBigInteger('referred_by')
                ->nullable();

            // AI & Analytics
            $table->json('preferences')
                ->nullable();

            $table->json('health_goals')
                ->nullable();

            // Status
            $table->enum('status', [
                'active',
                'inactive',
                'blocked'
            ])->default('active');

            // Verification
            $table->boolean('profile_completed')
                ->default(false);

            $table->timestamp('profile_completed_at')
                ->nullable();

            // Remarks
            $table->text('remarks')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('customer_code');
            $table->index('status');
            $table->index('customer_type');
            $table->index('next_followup_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_profiles');
    }
};
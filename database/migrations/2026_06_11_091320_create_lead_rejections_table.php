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
        Schema::create('lead_rejections', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Lead Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('lead_id')
                ->constrained('leads')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Rejected By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('rejected_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Rejection Category
            |--------------------------------------------------------------------------
            */

            $table->enum('rejection_type', [
                'duplicate',
                'invalid',
                'fake',
                'spam',
                'blacklisted',
                'wrong_number',
                'outside_service_area',
                'already_customer',
                'not_interested',
                'budget_issue',
                'competitor_selected',
                'medical_not_eligible',
                'appointment_declined',
                'service_unavailable',
                'other'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Rejection Reason
            |--------------------------------------------------------------------------
            */

            $table->string('reason');

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Duplicate Lead Mapping
            |--------------------------------------------------------------------------
            */

            $table->foreignId('duplicate_lead_id')
                ->nullable()
                ->constrained('leads')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Fraud Detection
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_fraud')
                ->default(false);

            $table->boolean('is_blacklisted')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Customer Feedback
            |--------------------------------------------------------------------------
            */

            $table->string('customer_response')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Recovery Option
            |--------------------------------------------------------------------------
            */

            $table->boolean('can_reopen')
                ->default(false);

            $table->timestamp('reopen_until')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'reopened',
                'closed'
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->timestamp('rejected_at');

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

            $table->index('lead_id');
            $table->index('rejected_by');
            $table->index('rejection_type');
            $table->index('is_fraud');
            $table->index('is_blacklisted');
            $table->index('rejected_at');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_rejections');
    }
};
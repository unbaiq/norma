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
        Schema::create('chemist_profiles', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            // System Generated
            $table->string('chemist_code')->unique();
            $table->string('wallet_code')->unique()->nullable();
            $table->string('referral_code')->unique();

            // Business Information
            $table->string('shop_name');
            $table->string('owner_name');

            $table->string('drug_license_number')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('pan_number')->nullable();

            // Territory Mapping
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('territory_id')->nullable();

            // Address
            $table->text('business_address')->nullable();
            $table->string('pincode')->nullable();

            // Distributor Mapping
            $table->unsignedBigInteger('distributor_id')->nullable();

            // Lead Statistics
            $table->integer('total_leads')->default(0);
            $table->integer('converted_leads')->default(0);
            $table->integer('rejected_leads')->default(0);

            // Business Statistics
            $table->integer('total_orders')->default(0);

            $table->decimal('conversion_rate', 8, 2)
                ->default(0);

            $table->decimal('revenue_generated', 15, 2)
                ->default(0);

            // Commission
            $table->decimal('total_commission', 15, 2)
                ->default(0);

            $table->decimal('pending_commission', 15, 2)
                ->default(0);

            $table->decimal('withdrawn_commission', 15, 2)
                ->default(0);

            // Performance
            $table->integer('reward_points')
                ->default(0);

            $table->decimal('performance_score', 8, 2)
                ->default(0);

            $table->enum('badge', [
                'bronze',
                'silver',
                'gold',
                'platinum'
            ])->nullable();

            // Ranking
            $table->integer('territory_rank')->nullable();
            $table->integer('monthly_rank')->nullable();

            // Banking
            $table->string('account_holder_name')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('ifsc_code')->nullable();
            $table->string('upi_id')->nullable();

            // Verification
            $table->boolean('kyc_verified')
                ->default(false);

            $table->timestamp('kyc_verified_at')
                ->nullable();

            // Profile Completion
            $table->boolean('profile_completed')
                ->default(false);

            // Status
            $table->enum('status', [
                'pending',
                'active',
                'inactive',
                'suspended',
                'blocked'
            ])->default('pending');

            // Approval
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approved_at')->nullable();

            // Last Activity
            $table->timestamp('last_lead_created_at')->nullable();
            $table->timestamp('last_login_at')->nullable();

            // Notes
            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('chemist_code');
            $table->index('referral_code');
            $table->index('territory_id');
            $table->index('distributor_id');
            $table->index('status');
            $table->index('badge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chemist_profiles');
    }
};
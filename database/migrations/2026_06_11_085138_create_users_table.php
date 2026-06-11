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
        Schema::create('users', function (Blueprint $table) {

            $table->id();

            // Unique System ID
            $table->string('user_code')->unique();

            // User Type
            $table->enum('user_type', [
                'admin',
                'super_admin',
                'customer',
                'chemist',
                'distributor',
                'staff',
                'calling_agent',
                'field_executive',
                'finance'
            ])->index();

            // Basic Information
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('full_name')->nullable();

            // Authentication
            $table->string('mobile', 20)->unique();
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();

            // Personal Information
            $table->enum('gender', [
                'male',
                'female',
                'other'
            ])->nullable();

            $table->date('date_of_birth')->nullable();
            $table->integer('age')->nullable();

            // Profile
            $table->string('profile_photo')->nullable();

            // Verification
            $table->boolean('mobile_verified')->default(false);
            $table->timestamp('mobile_verified_at')->nullable();

            $table->boolean('email_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();

            // Territory Mapping
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('territory_id')->nullable();

            // Location
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Status
            $table->enum('status', [
                'pending',
                'active',
                'inactive',
                'suspended',
                'blocked',
                'deleted'
            ])->default('pending')->index();

            // Security
            $table->integer('failed_login_attempts')->default(0);
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->timestamp('password_changed_at')->nullable();

            // Device Information
            $table->string('device_id')->nullable();
            $table->string('device_type')->nullable();
            $table->text('device_token')->nullable();

            // Referral
            $table->string('referral_code')->nullable()->unique();
            $table->string('referred_by')->nullable();

            // Wallet
            $table->string('wallet_code')->nullable()->unique();

            // KYC
            $table->boolean('kyc_verified')->default(false);
            $table->timestamp('kyc_verified_at')->nullable();

            // Account
            $table->timestamp('account_activated_at')->nullable();
            $table->timestamp('account_blocked_at')->nullable();

            // Remarks
            $table->text('remarks')->nullable();

            $table->rememberToken();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('mobile');
            $table->index('email');
            $table->index('user_code');
            $table->index('status');
            $table->index('user_type');
            $table->index('territory_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
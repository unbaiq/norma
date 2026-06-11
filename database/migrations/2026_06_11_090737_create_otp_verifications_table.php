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
        Schema::create('otp_verifications', function (Blueprint $table) {

            $table->id();

            // User Reference (Optional before registration)
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Mobile Number
            $table->string('mobile', 20)->index();

            // OTP Details
            $table->string('otp', 10);

            $table->enum('otp_type', [
                'registration',
                'login',
                'forgot_password',
                'mobile_change',
                'withdrawal_verification',
                'device_verification'
            ])->default('login');

            // Security
            $table->integer('attempts')->default(0);
            $table->integer('max_attempts')->default(5);

            // Device Information
            $table->string('device_uuid')->nullable();
            $table->ipAddress('ip_address')->nullable();

            // Verification Status
            $table->boolean('is_verified')->default(false);

            $table->timestamp('verified_at')->nullable();

            // Expiry
            $table->timestamp('expires_at');

            // Resend Tracking
            $table->integer('resend_count')->default(0);
            $table->timestamp('last_resend_at')->nullable();

            // Status
            $table->enum('status', [
                'pending',
                'verified',
                'expired',
                'failed',
                'blocked'
            ])->default('pending');

            // Additional Information
            $table->json('meta')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['mobile', 'otp_type']);
            $table->index('status');
            $table->index('expires_at');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_verifications');
    }
};
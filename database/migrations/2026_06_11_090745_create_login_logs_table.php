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
        Schema::create('login_logs', function (Blueprint $table) {

            $table->id();

            // User Information
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('mobile', 20)->nullable();

            // Login Type
            $table->enum('login_type', [
                'otp',
                'password',
                'social',
                'api'
            ])->default('otp');

            // Login Status
            $table->enum('status', [
                'success',
                'failed',
                'blocked',
                'expired'
            ]);

            // Failure Reason
            $table->string('failure_reason')->nullable();

            // Device Information
            $table->string('device_uuid')->nullable();
            $table->string('device_name')->nullable();
            $table->string('device_type')->nullable();
            $table->string('device_model')->nullable();
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();

            // Network Information
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            // Location
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Session
            $table->string('session_id')->nullable();
            $table->string('access_token')->nullable();

            // Login Time
            $table->timestamp('login_at')->nullable();
            $table->timestamp('logout_at')->nullable();

            // Duration
            $table->integer('session_duration')
                ->nullable()
                ->comment('Duration in seconds');

            // Security
            $table->boolean('is_suspicious')->default(false);
            $table->text('security_notes')->nullable();

            // Additional Data
            $table->json('meta')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('user_id');
            $table->index('mobile');
            $table->index('status');
            $table->index('login_type');
            $table->index('login_at');
            $table->index('ip_address');
            $table->index('device_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};
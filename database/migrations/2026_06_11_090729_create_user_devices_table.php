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
        Schema::create('user_devices', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Device Information
            $table->string('device_uuid')->unique();

            $table->enum('device_type', [
                'android',
                'ios',
                'web',
                'tablet'
            ]);

            $table->string('device_name')->nullable();
            $table->string('device_model')->nullable();
            $table->string('os_version')->nullable();
            $table->string('app_version')->nullable();

            // Push Notification
            $table->longText('fcm_token')->nullable();

            // Security
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent')->nullable();

            // Location
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            // Session Management
            $table->string('session_token')->nullable();
            $table->timestamp('last_login_at')->nullable();
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamp('logout_at')->nullable();

            // Login Status
            $table->enum('login_status', [
                'logged_in',
                'logged_out',
                'expired'
            ])->default('logged_out');

            // Verification
            $table->boolean('is_verified')->default(false);

            // Device Status
            $table->enum('status', [
                'active',
                'inactive',
                'blocked'
            ])->default('active');

            // Audit
            $table->unsignedBigInteger('blocked_by')->nullable();
            $table->timestamp('blocked_at')->nullable();
            $table->text('block_reason')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('user_id');
            $table->index('device_uuid');
            $table->index('device_type');
            $table->index('status');
            $table->index('login_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_devices');
    }
};
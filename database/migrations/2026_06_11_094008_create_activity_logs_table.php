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
        Schema::create('activity_logs', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | User Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->string('user_type')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Activity Information
            |--------------------------------------------------------------------------
            */

            $table->string('activity_type');

            $table->string('module');

            $table->string('action');

            $table->string('title')
                ->nullable();

            $table->text('description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Entity Reference
            |--------------------------------------------------------------------------
            */

            $table->string('subject_type')
                ->nullable();

            $table->unsignedBigInteger('subject_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Changes Tracking
            |--------------------------------------------------------------------------
            */

            $table->json('old_values')
                ->nullable();

            $table->json('new_values')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Request Information
            |--------------------------------------------------------------------------
            */

            $table->ipAddress('ip_address')
                ->nullable();

            $table->text('user_agent')
                ->nullable();

            $table->string('device')
                ->nullable();

            $table->string('platform')
                ->nullable();

            $table->string('browser')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Location Information
            |--------------------------------------------------------------------------
            */

            $table->string('country')
                ->nullable();

            $table->string('state')
                ->nullable();

            $table->string('city')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Session Information
            |--------------------------------------------------------------------------
            */

            $table->string('session_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'success',
                'failed',
                'warning'
            ])->default('success');

            /*
            |--------------------------------------------------------------------------
            | Related References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('leads')
                ->nullOnDelete();

            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained('appointments')
                ->nullOnDelete();

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            $table->foreignId('delivery_id')
                ->nullable()
                ->constrained('deliveries')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Activity Time
            |--------------------------------------------------------------------------
            */

            $table->timestamp('activity_at')
                ->useCurrent();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('user_id');
            $table->index('activity_type');
            $table->index('module');
            $table->index('action');
            $table->index('status');
            $table->index('activity_at');

            $table->index([
                'subject_type',
                'subject_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
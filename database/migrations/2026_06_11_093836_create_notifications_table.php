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
        Schema::create('notifications', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Notification Information
            |--------------------------------------------------------------------------
            */

            $table->string('notification_number')
                ->unique();

            $table->string('title');

            $table->text('message');

            /*
            |--------------------------------------------------------------------------
            | Recipient
            |--------------------------------------------------------------------------
            */

            $table->string('recipient_type');

            $table->unsignedBigInteger('recipient_id');

            /*
            |--------------------------------------------------------------------------
            | Notification Type
            |--------------------------------------------------------------------------
            */

            $table->enum('type', [
                'system',
                'order',
                'delivery',
                'lead',
                'appointment',
                'measurement',
                'commission',
                'wallet',
                'withdrawal',
                'promotion',
                'reminder'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Channel
            |--------------------------------------------------------------------------
            */

            $table->enum('channel', [
                'in_app',
                'push',
                'sms',
                'email',
                'whatsapp'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Priority
            |--------------------------------------------------------------------------
            */

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'critical'
            ])->default('medium');

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'queued',
                'sent',
                'delivered',
                'read',
                'failed'
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Related References
            |--------------------------------------------------------------------------
            */

            $table->string('reference_type')
                ->nullable();

            $table->unsignedBigInteger('reference_id')
                ->nullable();

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            $table->foreignId('delivery_id')
                ->nullable()
                ->constrained('deliveries')
                ->nullOnDelete();

            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('leads')
                ->nullOnDelete();

            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained('appointments')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Delivery Tracking
            |--------------------------------------------------------------------------
            */

            $table->timestamp('scheduled_at')
                ->nullable();

            $table->timestamp('sent_at')
                ->nullable();

            $table->timestamp('delivered_at')
                ->nullable();

            $table->timestamp('read_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Failure Tracking
            |--------------------------------------------------------------------------
            */

            $table->integer('retry_count')
                ->default(0);

            $table->text('failure_reason')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Action
            |--------------------------------------------------------------------------
            */

            $table->string('action_url')
                ->nullable();

            $table->string('icon')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Additional Data
            |--------------------------------------------------------------------------
            */

            $table->json('payload')
                ->nullable();

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('notification_number');
            $table->index('recipient_type');
            $table->index('recipient_id');
            $table->index('type');
            $table->index('channel');
            $table->index('priority');
            $table->index('status');
            $table->index('scheduled_at');
            $table->index('sent_at');

            $table->index([
                'reference_type',
                'reference_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
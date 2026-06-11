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
        Schema::create('notification_logs', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Notification Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('notification_id')
                ->constrained('notifications')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Recipient
            |--------------------------------------------------------------------------
            */

            $table->string('recipient_type');

            $table->unsignedBigInteger('recipient_id');

            /*
            |--------------------------------------------------------------------------
            | Channel Information
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
            | Provider Information
            |--------------------------------------------------------------------------
            */

            $table->string('provider')
                ->nullable();

            $table->string('provider_message_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Event Type
            |--------------------------------------------------------------------------
            */

            $table->enum('event_type', [
                'queued',
                'sent',
                'delivered',
                'opened',
                'clicked',
                'read',
                'failed',
                'bounced',
                'rejected',
                'unsubscribed'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Delivery Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'success',
                'failed'
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Contact Snapshot
            |--------------------------------------------------------------------------
            */

            $table->string('mobile')
                ->nullable();

            $table->string('email')
                ->nullable();

            $table->string('device_token')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Response Information
            |--------------------------------------------------------------------------
            */

            $table->text('response_message')
                ->nullable();

            $table->string('response_code')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Failure Information
            |--------------------------------------------------------------------------
            */

            $table->text('failure_reason')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Timing
            |--------------------------------------------------------------------------
            */

            $table->timestamp('queued_at')
                ->nullable();

            $table->timestamp('sent_at')
                ->nullable();

            $table->timestamp('delivered_at')
                ->nullable();

            $table->timestamp('opened_at')
                ->nullable();

            $table->timestamp('clicked_at')
                ->nullable();

            $table->timestamp('read_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Retry Information
            |--------------------------------------------------------------------------
            */

            $table->integer('attempt_number')
                ->default(1);

            $table->integer('retry_count')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | References
            |--------------------------------------------------------------------------
            */

            $table->string('reference_type')
                ->nullable();

            $table->unsignedBigInteger('reference_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Payload
            |--------------------------------------------------------------------------
            */

            $table->json('request_payload')
                ->nullable();

            $table->json('response_payload')
                ->nullable();

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('notification_id');
            $table->index('recipient_type');
            $table->index('recipient_id');
            $table->index('channel');
            $table->index('provider');
            $table->index('event_type');
            $table->index('status');
            $table->index('provider_message_id');
            $table->index('sent_at');
            $table->index('delivered_at');

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
        Schema::dropIfExists('notification_logs');
    }
};
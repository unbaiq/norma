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
        Schema::create('ticket_messages', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Ticket Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('support_ticket_id')
                ->constrained('support_tickets')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Sender Information
            |--------------------------------------------------------------------------
            */

            $table->string('sender_type');

            $table->unsignedBigInteger('sender_id');

            /*
            |--------------------------------------------------------------------------
            | Message Type
            |--------------------------------------------------------------------------
            */

            $table->enum('message_type', [
                'message',
                'reply',
                'internal_note',
                'system_note',
                'status_update'
            ])->default('message');

            /*
            |--------------------------------------------------------------------------
            | Message Content
            |--------------------------------------------------------------------------
            */

            $table->longText('message');

            /*
            |--------------------------------------------------------------------------
            | Attachments
            |--------------------------------------------------------------------------
            */

            $table->json('attachments')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Read Tracking
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_read')
                ->default(false);

            $table->timestamp('read_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Visibility
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_internal')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Status Tracking
            |--------------------------------------------------------------------------
            */

            $table->string('old_status')
                ->nullable();

            $table->string('new_status')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Additional Data
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

            $table->index('support_ticket_id');
            $table->index('sender_type');
            $table->index('sender_id');
            $table->index('message_type');
            $table->index('is_read');
            $table->index('is_internal');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_messages');
    }
};
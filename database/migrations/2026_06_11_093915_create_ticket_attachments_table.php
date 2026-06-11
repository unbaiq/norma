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
        Schema::create('ticket_attachments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Ticket Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('support_ticket_id')
                ->constrained('support_tickets')
                ->cascadeOnDelete();

            $table->foreignId('ticket_message_id')
                ->nullable()
                ->constrained('ticket_messages')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Uploaded By
            |--------------------------------------------------------------------------
            */

            $table->string('uploaded_by_type');

            $table->unsignedBigInteger('uploaded_by_id');

            /*
            |--------------------------------------------------------------------------
            | File Information
            |--------------------------------------------------------------------------
            */

            $table->string('file_name');

            $table->string('original_file_name');

            $table->string('file_path');

            $table->string('file_url')
                ->nullable();

            $table->string('disk')
                ->default('public');

            /*
            |--------------------------------------------------------------------------
            | File Details
            |--------------------------------------------------------------------------
            */

            $table->string('file_type')
                ->nullable();

            $table->string('mime_type')
                ->nullable();

            $table->unsignedBigInteger('file_size')
                ->default(0);

            $table->string('extension', 20)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Attachment Category
            |--------------------------------------------------------------------------
            */

            $table->enum('attachment_type', [
                'image',
                'document',
                'pdf',
                'invoice',
                'audio',
                'video',
                'medical_report',
                'identity_proof',
                'delivery_proof',
                'other'
            ])->default('document');

            /*
            |--------------------------------------------------------------------------
            | Security
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_private')
                ->default(true);

            $table->boolean('is_verified')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Preview
            |--------------------------------------------------------------------------
            */

            $table->string('thumbnail_path')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->timestamp('uploaded_at')
                ->useCurrent();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('support_ticket_id');
            $table->index('ticket_message_id');
            $table->index('uploaded_by_type');
            $table->index('uploaded_by_id');
            $table->index('attachment_type');
            $table->index('mime_type');
            $table->index('is_private');
            $table->index('uploaded_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_attachments');
    }
};
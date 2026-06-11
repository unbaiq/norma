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
        Schema::create('lead_attachments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Lead Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('lead_id')
                ->constrained('leads')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Uploaded By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('uploaded_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Attachment Information
            |--------------------------------------------------------------------------
            */

            $table->string('attachment_code')
                ->unique();

            $table->string('title');

            $table->text('description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Attachment Type
            |--------------------------------------------------------------------------
            */

            $table->enum('attachment_type', [
                'prescription',
                'medical_report',
                'xray',
                'mri',
                'photo',
                'measurement_photo',
                'appointment_document',
                'call_recording',
                'invoice',
                'delivery_proof',
                'kyc_document',
                'agreement',
                'other'
            ])->default('other');

            /*
            |--------------------------------------------------------------------------
            | File Information
            |--------------------------------------------------------------------------
            */

            $table->string('file_name');

            $table->string('original_file_name')
                ->nullable();

            $table->string('file_path');

            $table->string('file_extension')
                ->nullable();

            $table->string('mime_type')
                ->nullable();

            $table->unsignedBigInteger('file_size')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Related Module
            |--------------------------------------------------------------------------
            */

            $table->string('reference_type')
                ->nullable();

            $table->unsignedBigInteger('reference_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Visibility
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_customer_visible')
                ->default(false);

            $table->boolean('is_internal')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_verified')
                ->default(false);

            $table->timestamp('verified_at')
                ->nullable();

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'inactive',
                'rejected',
                'deleted'
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            $table->timestamp('uploaded_at')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('lead_id');
            $table->index('uploaded_by');
            $table->index('attachment_type');
            $table->index('status');
            $table->index('is_verified');

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
        Schema::dropIfExists('lead_attachments');
    }
};
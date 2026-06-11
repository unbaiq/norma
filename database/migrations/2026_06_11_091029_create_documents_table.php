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
        Schema::create('documents', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Owner Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Polymorphic Relation
            |--------------------------------------------------------------------------
            */

            $table->string('documentable_type')->nullable();
            $table->unsignedBigInteger('documentable_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Document Information
            |--------------------------------------------------------------------------
            */

            $table->string('document_code')->unique();

            $table->string('document_name');

            $table->enum('document_type', [

                // Identity
                'aadhaar',
                'pan',

                // Business
                'gst_certificate',
                'drug_license',
                'business_registration',

                // Banking
                'cancelled_cheque',
                'passbook',

                // Healthcare
                'prescription',
                'medical_report',

                // Operations
                'invoice',
                'agreement',
                'delivery_proof',

                // Employee
                'employee_id',
                'offer_letter',

                // Generic
                'other'
            ]);

            /*
            |--------------------------------------------------------------------------
            | File Information
            |--------------------------------------------------------------------------
            */

            $table->string('file_name');

            $table->string('original_file_name')->nullable();

            $table->string('file_path');

            $table->string('file_extension')->nullable();

            $table->string('mime_type')->nullable();

            $table->unsignedBigInteger('file_size')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Document Number
            |--------------------------------------------------------------------------
            */

            $table->string('document_number')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Validity
            |--------------------------------------------------------------------------
            */

            $table->date('issued_date')->nullable();

            $table->date('expiry_date')->nullable();

            $table->boolean('is_expired')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_verified')->default(false);

            $table->timestamp('verified_at')->nullable();

            $table->unsignedBigInteger('verified_by')->nullable();

            $table->text('verification_remarks')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Approval Workflow
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'under_review',
                'approved',
                'rejected',
                'expired'
            ])->default('pending');

            $table->text('rejection_reason')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Security
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_sensitive')->default(false);

            $table->boolean('is_public')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('meta')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('uploaded_by')->nullable();

            $table->timestamp('uploaded_at')->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('user_id');
            $table->index('document_type');
            $table->index('status');
            $table->index('document_number');
            $table->index('expiry_date');

            $table->index([
                'documentable_type',
                'documentable_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
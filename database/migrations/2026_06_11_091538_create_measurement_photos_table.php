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
        Schema::create('measurement_photos', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Measurement Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('measurement_id')
                ->constrained('measurements')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('field_executive_id')
                ->nullable()
                ->constrained('field_executives')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Photo Information
            |--------------------------------------------------------------------------
            */

            $table->string('photo_code')
                ->unique();

            $table->string('title')
                ->nullable();

            $table->text('description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Photo Type
            |--------------------------------------------------------------------------
            */

            $table->enum('photo_type', [
                'front_view',
                'back_view',
                'left_view',
                'right_view',
                'measurement_photo',
                'problem_area',
                'product_trial',
                'before_treatment',
                'after_treatment',
                'prescription',
                'medical_report',
                'customer_consent',
                'other'
            ])->default('measurement_photo');

            /*
            |--------------------------------------------------------------------------
            | File Information
            |--------------------------------------------------------------------------
            */

            $table->string('file_name');

            $table->string('original_name')
                ->nullable();

            $table->string('file_path');

            $table->string('file_url')
                ->nullable();

            $table->string('file_extension')
                ->nullable();

            $table->string('mime_type')
                ->nullable();

            $table->unsignedBigInteger('file_size')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Image Dimensions
            |--------------------------------------------------------------------------
            */

            $table->integer('width')
                ->nullable();

            $table->integer('height')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_verified')
                ->default(false);

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('verified_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | GPS Verification
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | AI Analysis
            |--------------------------------------------------------------------------
            */

            $table->boolean('ai_processed')
                ->default(false);

            $table->json('ai_analysis')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Customer Consent
            |--------------------------------------------------------------------------
            */

            $table->boolean('customer_consent')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'uploaded',
                'approved',
                'rejected',
                'archived'
            ])->default('uploaded');

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            $table->timestamp('captured_at')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('measurement_id');
            $table->index('customer_id');
            $table->index('field_executive_id');
            $table->index('photo_code');
            $table->index('photo_type');
            $table->index('status');
            $table->index('captured_at');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurement_photos');
    }
};
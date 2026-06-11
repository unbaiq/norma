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
        Schema::create('product_images', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Product Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('product_variant_id')
                ->nullable()
                ->constrained('product_variants')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Image Information
            |--------------------------------------------------------------------------
            */

            $table->string('image_code')
                ->unique();

            $table->string('title')
                ->nullable();

            $table->text('description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Image Type
            |--------------------------------------------------------------------------
            */

            $table->enum('image_type', [
                'thumbnail',
                'gallery',
                'front_view',
                'back_view',
                'side_view',
                'lifestyle',
                'size_chart',
                'instruction',
                'packaging',
                'certificate',
                'banner'
            ])->default('gallery');

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
            | Display Settings
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_primary')
                ->default(false);

            $table->boolean('is_featured')
                ->default(false);

            $table->integer('sort_order')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | AI Processing
            |--------------------------------------------------------------------------
            */

            $table->boolean('ai_processed')
                ->default(false);

            $table->json('ai_tags')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->foreignId('uploaded_by')
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

            $table->index('product_id');
            $table->index('product_variant_id');
            $table->index('image_code');
            $table->index('image_type');
            $table->index('is_primary');
            $table->index('is_featured');
            $table->index('sort_order');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
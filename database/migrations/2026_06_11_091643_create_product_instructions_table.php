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
        Schema::create('product_instructions', function (Blueprint $table) {

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
            | Instruction Information
            |--------------------------------------------------------------------------
            */

            $table->string('instruction_code')
                ->unique();

            $table->string('title');

            $table->text('short_description')
                ->nullable();

            $table->longText('instruction');

            /*
            |--------------------------------------------------------------------------
            | Instruction Type
            |--------------------------------------------------------------------------
            */

            $table->enum('instruction_type', [
                'usage',
                'wearing',
                'installation',
                'cleaning',
                'maintenance',
                'storage',
                'safety',
                'replacement',
                'exercise',
                'rehabilitation',
                'faq',
                'other'
            ])->default('usage');

            /*
            |--------------------------------------------------------------------------
            | Display
            |--------------------------------------------------------------------------
            */

            $table->integer('sort_order')
                ->default(0);

            $table->boolean('is_featured')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Media
            |--------------------------------------------------------------------------
            */

            $table->string('video_url')
                ->nullable();

            $table->string('pdf_file')
                ->nullable();

            $table->string('image')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Customer App Visibility
            |--------------------------------------------------------------------------
            */

            $table->boolean('show_in_customer_app')
                ->default(true);

            $table->boolean('show_in_chemist_app')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Product Lifecycle
            |--------------------------------------------------------------------------
            */

            $table->integer('replacement_after_days')
                ->nullable();

            $table->integer('maintenance_interval_days')
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

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
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
            $table->index('instruction_code');
            $table->index('instruction_type');
            $table->index('is_active');
            $table->index('show_in_customer_app');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_instructions');
    }
};
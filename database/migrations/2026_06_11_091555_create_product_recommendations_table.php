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
        Schema::create('product_recommendations', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Recommendation Information
            |--------------------------------------------------------------------------
            */

            $table->string('recommendation_code')
                ->unique();

            /*
            |--------------------------------------------------------------------------
            | References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('measurement_id')
                ->constrained('measurements')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
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
            | Executive Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('field_executive_id')
                ->nullable()
                ->constrained('field_executives')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Recommendation Details
            |--------------------------------------------------------------------------
            */

            $table->string('problem_category')
                ->nullable();

            $table->string('affected_area')
                ->nullable();

            $table->string('recommended_product');

            $table->string('product_category')
                ->nullable();

            $table->string('product_size')
                ->nullable();

            $table->string('product_variant')
                ->nullable();

            $table->integer('quantity')
                ->default(1);

            /*
            |--------------------------------------------------------------------------
            | Medical Justification
            |--------------------------------------------------------------------------
            */

            $table->longText('recommendation_reason')
                ->nullable();

            $table->longText('clinical_notes')
                ->nullable();

            $table->longText('usage_instructions')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            $table->decimal('mrp', 12, 2)
                ->default(0);

            $table->decimal('selling_price', 12, 2)
                ->default(0);

            $table->decimal('discount_amount', 12, 2)
                ->default(0);

            $table->decimal('final_price', 12, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | AI Recommendation
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_ai_recommended')
                ->default(false);

            $table->decimal('confidence_score', 5, 2)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Customer Approval
            |--------------------------------------------------------------------------
            */

            $table->boolean('customer_approved')
                ->default(false);

            $table->timestamp('customer_approved_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Order Conversion
            |--------------------------------------------------------------------------
            */

            $table->boolean('converted_to_order')
                ->default(false);

            $table->unsignedBigInteger('order_id')
                ->nullable();

            $table->timestamp('converted_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'recommended',
                'approved',
                'rejected',
                'converted',
                'expired'
            ])->default('recommended');

            /*
            |--------------------------------------------------------------------------
            | Validity
            |--------------------------------------------------------------------------
            */

            $table->date('valid_until')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Approval
            |--------------------------------------------------------------------------
            */

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Metadata
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

            $table->index('recommendation_code');
            $table->index('measurement_id');
            $table->index('customer_id');
            $table->index('lead_id');
            $table->index('appointment_id');
            $table->index('field_executive_id');
            $table->index('status');
            $table->index('customer_approved');
            $table->index('converted_to_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_recommendations');
    }
};
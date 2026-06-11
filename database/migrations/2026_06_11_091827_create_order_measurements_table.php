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
        Schema::create('order_measurements', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('order_item_id')
                ->nullable()
                ->constrained('order_items')
                ->cascadeOnDelete();

            $table->foreignId('measurement_id')
                ->nullable()
                ->constrained('measurements')
                ->nullOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Measurement Snapshot
            |--------------------------------------------------------------------------
            */

            $table->string('measurement_type');

            $table->string('body_part')
                ->nullable();

            $table->decimal('measurement_value', 10, 2);

            $table->string('measurement_unit')
                ->default('cm');

            /*
            |--------------------------------------------------------------------------
            | Product Fitting
            |--------------------------------------------------------------------------
            */

            $table->string('recommended_size')
                ->nullable();

            $table->string('selected_size')
                ->nullable();

            $table->string('fitting_type')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Clinical Information
            |--------------------------------------------------------------------------
            */

            $table->string('affected_area')
                ->nullable();

            $table->integer('pain_score')
                ->nullable();

            $table->text('observation_notes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->foreignId('field_executive_id')
                ->nullable()
                ->constrained('field_executives')
                ->nullOnDelete();

            $table->boolean('is_verified')
                ->default(false);

            $table->timestamp('verified_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Additional Information
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('order_id');
            $table->index('order_item_id');
            $table->index('measurement_id');
            $table->index('customer_id');
            $table->index('measurement_type');
            $table->index('recommended_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_measurements');
    }
};
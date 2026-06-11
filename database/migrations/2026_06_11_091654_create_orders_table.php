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
        Schema::create('orders', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Order Information
            |--------------------------------------------------------------------------
            */

            $table->string('order_number')->unique();

            /*
            |--------------------------------------------------------------------------
            | Customer References
            |--------------------------------------------------------------------------
            */

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

            $table->foreignId('measurement_id')
                ->nullable()
                ->constrained('measurements')
                ->nullOnDelete();

            $table->foreignId('product_recommendation_id')
                ->nullable()
                ->constrained('product_recommendations')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Partner References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('chemist_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('distributor_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('field_executive_id')
                ->nullable()
                ->constrained('field_executives')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Order Type
            |--------------------------------------------------------------------------
            */

            $table->enum('order_type', [
                'measurement_order',
                'walkin_order',
                'replacement_order',
                'service_order'
            ])->default('measurement_order');

            /*
            |--------------------------------------------------------------------------
            | Customer Information
            |--------------------------------------------------------------------------
            */

            $table->string('customer_name');

            $table->string('customer_mobile');

            $table->string('customer_email')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Delivery Address
            |--------------------------------------------------------------------------
            */

            $table->text('delivery_address');

            $table->foreignId('country_id')
                ->nullable()
                ->constrained('countries')
                ->nullOnDelete();

            $table->foreignId('state_id')
                ->nullable()
                ->constrained('states')
                ->nullOnDelete();

            $table->foreignId('city_id')
                ->nullable()
                ->constrained('cities')
                ->nullOnDelete();

            $table->foreignId('area_id')
                ->nullable()
                ->constrained('areas')
                ->nullOnDelete();

            $table->foreignId('pincode_id')
                ->nullable()
                ->constrained('pincodes')
                ->nullOnDelete();

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Pricing
            |--------------------------------------------------------------------------
            */

            $table->decimal('subtotal', 12, 2)
                ->default(0);

            $table->decimal('discount_amount', 12, 2)
                ->default(0);

            $table->decimal('tax_amount', 12, 2)
                ->default(0);

            $table->decimal('shipping_amount', 12, 2)
                ->default(0);

            $table->decimal('total_amount', 12, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            $table->enum('payment_method', [
                'cash',
                'upi',
                'card',
                'bank_transfer',
                'cod'
            ])->nullable();

            $table->enum('payment_status', [
                'pending',
                'partial',
                'paid',
                'failed',
                'refunded'
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Order Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'draft',
                'created',
                'confirmed',
                'processing',
                'ready',
                'dispatched',
                'out_for_delivery',
                'delivered',
                'cancelled',
                'returned'
            ])->default('created');

            /*
            |--------------------------------------------------------------------------
            | Delivery Tracking
            |--------------------------------------------------------------------------
            */

            $table->string('tracking_number')
                ->nullable();

            $table->date('expected_delivery_date')
                ->nullable();

            $table->timestamp('dispatched_at')
                ->nullable();

            $table->timestamp('delivered_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Commission Tracking
            |--------------------------------------------------------------------------
            */

            $table->boolean('commission_generated')
                ->default(false);

            $table->boolean('commission_paid')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            $table->longText('notes')
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

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

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

            $table->index('order_number');
            $table->index('customer_id');
            $table->index('lead_id');
            $table->index('appointment_id');
            $table->index('measurement_id');
            $table->index('chemist_id');
            $table->index('distributor_id');
            $table->index('status');
            $table->index('payment_status');
            $table->index('tracking_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
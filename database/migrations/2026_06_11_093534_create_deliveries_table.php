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
        Schema::create('deliveries', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Delivery Information
            |--------------------------------------------------------------------------
            */

            $table->string('delivery_number')->unique();

            /*
            |--------------------------------------------------------------------------
            | Order References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Delivery Assignment
            |--------------------------------------------------------------------------
            */

            $table->foreignId('field_executive_id')
                ->nullable()
                ->constrained('field_executives')
                ->nullOnDelete();

            $table->foreignId('distributor_id')
                ->nullable()
                ->constrained('distributor_profiles')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Warehouse Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('warehouse_location_id')
                ->nullable()
                ->constrained('warehouse_locations')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Tracking
            |--------------------------------------------------------------------------
            */

            $table->string('tracking_number')
                ->nullable()
                ->unique();

            $table->string('awb_number')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Customer Information Snapshot
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

            /*
            |--------------------------------------------------------------------------
            | GPS Coordinates
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Delivery Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'packed',
                'dispatched',
                'in_transit',
                'out_for_delivery',
                'delivered',
                'failed',
                'returned',
                'cancelled'
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | OTP Verification
            |--------------------------------------------------------------------------
            */

            $table->string('delivery_otp')
                ->nullable();

            $table->boolean('otp_verified')
                ->default(false);

            $table->timestamp('otp_verified_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Delivery Dates
            |--------------------------------------------------------------------------
            */

            $table->date('expected_delivery_date')
                ->nullable();

            $table->timestamp('dispatched_at')
                ->nullable();

            $table->timestamp('out_for_delivery_at')
                ->nullable();

            $table->timestamp('delivered_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Delivery Confirmation
            |--------------------------------------------------------------------------
            */

            $table->string('receiver_name')
                ->nullable();

            $table->string('receiver_mobile')
                ->nullable();

            $table->text('delivery_notes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Failed Delivery
            |--------------------------------------------------------------------------
            */

            $table->integer('attempt_count')
                ->default(0);

            $table->text('failure_reason')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Return Information
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_returned')
                ->default(false);

            $table->text('return_reason')
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

            $table->index('delivery_number');
            $table->index('order_id');
            $table->index('customer_id');
            $table->index('field_executive_id');
            $table->index('distributor_id');
            $table->index('warehouse_location_id');
            $table->index('tracking_number');
            $table->index('status');
            $table->index('expected_delivery_date');
            $table->index('delivered_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
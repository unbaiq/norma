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
        Schema::create('delivery_trackings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Tracking Information
            |--------------------------------------------------------------------------
            */

            $table->string('tracking_code')->unique();

            /*
            |--------------------------------------------------------------------------
            | Delivery References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('delivery_id')
                ->constrained('deliveries')
                ->cascadeOnDelete();

            $table->foreignId('delivery_assignment_id')
                ->nullable()
                ->constrained('delivery_assignments')
                ->nullOnDelete();

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Tracking Event
            |--------------------------------------------------------------------------
            */

            $table->enum('event_type', [
                'assigned',
                'picked_up',
                'warehouse_departure',
                'hub_arrival',
                'hub_departure',
                'in_transit',
                'out_for_delivery',
                'near_customer',
                'delivery_attempted',
                'delivered',
                'returned',
                'cancelled'
            ]);

            $table->string('status');

            /*
            |--------------------------------------------------------------------------
            | Location Information
            |--------------------------------------------------------------------------
            */

            $table->string('location_name')
                ->nullable();

            $table->text('address')
                ->nullable();

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Distance Tracking
            |--------------------------------------------------------------------------
            */

            $table->decimal('distance_from_destination', 10, 2)
                ->nullable();

            $table->decimal('distance_travelled', 10, 2)
                ->nullable();

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
            | Delivery Attempt
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_successful')
                ->default(true);

            $table->text('failure_reason')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | ETA
            |--------------------------------------------------------------------------
            */

            $table->timestamp('estimated_delivery_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Event Timestamp
            |--------------------------------------------------------------------------
            */

            $table->timestamp('tracked_at');

            /*
            |--------------------------------------------------------------------------
            | Metadata
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

            $table->index('tracking_code');
            $table->index('delivery_id');
            $table->index('delivery_assignment_id');
            $table->index('order_id');
            $table->index('event_type');
            $table->index('field_executive_id');
            $table->index('tracked_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_trackings');
    }
};
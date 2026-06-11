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
        Schema::create('delivery_status_histories', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Delivery Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('delivery_id')
                ->constrained('deliveries')
                ->cascadeOnDelete();

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Status Information
            |--------------------------------------------------------------------------
            */

            $table->string('from_status')
                ->nullable();

            $table->string('to_status');

            /*
            |--------------------------------------------------------------------------
            | Changed By
            |--------------------------------------------------------------------------
            */

            $table->foreignId('changed_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Assignment Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('delivery_assignment_id')
                ->nullable()
                ->constrained('delivery_assignments')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Tracking Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('delivery_tracking_id')
                ->nullable()
                ->constrained('delivery_trackings')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Status Reason
            |--------------------------------------------------------------------------
            */

            $table->string('reason')
                ->nullable();

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Failure Information
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_failed')
                ->default(false);

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
            | SLA Tracking
            |--------------------------------------------------------------------------
            */

            $table->integer('time_in_previous_status_minutes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Location Snapshot
            |--------------------------------------------------------------------------
            */

            $table->string('location_name')
                ->nullable();

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Customer Notification
            |--------------------------------------------------------------------------
            */

            $table->boolean('customer_notified')
                ->default(false);

            $table->timestamp('customer_notified_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status Change Time
            |--------------------------------------------------------------------------
            */

            $table->timestamp('status_changed_at');

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

            $table->index('delivery_id');
            $table->index('order_id');
            $table->index('from_status');
            $table->index('to_status');
            $table->index('changed_by');
            $table->index('status_changed_at');
            $table->index('is_failed');
            $table->index('is_returned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_status_histories');
    }
};
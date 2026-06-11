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
        Schema::create('delivery_assignments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Assignment Information
            |--------------------------------------------------------------------------
            */

            $table->string('assignment_number')
                ->unique();

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
            | Assigned Resource
            |--------------------------------------------------------------------------
            */

            $table->enum('assignee_type', [
                'field_executive',
                'delivery_executive',
                'distributor',
                'courier_partner',
                'logistics_partner'
            ]);

            $table->unsignedBigInteger('assignee_id');

            /*
            |--------------------------------------------------------------------------
            | Assignment Source
            |--------------------------------------------------------------------------
            */

            $table->foreignId('assigned_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Previous Assignment
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('previous_assignee_id')
                ->nullable();

            $table->string('previous_assignee_type')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Priority
            |--------------------------------------------------------------------------
            */

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'urgent'
            ])->default('medium');

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'assigned',
                'accepted',
                'picked_up',
                'in_transit',
                'out_for_delivery',
                'delivered',
                'failed',
                'cancelled',
                'reassigned'
            ])->default('assigned');

            /*
            |--------------------------------------------------------------------------
            | Schedule
            |--------------------------------------------------------------------------
            */

            $table->timestamp('assigned_at');

            $table->timestamp('accepted_at')
                ->nullable();

            $table->timestamp('picked_up_at')
                ->nullable();

            $table->timestamp('out_for_delivery_at')
                ->nullable();

            $table->timestamp('delivered_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | SLA Tracking
            |--------------------------------------------------------------------------
            */

            $table->integer('sla_hours')
                ->default(24);

            $table->boolean('sla_breached')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Vehicle Information
            |--------------------------------------------------------------------------
            */

            $table->string('vehicle_type')
                ->nullable();

            $table->string('vehicle_number')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Failure / Reassignment
            |--------------------------------------------------------------------------
            */

            $table->text('failure_reason')
                ->nullable();

            $table->text('reassignment_reason')
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

            $table->index('assignment_number');
            $table->index('delivery_id');
            $table->index('order_id');
            $table->index('assignee_type');
            $table->index('assignee_id');
            $table->index('status');
            $table->index('priority');
            $table->index('assigned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_assignments');
    }
};
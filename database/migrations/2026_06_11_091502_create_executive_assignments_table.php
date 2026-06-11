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
        Schema::create('executive_assignments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Executive
            |--------------------------------------------------------------------------
            */

            $table->foreignId('field_executive_id')
                ->constrained('field_executives')
                ->cascadeOnDelete();

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
            | Assignment Type
            |--------------------------------------------------------------------------
            */

            $table->enum('assignment_type', [
                'lead',
                'appointment',
                'measurement',
                'order',
                'delivery',
                'followup_visit',
                'service_visit'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Dynamic Reference
            |--------------------------------------------------------------------------
            */

            $table->string('reference_type');

            $table->unsignedBigInteger('reference_id');

            /*
            |--------------------------------------------------------------------------
            | Customer Information
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

            /*
            |--------------------------------------------------------------------------
            | Territory
            |--------------------------------------------------------------------------
            */

            $table->foreignId('territory_id')
                ->nullable()
                ->constrained('territories')
                ->nullOnDelete();

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
            | Assignment Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'assigned',
                'accepted',
                'in_progress',
                'completed',
                'cancelled',
                'reassigned',
                'rejected'
            ])->default('assigned');

            /*
            |--------------------------------------------------------------------------
            | SLA
            |--------------------------------------------------------------------------
            */

            $table->integer('sla_minutes')
                ->nullable();

            $table->integer('actual_minutes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Schedule
            |--------------------------------------------------------------------------
            */

            $table->timestamp('scheduled_at')
                ->nullable();

            $table->timestamp('accepted_at')
                ->nullable();

            $table->timestamp('started_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Reassignment
            |--------------------------------------------------------------------------
            */

            $table->foreignId('previous_executive_id')
                ->nullable()
                ->constrained('field_executives')
                ->nullOnDelete();

            $table->text('reassignment_reason')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | GPS Verification
            |--------------------------------------------------------------------------
            */

            $table->decimal('start_latitude', 10, 8)
                ->nullable();

            $table->decimal('start_longitude', 11, 8)
                ->nullable();

            $table->decimal('end_latitude', 10, 8)
                ->nullable();

            $table->decimal('end_longitude', 11, 8)
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

            $table->index('field_executive_id');
            $table->index('lead_id');
            $table->index('appointment_id');
            $table->index('territory_id');
            $table->index('assignment_type');
            $table->index('status');
            $table->index('scheduled_at');

            $table->index([
                'reference_type',
                'reference_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executive_assignments');
    }
};
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
        Schema::create('lead_assignments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Lead Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('lead_id')
                ->constrained('leads')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Assignment Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('assigned_to')
                ->constrained('users')
                ->cascadeOnDelete();

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
                'calling_agent',
                'team_lead',
                'field_executive',
                'operations',
                'distributor',
                'manager',
                'crm'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Previous Owner
            |--------------------------------------------------------------------------
            */

            $table->foreignId('previous_assignee')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Assignment Reason
            |--------------------------------------------------------------------------
            */

            $table->string('reason')
                ->nullable();

            $table->text('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Assignment Period
            |--------------------------------------------------------------------------
            */

            $table->timestamp('assigned_at');

            $table->timestamp('accepted_at')
                ->nullable();

            $table->timestamp('completed_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | SLA Tracking
            |--------------------------------------------------------------------------
            */

            $table->integer('sla_minutes')
                ->nullable();

            $table->integer('actual_minutes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Assignment Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'accepted',
                'in_progress',
                'completed',
                'reassigned',
                'cancelled',
                'rejected'
            ])->default('pending');

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

            $table->index('lead_id');
            $table->index('assigned_to');
            $table->index('assigned_by');
            $table->index('assignment_type');
            $table->index('status');
            $table->index('territory_id');
            $table->index('assigned_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_assignments');
    }
};
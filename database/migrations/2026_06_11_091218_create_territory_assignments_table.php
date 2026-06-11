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
        Schema::create('territory_assignments', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Territory
            |--------------------------------------------------------------------------
            */

            $table->foreignId('territory_id')
                ->constrained('territories')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | User
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Assignment Type
            |--------------------------------------------------------------------------
            */

            $table->enum('assignment_type', [
                'chemist',
                'distributor',
                'calling_agent',
                'field_executive',
                'manager',
                'supervisor'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Coverage
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_primary')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Assignment Period
            |--------------------------------------------------------------------------
            */

            $table->date('assigned_from');

            $table->date('assigned_to')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Assignment Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'inactive',
                'completed',
                'transferred'
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | Performance Tracking
            |--------------------------------------------------------------------------
            */

            $table->integer('assigned_leads')
                ->default(0);

            $table->integer('completed_leads')
                ->default(0);

            $table->integer('appointments_completed')
                ->default(0);

            $table->integer('orders_completed')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Approval
            |--------------------------------------------------------------------------
            */

            $table->foreignId('assigned_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Remarks
            |--------------------------------------------------------------------------
            */

            $table->text('remarks')
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

            $table->index('territory_id');
            $table->index('user_id');
            $table->index('assignment_type');
            $table->index('status');
            $table->index('assigned_from');

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Active Assignments
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'territory_id',
                'user_id',
                'assignment_type'
            ], 'territory_user_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('territory_assignments');
    }
};
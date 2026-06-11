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
        Schema::create('lead_statuses', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Status Information
            |--------------------------------------------------------------------------
            */

            $table->string('status_code')->unique();

            $table->string('name');

            $table->string('slug')->unique();

            $table->text('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Workflow
            |--------------------------------------------------------------------------
            */

            $table->integer('sequence')
                ->default(1);

            $table->unsignedBigInteger('parent_status_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status Type
            |--------------------------------------------------------------------------
            */

            $table->enum('status_type', [
                'new',
                'in_progress',
                'followup',
                'success',
                'failed',
                'closed'
            ])->default('new');

            /*
            |--------------------------------------------------------------------------
            | UI
            |--------------------------------------------------------------------------
            */

            $table->string('color_code')
                ->nullable();

            $table->string('icon')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Business Rules
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_initial')
                ->default(false);

            $table->boolean('is_final')
                ->default(false);

            $table->boolean('is_conversion_stage')
                ->default(false);

            $table->boolean('requires_followup')
                ->default(false);

            $table->boolean('requires_appointment')
                ->default(false);

            $table->boolean('requires_measurement')
                ->default(false);

            $table->boolean('requires_order')
                ->default(false);

            $table->boolean('generates_commission')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | SLA
            |--------------------------------------------------------------------------
            */

            $table->integer('sla_minutes')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('created_by')
                ->nullable();

            $table->unsignedBigInteger('updated_by')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Extra Data
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

            $table->index('status_code');
            $table->index('slug');
            $table->index('sequence');
            $table->index('status_type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_statuses');
    }
};
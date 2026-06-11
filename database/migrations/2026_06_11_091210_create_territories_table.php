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
        Schema::create('territories', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Territory Information
            |--------------------------------------------------------------------------
            */

            $table->string('territory_code')->unique();

            $table->string('name');

            $table->string('zone')->nullable();

            $table->text('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Location Mapping
            |--------------------------------------------------------------------------
            */

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->foreignId('state_id')
                ->constrained('states')
                ->cascadeOnDelete();

            $table->foreignId('city_id')
                ->constrained('cities')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Business Assignment
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('distributor_id')
                ->nullable();

            $table->unsignedBigInteger('manager_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Coverage Statistics
            |--------------------------------------------------------------------------
            */

            $table->integer('chemist_count')
                ->default(0);

            $table->integer('customer_count')
                ->default(0);

            $table->integer('field_executive_count')
                ->default(0);

            $table->integer('calling_agent_count')
                ->default(0);

            $table->integer('distributor_count')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Lead Statistics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_leads')
                ->default(0);

            $table->integer('converted_leads')
                ->default(0);

            $table->decimal('conversion_rate', 8, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Revenue Statistics
            |--------------------------------------------------------------------------
            */

            $table->decimal('total_revenue', 15, 2)
                ->default(0);

            $table->decimal('total_commission', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | SLA Configuration
            |--------------------------------------------------------------------------
            */

            $table->integer('lead_assignment_sla_minutes')
                ->default(15);

            $table->integer('appointment_sla_hours')
                ->default(24);

            $table->integer('delivery_sla_days')
                ->default(3);

            /*
            |--------------------------------------------------------------------------
            | Serviceability
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_serviceable')
                ->default(true);

            $table->boolean('is_active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Territory Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'inactive',
                'blocked'
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | Territory Type
            |--------------------------------------------------------------------------
            */

            $table->enum('territory_type', [
                'urban',
                'semi_urban',
                'rural',
                'metro'
            ])->default('urban');

            /*
            |--------------------------------------------------------------------------
            | Geo Boundary
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            $table->decimal('radius_km', 8, 2)
                ->nullable();

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
            | Additional Data
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

            $table->index('territory_code');
            $table->index('country_id');
            $table->index('state_id');
            $table->index('city_id');
            $table->index('distributor_id');
            $table->index('manager_id');
            $table->index('status');
            $table->index('territory_type');
            $table->index('is_serviceable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('territories');
    }
};
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
        Schema::create('daily_kpis', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | KPI Date
            |--------------------------------------------------------------------------
            */

            $table->date('kpi_date');

            /*
            |--------------------------------------------------------------------------
            | Lead Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_leads')
                ->default(0);

            $table->integer('qualified_leads')
                ->default(0);

            $table->integer('converted_leads')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Appointment Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('appointments_created')
                ->default(0);

            $table->integer('appointments_completed')
                ->default(0);

            $table->integer('appointments_cancelled')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Measurement Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('measurements_taken')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Order Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('orders_created')
                ->default(0);

            $table->integer('orders_completed')
                ->default(0);

            $table->integer('orders_cancelled')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Delivery Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('deliveries_completed')
                ->default(0);

            $table->integer('deliveries_failed')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Revenue Metrics
            |--------------------------------------------------------------------------
            */

            $table->decimal('gross_revenue', 15, 2)
                ->default(0);

            $table->decimal('net_revenue', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Commission Metrics
            |--------------------------------------------------------------------------
            */

            $table->decimal('commission_generated', 15, 2)
                ->default(0);

            $table->decimal('commission_paid', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Wallet Metrics
            |--------------------------------------------------------------------------
            */

            $table->decimal('withdrawal_requested', 15, 2)
                ->default(0);

            $table->decimal('withdrawal_paid', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | User Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('active_customers')
                ->default(0);

            $table->integer('active_chemists')
                ->default(0);

            $table->integer('active_distributors')
                ->default(0);

            $table->integer('active_field_executives')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Support Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('tickets_created')
                ->default(0);

            $table->integer('tickets_resolved')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Fraud Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('fraud_cases_created')
                ->default(0);

            $table->integer('fraud_cases_resolved')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Performance Metrics
            |--------------------------------------------------------------------------
            */

            $table->decimal('lead_conversion_rate', 8, 2)
                ->default(0);

            $table->decimal('appointment_completion_rate', 8, 2)
                ->default(0);

            $table->decimal('order_conversion_rate', 8, 2)
                ->default(0);

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
            | Constraints
            |--------------------------------------------------------------------------
            */

            $table->unique('kpi_date');

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('kpi_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_kpis');
    }
};
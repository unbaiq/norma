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
        Schema::create('performance_scores', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Entity Information
            |--------------------------------------------------------------------------
            */

            $table->string('entity_type');

            $table->unsignedBigInteger('entity_id');

            /*
            |--------------------------------------------------------------------------
            | Period Information
            |--------------------------------------------------------------------------
            */

            $table->enum('period_type', [
                'daily',
                'weekly',
                'monthly',
                'quarterly',
                'yearly'
            ]);

            $table->date('period_start');

            $table->date('period_end');

            /*
            |--------------------------------------------------------------------------
            | Performance Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_leads')
                ->default(0);

            $table->integer('converted_leads')
                ->default(0);

            $table->integer('appointments_completed')
                ->default(0);

            $table->integer('measurements_completed')
                ->default(0);

            $table->integer('orders_completed')
                ->default(0);

            $table->integer('deliveries_completed')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Financial Metrics
            |--------------------------------------------------------------------------
            */

            $table->decimal('revenue_generated', 15, 2)
                ->default(0);

            $table->decimal('commission_earned', 15, 2)
                ->default(0);

            $table->decimal('bonus_earned', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Quality Metrics
            |--------------------------------------------------------------------------
            */

            $table->decimal('customer_rating', 5, 2)
                ->default(0);

            $table->decimal('attendance_score', 8, 2)
                ->default(0);

            $table->decimal('response_score', 8, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | KPI Scores
            |--------------------------------------------------------------------------
            */

            $table->decimal('lead_score', 8, 2)
                ->default(0);

            $table->decimal('sales_score', 8, 2)
                ->default(0);

            $table->decimal('quality_score', 8, 2)
                ->default(0);

            $table->decimal('activity_score', 8, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Final Performance
            |--------------------------------------------------------------------------
            */

            $table->decimal('performance_score', 10, 2)
                ->default(0);

            $table->integer('rank_position')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Grade
            |--------------------------------------------------------------------------
            */

            $table->enum('grade', [
                'A+',
                'A',
                'B',
                'C',
                'D',
                'F'
            ])->nullable();

            /*
            |--------------------------------------------------------------------------
            | Achievement
            |--------------------------------------------------------------------------
            */

            $table->string('badge')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('calculation_data')
                ->nullable();

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('entity_type');
            $table->index('entity_id');
            $table->index('period_type');
            $table->index('performance_score');
            $table->index('rank_position');
            $table->index('grade');

            $table->unique([
                'entity_type',
                'entity_id',
                'period_type',
                'period_start'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('performance_scores');
    }
};
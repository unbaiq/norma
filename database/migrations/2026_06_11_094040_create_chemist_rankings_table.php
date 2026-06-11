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
        Schema::create('chemist_rankings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Chemist Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('chemist_profile_id')
                ->constrained('chemist_profiles')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Ranking Period
            |--------------------------------------------------------------------------
            */

            $table->year('year');

            $table->tinyInteger('month');

            $table->date('period_start');

            $table->date('period_end');

            /*
            |--------------------------------------------------------------------------
            | Lead Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_leads')
                ->default(0);

            $table->integer('converted_leads')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Order Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_orders')
                ->default(0);

            $table->integer('completed_orders')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Revenue Metrics
            |--------------------------------------------------------------------------
            */

            $table->decimal('total_revenue', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Commission Metrics
            |--------------------------------------------------------------------------
            */

            $table->decimal('commission_earned', 15, 2)
                ->default(0);

            $table->decimal('bonus_earned', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Customer Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('repeat_customers')
                ->default(0);

            $table->decimal('customer_rating', 5, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Performance Metrics
            |--------------------------------------------------------------------------
            */

            $table->decimal('conversion_rate', 8, 2)
                ->default(0);

            $table->decimal('success_rate', 8, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Ranking
            |--------------------------------------------------------------------------
            */

            $table->decimal('performance_score', 10, 2)
                ->default(0);

            $table->integer('rank_position')
                ->default(0);

            $table->integer('previous_rank')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Badge & Level
            |--------------------------------------------------------------------------
            */

            $table->enum('badge', [
                'bronze',
                'silver',
                'gold',
                'platinum',
                'diamond'
            ])->nullable();

            $table->string('level')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Rewards
            |--------------------------------------------------------------------------
            */

            $table->decimal('reward_amount', 15, 2)
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

            $table->unique([
                'chemist_profile_id',
                'year',
                'month'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('chemist_profile_id');
            $table->index('year');
            $table->index('month');
            $table->index('rank_position');
            $table->index('performance_score');
            $table->index('badge');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chemist_rankings');
    }
};
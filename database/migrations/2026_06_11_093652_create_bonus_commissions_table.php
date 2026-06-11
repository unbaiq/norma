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
        Schema::create('bonus_commissions', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Bonus Information
            |--------------------------------------------------------------------------
            */

            $table->string('bonus_number')->unique();

            $table->string('title');

            $table->text('description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Campaign Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('commission_campaign_id')
                ->nullable()
                ->constrained('commission_campaigns')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Beneficiary
            |--------------------------------------------------------------------------
            */

            $table->enum('beneficiary_type', [
                'chemist',
                'distributor',
                'field_executive',
                'calling_agent',
                'territory_manager',
                'partner'
            ]);

            $table->unsignedBigInteger('beneficiary_id');

            /*
            |--------------------------------------------------------------------------
            | Achievement Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_leads')
                ->default(0);

            $table->integer('total_orders')
                ->default(0);

            $table->decimal('total_revenue', 15, 2)
                ->default(0);

            $table->decimal('conversion_rate', 8, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Bonus Calculation
            |--------------------------------------------------------------------------
            */

            $table->enum('bonus_type', [
                'fixed',
                'percentage',
                'reward',
                'milestone'
            ]);

            $table->decimal('base_amount', 15, 2)
                ->default(0);

            $table->decimal('bonus_percentage', 10, 2)
                ->nullable();

            $table->decimal('bonus_amount', 15, 2);

            /*
            |--------------------------------------------------------------------------
            | Related References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            $table->foreignId('delivery_id')
                ->nullable()
                ->constrained('deliveries')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Wallet Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('wallet_id')
                ->nullable()
                ->constrained('wallets')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Bonus Period
            |--------------------------------------------------------------------------
            */

            $table->date('period_start');

            $table->date('period_end');

            /*
            |--------------------------------------------------------------------------
            | Approval Workflow
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'approved',
                'credited',
                'paid',
                'rejected',
                'cancelled'
            ])->default('pending');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Payment Tracking
            |--------------------------------------------------------------------------
            */

            $table->timestamp('credited_at')
                ->nullable();

            $table->timestamp('paid_at')
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

            $table->index('bonus_number');
            $table->index('commission_campaign_id');
            $table->index('beneficiary_type');
            $table->index('beneficiary_id');
            $table->index('bonus_type');
            $table->index('status');
            $table->index('period_start');
            $table->index('period_end');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bonus_commissions');
    }
};
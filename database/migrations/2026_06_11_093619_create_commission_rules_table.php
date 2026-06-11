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
        Schema::create('commission_rules', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Rule Information
            |--------------------------------------------------------------------------
            */

            $table->string('rule_code')->unique();

            $table->string('name');

            $table->text('description')->nullable();

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

            /*
            |--------------------------------------------------------------------------
            | Commission Scope
            |--------------------------------------------------------------------------
            */

            $table->enum('commission_on', [
                'lead',
                'appointment',
                'measurement',
                'order',
                'delivery',
                'product'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Product Scope
            |--------------------------------------------------------------------------
            */

            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();

            $table->foreignId('product_category_id')
                ->nullable()
                ->constrained('product_categories')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Rule Type
            |--------------------------------------------------------------------------
            */

            $table->enum('commission_type', [
                'fixed',
                'percentage'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Commission Values
            |--------------------------------------------------------------------------
            */

            $table->decimal('commission_value', 12, 2);

            $table->decimal('minimum_commission', 12, 2)
                ->default(0);

            $table->decimal('maximum_commission', 12, 2)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Eligibility
            |--------------------------------------------------------------------------
            */

            $table->decimal('minimum_order_amount', 12, 2)
                ->default(0);

            $table->decimal('maximum_order_amount', 12, 2)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Effective Period
            |--------------------------------------------------------------------------
            */

            $table->date('effective_from');

            $table->date('effective_to')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Priority
            |--------------------------------------------------------------------------
            */

            $table->integer('priority')
                ->default(1);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Approval
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Additional Conditions
            |--------------------------------------------------------------------------
            */

            $table->json('conditions')
                ->nullable();

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('rule_code');
            $table->index('beneficiary_type');
            $table->index('commission_on');
            $table->index('commission_type');
            $table->index('product_id');
            $table->index('product_category_id');
            $table->index('effective_from');
            $table->index('effective_to');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_rules');
    }
};
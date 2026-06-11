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
        Schema::create('distributor_profiles', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | System Generated Information
            |--------------------------------------------------------------------------
            */

            $table->string('distributor_code')->unique();
            $table->string('wallet_code')->unique()->nullable();
            $table->string('territory_code')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Business Information
            |--------------------------------------------------------------------------
            */

            $table->string('business_name');
            $table->string('owner_name');

            $table->string('gst_number')->nullable();
            $table->string('pan_number')->nullable();
            $table->string('licence_number')->nullable();

            $table->string('business_registration_number')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Territory Mapping
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('area_id')->nullable();
            $table->unsignedBigInteger('territory_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Warehouse Information
            |--------------------------------------------------------------------------
            */

            $table->string('warehouse_name')->nullable();

            $table->text('warehouse_address')->nullable();

            $table->string('warehouse_pincode')->nullable();

            $table->decimal('warehouse_latitude', 10, 8)->nullable();
            $table->decimal('warehouse_longitude', 11, 8)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Banking Information
            |--------------------------------------------------------------------------
            */

            $table->string('account_holder_name')->nullable();

            $table->string('bank_name')->nullable();

            $table->string('account_number')->nullable();

            $table->string('ifsc_code')->nullable();

            $table->string('upi_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Network Statistics
            |--------------------------------------------------------------------------
            */

            $table->integer('active_chemists')->default(0);

            $table->integer('total_chemists')->default(0);

            /*
            |--------------------------------------------------------------------------
            | Order Statistics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_orders')->default(0);

            $table->integer('accepted_orders')->default(0);

            $table->integer('delivered_orders')->default(0);

            $table->integer('rejected_orders')->default(0);

            /*
            |--------------------------------------------------------------------------
            | Delivery Performance
            |--------------------------------------------------------------------------
            */

            $table->decimal('delivery_success_rate', 8, 2)
                ->default(0);

            $table->decimal('sla_compliance_rate', 8, 2)
                ->default(0);

            $table->decimal('average_delivery_time', 8, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Revenue & Commission
            |--------------------------------------------------------------------------
            */

            $table->decimal('total_revenue', 15, 2)
                ->default(0);

            $table->decimal('total_commission', 15, 2)
                ->default(0);

            $table->decimal('pending_commission', 15, 2)
                ->default(0);

            $table->decimal('withdrawn_commission', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Inventory Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_products')->default(0);

            $table->integer('low_stock_products')->default(0);

            $table->integer('out_of_stock_products')->default(0);

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->boolean('kyc_verified')->default(false);

            $table->timestamp('kyc_verified_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Approval Workflow
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('approved_by')->nullable();

            $table->timestamp('approved_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'pending',
                'active',
                'inactive',
                'suspended',
                'blocked'
            ])->default('pending');

            /*
            |--------------------------------------------------------------------------
            | Last Activity
            |--------------------------------------------------------------------------
            */

            $table->timestamp('last_order_received_at')->nullable();

            $table->timestamp('last_delivery_at')->nullable();

            $table->timestamp('last_login_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Remarks
            |--------------------------------------------------------------------------
            */

            $table->text('remarks')->nullable();

            $table->timestamps();
            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('distributor_code');
            $table->index('territory_id');
            $table->index('status');
            $table->index('country_id');
            $table->index('state_id');
            $table->index('city_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributor_profiles');
    }
};
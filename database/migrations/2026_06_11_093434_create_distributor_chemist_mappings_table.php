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
        Schema::create('distributor_chemist_mappings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Distributor & Chemist
            |--------------------------------------------------------------------------
            */

            $table->foreignId('distributor_id')
                ->constrained('distributor_profiles')
                ->cascadeOnDelete();

            $table->foreignId('chemist_id')
                ->constrained('chemist_profiles')
                ->cascadeOnDelete();

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
            | Assignment Information
            |--------------------------------------------------------------------------
            */

            $table->string('mapping_code')
                ->unique();

            $table->date('assigned_date');

            $table->date('effective_from')
                ->nullable();

            $table->date('effective_to')
                ->nullable();

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
                'transferred',
                'terminated'
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | Business Metrics
            |--------------------------------------------------------------------------
            */

            $table->integer('total_leads')
                ->default(0);

            $table->integer('converted_leads')
                ->default(0);

            $table->integer('total_orders')
                ->default(0);

            $table->decimal('total_revenue', 15, 2)
                ->default(0);

            $table->decimal('total_commission', 15, 2)
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Transfer Tracking
            |--------------------------------------------------------------------------
            */

            $table->foreignId('previous_distributor_id')
                ->nullable()
                ->constrained('distributor_profiles')
                ->nullOnDelete();

            $table->text('transfer_reason')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Approval
            |--------------------------------------------------------------------------
            */

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamp('approved_at')
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
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Constraints
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'distributor_id',
                'chemist_id'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('territory_id');
            $table->index('status');
            $table->index('assigned_date');
            $table->index('mapping_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distributor_chemist_mappings');
    }
};
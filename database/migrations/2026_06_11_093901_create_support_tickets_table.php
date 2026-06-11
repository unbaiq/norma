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
        Schema::create('support_tickets', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Ticket Information
            |--------------------------------------------------------------------------
            */

            $table->string('ticket_number')->unique();

            $table->string('subject');

            $table->longText('description');

            /*
            |--------------------------------------------------------------------------
            | Ticket Owner
            |--------------------------------------------------------------------------
            */

            $table->string('user_type');

            $table->unsignedBigInteger('user_id');

            /*
            |--------------------------------------------------------------------------
            | Category
            |--------------------------------------------------------------------------
            */

            $table->enum('category', [
                'order',
                'delivery',
                'product',
                'measurement',
                'appointment',
                'commission',
                'wallet',
                'withdrawal',
                'technical',
                'account',
                'billing',
                'general'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Priority
            |--------------------------------------------------------------------------
            */

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'urgent',
                'critical'
            ])->default('medium');

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'open',
                'assigned',
                'in_progress',
                'waiting_for_customer',
                'resolved',
                'closed',
                'reopened',
                'cancelled'
            ])->default('open');

            /*
            |--------------------------------------------------------------------------
            | Assignment
            |--------------------------------------------------------------------------
            */

            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

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

            $table->foreignId('appointment_id')
                ->nullable()
                ->constrained('appointments')
                ->nullOnDelete();

            $table->foreignId('commission_id')
                ->nullable()
                ->constrained('commissions')
                ->nullOnDelete();

            $table->foreignId('wallet_id')
                ->nullable()
                ->constrained('wallets')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Resolution
            |--------------------------------------------------------------------------
            */

            $table->longText('resolution')
                ->nullable();

            $table->timestamp('resolved_at')
                ->nullable();

            $table->foreignId('resolved_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | SLA Tracking
            |--------------------------------------------------------------------------
            */

            $table->timestamp('first_response_at')
                ->nullable();

            $table->timestamp('due_at')
                ->nullable();

            $table->boolean('sla_breached')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Customer Feedback
            |--------------------------------------------------------------------------
            */

            $table->tinyInteger('rating')
                ->nullable();

            $table->text('feedback')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Attachments
            |--------------------------------------------------------------------------
            */

            $table->json('attachments')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Audit
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

            $table->index('ticket_number');
            $table->index('user_type');
            $table->index('user_id');
            $table->index('category');
            $table->index('priority');
            $table->index('status');
            $table->index('assigned_to');
            $table->index('order_id');
            $table->index('delivery_id');
            $table->index('resolved_at');
            $table->index('due_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
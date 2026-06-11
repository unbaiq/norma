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
        Schema::create('permission_user', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('permission_id')
                ->constrained('permissions')
                ->cascadeOnDelete();

            // Permission Assignment Information
            $table->timestamp('assigned_at')->nullable();

            $table->unsignedBigInteger('assigned_by')->nullable();

            // Status
            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            // Optional Expiry
            $table->timestamp('expires_at')->nullable();

            // Notes
            $table->text('remarks')->nullable();

            $table->timestamps();

            // Prevent duplicate permission assignment
            $table->unique([
                'user_id',
                'permission_id'
            ]);

            $table->index('user_id');
            $table->index('permission_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission_user');
    }
};
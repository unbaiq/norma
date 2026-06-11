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
        Schema::create('permissions', function (Blueprint $table) {

            $table->id();

            // Unique Permission Code
            $table->string('permission_code')->unique();

            // Permission Details
            $table->string('name');
            $table->string('slug')->unique();

            $table->string('module');
            $table->string('action');

            $table->text('description')->nullable();

            // Grouping
            $table->string('group_name')->nullable();

            // System Permission
            $table->boolean('is_system')->default(false);

            // Status
            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            // Audit
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('module');
            $table->index('action');
            $table->index('status');
            $table->index('group_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permissions');
    }
};
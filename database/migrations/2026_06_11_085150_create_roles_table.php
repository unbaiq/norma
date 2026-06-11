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
        Schema::create('roles', function (Blueprint $table) {

            $table->id();

            // Unique Role Code
            $table->string('role_code')->unique();

            // Role Details
            $table->string('name')->unique();
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            // Hierarchy
            $table->unsignedBigInteger('parent_role_id')->nullable();

            // Access Level
            $table->integer('level')->default(1);

            // Role Type
            $table->enum('role_type', [
                'system',
                'business',
                'custom'
            ])->default('business');

            // Permissions Flags
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_default')->default(false);

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
            $table->index('name');
            $table->index('slug');
            $table->index('status');
            $table->index('level');
            $table->index('parent_role_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
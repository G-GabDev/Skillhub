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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();

            // Relationships
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Proposal content
            $table->text('cover_letter');
            $table->decimal('bid_amount', 10, 2);

            // Status options for tracking progress
            $table->enum('status', ['pending', 'accepted', 'rejected', 'completed'])->default('pending');

            // Optional for tracking messaging or timestamps
            $table->timestamp('submitted_at')->useCurrent();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposals');
    }
};

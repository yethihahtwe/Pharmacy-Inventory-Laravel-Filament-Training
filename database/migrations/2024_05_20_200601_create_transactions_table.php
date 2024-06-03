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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('type');
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->date('exp_date')->nullable();
            $table->string('batch')->nullable();
            $table->integer('amount');
            $table->foreignId('donor_id')->constrained('donors')->cascadeOnDelete();
            $table->foreignId('source')->nullable()->constrained('warehouses')->cascadeOnDelete();
            $table->foreignId('destination')->nullable()->constrained('warehouses')->cascadeOnDelete();
            $table->boolean('is_pending')->default(true);
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

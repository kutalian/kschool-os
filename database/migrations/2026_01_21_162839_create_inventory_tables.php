<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('inventory_items')) {
            Schema::create('inventory_items', function (Blueprint $table) {
                $table->id();
                $table->string('item_name');
                $table->string('category')->nullable();
                $table->string('item_code')->nullable()->unique();
                $table->text('description')->nullable();
                $table->integer('quantity')->default(0);
                $table->string('unit')->default('piece');
                $table->string('location')->nullable();
                $table->date('purchase_date')->nullable();
                $table->decimal('purchase_price', 10, 2)->nullable();
                $table->string('supplier')->nullable();
                $table->date('warranty_expiry')->nullable();
                $table->enum('condition_status', ['Good', 'Fair', 'Poor', 'Damaged'])->default('Good');
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('inventory_movements')) {
            Schema::create('inventory_movements', function (Blueprint $table) {
                $table->id();
                $table->foreignId('item_id')->constrained('inventory_items')->onDelete('cascade');
                $table->enum('movement_type', ['In', 'Out', 'Damaged', 'Lost', 'Return'])->default('In');
                $table->integer('quantity');
                $table->string('from_location')->nullable();
                $table->string('to_location')->nullable();
                $table->foreignId('issued_to')->nullable()->constrained('users')->onDelete('set null');
                $table->text('reason')->nullable();
                $table->date('movement_date');
                $table->foreignId('handled_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
        Schema::dropIfExists('inventory_items');
    }
};

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
        Schema::disableForeignKeyConstraints();

        // 1. Rename tables to singular as per screenshots
        if (Schema::hasTable('products') && !Schema::hasTable('product')) {
            Schema::rename('products', 'product');
        }
        
        if (Schema::hasTable('categories') && !Schema::hasTable('category')) {
            Schema::rename('categories', 'category');
        }

        // 2. Fix 'category' table schema
        if (Schema::hasColumn('category', 'product_id')) {
            try {
                DB::statement('ALTER TABLE category DROP FOREIGN KEY categories_product_id_foreign');
            } catch (\Exception $e) {}
            try {
                DB::statement('ALTER TABLE category DROP FOREIGN KEY category_product_id_foreign');
            } catch (\Exception $e) {}
            
            Schema::table('category', function (Blueprint $table) {
                $table->dropColumn('product_id');
            });
        }

        Schema::table('category', function (Blueprint $table) {
            $table->string('name')->unique()->change();
        });

        // 3. Fix 'product' table schema
        Schema::table('product', function (Blueprint $table) {
            // Rename qty to quantity as per screenshot
            if (Schema::hasColumn('product', 'qty')) {
                $table->renameColumn('qty', 'quantity');
            }
            
            // Change quantity to string and price to decimal(10,2) as per screenshot
            $table->string('quantity')->change();
            $table->decimal('price', 10, 2)->change();
            
            // Add category_id if it doesn't exist
            if (!Schema::hasColumn('product', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('user_id')->constrained('category')->cascadeOnDelete();
            }
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('product', function (Blueprint $table) {
            if (Schema::hasColumn('product', 'category_id')) {
                $table->dropConstrainedForeignId('category_id');
            }
            $table->decimal('price', 15, 2)->change();
            Schema::table('product', function(Blueprint $table) {
                $table->integer('quantity')->change();
            });
            $table->renameColumn('quantity', 'qty');
        });

        Schema::table('category', function (Blueprint $table) {
            $table->string('name')->unique(false)->change();
            if (!Schema::hasColumn('category', 'product_id')) {
                $table->foreignId('product_id')->nullable()->constrained('product')->cascadeOnDelete();
            }
        });

        if (Schema::hasTable('product')) {
            Schema::rename('product', 'products');
        }
        if (Schema::hasTable('category')) {
            Schema::rename('category', 'categories');
        }

        Schema::enableForeignKeyConstraints();
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Check if columns don't exist before adding them
            if (!Schema::hasColumn('products', 'shopify_product_id')) {
                $table->string('shopify_product_id')->nullable()->unique();
            }
            
            if (!Schema::hasColumn('products', 'brand')) {
                $table->string('brand')->nullable();
            }
            
            if (!Schema::hasColumn('products', 'fragrance_family')) {
                $table->string('fragrance_family')->nullable();
            }
            
            if (!Schema::hasColumn('products', 'is_featured')) {
                $table->boolean('is_featured')->default(false);
            }
            
            if (!Schema::hasColumn('products', 'hoverImage')) {
                $table->string('hoverImage')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'shopify_product_id',
                'brand',
                'fragrance_family',
                'is_featured',
                'hoverImage'
            ]);
        });
    }
};
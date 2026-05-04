<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'is_seller')) {
                $table->boolean('is_seller')->default(false)->after('role');
            }
            if (! Schema::hasColumn('users', 'is_customer')) {
                $table->boolean('is_customer')->default(true)->after('is_seller');
            }
        });

        if (Schema::hasColumn('users', 'is_seller') && Schema::hasColumn('users', 'is_customer')) {
            DB::table('users')->where('role', 'seller')->update([
                'is_seller' => true,
                'is_customer' => true,
            ]);

            DB::table('users')->where('role', 'customer')->update([
                'is_customer' => true,
            ]);

            DB::table('users')->where('role', 'admin')->update([
                'is_seller' => false,
                'is_customer' => false,
            ]);
        }

        Schema::table('products', function (Blueprint $table) {
            if (! Schema::hasColumn('products', 'product_status')) {
                $table->string('product_status')->default('available')->after('is_active');
            }
            if (! Schema::hasColumn('products', 'quantity')) {
                $table->integer('quantity')->default(0)->after('product_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'is_seller')) {
                $table->dropColumn('is_seller');
            }
            if (Schema::hasColumn('users', 'is_customer')) {
                $table->dropColumn('is_customer');
            }
        });

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'product_status')) {
                $table->dropColumn('product_status');
            }
            if (Schema::hasColumn('products', 'quantity')) {
                $table->dropColumn('quantity');
            }
        });
    }
};

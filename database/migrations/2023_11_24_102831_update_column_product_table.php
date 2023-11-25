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
        Schema::table('products', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('price')->after('name');
            $table->string('category')->after('price');
            $table->string('brand')->after('category');
            $table->string('sale')->after('brand');
            $table->string('sale-value')->after('sale');
            $table->string('company')->after('sale-value');
            $table->string('photo')->after('company');
            $table->string('detail')->after('photo');
            $table->string('id_user')->after('detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};

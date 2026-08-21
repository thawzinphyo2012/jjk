<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('title_mm')->nullable()->after('title');
            $table->text('description_mm')->nullable()->after('description');
            $table->string('image')->nullable()->after('icon_color');
        });

        Schema::table('graphics', function (Blueprint $table) {
            $table->string('title_mm')->nullable()->after('title');
            $table->string('category_mm')->nullable()->after('category');
            $table->text('description_mm')->nullable()->after('description');
            $table->string('image')->nullable()->after('gradient');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['title_mm', 'description_mm', 'image']);
        });

        Schema::table('graphics', function (Blueprint $table) {
            $table->dropColumn(['title_mm', 'category_mm', 'description_mm', 'image']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (!Schema::hasColumn('books', 'category_id')) {
                // Tambah tanpa foreign key constraint dulu
                $table->unsignedBigInteger('category_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('books', 'publisher')) {
                $table->string('publisher')->nullable()->after('author');
            }
            if (!Schema::hasColumn('books', 'published_year')) {
                $table->integer('published_year')->nullable()->after('publisher');
            }
            if (!Schema::hasColumn('books', 'stock')) {
                $table->integer('stock')->default(0)->after('published_year');
            }
            if (!Schema::hasColumn('books', 'summary')) {
                $table->text('summary')->nullable()->after('stock');
            }
            if (!Schema::hasColumn('books', 'status')) {
                $table->string('status')->default('available')->after('summary');
            }
            if (!Schema::hasColumn('books', 'cover')) {
                $table->string('cover')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['category_id', 'publisher', 'published_year', 'stock', 'summary', 'status', 'cover']);
        });
    }
};

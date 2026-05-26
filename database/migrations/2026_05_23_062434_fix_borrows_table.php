<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrows', function (Blueprint $table) {
            // Ubah kolom borrowed_at dari timestamp ke date (kalau masih timestamp)
            if (Schema::hasColumn('borrows', 'borrowed_at')) {
                $table->date('borrowed_at')->nullable()->change();
            }

            // Tambah return_date kalau belum ada
            if (!Schema::hasColumn('borrows', 'return_date')) {
                $table->date('return_date')->nullable()->after('borrowed_at');
            }

            // Ubah returned_at dari timestamp ke date
            if (Schema::hasColumn('borrows', 'returned_at')) {
                $table->date('returned_at')->nullable()->change();
            }

            // Ubah enum status supaya support 'dipinjam' dan 'dikembalikan'
            // MySQL: drop enum lama, ganti dengan string
            if (Schema::hasColumn('borrows', 'status')) {
                $table->string('status')->default('dipinjam')->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->string('status')->default('borrowed')->change();
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Ubah kolom status jadi string supaya support semua nilai baru
        Schema::table('borrows', function (Blueprint $table) {
            $table->string('status')->default('menunggu')->change();
        });

        // Tambah kolom catatan penolakan kalau ada
        Schema::table('borrows', function (Blueprint $table) {
            if (!Schema::hasColumn('borrows', 'catatan')) {
                $table->string('catatan')->nullable()->after('status');
            }
            if (!Schema::hasColumn('borrows', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('catatan');
            }
            if (!Schema::hasColumn('borrows', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('borrows', function (Blueprint $table) {
            $table->string('status')->default('dipinjam')->change();
        });
    }
};

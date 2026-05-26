<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrowed_at',
        'return_date',
        'returned_at',
        'status',
        'catatan',
        'approved_by',
        'approved_at',
    ];

    // Status constants
    const STATUS_MENUNGGU          = 'menunggu';
    const STATUS_DIPINJAM          = 'dipinjam';
    const STATUS_MENUNGGU_KEMBALI  = 'menunggu_kembali';
    const STATUS_DIKEMBALIKAN      = 'dikembalikan';
    const STATUS_DITOLAK           = 'ditolak';

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helper: label & warna badge
    public function statusLabel(): string
    {
        return match($this->status) {
            self::STATUS_MENUNGGU         => 'Menunggu Persetujuan',
            self::STATUS_DIPINJAM         => 'Dipinjam',
            self::STATUS_MENUNGGU_KEMBALI => 'Menunggu Konfirmasi Kembali',
            self::STATUS_DIKEMBALIKAN     => 'Dikembalikan',
            self::STATUS_DITOLAK          => 'Ditolak',
            default                       => ucfirst($this->status),
        };
    }

    public function statusColor(): string
    {
        return match($this->status) {
            self::STATUS_MENUNGGU         => 'badge-yellow',
            self::STATUS_DIPINJAM         => 'badge-green',
            self::STATUS_MENUNGGU_KEMBALI => 'badge-blue',
            self::STATUS_DIKEMBALIKAN     => 'badge-gray',
            self::STATUS_DITOLAK          => 'badge-red',
            default                       => 'badge-gray',
        };
    }
}

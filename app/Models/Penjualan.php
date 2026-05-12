<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Model Penjualan
 * 
 * Merepresentasikan tabel 'penjualans' di database.
 * Data diasumsikan sudah bersih (tidak ada NULL, format valid).
 */
class Penjualan extends Model
{
    /**
     * Nama tabel yang terhubung dengan model ini.
     */
    protected $table = 'penjualans';

    /**
     * Kolom-kolom yang diizinkan untuk mass assignment.
     */
    protected $fillable = [
        'tanggal',
        'produk',
        'kategori',
        'jumlah',
        'harga',
        'total',
    ];

    /**
     * Casting tipe data untuk kolom tertentu.
     * Memastikan tanggal di-cast sebagai objek Carbon.
     */
    protected $casts = [
        'tanggal' => 'date',
        'jumlah'  => 'integer',
        'harga'   => 'integer',
        'total'   => 'integer',
    ];
}

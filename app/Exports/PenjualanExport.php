<?php

namespace App\Exports;

use App\Models\Penjualan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Export class untuk mengekspor data penjualan ke Excel.
 * Menggunakan package maatwebsite/excel.
 */
class PenjualanExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * Mengambil seluruh data penjualan, diurutkan berdasarkan tanggal terbaru.
     */
    public function collection()
    {
        return Penjualan::orderBy('tanggal', 'desc')->get();
    }

    /**
     * Header kolom pada file Excel.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Tanggal',
            'Produk',
            'Kategori',
            'Jumlah',
            'Harga',
            'Total',
        ];
    }

    /**
     * Mapping setiap baris data ke kolom Excel.
     */
    public function map($penjualan): array
    {
        return [
            $penjualan->id,
            $penjualan->tanggal->format('Y-m-d'),
            $penjualan->produk,
            $penjualan->kategori,
            $penjualan->jumlah,
            $penjualan->harga,
            $penjualan->total,
        ];
    }

    /**
     * Styling untuk header Excel (baris pertama dibold).
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

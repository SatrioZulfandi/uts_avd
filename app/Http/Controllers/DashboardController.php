<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Exports\PenjualanExport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

/**
 * DashboardController
 * 
 * Mengelola halaman dashboard analitik penjualan beserta fitur export.
 */
class DashboardController extends Controller
{
    /**
     * Menampilkan halaman dashboard dengan 4 set data untuk chart.
     */
    public function index()
    {
        // =====================================================
        // 1. PENJUALAN PER PRODUK
        //    Total penjualan keseluruhan (SUM total) di-group per produk.
        //    Digunakan untuk: Bar Chart (Total Penjualan per Produk)
        // =====================================================
        $penjualanPerProduk = Penjualan::select('produk', DB::raw('SUM(total) as total_penjualan'))
            ->groupBy('produk')
            ->orderByDesc('total_penjualan')
            ->get();

        // =====================================================
        // 2. PENJUALAN PER MINGGU
        //    Penjualan per produk berdasarkan tanggal per minggu.
        //    Menggunakan YEARWEEK() untuk mengelompokkan per minggu.
        //    Digunakan untuk: Pie Chart (Proporsi per Kategori)
        // =====================================================
        $penjualanPerMinggu = Penjualan::select(
                'produk',
                DB::raw("YEARWEEK(tanggal, 1) as minggu"),
                DB::raw('SUM(total) as total_penjualan')
            )
            ->groupBy('produk', 'minggu')
            ->orderBy('minggu')
            ->get();

        // =====================================================
        // 3. PENJUALAN PER BULAN
        //    Penjualan per kategori per bulannya.
        //    Digunakan untuk: Bar Chart (Penjualan per Kategori per Bulan)
        // =====================================================
        $penjualanPerBulan = Penjualan::select(
                'kategori',
                DB::raw("DATE_FORMAT(tanggal, '%Y-%m') as bulan"),
                DB::raw('SUM(total) as total_penjualan')
            )
            ->groupBy('kategori', 'bulan')
            ->orderBy('bulan')
            ->get();

        // =====================================================
        // 4. TREN PENJUALAN
        //    Tren penjualan berdasarkan waktu (tanggal) dengan 
        //    jumlah transaksi (COUNT) dan total penjualan (SUM).
        //    Digunakan untuk: Line Chart (Tren Penjualan)
        // =====================================================
        $trenPenjualan = Penjualan::select(
                'tanggal',
                DB::raw('COUNT(*) as jumlah_transaksi'),
                DB::raw('SUM(total) as total_penjualan')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // =====================================================
        // DATA TAMBAHAN: Proporsi per Kategori (untuk Pie Chart)
        // =====================================================
        $penjualanPerKategori = Penjualan::select('kategori', DB::raw('SUM(total) as total_penjualan'))
            ->groupBy('kategori')
            ->orderByDesc('total_penjualan')
            ->get();

        // Kirim semua data ke view dashboard
        return view('dashboard', compact(
            'penjualanPerProduk',
            'penjualanPerMinggu',
            'penjualanPerBulan',
            'trenPenjualan',
            'penjualanPerKategori'
        ));
    }

    /**
     * Export data penjualan ke file Excel (.xlsx).
     * Menggunakan package maatwebsite/excel.
     */
    public function exportExcel()
    {
        return Excel::download(new PenjualanExport, 'data-penjualan.xlsx');
    }

    /**
     * Export data penjualan ke file PDF.
     * Menggunakan package barryvdh/laravel-dompdf.
     */
    public function exportPdf()
    {
        // Ambil semua data penjualan untuk ditampilkan di PDF
        $penjualans = Penjualan::orderBy('tanggal', 'desc')->get();

        // Hitung ringkasan statistik
        $totalPenjualan   = $penjualans->sum('total');
        $totalTransaksi   = $penjualans->count();
        $rataRataPenjualan = $totalTransaksi > 0 ? round($totalPenjualan / $totalTransaksi) : 0;

        // Load view PDF dan generate
        $pdf = Pdf::loadView('exports.penjualan-pdf', compact(
            'penjualans',
            'totalPenjualan',
            'totalTransaksi',
            'rataRataPenjualan'
        ));

        // Set orientasi landscape untuk tabel yang lebar
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan-penjualan.pdf');
    }
}

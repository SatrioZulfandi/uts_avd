<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Analitik Penjualan</title>
    <meta name="description" content="Dashboard analitik penjualan dengan visualisasi data menggunakan Chart.js">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .chart-container { position: relative; width: 100%; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800">

    <!-- ============================================= -->
    <!-- HEADER / NAVBAR                               -->
    <!-- ============================================= -->
    <header class="sticky top-0 z-50 bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="bg-blue-600 w-10 h-10 rounded-lg flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-gray-900">Dashboard Analitik Penjualan</h1>
                    <p class="text-sm text-gray-500">Visualisasi & Insight Data Penjualan</p>
                </div>
            </div>
            <!-- Tombol Export -->
            <div class="flex gap-3">
                <a href="{{ route('export.excel') }}" id="btn-export-excel"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export Excel
                </a>
                <a href="{{ route('export.pdf') }}" id="btn-export-pdf"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors duration-200 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    Export PDF
                </a>
            </div>
        </div>
    </header>

    <!-- ============================================= -->
    <!-- MAIN CONTENT                                  -->
    <!-- ============================================= -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

        <!-- Baris 1: Line Chart (Full Width) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-1">Tren Penjualan Berdasarkan Waktu</h2>
            <p class="text-sm text-gray-500 mb-4">Jumlah transaksi & total penjualan harian</p>
            <div class="chart-container" style="height:320px;">
                <canvas id="chartTren"></canvas>
            </div>
        </div>

        <!-- Baris 2: Bar Chart Produk + Pie Chart Kategori -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Bar Chart: Total Penjualan per Produk -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-1">Total Penjualan per Produk</h2>
                <p class="text-sm text-gray-500 mb-4">Perbandingan total revenue tiap produk</p>
                <div class="chart-container" style="height:320px;">
                    <canvas id="chartProduk"></canvas>
                </div>
            </div>

            <!-- Pie Chart: Proporsi per Kategori -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-1">Proporsi Penjualan per Kategori</h2>
                <p class="text-sm text-gray-500 mb-4">Distribusi total penjualan berdasarkan kategori</p>
                <div class="chart-container" style="height:320px;">
                    <canvas id="chartKategori"></canvas>
                </div>
            </div>
        </div>

        <!-- Baris 3: Bar Chart Kategori per Bulan (full width) -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-1">Penjualan per Kategori per Bulan</h2>
            <p class="text-sm text-gray-500 mb-4">Stacked bar chart breakdown bulanan</p>
            <div class="chart-container" style="height:360px;">
                <canvas id="chartBulanan"></canvas>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mt-4 border-t border-gray-200 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Dashboard Analitik Penjualan
    </footer>

    <!-- ============================================= -->
    <!-- CHART.JS SCRIPTS                              -->
    <!-- ============================================= -->
    <script>
        // Palet warna standar
        const COLORS = [
            '#3b82f6','#8b5cf6','#06b6d4','#f59e0b','#ef4444',
            '#10b981','#ec4899','#f97316','#14b8a6','#6366f1',
            '#84cc16','#e11d48','#0ea5e9','#a855f7','#22c55e',
        ];

        // Default styling untuk semua chart (Light Mode)
        Chart.defaults.color = '#6b7280';
        Chart.defaults.borderColor = '#e5e7eb';
        Chart.defaults.font.family = "'Inter', sans-serif";

        const tooltipConfig = {
            backgroundColor: '#ffffff',
            titleColor: '#111827',
            bodyColor: '#4b5563',
            borderColor: '#e5e7eb',
            borderWidth: 1,
            padding: 12,
            cornerRadius: 6,
            boxPadding: 4
        };

        // =============================================
        // 1. LINE CHART — Tren Penjualan
        // =============================================
        const trenLabels = @json($trenPenjualan->pluck('tanggal')->map(fn($t) => \Carbon\Carbon::parse($t)->format('d/m')));
        const trenTransaksi = @json($trenPenjualan->pluck('jumlah_transaksi'));
        const trenTotal = @json($trenPenjualan->pluck('total_penjualan'));

        new Chart(document.getElementById('chartTren'), {
            type: 'line',
            data: {
                labels: trenLabels,
                datasets: [
                    {
                        label: 'Jumlah Transaksi',
                        data: trenTransaksi,
                        borderColor: '#3b82f6',
                        backgroundColor: 'rgba(59,130,246,0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        borderWidth: 2,
                        yAxisID: 'y',
                    },
                    {
                        label: 'Total Penjualan (Rp)',
                        data: trenTotal,
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139,92,246,0.1)',
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        borderWidth: 2,
                        yAxisID: 'y1',
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { position: 'top', labels: { usePointStyle: true, padding: 20 } },
                    tooltip: {
                        ...tooltipConfig,
                        callbacks: {
                            label: ctx => {
                                if (ctx.datasetIndex === 1) return ctx.dataset.label + ': Rp ' + Number(ctx.raw).toLocaleString('id-ID');
                                return ctx.dataset.label + ': ' + ctx.raw;
                            }
                        }
                    }
                },
                scales: {
                    y:  { type: 'linear', position: 'left',  title: { display: true, text: 'Jumlah Transaksi' }, beginAtZero: true },
                    y1: { type: 'linear', position: 'right', title: { display: true, text: 'Total (Rp)' }, beginAtZero: true, grid: { drawOnChartArea: false } },
                    x: { ticks: { maxRotation: 45, maxTicksLimit: 15 } }
                }
            }
        });

        // =============================================
        // 2. BAR CHART — Total Penjualan per Produk
        // =============================================
        const produkLabels = @json($penjualanPerProduk->pluck('produk'));
        const produkData = @json($penjualanPerProduk->pluck('total_penjualan'));

        new Chart(document.getElementById('chartProduk'), {
            type: 'bar',
            data: {
                labels: produkLabels,
                datasets: [{
                    label: 'Total Penjualan (Rp)',
                    data: produkData,
                    backgroundColor: COLORS.slice(0, produkLabels.length),
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        ...tooltipConfig,
                        callbacks: { label: ctx => 'Rp ' + Number(ctx.raw).toLocaleString('id-ID') }
                    }
                },
                scales: {
                    y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + (v/1000) + 'K' } },
                    x: { ticks: { maxRotation: 45 } }
                }
            }
        });

        // =============================================
        // 3. PIE/DOUGHNUT CHART — Proporsi per Kategori
        // =============================================
        const kategoriLabels = @json($penjualanPerKategori->pluck('kategori'));
        const kategoriData = @json($penjualanPerKategori->pluck('total_penjualan'));

        new Chart(document.getElementById('chartKategori'), {
            type: 'doughnut',
            data: {
                labels: kategoriLabels,
                datasets: [{
                    data: kategoriData,
                    backgroundColor: COLORS.slice(0, kategoriLabels.length),
                    borderColor: '#ffffff',
                    borderWidth: 2,
                    hoverOffset: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: { position: 'right', labels: { usePointStyle: true, padding: 16, font: { size: 12 } } },
                    tooltip: {
                        ...tooltipConfig,
                        callbacks: {
                            label: ctx => {
                                const total = ctx.dataset.data.reduce((a,b) => Number(a) + Number(b), 0);
                                const pct = ((Number(ctx.raw) / total) * 100).toFixed(1);
                                return ctx.label + ': Rp ' + Number(ctx.raw).toLocaleString('id-ID') + ' (' + pct + '%)';
                            }
                        }
                    }
                }
            }
        });

        // =============================================
        // 4. STACKED BAR CHART — Kategori per Bulan
        // =============================================
        const rawBulanan = @json($penjualanPerBulan);

        // Extract unique bulan & kategori
        const bulans = [...new Set(rawBulanan.map(i => i.bulan))].sort();
        const kategoris = [...new Set(rawBulanan.map(i => i.kategori))];

        // Build datasets per kategori
        const bulananDatasets = kategoris.map((kat, idx) => {
            const data = bulans.map(b => {
                const found = rawBulanan.find(i => i.kategori === kat && i.bulan === b);
                return found ? found.total_penjualan : 0;
            });
            return {
                label: kat,
                data: data,
                backgroundColor: COLORS[idx % COLORS.length],
                borderRadius: 2,
                borderSkipped: false,
            };
        });

        new Chart(document.getElementById('chartBulanan'), {
            type: 'bar',
            data: { labels: bulans, datasets: bulananDatasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top', labels: { usePointStyle: true, padding: 20 } },
                    tooltip: {
                        ...tooltipConfig,
                        callbacks: { label: ctx => ctx.dataset.label + ': Rp ' + Number(ctx.raw).toLocaleString('id-ID') }
                    }
                },
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true, ticks: { callback: v => 'Rp ' + (v/1000) + 'K' } }
                }
            }
        });
    </script>
</body>
</html>

@extends('layouts.admin')

@section('title', 'Ringkasan Tahunan')
@section('page-title', 'Ringkasan Tahunan')
@section('page-description', 'Analisis prestasi aset untuk tahun {{ $year }}')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Ringkasan Tahunan {{ $year }}</h1>
                <p class="text-emerald-100 text-lg">Analisis lengkap prestasi aset untuk tahun {{ $year }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">Tahun {{ $year }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-trending-up text-emerald-200'></i>
                        <span class="text-emerald-100">Analisis Lengkap</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-calendar text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Total Assets -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-box text-blue-600 text-xl'></i>
                </div>
                <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">Aset</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $summary['total_assets'] }}</h3>
            <p class="text-sm text-gray-600">Aset Baharu {{ $year }}</p>
        </div>

        <!-- Acquisition Value -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-dollar text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">RM</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($summary['total_acquisitions_value'], 0) }}</h3>
            <p class="text-sm text-gray-600">Nilai Perolehan</p>
        </div>

        <!-- Disposals -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-trash text-red-600 text-xl'></i>
                </div>
                <span class="text-sm text-red-600 bg-red-100 px-2 py-1 rounded-full font-medium">Pelupusan</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $summary['total_disposals'] }}</h3>
            <p class="text-sm text-gray-600">Jumlah Pelupusan</p>
        </div>

        <!-- Disposal Value -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-money text-orange-600 text-xl'></i>
                </div>
                <span class="text-sm text-orange-600 bg-orange-100 px-2 py-1 rounded-full font-medium">RM</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($summary['total_disposals_value'], 0) }}</h3>
            <p class="text-sm text-gray-600">Nilai Pelupusan</p>
        </div>

        <!-- Maintenance Cost -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-wrench text-purple-600 text-xl'></i>
                </div>
                <span class="text-sm text-purple-600 bg-purple-100 px-2 py-1 rounded-full font-medium">Kos</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($summary['total_maintenance_cost'], 0) }}</h3>
            <p class="text-sm text-gray-600">Kos Penyelenggaraan</p>
        </div>

        <!-- Inspections -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-search text-indigo-600 text-xl'></i>
                </div>
                <span class="text-sm text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full font-medium">Pemeriksaan</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $summary['inspections_conducted'] }}</h3>
            <p class="text-sm text-gray-600">Pemeriksaan Dijalankan</p>
        </div>
    </div>

    <!-- Year Navigation -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Navigasi Tahun</h2>
                <p class="text-sm text-gray-600">Pilih tahun untuk melihat ringkasan</p>
            </div>
            <i class='bx bx-calendar-alt text-2xl text-gray-400'></i>
        </div>
        
        <div class="flex items-center space-x-4">
            @for($i = now()->year; $i >= now()->year - 5; $i--)
                <a href="{{ route('admin.reports.annual-summary', $i) }}" 
                   class="px-4 py-2 rounded-lg transition-colors {{ $i == $year ? 'bg-emerald-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                    {{ $i }}
                </a>
            @endfor
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-4">
        <button onclick="window.print()" 
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center">
            <i class='bx bx-printer mr-2'></i>
            Cetak Laporan
        </button>
        <a href="{{ route('admin.reports.index') }}" 
           class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
            Kembali
        </a>
    </div>
</div>
@endsection 
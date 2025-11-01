@extends('layouts.app')

@section('body')
<div class="min-h-screen bg-gradient-to-br from-yellow-50 to-white py-10">
    <div class="container mx-auto px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-yellow-500">Dashboard</h1>
            <a href="{{ route('materials.create') }}"
               class="bg-yellow-400 hover:bg-yellow-500 text-white px-5 py-2 rounded-lg font-semibold transition">
               + Unggah
            </a>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-3 gap-6 mb-12 text-center">
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500 text-sm">Materi Terjual</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $soldCount }}</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500 text-sm">Pendapatan</p>
                <p class="text-3xl font-bold text-yellow-500">Rp {{ number_format($income, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500 text-sm">Jumlah Upload</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $uploadCount }}</p>
            </div>
        </div>

        <!-- Riwayat Pembelian -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Riwayat Pembelian</h2>
        <div class="grid md:grid-cols-3 gap-6 mb-10">
            @forelse ($purchased as $item)
                <div class="bg-white border rounded-xl p-4 flex flex-col shadow hover:shadow-lg transition">
                    <div class="flex justify-center mb-4">
                        @if (Str::endsWith($item->file_name, '.pdf'))
                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" alt="PDF" class="w-12">
                        @else
                            <img src="https://upload.wikimedia.org/wikipedia/commons/4/4f/Microsoft_Word_icon_%282019–present%29.svg" alt="DOC" class="w-12">
                        @endif
                    </div>
                    <h3 class="text-gray-700 font-semibold text-lg">{{ $item->title }}</h3>
                    <p class="text-sm text-gray-500 mb-2">{{ $item->category->name ?? '-' }}</p>
                    <p class="text-gray-700 text-sm flex-grow">{{ Str::limit($item->description, 60) }}</p>
                    <p class="text-right mt-3 font-bold text-yellow-500">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                </div>
            @empty
                <p class="text-gray-500 italic col-span-3">Belum ada pembelian</p>
            @endforelse
        </div>

        <!-- Materi Diunggah -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Materi Diunggah</h2>
        <div class="grid md:grid-cols-3 gap-6">
            @forelse ($uploads as $upload)
                <div class="bg-white border rounded-xl p-4 flex flex-col shadow hover:shadow-lg transition">
                    <div class="flex justify-center mb-4">
                        @if (Str::endsWith($upload->file_name, '.pdf'))
                            <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" alt="PDF" class="w-12">
                        @else
                            <img src="https://upload.wikimedia.org/wikipedia/commons/4/4f/Microsoft_Word_icon_%282019–present%29.svg" alt="DOC" class="w-12">
                        @endif
                    </div>
                    <h3 class="text-gray-700 font-semibold text-lg">{{ $upload->title }}</h3>
                    <p class="text-sm text-gray-500 mb-2">{{ $upload->category->name ?? '-' }}</p>
                    <p class="text-gray-700 text-sm flex-grow">{{ Str::limit($upload->description, 60) }}</p>
                    <p class="text-right mt-3 font-bold text-yellow-500">
                        @if ($upload->price > 0)
                            Rp {{ number_format($upload->price, 0, ',', '.') }}
                        @else
                            Gratis
                        @endif
                    </p>
                </div>
            @empty
                <p class="text-gray-500 italic col-span-3">Belum ada materi yang diunggah</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-yellow-50 via-white to-white py-12">

    <!-- Header -->
    <div class="text-center mb-10">
        <h1 class="text-4xl font-extrabold text-yellow-500 mb-3">
            Jelajahi Materi 🔍
        </h1>
        <p class="text-gray-600 text-lg max-w-2xl mx-auto">
            Temukan catatan, ringkasan, dan sumber belajar dari berbagai bidang ilmu — semua dalam satu tempat.
        </p>
    </div>

    <!-- Search and Filter -->
    <div class="flex justify-center gap-4 mb-10 px-6">
        <form action="{{ route('explore') }}" method="GET" class="flex gap-3 w-full max-w-3xl">
            <input type="text" name="q" value="{{ request('q') }}"
                placeholder="Cari Materi..."
                class="w-full px-4 py-2 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-yellow-400">

            <button type="submit"
                class="bg-yellow-400 text-white px-6 py-2 rounded-xl hover:bg-yellow-500 transition">
                Cari
            </button>
        </form>
    </div>

    <!-- Grid Materi -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 px-8 md:px-16">
        @forelse($materi as $item)
        <div class="border-2 border-red-200 rounded-2xl p-5 shadow hover:shadow-lg transition bg-white">
            <div class="flex justify-center mb-4">
                @if(Str::endsWith($item->tipe_file, 'pdf'))
                    <img src="{{ asset('images/pdf-icon.svg') }}" alt="PDF" class="w-16 h-16">
                @elseif(Str::endsWith($item->tipe_file, 'docx') || Str::endsWith($item->tipe_file, 'doc'))
                    <img src="{{ asset('images/word-icon.svg') }}" alt="Word" class="w-16 h-16">
                @endif
            </div>

            <h3 class="text-lg font-bold text-gray-800 text-center">{{ $item->judul }}</h3>
            <p class="text-gray-500 text-sm mt-2 text-center">{{ Str::limit($item->deskripsi, 70) }}</p>

            <div class="flex justify-center mt-4">
                @if($item->tipe_publikasi === 'Berbayar')
                    <span class="bg-yellow-400 text-white px-4 py-1 rounded-full text-sm font-semibold">
                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                    </span>
                @else
                    <span class="bg-green-400 text-white px-4 py-1 rounded-full text-sm font-semibold">
                        Gratis
                    </span>
                @endif
            </div>

            <div class="text-center mt-5">
                <a href="{{ route('materi.show', $item->id) }}"
                    class="bg-yellow-400 text-white px-6 py-2 rounded-lg hover:bg-yellow-500 transition font-semibold">
                    Lihat Detail
                </a>
            </div>
        </div>
        @empty
            <div class="col-span-full text-center text-gray-500">
                Tidak ada materi ditemukan.
            </div>
        @endforelse
    </div>

    <!-- Button Lihat Lebih Banyak -->
    @if($materi->hasMorePages())
    <div class="flex justify-center mt-12">
        <a href="{{ $materi->nextPageUrl() }}"
           class="px-8 py-3 bg-yellow-400 text-white rounded-xl font-semibold hover:bg-yellow-500 transition">
            Lihat Lebih Banyak...
        </a>
    </div>
    @endif

</div>
@endsection

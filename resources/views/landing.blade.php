@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col bg-gradient-to-b from-yellow-100 via-white to-white">

    <!-- Navbar -->
    <nav class="flex justify-between items-center py-5 px-10 bg-transparent">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.svg') }}" alt="Lentera Logo" class="w-7 h-7">
            <span class="text-2xl font-bold text-yellow-500">Lentera</span>
        </div>

        <div class="flex items-center space-x-6 text-gray-700 font-medium">
            <a href="#fitur" class="hover:text-yellow-500 transition">Jelajahi</a>
            <a href="#tentang" class="hover:text-yellow-500 transition">Tentang</a>
            <a href="#kontak" class="hover:text-yellow-500 transition">Kontak</a>
            <a href="{{ route('login') }}"
               class="bg-yellow-400 text-white px-5 py-2 rounded-lg hover:bg-yellow-500 transition font-semibold shadow">
               Masuk
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="flex-grow flex flex-col justify-center items-center text-center px-6 mt-10">
        <h1 class="text-5xl md:text-6xl font-extrabold leading-tight text-transparent bg-clip-text bg-gradient-to-r from-yellow-500 to-orange-400">
            Terangi <br> Perjalanan <span class="block">Belajarmu ✨</span>
        </h1>

        <p class="text-gray-600 text-lg md:text-xl max-w-2xl mt-6">
            Lentera adalah platform berbagi dan menjelajahi materi belajar — tempat di mana pengetahuan menyala dan tumbuh bersama komunitas.
        </p>

        <div class="flex flex-col md:flex-row gap-5 mt-10">
            <a href="{{ route('register') }}"
               class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-8 py-3 rounded-full shadow transition">
               Mulai Sekarang
            </a>

            <a href="{{ route('materials.index') }}"
               class="border-2 border-yellow-400 text-yellow-500 hover:bg-yellow-400 hover:text-white font-semibold px-8 py-3 rounded-full transition">
               Jelajahi Materi
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-6 text-sm text-gray-500">
        © {{ date('Y') }} <span class="font-semibold text-yellow-500">Lentera</span> — Komunitas Belajar
    </footer>
</div>
@endsection

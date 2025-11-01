@extends('layouts.app')

@section('body')
<div class="min-h-screen bg-linear-to-br from-yellow-50 to-white flex justify-center py-12 px-6">
    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-lg p-10 relative">

    <!-- Tombol Kembali (di luar container putih) -->
    <div class="w-full max-w-7xl mb-6 flex justify-start">
        <a href="{{ url('/dashboard') }}"
           class="flex items-center gap-2 bg-white shadow px-5 py-2 rounded-full text-gray-700 hover:text-yellow-500 transition font-medium">
            <span class="text-xl">←</span> Kembali
        </a>
    </div>

    <!-- Container utama -->
    <div class="w-full max-w-7xl bg-white rounded-[2rem] shadow-lg relative overflow-hidden">

        <!-- Header gradien -->
        <div class="bg-gradient-to-r from-yellow-400 to-yellow-200 h-24 flex justify-end items-center px-10">
            <button
                class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-2 rounded-lg transition">
                Edit
            </button>
        </div>

        <!-- Isi konten -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 px-16 py-12">

            <!-- Kiri: Profil dan Form -->
            <div>
                <div class="flex flex-col items-center space-y-4 mb-8">
                    <img src="{{ asset('images/Profile.png') }}" alt="Profile Picture"
                         class="w-28 h-28 rounded-full object-cover shadow border-4 border-yellow-200">
                    <div class="text-center">
                        <h2 class="text-lg font-semibold text-gray-800">John Doe</h2>
                        <p class="text-gray-500 text-sm">johndoe@gmail.com</p>
                    </div>
                </div>

                <!-- Formulir -->
                <form action="" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-gray-600 font-medium mb-1">Nama</label>
                        <input type="text" name="name" value="Nama Lengkap"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-yellow-400 focus:outline-none shadow-sm">
                    </div>

                    <div>
                        <label class="block text-gray-600 font-medium mb-1">Tahun Masuk</label>
                        <input type="number" name="year" value="2024"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-yellow-400 focus:outline-none shadow-sm">
                    </div>

                    <div>
                        <label class="block text-gray-600 font-medium mb-1">Semester</label>
                        <input type="text" name="semester" value="3"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-yellow-400 focus:outline-none shadow-sm">
                    </div>

                    <div>
                        <label class="block text-gray-600 font-medium mb-1">Program Studi</label>
                        <input type="text" name="prodi" value="Ilmu Komputer dan Rekayasa"
                               class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 focus:ring-2 focus:ring-yellow-400 focus:outline-none shadow-sm">
                    </div>

                    <button type="button"
                            class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-2 rounded-lg transition mt-4">
                        Keluar
                    </button>
                </form>
            </div>

            <!-- Kanan: Statistik -->
            <div class="flex flex-col justify-start mt-4">
                <h2 class="text-center text-xl font-semibold text-gray-700 mb-6">Statistik</h2>

                <div class="grid grid-cols-2 gap-6 mb-6">

                    <!-- Rank -->
                    <div class="bg-white rounded-2xl shadow p-4 border border-gray-100">
                        <p class="text-gray-500 text-sm mb-1">Rank</p>
                        <p class="font-semibold text-gray-700">Si Baik</p>
                        <div class="w-full bg-gray-200 h-2 rounded-full mt-2">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width:50%"></div>
                        </div>
                    </div>

                    <!-- XP -->
                    <div class="bg-white rounded-2xl shadow p-4 border border-gray-100">
                        <p class="text-gray-500 text-sm mb-1">XP</p>
                        <div class="flex justify-between text-sm text-gray-600">
                            <span>1520</span>
                            <span>/ 3000</span>
                        </div>
                        <div class="w-full bg-gray-200 h-2 rounded-full mt-2">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width:40%"></div>
                        </div>
                    </div>
                </div>

                <!-- Membantu -->
                <div class="bg-white rounded-2xl shadow p-6 border border-gray-100 text-center">
                    <p class="text-gray-500 text-sm mb-2">Membantu</p>
                    <p class="text-2xl font-bold text-yellow-500">150 Pengguna</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

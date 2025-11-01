@extends('layouts.app')

@section('body')
<div class="min-h-screen bg-linear-to-br from-yellow-50 to-white flex justify-center py-12 px-6">
    <div class="w-full max-w-6xl bg-white rounded-3xl shadow-lg p-10 relative">

        <!-- Tombol kembali -->
        <div class="absolute top-6 left-6">
            <button onclick="history.back()"
                class="flex items-center gap-2 text-gray-600 hover:text-yellow-500 transition">
                ← Kembali
            </button>
        </div>

        <!-- Header dan tombol Edit -->
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-2xl font-bold text-gray-700">Profil</h1>
            <button class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-2 rounded-full transition">
                Edit
            </button>
        </div>

        <!-- Bagian Profil -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <!-- Kiri: Foto & info user -->
            <div class="flex flex-col items-center space-y-4">
                <img src="https://i.pravatar.cc/150" alt="Profile Picture"
                     class="w-32 h-32 rounded-full object-cover border-4 border-yellow-300 shadow">
                <div class="text-center">
                    <h2 class="text-lg font-semibold text-gray-700">John Doe</h2>
                    <p class="text-gray-500 text-sm">johndoe@example.com</p>
                </div>
            </div>

            <!-- Tengah: Form data -->
            <div class="col-span-2">
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <label class="block text-gray-600 font-medium mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="John Doe"
                                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-gray-600 font-medium mb-1">Tahun Masuk</label>
                            <input type="number" name="year" value="2022"
                                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-gray-600 font-medium mb-1">Semester</label>
                            <input type="text" name="semester" value="5"
                                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-gray-600 font-medium mb-1">Hobi & Minat</label>
                            <input type="text" name="interest" value="Film, Komputer dan Kebudayaan"
                                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                        </div>
                    </div>

                    <button type="submit"
                            class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-6 py-2 rounded-lg transition">
                        Simpan
                    </button>
                </form>
            </div>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-3 gap-6 mt-16">
            <div class="col-span-3 md:col-span-1">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Statistik</h2>
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-xl border">
                        <p class="text-gray-500 text-sm">Rank</p>
                        <div class="flex items-center justify-between mt-1">
                            <p class="text-lg font-semibold text-gray-800">Bronze</p>
                            <span class="text-sm text-gray-400">3/10</span>
                        </div>
                        <div class="w-full bg-gray-200 h-2 rounded-full mt-2">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width:30%"></div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border">
                        <p class="text-gray-500 text-sm">XP</p>
                        <div class="flex items-center justify-between mt-1">
                            <p class="text-lg font-semibold text-gray-800">1800</p>
                            <span class="text-sm text-gray-400">/ 2500</span>
                        </div>
                        <div class="w-full bg-gray-200 h-2 rounded-full mt-2">
                            <div class="bg-yellow-400 h-2 rounded-full" style="width:70%"></div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-xl border text-center">
                        <p class="text-gray-500 text-sm mb-1">Membantu</p>
                        <p class="text-2xl font-bold text-yellow-500">160 Pengguna</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

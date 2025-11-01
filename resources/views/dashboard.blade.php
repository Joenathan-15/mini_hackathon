@extends('layouts.app')

@section('body')
<div class="min-h-screen bg-linear-to-br from-yellow-50 to-white py-10">
    <div class="container mx-auto px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-yellow-500">Dashboard</h1>
        </div>

        <!-- Statistik -->
        <div class="grid grid-cols-3 gap-6 mb-12 text-center">
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500 text-sm">Materi Terjual</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $soldCount }}</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500 text-sm">Pendapatan</p>
                <p class="text-3xl font-bold text-yellow-500">Rp{{ number_format($income, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500 text-sm">Jumlah Upload</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $uploadCount }}</p>
            </div>
        </div>

        <!-- Riwayat Pembelian -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Riwayat Pembelian</h2>
        <div id="purchases-container" class="grid md:grid-cols-3 gap-6 mb-10">
            <p class="text-gray-500 italic col-span-3 text-center" id="loading-purchase">Memuat data...</p>
        </div>

        <!-- Materi Diunggah -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Berhasil Di Unggah</h2>
        <div id="uploads-container" class="grid md:grid-cols-3 gap-6">
            <p class="text-gray-500 italic col-span-3 text-center" id="loading-upload">Memuat data...</p>
        </div>
    </div>
</div>
@endsection

@section("script")
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {

    // === Fetch Riwayat Pembelian ===
    $.ajax({
        url: "{{ route('material.purchases.index') }}",
        type: "GET",
        dataType: "json",
        success: function (response) {
            const container = $("#purchases-container");
            container.empty();

            if (!response || response.length === 0) {
                container.append(`<p class="text-gray-500 italic col-span-3 text-center">Belum ada pembelian</p>`);
                return;
            }

            response.forEach(item => {
                const isPdf = item.file_name.endsWith('.pdf');
                const iconUrl = isPdf
                    ? "https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg"
                    : "https://upload.wikimedia.org/wikipedia/commons/4/4f/Microsoft_Word_icon_%282019–present%29.svg";

                const status = item.status === 'verified' 
                    ? `<span class='text-green-500 text-xs'>Diverifikasi oleh AI ✓</span>` 
                    : item.status === 'pending'
                    ? `<span class='text-yellow-500 text-xs'>Menunggu verifikasi ⚠️</span>`
                    : `<span class='text-red-500 text-xs'>Tidak terverifikasi oleh AI ⚠️</span>`;

                const priceText = item.price > 0
                    ? `Rp ${new Intl.NumberFormat('id-ID').format(item.price)}`
                    : 'Gratis';

                const card = `
                    <div class="border-2 border-red-500 rounded-xl p-4 bg-white shadow hover:shadow-lg transition flex flex-col">
                        <div class="flex justify-center mb-3">
                            <img src="${iconUrl}" alt="File" class="w-16">
                        </div>
                        <div class="text-center mb-2">
                            <h3 class="font-semibold text-gray-800 text-sm">${item.title}</h3>
                            <p class="text-xs text-gray-500">${item.category?.name ?? '-'}</p>
                        </div>
                        <div class="flex justify-between items-center mt-auto">
                            <div>
                                <p class="text-green-500 text-xs">${priceText}</p>
                                ${status}
                            </div>
                            <button class="bg-yellow-400 hover:bg-yellow-500 text-white text-xs px-4 py-1.5 rounded-full flex items-center gap-1">
                                <i class="fa fa-download"></i> Unduh
                            </button>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        },
        error: function () {
            $("#purchases-container").html(`<p class="text-red-500 italic col-span-3 text-center">Gagal memuat data</p>`);
        }
    });

    // === Fetch Materi Diunggah ===
    $.ajax({
        url: "{{ route('materials.index') }}",
        type: "GET",
        dataType: "json",
        success: function (response) {
            const container = $("#uploads-container");
            container.empty();

            if (!response || response.length === 0) {
                container.append(`<p class="text-gray-500 italic col-span-3 text-center">Belum ada materi yang diunggah</p>`);
                return;
            }

            response.forEach(upload => {
                const isPdf = upload.file_name.endsWith('.pdf');
                const iconUrl = isPdf
                    ? "https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg"
                    : "https://upload.wikimedia.org/wikipedia/commons/4/4f/Microsoft_Word_icon_%282019–present%29.svg";

                const status = upload.status === 'verified' 
                    ? `<span class='text-green-500 text-xs'>Diverifikasi oleh AI ✓</span>` 
                    : upload.status === 'pending'
                    ? `<span class='text-yellow-500 text-xs'>Menunggu verifikasi ⚠️</span>`
                    : `<span class='text-red-500 text-xs'>Tidak terverifikasi oleh AI ⚠️</span>`;

                const priceText = upload.price > 0
                    ? `Rp ${new Intl.NumberFormat('id-ID').format(upload.price)}`
                    : 'Gratis';

const card = `
                    <div class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden">
                        <div class="flex justify-center items-center h-40 bg-white">
                            <img src="${iconUrl}" alt="File Icon" class="w-20 h-20 object-contain">
                        </div>
                        <div class="border-t border-gray-200"></div>
                        <div class="p-4 relative">
                            <div class="absolute top-3 right-4">${status}</div>
                            <div class="mb-4">
                                <h3 class="text-gray-800 font-semibold text-lg">${upload.title}</h3>
                                <p class="text-xs text-gray-500 mt-1">${upload.category?.name ?? '-'}</p>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <span class="text-green-500 font-medium text-sm">${priceText}</span>
                                <button class="flex items-center gap-3 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded-full transition">
                                    <span class="w-7 h-7 bg-yellow-600 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4" />
                                        </svg>
                                    </span>
                                    <span class="text-sm">Unduh</span>
                                </button>
                            </div>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        },
        error: function () {
            $("#uploads-container").html(`<p class="text-red-500 italic col-span-3 text-center">Gagal memuat data</p>`);
        }
    });

});
</script>
@endsection

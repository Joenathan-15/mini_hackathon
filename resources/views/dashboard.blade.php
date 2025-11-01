@extends('layouts.app')
@section("title","")
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
<script>
    $(document).ready(function () {

    const icons = {
        pdf: "https://img.icons8.com/color/96/pdf.png",
        doc: "https://img.icons8.com/color/96/ms-word.png",
        docx: "https://img.icons8.com/color/96/ms-word.png",
        ppt: "https://img.icons8.com/color/96/ms-powerpoint.png",
        pptx: "https://img.icons8.com/color/96/ms-powerpoint.png",
        default: "https://img.icons8.com/ios-filled/100/document--v1.png"
    };

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
                const ext = item.file_name.split('.').pop().toLowerCase();
                const iconUrl = icons[ext] || icons.default;

                const priceText = item.price > 0
                    ? `Rp ${new Intl.NumberFormat('id-ID').format(item.price)}`
                    : 'Gratis';

                const status = `
                    <span class="bg-yellow-400 text-white px-2 py-1 rounded-full text-xs font-semibold">
                        ${item.status ?? 'Selesai'}
                    </span>
                `;

                const status = item.status === 'verified' 
                    ? `<span class='text-green-500 text-xs'>Diverifikasi oleh AI ✓</span>` 
                    : item.status === 'pending'
                    ? `<span class='text-yellow-500 text-xs'>Menunggu verifikasi ⚠️</span>`
                    : `<span class='text-red-500 text-xs'>Tidak terverifikasi oleh AI ⚠️</span>`;

                const priceText = item.price > 0
                    ? `Rp ${new Intl.NumberFormat('id-ID').format(item.price)}`
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
                                <h3 class="text-gray-800 font-semibold text-lg">${item.title}</h3>
                                <p class="text-xs text-gray-500 mt-1">${item.category?.name ?? '-'}</p>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <span class="text-green-500 font-medium text-sm">${priceText}</span>
                                <a href="/materi/${item.id}" class="flex items-center gap-3 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded-full transition">
                                    <span class="w-7 h-7 bg-yellow-600 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m6 0l-3-3m3 3l-3 3" />
                                        </svg>
                                    </span>
                                    <span class="text-sm">Lihat Detail</span>
                                </a>
                            </div>
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
                const ext = upload.file_name.split('.').pop().toLowerCase();
                const iconUrl = icons[ext] || icons.default;

                const status = upload.status === 'verified' 
                    ? `<span class='text-green-500 text-xs'>Diverifikasi oleh AI ✓</span>` 
                    : upload.status === 'pending'
                    ? `<span class='text-yellow-500 text-xs'>Menunggu verifikasi ⚠️</span>`
                    : `<span class='text-red-500 text-xs'>Tidak terverifikasi oleh AI ⚠️</span>`;

                const priceText = upload.price > 0
                    ? `Rp ${new Intl.NumberFormat('id-ID').format(upload.price)}`
                    : 'Gratis';

                const status = `
                    <span class="bg-green-400 text-white px-2 py-1 rounded-full text-xs font-semibold">
                        Diunggah
                    </span>
                `;

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
                                <a href="/materi/${upload.id}" class="flex items-center gap-3 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded-full transition">
                                    <span class="w-7 h-7 bg-yellow-600 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m6 0l-3-3m3 3l-3 3" />
                                        </svg>
                                    </span>
                                    <span class="text-sm">Lihat Detail</span>
                                </a>
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

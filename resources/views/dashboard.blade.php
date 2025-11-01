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
        <div class="grid md:grid-cols-3 gap-6 mb-10">
            <p class="text-gray-500 italic col-span-3 text-center">Belum ada pembelian</p>
        </div>

        <!-- Materi Diunggah -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Materi Diunggah</h2>
        <div id="uploads-container" class="grid md:grid-cols-3 gap-6">
            <p class="text-gray-500 italic col-span-3 text-center" id="loading">Memuat data...</p>
        </div>
    </div>
</div>
@endsection

@section("script")
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function () {
    $.ajax({
        url: "{{ route('materials.index') }}", // adjust if needed
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

                const priceText = upload.price > 0
                    ? `Rp ${new Intl.NumberFormat('id-ID').format(upload.price)}`
                    : 'Gratis';

                const card = `
                    <div class="bg-white border rounded-xl p-4 flex flex-col shadow hover:shadow-lg transition">
                        <div class="flex justify-center mb-4">
                            <img src="${iconUrl}" alt="File" class="w-12">
                        </div>
                        <h3 class="text-gray-700 font-semibold text-lg">${upload.title}</h3>
                        <p class="text-sm text-gray-500 mb-2">${upload.category?.name ?? '-'}</p>
                        <p class="text-gray-700 text-sm flex-grow">${upload.description?.substring(0, 60) ?? ''}</p>
                        <p class="text-right mt-3 font-bold text-yellow-500">${priceText}</p>
                    </div>
                `;
                container.append(card);
            });
        },
        error: function (xhr, status, error) {
            console.error("Error fetching materials:", error);
            $("#uploads-container").html(`<p class="text-red-500 italic col-span-3 text-center">Gagal memuat data</p>`);
        }
    });
});
</script>
@endsection

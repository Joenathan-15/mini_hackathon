@extends('layouts.app')
@section("title","Dashboard")
@section('body')
<div class="min-h-screen bg-linear-to-br from-yellow-50 to-white py-10">
    <div class="container mx-auto px-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-bold text-yellow-500">Dashboard</h1>
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-3 gap-6 mb-12 text-center">
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500 text-sm">Materials Sold</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $soldCount }}</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500 text-sm">Income</p>
                <p class="text-3xl font-bold text-yellow-500">Rp{{ number_format($income, 0, ',', '.') }}</p>
            </div>
            <div class="bg-white shadow rounded-xl p-6">
                <p class="text-gray-500 text-sm">Total Uploads</p>
                <p class="text-3xl font-bold text-yellow-500">{{ $uploadCount }}</p>
            </div>
        </div>

        <!-- Purchase History -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Purchase History</h2>
        <div id="purchases-container" class="grid md:grid-cols-3 gap-6 mb-10">
            <p class="text-gray-500 italic col-span-3 text-center" id="loading-purchase">Loading data...</p>
        </div>

        <!-- Uploaded Materials -->
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Successfully Uploaded</h2>
        <div id="uploads-container" class="grid md:grid-cols-3 gap-6">
            <p class="text-gray-500 italic col-span-3 text-center" id="loading-upload">Loading data...</p>
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

    // === Fetch Purchase History ===
    $.ajax({
        url: "{{ route('material.purchases.index') }}",
        type: "GET",
        dataType: "json",
        success: function (response) {
            const container = $("#purchases-container");
            container.empty();

            if (!response || response.length === 0) {
                container.append(`<p class="text-gray-500 italic col-span-3 text-center">No purchases yet</p>`);
                return;
            }

            response.forEach(item => {
                const fileExtension = item.file_name.split('.').pop().toLowerCase();
                const iconUrl = icons[fileExtension] || icons.default;

                const priceText = item.price > 0
                    ? `Rp ${new Intl.NumberFormat('id-ID').format(item.price)}`
                    : 'Free';

                const statusBadge = item.status === 'verified'
                    ? `<span class='text-green-500 text-xs'>Verified by AI ✓</span>`
                    : item.status === 'pending'
                    ? `<span class='text-yellow-500 text-xs'>Pending verification ⚠️</span>`
                    : `<span class='text-red-500 text-xs'>Not verified by AI ⚠️</span>`;

                const card = `
                    <div class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden">
                        <div class="flex justify-center items-center h-40 bg-white">
                            <img src="${iconUrl}" alt="File Icon" class="w-20 h-20 object-contain">
                        </div>
                        <div class="border-t border-gray-200"></div>
                        <div class="p-4 relative">
                            <div class="absolute top-3 right-4">${statusBadge}</div>
                            <div class="mb-4">
                                <h3 class="text-gray-800 font-semibold text-lg">${item.title}</h3>
                                <p class="text-xs text-gray-500 mt-1">${item.category?.name ?? '-'}</p>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <span class="text-green-500 font-medium text-sm">${priceText}</span>
                                <a href="/materials/${item.id}" class="flex items-center gap-3 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded-full transition">
                                    <span class="w-7 h-7 bg-yellow-600 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm">View Details</span>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        },
        error: function () {
            $("#purchases-container").html(`<p class="text-red-500 italic col-span-3 text-center">Failed to load data</p>`);
        }
    });

    // === Fetch Uploaded Materials ===
    $.ajax({
        url: "{{ route('materials.index') }}",
        type: "GET",
        dataType: "json",
        success: function (response) {
            const container = $("#uploads-container");
            container.empty();

            if (!response || response.length === 0) {
                container.append(`<p class="text-gray-500 italic col-span-3 text-center">No materials uploaded yet</p>`);
                return;
            }

            response.forEach(upload => {
                const fileExtension = upload.file_name.split('.').pop().toLowerCase();
                const iconUrl = icons[fileExtension] || icons.default;

                const statusBadge = upload.status === 'verified'
                    ? `<span class='text-green-500 text-xs'>Verified by AI ✓</span>`
                    : upload.status === 'pending'
                    ? `<span class='text-yellow-500 text-xs'>Pending verification ⚠️</span>`
                    : `<span class='text-red-500 text-xs'>Not verified by AI ⚠️</span>`;

                const priceText = upload.price > 0
                    ? `Rp ${new Intl.NumberFormat('id-ID').format(upload.price)}`
                    : 'Free';

                const card = `
                    <div class="bg-white border rounded-xl shadow-sm hover:shadow-lg transition overflow-hidden">
                        <div class="flex justify-center items-center h-40 bg-white">
                            <img src="${iconUrl}" alt="File Icon" class="w-20 h-20 object-contain">
                        </div>
                        <div class="border-t border-gray-200"></div>
                        <div class="p-4 relative">
                            <div class="absolute top-3 right-4">${statusBadge}</div>
                            <div class="mb-4">
                                <h3 class="text-gray-800 font-semibold text-lg">${upload.title}</h3>
                                <p class="text-xs text-gray-500 mt-1">${upload.category?.name ?? '-'}</p>
                            </div>
                            <div class="flex items-center justify-between mt-6">
                                <span class="text-green-500 font-medium text-sm">${priceText}</span>
                                <a href="/materials/${upload.id}" class="flex items-center gap-3 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold px-4 py-2 rounded-full transition">
                                    <span class="w-7 h-7 bg-yellow-600 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <span class="text-sm">View Details</span>
                                </a>
                            </div>
                        </div>
                    </div>
                `;
                container.append(card);
            });
        },
        error: function () {
            $("#uploads-container").html(`<p class="text-red-500 italic col-span-3 text-center">Failed to load data</p>`);
        }
    });

});
</script>
@endsection

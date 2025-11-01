@extends('layouts.app')

@section('title', 'Jelajahi')

@section('head')
<style>
    .tag {
        background-color: oklch(var(--p)/0.15);
        color: oklch(var(--p));
        border: 1px solid oklch(var(--p)/0.3);
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        display: inline-flex;
        align-items: center;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }

    .tag:hover {
        background-color: oklch(var(--p)/0.25);
    }

    .tag .remove {
        margin-left: 0.4rem;
        cursor: pointer;
        font-weight: bold;
    }

    .autocomplete-list {
        max-height: 200px;
        overflow-y: auto;
    }

    .autocomplete-item {
        transition: 0.2s ease, color 0.2s ease;
    }

    .autocomplete-item:hover {
        background-color: oklch(var(--p)/0.1);
        color: oklch(var(--p));
    }
</style>
@endsection

@section('body')
<section class="py-16 bg-linear-to-br from-primary/5">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold bg-linear-to-r from-primary to-secondary bg-clip-text text-transparent mb-3">
                Jelajahi Materi 🔍
            </h1>
            <p class="text-base-content/60 text-sm sm:text-base max-w-2xl mx-auto">
                Temukan catatan, ringkasan, dan sumber belajar dari berbagai bidang ilmu — semua dalam satu tempat.
            </p>
        </div>

        <!-- Search + Filter Bar -->
        <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
            <label class="input input-bordered flex items-center gap-2 w-full sm:w-80 bg-white shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 opacity-50" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                </svg>
                <input id="search" type="search" class="grow text-sm" placeholder="Cari Materi..." />
            </label>

            <!-- Category Filter -->
            <div class="relative w-full sm:w-80">
                <div id="category-box"
                    class="input input-bordered flex flex-wrap items-center gap-1 w-full cursor-text bg-white shadow-sm">
                    <div id="selected-tags" class="flex flex-wrap items-center gap-1"></div>
                    <input id="category-filter" type="text"
                        class="flex-1 min-w-24 border-none outline-none text-sm" placeholder="Tambahkan kategori..."
                        autocomplete="off" />
                </div>

                <!-- Autocomplete Dropdown -->
                <ul id="autocomplete-list"
                    class="autocomplete-list absolute z-50 w-full mt-1 bg-base-100 border border-base-300 rounded-xl shadow-lg hidden">
                </ul>
            </div>
        </div>

        <!-- Material Cards -->
        <div id="material_cards" class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
        </div>
    </div>
</section>

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
        error: function (xhr, status, error) {
            console.error("Error fetching purchases:", error);
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
        error: function (xhr, status, error) {
            console.error("Error fetching materials:", error);
            $("#uploads-container").html(`<p class="text-red-500 italic col-span-3 text-center">Gagal memuat data</p>`);
        }
    });

});
</script>
@endsection

<script>
$(function () {
    const $input = $('#category-filter');
    const $list = $('#autocomplete-list');
    const $selected = $('#selected-tags');
    const $search = $('#search');
    const $content = $('#material_cards');
    let selectedValues = [];
    let categories = [];
    let debounceTimer;

    // Fetch categories
    function fetchCategories(query = '') {
        $.ajax({
            url: '/api/categories',
            method: 'GET',
            data: { search: query },
            dataType: 'json',
            success: function (data) {
                categories = data.data || data || [];
                refreshList();
            },
            error: function () {
                console.error('Gagal mengambil data kategori.');
                refreshList();
            }
        });
    }

    // Fetch materials
    function fetchMaterials() {
        const query = $search.val().trim();
        $.ajax({
            url: '/materials',
            method: 'GET',
            data: { search: query, categories: selectedValues },
            dataType: 'json',
            beforeSend: function () {
                $content.html(`
                    <div class="col-span-full flex justify-center items-center py-20">
                        <span class="loading loading-spinner loading-lg text-primary"></span>
                    </div>
                `);
            },
            success: function (data) {
                const materials = data || [];
                renderMaterials(materials);
            },
            error: function () {
                $content.html(`
                    <div class="col-span-full text-center py-20 text-error">
                        Gagal memuat materi.
                    </div>
                `);
            }
        });
    }

    // Render material cards
function renderMaterials(materials) {
    // ... (kode pengecekan materials.length dan iconMap tetap sama)
    
    // Pemetaan ikon file (Pastikan iconMap ini sudah benar)
    const iconMap = {
        pdf: "https://img.icons8.com/color/96/pdf.png",
        doc: "https://img.icons8.com/color/96/ms-word.png",
        docx: "https://img.icons8.com/color/96/ms-word.png",
        ppt: "https://img.icons8.com/color/96/ms-powerpoint.png",
        pptx: "https://img.icons8.com/color/96/ms-powerpoint.png",
        default: "https://img.icons8.com/ios-filled/100/document--v1.png"
    };

    $content.empty();
    materials.forEach((m) => {
        const price = m.price > 0 ? `Rp ${new Intl.NumberFormat('id-ID').format(m.price)}` : 'Gratis';
        
        let ext = m.file_path ? m.file_path.split('.').pop().toLowerCase() : (m.file_type ? m.file_type.toLowerCase() : '');
        const iconSrc = iconMap[ext] || iconMap.default;

        // --- Tentukan Status dan Teks Tombol ---
        // (Asumsi: Status 'Menunggu verifikasi' adalah dari data 'm.status')
        const statusText = m.status === 'pending' || m.status === 'Menunggu verifikasi'
            ? `<span class="text-yellow-600 text-xs font-semibold flex items-center gap-1">Menunggu verifikasi <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.332 16c-.77 1.333.192 3 1.732 3z" /></svg></span>`
            : ''; // Anda bisa menambahkan status lain di sini (misalnya 'Terverifikasi')

        const buttonText = m.is_purchased ? 'Unduh' : 'Lihat Detail';
        const buttonIcon = m.is_purchased 
            ? `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>` 
            : `<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m6 0l-3-3m3 3l-3 3" /></svg>`;
            
        // Catatan: Saya menggunakan border-primary/50 untuk meniru garis merah muda di screenshot
        $content.append(`
            <div class="card bg-white border border-primary/50 shadow-md transition hover:shadow-lg">
                <div class="p-6">
                    <div class="flex justify-center items-center h-20 mb-4">
                        <img src="${iconSrc}" alt="${ext.toUpperCase()} Icon" class="w-16 h-16 object-contain">
                    </div>
                    
                    <div class="border-t border-base-200 pt-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <h2 class="text-lg font-bold text-gray-800 line-clamp-2">${m.title || 'Judul Materi'}</h2>
                                <p class="text-xs text-gray-500 mt-1">${m.metadata || 'Semester 4 | Farmasi | FMIPA'}</p> 
                                </div>
                            
                            <div class="ml-4 flex-shrink-0">
                                ${statusText}
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-4">
                            <span class="text-green-600 font-bold text-base">${price}</span>

                            <a href="/materials/${m.id}" class="btn btn-sm bg-yellow-400 hover:bg-yellow-500 text-white font-bold rounded-lg px-6">
                                ${buttonIcon}
                                ${buttonText}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `);
    });
}


    // Autocomplete logic
    function refreshList(showAll = false) {
        const val = $input.val().toLowerCase();
        $list.empty();

        const filtered = categories.filter(c =>
            (showAll || c.toLowerCase().includes(val)) && !selectedValues.includes(c)
        );

        if (filtered.length === 0) $list.addClass('hidden');
        else $list.removeClass('hidden');

        filtered.forEach(c => {
            $list.append(`<li class="autocomplete-item px-4 py-2 cursor-pointer hover:bg-primary/10">${c}</li>`);
        });
    }

    function addTag(value) {
        if (!selectedValues.includes(value)) {
            selectedValues.push(value);
            $selected.append(`<span class="tag">${value}<span class="remove">&times;</span></span>`);
            $input.val('');
            refreshList(true);
            fetchMaterials();
        }
    }

    // Events
    $input.on('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => fetchCategories($(this).val()), 300);
    });

    $input.on('focus', function () { fetchCategories(''); });
    $list.on('click', '.autocomplete-item', function () {
        addTag($(this).text());
        $list.addClass('hidden');
    });
    $selected.on('click', '.remove', function () {
        const value = $(this).parent().text().trim().slice(0, -1);
        selectedValues = selectedValues.filter(v => v !== value);
        $(this).parent().remove();
        fetchMaterials();
    });
    $(document).on('click', function (e) {
        if (!$(e.target).closest('#category-box, #autocomplete-list').length) $list.addClass('hidden');
    });

    $search.on('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchMaterials, 400);
    });

    // Init
    fetchCategories('');
    fetchMaterials();
});
</script>
@endsection

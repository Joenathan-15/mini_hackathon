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
            url: '/categories',
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
        if (materials.length === 0) {
            $content.html(`
                <div class="col-span-full text-center py-20 text-base-content/70">
                    Tidak ada materi ditemukan.
                </div>
            `);
            return;
        }

        $content.empty();
        materials.forEach((m) => {
            const price = m.price > 0 ? `Rp ${new Intl.NumberFormat('id-ID').format(m.price)}` : 'Gratis';
            $content.append(`
                <div class="card bg-white border border-base-200 shadow-md hover:shadow-xl transition-transform hover:-translate-y-1 duration-300">
                    <div class="h-48 flex items-center justify-center bg-linear-to-br from-primary/10 to-secondary/10">
                        <div class="bg-primary/20 p-4 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title text-lg font-semibold">${m.title}</h2>
                        <p class="text-base-content/70 text-sm line-clamp-3">${m.description || 'Tidak ada deskripsi.'}</p>
                        <div class="flex items-center justify-between mt-3">
                            <span class="badge badge-primary badge-outline text-xs">${m.category || '-'}</span>
                            <span class="text-sm font-medium text-primary">${price}</span>
                        </div>
                        <a href="/materials/${m.id}" class="btn btn-sm btn-primary mt-4 rounded-full w-full">Lihat Detail</a>
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

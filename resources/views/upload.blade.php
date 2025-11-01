@extends('layouts.app') {{-- Ganti dari layouts.auth ke layouts.app --}}

@section('title', 'Unggah Materi')

@section('head')
{{-- Tambahkan FontAwesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('body')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto text-center mb-10">
        <h1 class="text-3xl font-bold text-base-content mb-3">Unggah Catatan atau Jurnal</h1>
        <p class="text-base-content/70">
            Seret & letakkan file kamu di bawah, atau klik untuk memilih dari perangkat.
        </p>
    </div>

    {{-- Pesan sukses / error --}}
    @if (session('success'))
    <div class="alert alert-success mb-5 shadow-lg">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="alert alert-error mb-5 shadow-lg">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- Dropzone -->
    <div class="max-w-2xl mx-auto flex flex-col items-center">
        <div id="dropzone-area"
            class="w-full bg-base-200 border-2 border-dashed border-base-300 rounded-xl shadow-md p-10 flex flex-col items-center justify-center cursor-pointer hover:border-primary transition text-center">
            <i class="fas fa-cloud-upload-alt text-6xl text-primary mb-4"></i>
            <p class="text-lg font-medium text-base-content">Tarik & letakkan file di sini</p>
            <p class="text-sm text-base-content/70 mt-1">atau klik untuk memilih file</p>
            <input id="file-input" type="file" name="file" class="hidden" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt" />
        </div>

        <a href="{{ url('/') }}" class="btn btn-ghost mt-6 flex items-center justify-center gap-2">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
    </div>

    <!-- Form detail -->
    <div id="upload-form" class="max-w-2xl mx-auto bg-base-200 rounded-box shadow-lg p-8 mt-8 hidden">
        <div class="flex items-center mb-6">
            <div id="file-icon"
                class="w-16 h-20 bg-neutral flex items-center justify-center text-white rounded-md mr-4">
                <i class="fas fa-file text-2xl"></i>
            </div>
            <div>
                <p id="file-name" class="font-semibold text-base-content"></p>
                <p class="text-sm text-base-content/70" id="file-size"></p>
            </div>
        </div>

        {{-- Ganti action dengan route yang sesuai --}}
        {{-- {{ route('materials.store') }} --}}
        <form action="{{route('material.store')}}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <input id="form-file-input" type="file" name="file_path" class="hidden" />

            <div class="form-control">
                <label class="label font-medium">Judul (Diperlukan)</label>
                <input type="text" name="title" class="input input-bordered w-full"
                    placeholder="Contoh: Catatan Pemrograman Web" required>
            </div>

            <div class="form-control">
                <label class="label font-medium">Deskripsi (Diperlukan)</label>
                <textarea name="description" class="textarea textarea-bordered w-full"
                    placeholder="Berikan ringkasan singkat isi dokumen..." required></textarea>
            </div>

            {{-- Tambahkan field kategori --}}
            <div class="form-control">
                <label class="label font-medium">Kategori</label>
                <div id="category-input-container"
                    class="flex flex-wrap items-center gap-2 input input-bordered w-full min-h-12 p-2">
                    <input id="category-input" type="text" class="flex-1 bg-transparent outline-none"
                        placeholder="Ketik dan tekan Enter..." />
                </div>
                <input type="hidden" name="categories" id="categories-hidden">
            </div>

            <div class="form-control">
                <label class="label font-medium">Tipe Publikasi</label>
                <div class="flex gap-4">
                    <label class="cursor-pointer flex items-center gap-2">
                        <input type="radio" name="type" value="free" class="radio radio-primary" checked>
                        <span>Gratis</span>
                    </label>
                    <label class="cursor-pointer flex items-center gap-2">
                        <input type="radio" name="type" value="paid" class="radio radio-primary">
                        <span>Berbayar</span>
                    </label>
                </div>
            </div>

            <div id="price-field" class="form-control hidden">
                <label class="label font-medium">Harga (Rp)</label>
                <input type="number" name="price" class="input input-bordered w-full" placeholder="Contoh: 5000"
                    min="0">
            </div>

            <div class="flex justify-between items-center">
                <button type="button" id="cancel-upload" class="btn btn-ghost">
                    <i class="fas fa-times"></i> Hapus
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i> Kirim
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    (function(){
        const dropzone = document.getElementById('dropzone-area');
        const fileInput = document.getElementById('file-input');
        const formFileInput = document.getElementById('form-file-input');
        const uploadForm = document.getElementById('upload-form');
        const fileNameEl = document.getElementById('file-name');
        const fileSizeEl = document.getElementById('file-size');
        const cancelUpload = document.getElementById('cancel-upload');
        const priceField = document.getElementById('price-field');
        const typeRadios = document.querySelectorAll('input[name="type"]');

        if (!dropzone) return;

        // klik buka picker
        dropzone.addEventListener('click', () => fileInput.click());

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            handleFile(file);
        });

        dropzone.addEventListener('dragover', (event) => {
            event.preventDefault();
            dropzone.classList.add('border-primary', 'bg-base-300');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-primary', 'bg-base-300');
        });

        dropzone.addEventListener('drop', (event) => {
            event.preventDefault();
            dropzone.classList.remove('border-primary', 'bg-base-300');
            const file = event.dataTransfer.files[0];
            handleFile(file);
        });

        function handleFile(file) {
            if (file) {
                // Validasi tipe file
                const allowedTypes = ['.pdf', '.doc', '.docx', '.ppt', '.pptx', '.txt'];
                const fileExtension = '.' + file.name.split('.').pop().toLowerCase();

                if (!allowedTypes.includes(fileExtension)) {
                    alert('Tipe file tidak didukung. Silakan pilih file PDF, DOC, DOCX, PPT, PPTX, atau TXT.');
                    return;
                }

                // Validasi ukuran file (max 10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar. Maksimal 10MB.');
                    return;
                }

                fileNameEl.textContent = file.name;
                fileSizeEl.textContent = `${(file.size / 1024 / 1024).toFixed(2)} MB`;
                dropzone.classList.add('hidden');
                uploadForm.classList.remove('hidden');

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                formFileInput.files = dataTransfer.files;
            }
        }

        cancelUpload.addEventListener('click', () => {
            if (fileInput) fileInput.value = '';
            if (formFileInput) formFileInput.value = '';
            uploadForm.classList.add('hidden');
            dropzone.classList.remove('hidden');
        });

        typeRadios.forEach(radio => {
            radio.addEventListener('change', () => {
                if (radio.value === 'paid' && radio.checked) {
                    priceField.classList.remove('hidden');
                    priceField.querySelector('input').setAttribute('required', true);
                } else if (radio.value === 'free' && radio.checked) {
                    priceField.classList.add('hidden');
                    priceField.querySelector('input').removeAttribute('required');
                    priceField.querySelector('input').value = '';
                }
            });
        });
                const container = document.getElementById('category-input-container');
        const input = document.getElementById('category-input');
        const hiddenInput = document.getElementById('categories-hidden');
        let tags = [];

        function updateHiddenInput() {
            hiddenInput.value = JSON.stringify(tags);
        }

        function renderTags() {
            // remove existing tags except input
            container.querySelectorAll('.tag').forEach(tag => tag.remove());
            tags.forEach(tag => {
                const tagEl = document.createElement('span');
                tagEl.className = 'tag bg-primary/10 border border-primary/30 text-primary px-3 py-1 rounded-full text-sm flex items-center gap-1';
                tagEl.innerHTML = `
                    ${tag}
                    <button type="button" class="remove-tag text-primary hover:text-error">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                `;
                container.insertBefore(tagEl, input);

                tagEl.querySelector('.remove-tag').addEventListener('click', () => {
                    tags = tags.filter(t => t !== tag);
                    renderTags();
                    updateHiddenInput();
                });
            });
        }

        input.addEventListener('keydown', (e) => {
            const value = input.value.trim();
            if ((e.key === 'Enter' || e.key === ',') && value) {
                e.preventDefault();
                if (!tags.includes(value)) {
                    tags.push(value);
                    renderTags();
                    updateHiddenInput();
                }
                input.value = '';
            } else if (e.key === 'Backspace' && !value && tags.length) {
                tags.pop();
                renderTags();
                updateHiddenInput();
            }
        });

    })();
</script>
@endsection

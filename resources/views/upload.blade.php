@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-yellow-50 to-white">
    <div id="dropZoneSection" class="w-full max-w-3xl text-center p-10">
        <h1 class="text-2xl font-bold text-gray-700 mb-8">Unggah Catatan atau Jurnal</h1>

        <!-- Drop Zone -->
        <label for="fileInput"
               id="dropZone"
               class="border-2 border-dashed border-blue-400 bg-white rounded-2xl p-16 cursor-pointer hover:bg-blue-50 transition block">
            <div class="flex flex-col items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-yellow-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 16V4m0 12a4 4 0 008 0m-8 0H5a2 2 0 00-2 2v3h18v-3a2 2 0 00-2-2h-2" />
                </svg>
                <p class="text-gray-600">Tarik & letakkan file di sini</p>
                <p class="text-sm text-gray-400 mt-1">atau klik untuk memilih file (.pdf, .doc, .docx)</p>
            </div>
            <input type="file" id="fileInput" accept=".pdf,.doc,.docx" class="hidden" />
        </label>

        <button class="mt-6 text-gray-500 hover:underline" onclick="history.back()">← Kembali</button>
    </div>

    <!-- Form Section -->
    <div id="formSection" class="hidden w-full max-w-4xl bg-white rounded-2xl shadow-xl flex p-8 gap-8">
        <!-- Preview -->
        <div class="flex items-center justify-center border-2 border-dashed border-red-400 rounded-xl w-1/3 min-h-[300px]">
            <div class="text-center">
                <img id="fileIcon" src="" alt="File Icon" class="w-24 mx-auto mb-4">
                <p id="fileName" class="text-sm text-gray-600"></p>
            </div>
        </div>

        <!-- Form Fields -->
        <div class="flex-1 space-y-4">
            <h2 class="text-xl font-semibold text-gray-700">Detail File</h2>
            <form id="uploadForm" action="{{ route('materials.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="file" id="hiddenFile">

                <div>
                    <label class="block text-gray-600 font-medium">Judul</label>
                    <input type="text" name="title" placeholder="Contoh: Catatan Perhitungan Fisika"
                           class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                </div>

                <div>
                    <label class="block text-gray-600 font-medium">Deskripsi</label>
                    <textarea name="description" placeholder="Berikan deskripsi file di sini..."
                              class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-yellow-400 focus:outline-none"></textarea>
                </div>

                <div class="flex items-center gap-4">
                    <label class="block text-gray-600 font-medium">Tipe Publikasi</label>
                    <label class="flex items-center gap-1">
                        <input type="radio" name="type" value="Berbayar" class="text-yellow-500" checked>
                        <span>Berbayar</span>
                    </label>
                    <label class="flex items-center gap-1">
                        <input type="radio" name="type" value="Gratis" class="text-yellow-500">
                        <span>Gratis</span>
                    </label>
                </div>

                <div>
                    <label class="block text-gray-600 font-medium">Harga (Rp)</label>
                    <input type="number" name="price" placeholder="contoh: 10000"
                           class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-yellow-400 focus:outline-none">
                </div>

                <button type="submit"
                        class="w-full mt-4 bg-yellow-400 hover:bg-yellow-500 text-white font-semibold py-2 rounded-lg transition">
                    Publish
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('fileInput');
    const dropZoneSection = document.getElementById('dropZoneSection');
    const formSection = document.getElementById('formSection');
    const fileNameDisplay = document.getElementById('fileName');
    const fileIcon = document.getElementById('fileIcon');

    dropZone.addEventListener('click', () => fileInput.click());

    dropZone.addEventListener('dragover', e => {
        e.preventDefault();
        dropZone.classList.add('bg-blue-50');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('bg-blue-50');
    });

    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        dropZone.classList.remove('bg-blue-50');
        const file = e.dataTransfer.files[0];
        handleFile(file);
    });

    fileInput.addEventListener('change', e => {
        const file = e.target.files[0];
        handleFile(file);
    });

    function handleFile(file) {
        const allowed = ["application/pdf",
                         "application/msword",
                         "application/vnd.openxmlformats-officedocument.wordprocessingml.document"];

        if (file && allowed.includes(file.type)) {
            fileNameDisplay.textContent = file.name;

            // Ganti icon sesuai ekstensi
            if (file.name.endsWith('.pdf')) {
                fileIcon.src = "https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg";
            } else {
                fileIcon.src = "https://upload.wikimedia.org/wikipedia/commons/8/8c/Microsoft_Word_2013-2019_logo.svg";
            }

            dropZoneSection.classList.add('hidden');
            formSection.classList.remove('hidden');
        } else {
            alert("Hanya file PDF, DOC, atau DOCX yang diperbolehkan!");
        }
    }
</script>
@endsection

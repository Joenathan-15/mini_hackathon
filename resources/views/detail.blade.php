@extends('layouts.app')

@section('title', 'Detail Materi')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-6">
  <h2 class="text-3xl font-bold text-yellow-600 mb-10 text-center">Detail Materi 🔍</h2>

  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
    <!-- Gambar PDF -->
    <div class="flex justify-center">
      <div class="border-4 border-red-400 rounded-xl p-10">
        <img src="https://img.icons8.com/color/96/pdf.png" alt="PDF" class="w-40 mx-auto">
      </div>
    </div>

    <!-- Detail Materi -->
    <div>
      <h3 class="text-2xl font-bold">Ejaan Yang Di Sempurnakan IV</h3>
      <p class="text-gray-500 uppercase">Bahasa Indonesia</p>
      <p class="text-green-600 font-bold text-xl mt-2">Rp5.000</p>

      <hr class="my-3 border-red-400 w-3/4">

      <h4 class="font-semibold mb-1">Description</h4>
      <p class="text-gray-600 text-sm mb-2">
        Alice and Her Purple Diary is an American classic romance series by James Anderson...
      </p>
      <a href="#" class="text-green-600 text-sm font-semibold">Baca selengkapnya</a>

      <div class="mt-6 p-4 border rounded-lg">
        <p class="text-sm text-gray-700 mb-2">Terjual</p>
        <input type="text" readonly value="102"
               class="border px-3 py-1 rounded w-24 text-center mb-3">
        <br>
        <button class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-md w-full font-semibold">
          Beli Sekarang
        </button>

        <div class="flex justify-between mt-3">
          <button class="border border-green-500 text-green-600 px-4 py-1 rounded-md hover:bg-green-50 flex items-center gap-1">
            👍 Suka
          </button>
          <button class="border border-red-500 text-red-600 px-4 py-1 rounded-md hover:bg-red-50 flex items-center gap-1">
            👎 Tidak Suka
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

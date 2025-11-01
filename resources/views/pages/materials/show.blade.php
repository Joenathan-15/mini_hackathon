@extends('layouts.app')
@section("title", $material->title ?? 'Detail Materi')

@section('head')
<style>
    .page-bg {
        background: linear-gradient(135deg, rgba(255, 244, 214, 0.95) 0%, rgba(255, 255, 255, 1) 60%);
    }

    .detail-title {
        font-weight: 800;
        color: #f4b92a;
        font-size: 2.75rem;
        text-align: center;
    }

    .preview-box {
        border: 3px solid #e60000;
        background: #fff;
        min-height: 640px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }

    .pdf-icon {
        width: 320px;
        height: 320px;
        object-fit: contain;
    }

    .progress-track {
        background: #efefef;
        height: 10px;
        border-radius: 999px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: #10b981;
        width: 70%;
        transition: width .4s ease;
    }

    .info-card {
        border: 1px solid rgba(0, 0, 0, 0.06);
        background: rgba(255, 255, 255, 0.98);
        padding: 1rem;
        border-radius: 8px;
    }

    .btn-like,
    .btn-dislike {
        width: 48%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .5rem;
        padding: .6rem .8rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all .2s ease;
    }

    .btn-like {
        border: 1px solid #10b981;
        color: #059669;
        background: transparent;
    }

    .btn-dislike {
        border: 1px solid #ef4444;
        color: #ef4444;
        background: transparent;
    }

    .btn-like:hover {
        background: #10b981;
        color: white;
    }

    .btn-dislike:hover {
        background: #ef4444;
        color: white;
    }

    @media (max-width:1024px) {
        .preview-box {
            min-height: 420px
        }

        .pdf-icon {
            width: 220px;
            height: 220px
        }

        .detail-title {
            font-size: 2rem
        }
    }
</style>
@endsection

@section('body')
<div class="min-h-screen page-bg py-10">
    <div class="container mx-auto px-8">
        <div class="text-center mb-8">
            <h1 class="detail-title">Detail Materi 🔍</h1>
        </div>

        <div class="grid grid-cols-12 gap-8 items-start">
            {{-- LEFT: big preview --}}
            <div class="col-span-12 lg:col-span-7">
                <div class="preview-box">
                    @php
                    $fileName = is_object($material) ? ($material->file_name ?? null) : ($material['file_name'] ??
                    null);
                    $ext = $fileName ? strtolower(pathinfo($fileName, PATHINFO_EXTENSION)) : null;
                    @endphp

                    @if($ext && in_array($ext, ['pdf']))
                    <img src="https://img.icons8.com/color/96/pdf.png" alt="PDF" class="pdf-icon">
                    @elseif(is_object($material) && !empty($material->thumbnail_url))
                    <img src="{{ $material->thumbnail_url }}" alt="{{ $material->title }}" class="pdf-icon">
                    @elseif(!is_object($material) && !empty($material['thumbnail_url']))
                    <img src="{{ $material['thumbnail_url'] }}" alt="{{ $material['title'] ?? 'Materi' }}"
                        class="pdf-icon">
                    @else
                    <img src="https://img.icons8.com/color/96/pdf.png" alt="PDF" class="pdf-icon">
                    @endif
                </div>
            </div>

            {{-- RIGHT: details --}}
            <div class="col-span-12 lg:col-span-5">
                <div class="space-y-6">
                    {{-- Title & Category --}}
                    <div>
                        <h2 class="text-3xl lg:text-4xl font-extrabold text-gray-800">
                            {{ is_object($material) ? ($material->title ?? 'Judul Materi') : ($material['title'] ??
                            'Judul Materi') }}
                        </h2>
                        <p class="text-xs text-gray-400 uppercase mt-2">
                            {{ is_object($material) ? ($material->category->name ?? '-') : ($material['category'] ??
                            '-') }}
                        </p>
                    </div>

                    {{-- Price & progress --}}
                    <div>
                        @php
                        $price = is_object($material) ? ($material->price ?? 0) : ($material['price'] ?? 0);
                        $priceText = $price > 0 ? 'Rp'.number_format($price,0,',','.') : 'Gratis';
                        $progress = is_object($material) ? ($material->popularity ?? ($material->progress ?? 70)) :
                        ($material['popularity'] ?? ($material['progress'] ?? 70));
                        $progressColor = $price > 0 ? '#ef4444' : '#10b981';
                        @endphp

                        <div class="text-2xl font-extrabold text-green-600">
                            {{ $priceText }}
                        </div>

                        <div class="mt-4">
                            <div class="progress-track">
                                <div class="progress-fill"
                                    style="width: {{ intval($progress) }}%; background: {{ $progressColor }};"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <h3 class="font-semibold text-sm text-gray-700 mb-2">Deskripsi</h3>
                        <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                            {{ $material->description ?? (is_object($material) ? ($material->description ?? '-') :
                            ($material['description'] ?? '-')) }}
                        </p>
                    </div>

                    {{-- Info card --}}
                    <div class="info-card">
                        <div class="mb-4">
                            <label class="text-sm font-semibold text-gray-700 block mb-2">Jumlah download</label>
                            <input type="text" readonly
                                value="{{ $downloadCount ?? (is_object($material) ? ($material->downloads ?? 0) : ($material['downloads'] ?? 0)) }}"
                                class="w-full px-3 py-2 border rounded text-center" />
                        </div>

                        <div class="mb-4">
                            @if($price > 0)
                            <form
                                action="{{ route('materials.purchase', is_object($material) ? $material->id : ($material['id'] ?? 0)) }}"
                                method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full py-3 rounded text-white font-semibold bg-green-600 hover:bg-green-700">Beli
                                    Sekarang</button>
                            </form>
                            @else
                            <a
                                href="{{ url('materials/download', is_object($material) ? $material->id : ($material['id'] ?? 0)) }}"
                                class="w-full inline-block text-center py-3 rounded text-white font-semibold bg-green-600 hover:bg-green-700">Unduh</a>

                            @endif
                        </div>

                        <div class="flex gap-4">
                            <button id="btn-like" class="btn-like">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 9l-1 4h6l-1 7-6-3v-8a2 2 0 01.4-1.2L14 9z" />
                                </svg>
                                Suka <span id="like-count" class="ml-2 text-sm text-gray-500">({{ $likes ?? 0 }})</span>
                            </button>

                            <button id="btn-dislike" class="btn-dislike">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 15l1-4H5l1-7 6 3v8a2 2 0 01-.4 1.2L10 15z" />
                                </svg>
                                Tidak Suka <span id="dislike-count" class="ml-2 text-sm text-gray-500">({{ $dislikes ??
                                    0 }})</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Full description --}}
    </div>
</div>
@endsection

@section("script")
<script>
    $(document).ready(function () {
  const likeUrl = "{{ url('materials/like', is_object($material) ? $material->id : ($material['id'] ?? 0)) }}";
  const dislikeUrl = "{{ url('materials/dislike', is_object($material) ? $material->id : ($material['id'] ?? 0)) }}";

  $('#btn-like').on('click', function (e) {
    e.preventDefault();
    $.post(likeUrl, {_token: '{{ csrf_token() }}'})
      .done(function(res){
        if(res && res.likes !== undefined) $('#like-count').text('(' + res.likes + ')');
      }).fail(function(){
        alert('Gagal memberikan suka.');
      });
  });

  $('#btn-dislike').on('click', function (e) {
    e.preventDefault();
    $.post(dislikeUrl, {_token: '{{ csrf_token() }}'})
      .done(function(res){
        if(res && res.dislikes !== undefined) $('#dislike-count').text('(' + res.dislikes + ')');
      }).fail(function(){
        alert('Gagal memberikan tidak suka.');
      });
  });
});
</script>
@endsection

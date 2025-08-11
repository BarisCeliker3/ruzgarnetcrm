@extends('admin.layout.main')

@section('title', 'İçerik Yükleme Servisi')

@section('content')
<div class="max-w-5xl mx-auto mt-10">
    <h2 class="text-3xl font-bold mb-8 text-indigo-600 text-center">UYGULAMA İÇERİKLERİ</h2>

    <!-- Yeni İçerik Ekleme Formu -->
    <div class="bg-white shadow-lg rounded-2xl mb-10">
        <div class="px-8 py-4 border-b border-gray-100 text-xl font-semibold text-indigo-600">
            Yeni İçerik Ekle
        </div>
        <div class="px-8 py-8">
            <form action="{{ route('admin.content_creator.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-7">
                    <label for="title" class="block text-lg font-medium text-gray-700 mb-2">Başlık</label>
                    <input type="text" name="title" class="w-full border border-gray-300 rounded-lg p-3 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-base" required maxlength="255" value="{{ old('title') }}">
                    @error('title')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-7">
                    <label for="content" class="block text-lg font-medium text-gray-700 mb-2">İçerik</label>
                    <textarea name="content" class="w-full border border-gray-300 rounded-lg p-3 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-base" rows="6" required>{{ old('content') }}</textarea>
                    @error('content')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-7">
                    <label for="category" class="block text-lg font-medium text-gray-700 mb-2">Kategori</label>
                    <select name="category" class="w-full border border-gray-300 rounded-lg p-3 focus:border-indigo-500 focus:ring focus:ring-indigo-200 text-base" required>
                        <option value="">Kategori Seçiniz</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-8">
                    <label for="image" class="block text-lg font-medium text-gray-700 mb-2">Resim (isteğe bağlı)</label>
                    <input type="file" name="image" class="w-full border border-gray-300 rounded-lg p-2 focus:border-indigo-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-indigo-50 file:text-indigo-700" accept="image/*">
                    @error('image')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-lg text-lg transition">Kaydet</button>
            </form>
        </div>
    </div>

 

    <div class="space-y-8">
    @foreach($contents as $content)
        <div class="bg-white shadow rounded-xl px-8 py-6 flex flex-col md:flex-row md:items-center gap-6">
            @if($content->image_url)
                <div class="flex-shrink-0">
                    <img src="{{ $content->image_url }}" alt="Resim" class="rounded-lg border shadow max-w-[200px]">
                </div>
            @endif
            <div class="flex-1">
                <h4 class="text-xl font-semibold text-indigo-800 mb-2">{{ $content->title }}</h4>
                <div class="mb-2"><span class="font-semibold text-gray-600">Kategori:</span> <span class="text-gray-800">{{ $content->category ?? '-' }}</span></div>
                <p class="text-gray-700">{{ $content->content }}</p>
                <div class="mt-5 flex gap-3">
                    <a href="{{ route('admin.content_creator.edit', $content->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-gray-900 font-semibold px-5 py-2 rounded-lg text-sm transition">Düzenle</a>
                    <form action="{{ route('admin.content_creator.destroy', $content->id) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 rounded-lg text-sm transition">Sil</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
    </div>
</div>
@endsection
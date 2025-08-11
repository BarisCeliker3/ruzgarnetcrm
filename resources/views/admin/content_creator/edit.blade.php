@extends('admin.layout.main')

@section('title', 'İçeriği Düzenle')

@section('content')
<div class="max-w-4xl mx-auto mt-12 bg-white rounded-2xl shadow-lg p-12">
    <h2 class="text-3xl font-bold mb-10 text-center text-indigo-700">İçeriği Düzenle</h2>
    @if ($errors->any())
        <div class="mb-8">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.content_creator.update', $content->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-7">
            <label for="title" class="block text-lg font-semibold text-gray-700 mb-2">Başlık</label>
            <input type="text" 
                   class="w-full rounded-lg border border-gray-300 p-3 text-lg focus:border-indigo-500 focus:ring focus:ring-indigo-200" 
                   id="title" 
                   name="title" 
                   value="{{ old('title', $content->title) }}" 
                   required>
        </div>

        <div class="mb-7">
            <label for="content" class="block text-lg font-semibold text-gray-700 mb-2">İçerik</label>
            <textarea 
                class="w-full rounded-lg border border-gray-300 p-3 text-base focus:border-indigo-500 focus:ring focus:ring-indigo-200" 
                id="content" 
                name="content" 
                rows="8" 
                required>{{ old('content', $content->content) }}</textarea>
        </div>

        <div class="mb-7">
            <label for="category" class="block text-lg font-semibold text-gray-700 mb-2">Kategori</label>
            <select 
                class="w-full rounded-lg border border-gray-300 p-3 text-base focus:border-indigo-500 focus:ring focus:ring-indigo-200" 
                id="category" 
                name="category" 
                required>
                @foreach ($categories as $cat)
                    <option value="{{ $cat }}" {{ (old('category', $content->category) == $cat) ? 'selected' : '' }}>
                        {{ $cat }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-7">
            <label class="block text-lg font-semibold text-gray-700 mb-2">Mevcut Resim</label>
            @if (!empty($content->image_url))
                <img src="{{ $content->image_url }}" alt="mevcut resim" class="rounded-xl shadow border max-w-2xl mb-2">
            @else
                <span class="text-gray-500">Resim yok</span>
            @endif
        </div>

        <div class="mb-10">
            <label for="image" class="block text-lg font-semibold text-gray-700 mb-2">Yeni Resim (isteğe bağlı)</label>
            <input 
                class="block w-full text-base text-gray-700 border border-gray-300 rounded-lg cursor-pointer focus:outline-none focus:border-indigo-500" 
                type="file" 
                id="image" 
                name="image" 
                accept="image/*">
            <span class="text-xs text-gray-500">Yüklemek isterseniz yeni bir resim seçebilirsiniz.</span>
        </div>

        <div class="flex gap-4">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-lg text-lg transition">Güncelle</button>
            <a href="{{ route('admin.content_creator.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-8 py-3 rounded-lg text-lg transition">Geri</a>
        </div>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 max-w-screen-lg">
    <h2 class="text-2xl font-bold mb-4">商品登録</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <!-- 商品名 -->
        <div>
            <label for="name" class="block font-semibold mb-1">商品名</label>
            <input type="text" name="name" id="name" placeholder="商品名を入力" class="w-full border rounded p-2">
            @error('name')
             <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 値段 -->
        <div>
            <label for="price" class="block font-semibold mb-1">値段</label>
            <input type="number" name="price" id="price" placeholder="値段を入力" class="w-full border rounded p-2">
            @error('price')
             <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 画像 -->
        @php
        
          $images = File::files(storage_path('app/public/fruits-img'));
        @endphp

        <div>
         <label class="block mb-2 font-semibold" for="image">商品画像</label>
         <input type="file" name="image" id="image" accept="image/*" class="w-full border rounded p-2" required onchange="previewImage(event)">
         @error('image')
             <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
         @enderror
         <div class="mt-2">
          <img id="image-preview" class="w-48 h-auto" style="display: none;">
         </div>
        </div>


        <!-- 季節 -->
        <div>
            <label class="block font-semibold mb-1">季節</label>
            <div class="flex flex-wrap gap-2">
                <label><input type="checkbox" id="season" name="season[]" value="春" class="mr-1">春</label>
                <label><input type="checkbox" id="season" name="season[]" value="夏" class="mr-1">夏</label>
                <label><input type="checkbox" id="season" name="season[]" value="秋" class="mr-1">秋</label>
                <label><input type="checkbox" id="season"name="season[]" value="冬" class="mr-1">冬</label>
            </div>
            @error('season')
             <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- 商品説明 -->
        <div>
            <label for="description" class="block font-semibold mb-1">商品説明</label>
            <textarea name="description" id="description" placeholder="商品の説明を入力" class="w-full border rounded p-2" rows="4"></textarea>
            @error('description')
             <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4 mt-6">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">登録</button>
            <a href="{{ route('products.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded">戻る</a>
        </div>
    </form>
</div>
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('image-preview');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection

@extends('layouts.app') 

@section('content')
<div class="container mx-auto p-4 max-w-screen-lg">
    <h2 class="text-2xl font-bold mb-6">商品編集</h2>


    {{-- 更新フォーム --}}
<form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- 左側：画像 --}}
        <div>
            <label class="block mb-2 font-semibold"></label>
            @if ($product->image)
                <img id="current-image" src="{{ asset('storage/' . $product->image) }}" alt="商品画像" class="w-full h-auto max-w-md mb-4" onclick="selectImage()">
            @else
                <p>画像なし</p>
            @endif

            {{-- 新しい画像アップロード --}}
            <label for="image" class="block font-semibold mb-2"></label>
            <input type="file" name="image" id="image" accept="image/*" class="w-full max-w-xs border rounded p-2" onchange="previewImage(event)">
            @error('image')
             <p class="text-red-500 text-sm mt-1">{{ ($message) }}</p>
            @enderror
            <div class="mt-2">
                <img id="image-preview" class="w-full max-w-md h-auto" style="display: none;">
            </div>
        </div>

        {{-- 右側：商品名、値段、季節 --}}
        <div class="space-y-4">
            {{-- 商品名 --}}
            <div>
                <label class="block mb-2 font-semibold" for="name">商品名</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="w-full border rounded p-2" >
                @error('name')
                 <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 値段 --}}
            <div>
                <label class="block mb-2 font-semibold" for="price">値段</label>
                <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" class="w-full border rounded p-2" >
                @error('price')
                 <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
 
            </div>

            {{-- 季節 --}}
            <div>
                <label class="block mb-2 font-semibold">季節</label>
                @php $seasons = ['春', '夏', '秋', '冬']; @endphp
                <div class="flex flex-wrap gap-4">
                    @foreach ($seasons as $season)
                        <label>
                            <input
                                type="checkbox"
                                name="season[]"
                                value="{{ $season }}"
                                class="mr-1"
                                {{ in_array($season, (array) old('season', $product->season)) ? 'checked' : '' }}
                            >
                            {{ $season }}
                        </label>
                     @endforeach               
                </div>
                @error('season')
                     <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
            </div>
        </div>
    </div>

    {{-- 商品説明：下に配置 --}}
    <div>
        <label class="block mb-2 font-semibold" for="description">商品説明</label>
        <textarea id="description" name="description" rows="4" class="w-full border rounded p-2">{{ old('description', $product->description) }}</textarea>
        @error('description')
         <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

    </div>

    {{-- ボタンたち --}}
    <div class="flex items-center justify-between mt-8">
        {{-- 戻るボタン --}}
        <a href="{{ route('products.index') }}" class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-6 rounded">
            戻る
        </a>

        {{-- 変更を保存ボタン --}}
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded">
            変更を保存
        </button>
    </form>

        {{-- 削除ボタン --}}
        <form action="{{ route('products.delete', $product->id) }}" method="POST" onsubmit="return confirm('本当に削除しますか？')">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 text-2xl ml-4">🗑️</button>
        </form>

    </div>

</div>
<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('image-preview');
    const currentImage = document.getElementById('current-image');

    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (currentImage) currentImage.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function selectImage() {
    // 画像がクリックされた場合、フォームの送信をトリガーする
    document.getElementById('image').click();
}
</script>
@endsection
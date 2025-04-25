@extends('layouts.app') 

@section('content')
<div class="container mx-auto p-4">

    {{-- 上部操作エリアと商品一覧を横並びに --}}
    <div class="flex gap-6">

        {{-- 左側：検索・並び替えエリア --}}
        <div class="w-full md:w-1/3 flex flex-col gap-4">
            <h2 class="text-xl font-bold">商品一覧</h2>

            {{-- 検索フォーム --}}
            <form action="{{ route('products.index') }}" method="GET" class="flex flex-col gap-2">
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="商品名で検索" class="border rounded p-2 w-full max-w-xs">
                <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 text-white font-semibold rounded-full px-4 py-2 transition w-full max-w-xs ">検索</button>
            </form>

            {{-- 並び替えセレクト --}}
            <form action="{{ route('products.index') }}" method="GET">
                <input type="hidden" name="keyword" value="{{ request('keyword') }}">
                <select name="sort" onchange="this.form.submit()" class="border rounded p-2 w-full max-w-xs">
                    <option value="">並び替え選択</option>
                    <option value="high" {{ request('sort') == 'high' ? 'selected' : '' }}>価格が高い順</option>
                    <option value="low" {{ request('sort') == 'low' ? 'selected' : '' }}>価格が安い順</option>
                </select>
            </form>

            {{-- 並び替え条件タグ --}}
            @if(request('sort'))
                <span class="border-2 border-yellow-400 text-yellow-600 rounded-full px-3 py-1 text-sm inline-flex items-center gap-2 w-fit max-w-xs">
                    {{ request('sort') === 'high' ? '価格が高い順' : '価格が安い順' }}
                    <a href="{{ route('products.index', ['keyword' => request('keyword')]) }}" class="text-red-500 text-sm">×</a>
                </span>
            @endif

            {{-- 商品追加ボタン（モバイル時はここに） --}}
            <a href="{{ route('products.create') }}" class="bg-orange-500 text-white rounded px-6 py-2 shadow hover:bg-orange-600 transition w-fit mt-4 md:hidden">
                +商品追加
            </a>
        </div>

        {{-- 右側：商品カード一覧 --}}
        <div class="w-full md:w-2/3 flex flex-col gap-4">
            {{-- 商品追加ボタン（PC表示） --}}
            <div class="flex justify-end mb-2 hidden md:block">
                <a href="{{ route('products.create') }}" class="bg-orange-500 text-white rounded px-6 py-2 shadow hover:bg-orange-600 transition">
                    +商品追加
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="border rounded-lg p-4 shadow hover:shadow-lg transition bg-white">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover mb-3 rounded">
                        <div class="flex justify-between items-center mb-1">
                         <h2 class="text-lg font-bold mb-1 text-gray-900">{{ $product->name }}</h2>
                         <p class="text-gray-700">{{ number_format($product->price) }}円</p>
                        </div> 
                    </a>
                @endforeach
            </div>
        </div>

    </div>
    <div class="pagination">
    {{-- 前のページリンク --}}
    @if ($currentPage > 1)
        <a href="{{ route('products.index', array_merge(request()->query(), ['page' => $currentPage - 1])) }}">前へ</a>
    @endif

    {{-- ページ番号リンク --}}
    @for ($i = 1; $i <= $totalPages; $i++)
        <a href="{{ route('products.index', array_merge(request()->query(), ['page' => $i])) }}" 
           class="{{ $i == $currentPage ? 'font-bold text-yellow-500' : '' }}">
            {{ $i }}
        </a>
    @endfor

    {{-- 次のページリンク --}}
    @if ($currentPage < $totalPages)
        <a href="{{ route('products.index', array_merge(request()->query(), ['page' => $currentPage + 1])) }}">次へ</a>
    @endif
</div>


</div>
@endsection

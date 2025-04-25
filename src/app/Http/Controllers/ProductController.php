<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    /**
     * 商品検索画面
     */
    public function search(Request $request)
    {
        $query = Product::query();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'high') {
                $query->orderBy('price', 'desc');
            } elseif ($request->sort === 'low') {
                $query->orderBy('price', 'asc');
            }
        }

       $currentPage = $request->input('page', 1); // 現在のページ番号を取得
       $perPage = 6; // 1ページに表示する商品数
       $skip = ($currentPage - 1) * $perPage; // どこからデータをスキップするか計算

      // 商品データを取得
       $products = $query->skip($skip)->take($perPage)->get();

      // 商品の総数を取得
       $total = $query->count();

      // ページネーションを計算
       $totalPages = ceil($total / $perPage); // 総ページ数

      // 商品ページを表示
       return view('products.index', [
        'products' => $products,
        'total' => $total,
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'sort' => $request->sort,
        'keyword' => $request->keyword,
       ]);
      }

    /**
     * 商品登録画面
     */
    public function create()
    {
        $images = File::files(storage_path('app/public/fruits-img'));
        return view('products.register',compact('images'));
    }

    /**
     * 商品登録保存
     */
    public function store(UpdateProductRequest $request)
    {
        $validated = $request->validated();

        // 画像アップロード
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('fruits-img', 'public');
        } else {
            $path = null;
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $path,
            'season' =>$request->season,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index')->with('success', '商品を登録しました！');
    }

    /**
     * 商品詳細画面（編集フォームも兼ねる）
     */
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        $images = File::files(storage_path('app/public/fruits-img'));
        return view('products.show', compact('product','images'));
    }

    /**
     * 商品更新
     */
    public function update(UpdateProductRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

       

        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('fruits-img', 'public');
            $product->image = $path;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $product->image,
            'season' => $request->season,
            'description' => $request->description,
            
        ]);

        return redirect()->route('products.index');
    }

    /**
     * 商品削除
     */
    public function delete($productId)
    {
        
        $product = Product::find($productId);

        // 画像も削除
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index');
    }
}

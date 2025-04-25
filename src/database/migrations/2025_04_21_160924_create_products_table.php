<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * 商品一覧画面
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

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

        $products = $query->get();

        return view('products.index', compact('products'))
            ->with('sort', $request->sort)
            ->with('keyword', $request->keyword);
    }

    /**
     * 商品登録画面
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * 商品登録保存
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|integer',
            'image' => 'required|image',
            'description' => 'required',
        ]);

        $path = $request->file('image')->store('products', 'public');

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'image' => $path,
            'description' => $request->description,
        ]);

        return redirect()->route('products.index');
    }

    /**
     * 商品詳細画面（編集フォームも兼ねる）
     */
    public function show($productId)
    {
        $product = Product::findOrFail($productId);
        return view('products.show', compact('product'));
    }

    /**
     * 商品更新
     */
    public function update(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|integer',
            'description' => 'required',
            'image' => 'nullable|image', // 画像は任意
        ]);

        if ($request->hasFile('image')) {
            // 古い画像を削除
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $path = $request->file('image')->store('products', 'public');
            $product->image = $path;
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $product->image, // 新しい画像またはそのまま
        ]);

        return redirect()->route('products.index');
    }

    /**
     * 商品削除
     */
    public function delete($productId)
    {
        $product = Product::findOrFail($productId);

        // 画像も削除
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index');
    }
}

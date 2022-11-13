<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
            DB::beginTransaction();
            $data['preview_image'] = Storage::disk('public')->put('/images/preview', $data['preview_image']);
            $data['main_image'] = Storage::disk('public')->put('/images/main', $data['main_image']);
            $product = Product::firstOrCreate($data);
            DB::commit();

        return redirect()->route('products.index');

    }

    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $data = $request->validated();

            if (isset($data['preview_image'])) {
                $data['preview_image'] = Storage::disk('public')->put('/images/preview', $data['preview_image']);
            }
            if (isset($data['main_image'])) {
                $data['main_image'] = Storage::disk('public')->put('/images/main', $data['main_image']);
            }
        $product->update($data);
        return view('products.show', compact('product'));

    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');
    }
}

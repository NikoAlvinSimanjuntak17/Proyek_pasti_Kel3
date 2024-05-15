<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;



class ProductController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('http://localhost:9091/api/products');
                $responseData = $response->json();
                $products = $responseData['data'];

                $response = Http::get('http://localhost:9092/api/categories');
                $responseCategories = $response->json();
                $categories = $responseCategories['data'];


                return view('admin.allproducts', compact('products'));
            } catch (\Exception $e) {
                // Handle the case when endpoints are not accessible
                Log::error('Failed to fetch data for dashboard: ' . $e->getMessage());
                return view('admin.allproducts')->with('categories', [])->with('products', []);
            }
    }

    public function create()
    {
        try {
            $response = Http::get('http://localhost:9092/api/categories');
            $categories = $response->json();

            return view('admin.addproduct', compact('categories'));
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            Log::error('Failed to fetch categories: ' . $e->getMessage());
            return view('admin.addproduct')->with('categories', []);
        }
    }
    public function store(Request $request)
    {
        try {
            $image = $request->file('image');
            $image_name = 'http://localhost:8000/images/products/' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/products'), $image_name);

            $response = Http::post('http://localhost:9091/api/products', [
                'name' => $request->input('name'),
                'price' => intval($request->input('price')),
                'quantity' => intval($request->input('quantity')),
                'description' => $request->input('description'),
                'image' => $image_name,
                'category_id' => intval($request->input('category_id')),
            ]);

            if ($response->successful()) {
                return redirect()->route('admin.products.index')->with('success', 'Product added successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to add product');
            }
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
        }
    }
public static function getCategoryName($categoryId)
{
    try {
        $response = Http::get('http://localhost:9092/api/categories/' . $categoryId);
        $category = $response->json();

        return $category['data']['name'];
    } catch (\Exception $e) {
        // Handle the case when endpoints are not accessible
        Log::error('Failed to fetch category: ' . $e->getMessage());
        return null;
    }
}



public function edit($id)
{
    try {
        $response = Http::get('http://localhost:9091/api/products/' . $id);
        $responseData = $response->json();
        $product = $responseData['data'];

        $response = Http::get('http://localhost:9092/api/categories');
        $categories = $response->json();

        return view('admin.editproduct', compact('product', 'categories'));
    } catch (\Exception $e) {
        // Handle the case when endpoints are not accessible
        Log::error('Failed to fetch product or categories: ' . $e->getMessage());
        return redirect()->route('admin.products.index')->with('error', 'Failed to fetch product or categories.');
    }
}

public function update(Request $request, $id)
{
    try {
        $image = $request->file('image');
        $image_name = 'http://localhost:8000/images/products/' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/products'), $image_name);

        $product_id = intval($request->category_id);

        $response = Http::put('http://localhost:9091/api/products/' . $id, [
            'ID' => $product_id,
            'name' => $request->input('name'),
            'price' => intval($request->input('price')),
            'quantity' => intval($request->input('quantity')),
            'description' => $request->input('description'),
            'image' => $image_name,
            'category_id' => intval($request->input('category_id')),
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update product');
        }
    } catch (\Exception $e) {
        // Handle the case when endpoints are not accessible
        return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
    }
}
public function editProductImage($id)
{
    $response = Http::get('http://localhost:9091/api/products/' . $id);
    $responseData = $response->json();
    $products = $responseData['data'];

    return view('admin.editproductimg', compact('products'));
}

    public function updateProductImage(Request $request)
    {
        $image = $request->file('image');
        $image_name = 'http://localhost:8000/images/products/' . time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images/products'), $image_name);

        $response = Http::put('http://localhost:9091/api/products/' . $request->input('id'), [
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'quantity' => $request->input('quantity'),
            'description' => $request->input('description'),
            'image' => $image_name,
            'category_id' => $request->input('category_id'),
        ]);

        if ($response->successful()) {
            return redirect()->route('admin.products.index')->with('success', 'Product image updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update product image');
        }
    }


    public function destroy($id)
    {
        try {
            $response = Http::delete('http://localhost:9091/api/products/' . $id);

            if ($response->successful()) {
                return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to delete product');
            }
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
        }
    }
}
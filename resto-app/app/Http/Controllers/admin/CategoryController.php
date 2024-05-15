<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class CategoryController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('http://localhost:9092/api/categories');
            if ($response->successful()) {
                $responseData = $response->json();
                $categories = $responseData['data']; // Access the 'data' array
                return view('admin.allcategory', compact('categories'));
            } else {
                Log::error('Failed to fetch categories: ' . $response->status());
                // Handle the error response
                return view('admin.allcategory')->with('categories', []);
            }
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            Log::error('Failed to fetch categories: ' . $e->getMessage());
            return view('admin.allcategory')->with('categories', []);
        }
    }


    public function create()
    {
        return view('admin.addcategory');
    }

    public function store(Request $request)
    {
        try {
            $response = Http::post('http://localhost:9092/api/categories', [
                'name' => $request->category_name,
            ]);

            if ($response->successful()) {
                return redirect()->route('admin.categories.index')->with('success', 'Category added successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to add category');
            }
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
        }
    }

    public function edit($id)
    {
        $response = Http::get('http://localhost:9092/api/categories/' . $id);
        $category = $response->json()['data'];


        return view('admin.editcategory', compact('category'));
    }
    public function update(Request $request, $id)
    {
        try {
            $category_id = intval($request->category_id);

            $response = Http::put('http://localhost:9092/api/categories/' . $id, [
                'name' => $request->category_name,
                'ID' => $category_id,
            ]);

            if ($response->successful()) {
                return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to update category');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }



    public function destroy($id)
    {
        try {
            $response = Http::delete('http://localhost:9092/api/categories/' . $id);

            if ($response->successful()) {
                return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to delete category');
            }
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
        }
    }
}

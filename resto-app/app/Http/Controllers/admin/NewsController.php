<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class NewsController extends Controller
{
    public function index()
    {
        try {
            $response = Http::get('http://localhost:9099/api/hot-news');
            if ($response->successful()) {
                $responseData = $response->json();
                $news = $responseData['data'];

                return view('admin.allnews', compact('news'));
            } else {
                Log::error('Failed to fetch galleries: ' . $response->status());
                // Handle the error response
                return view('admin.allnews')->with('news', []);
            }
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            Log::error('Failed to fetch categories: ' . $e->getMessage());
            return view('admin.allnews')->with('news', []);
        }
    }

public function create()
{
    return view('admin.addnews');
}

public function store(Request $request)
{
    // Validasi form jika diperlukan
    try {
    // Kirim data ke backend Golang
    $response = Http::post('http://localhost:9099/api/hot-news', [
        'title' => $request->input('title'),
        'content' => $request->input('content'),
        'author' => $request->input('author'),
        'published_at' => $request->input('published_at'),

    ]);

    // Redirect atau tampilkan pesan sesuai kebutuhan
    if ($response->successful()) {
        return redirect()->route('admin.news.index')->with('success', 'Product added successfully');
    } else {
        return redirect()->back()->with('error', 'Failed to add product');
    }
} catch (\Exception $e) {
    // Handle the case when endpoints are not accessible
    return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
    }
}
public function edit($id)
{
    $response = Http::get('http://localhost:9099/api/hot-news/' . $id);
    $news = $response['data'];


    return view('admin.editnews', compact('news'));
}

public function update(Request $request, $id)
{
    try {
        $id = intval($request->input('id'));
        $response = Http::put('http://localhost:9099/api/hot-news/' . $id, [
            'title' => $request->input('title'),
            'ID' => $id,
            'content' => $request->input('content'),
            'author' => $request->input('author'),
            'published_at' => $request->input('published_at'),
        ]);
        dd($response->json());

        if ($response->successful()) {
            return redirect()->route('admin.news.index')->with('success', 'Category updated successfully');
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
        $response = Http::delete('http://localhost:9099/api/hot-news/' . $id);

        if ($response->successful()) {
            return redirect()->route('admin.news.index')->with('success', 'Category deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete category');
        }
    } catch (\Exception $e) {
        // Handle the case when endpoints are not accessible
        return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
    }
}
}

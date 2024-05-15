<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class GalleryController extends Controller
{
    public function index()
    {
    try {
        $response = Http::get('http://localhost:9094/api/galleries');
        if ($response->successful()) {
        $responseData = $response->json();
        $galleries = $responseData->json()['data'];
        return view('admin.allgallery', compact('galleries'));
    }  else {
        Log::error('Failed to fetch galleries: ' . $response->status());
        // Handle the error response
        return view('admin.allgallery')->with('galleries', []);
    }
}
    catch (\Exception $e) {
        // Handle the case when endpoints are not accessible
        Log::error('Failed to fetch categories: ' . $e->getMessage());
        return view('admin.allgallery')->with('galleries', []);
    }
}

    public function create()
    {
        return view('admin.addgallery');
    }

    public function store(Request $request)
    {
        // Validasi form jika diperlukan
        try {
        // Upload gambar
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = 'http://localhost:8000/images/galleries/' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/galleries'), $image_name);
        } else {
            $image_name = null;
        }

        // Kirim data ke backend Golang
        $response = Http::post('http://localhost:9094/api/galleries', [
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $image_name, // URL gambar
        ]);

        // Redirect atau tampilkan pesan sesuai kebutuhan
        if ($response->successful()) {
            return redirect()->route('admin.gallery.index')->with('success', 'Product added successfully');
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
        $response = Http::get("http://localhost:9094/api/galleries/{$id}");
        $gallery = $response->json()['data'];
        return view('admin.editgallery', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        // Validasi form jika diperlukan
        try {
        // Ambil galeri yang akan diperbarui
        $response = Http::get("http://localhost:9094/api/galleries/{$id}");
        $gallery = $response->json()['data'];

        // Upload gambar baru jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = 'http://localhost:8000/images/galleries/' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/galleries'), $image_name);

            // Hapus gambar lama jika ada
            if ($gallery['image']) {
                // Hapus gambar lama dari direktori
                $old_image_path = public_path('images/galleries/') . basename($gallery['image']);
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }
            }
        } else {
            // Jika tidak ada gambar baru, gunakan gambar lama
            $image_name = $gallery['image'];
        }

        // Kirim data pembaruan ke backend Golang
        $response = Http::put("http://localhost:9094/api/galleries/{$id}", [
            'id' => intval($request->input('id')),
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'image' => $image_name, // URL gambar baru atau lama
        ]);
        if ($response->successful()) {
            return redirect()->route('admin.gallery.index');
        }else {
                return redirect()->back()->with('error', 'Failed to delete category');
            }
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
            }
        }



    public function destroy($id)
    {
        try {
        $response = Http::delete("http://localhost:9094/api/galleries/{$id}");
        if ($response->successful()) {
        return redirect()->route('admin.gallery.index');
    } else {
        return redirect()->back()->with('error', 'Failed to delete category');
    }
        } catch (\Exception $e) {
        // Handle the case when endpoints are not accessible
        return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
        }
    }
}
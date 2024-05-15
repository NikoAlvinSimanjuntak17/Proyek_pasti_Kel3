<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class ClientController extends Controller
{
    public function index()
    {
        try {
            $token = session()->get('token');
            $responseProfile = Http::withHeaders([
                'Authorization' =>  $token,
            ])->get('http://localhost:9090/api/user/profile');

            $responseDataProfile = $responseProfile->json();
            $user = $responseDataProfile['data'];

            $response = Http::get('http://localhost:9092/api/categories');
            $responseCategories = $response->json();
            $categories = $responseCategories['data'];

            $response = Http::get('http://localhost:9091/api/products');
            $responseProducts = $response->json();
            $products = $responseProducts['data'];

            $response = Http::get('http://localhost:9094/api/galleries');
            $responseGallery = $response->json();
            $galleries = $responseGallery['data'];

            $response = Http::get("http://localhost:9095/api/feedbacks");
            $responseFeedback = $response->json();
            $feedbacks = $responseFeedback['data'];


            return view('customer.dashboard', compact('feedbacks','galleries','categories', 'products', 'user'));
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            Log::error('Failed to fetch data for dashboard: ' . $e->getMessage());
            return view('customer.dashboard')->with('galleries', [])->with('feedbacks', [])->with('categories', [])->with('products', [])->with('user', []);
        }
    }
    public function Profile(){
        try {
            $token = session()->get('token');
            $responseProfile = Http::withHeaders([
                'Authorization' =>  $token,
            ])->get('http://localhost:9090/api/user/profile');

            $responseDataProfile = $responseProfile->json();
            $user = $responseDataProfile['data'];

            return view('customer.profile', compact('user'));
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            Log::error('Failed to fetch data for dashboard: ' . $e->getMessage());
            return view('customer.profile')->with('user', []);
        }


    }

    public function Product()
    {
        try {
            $token = session()->get('token');
            $responseProfile = Http::withHeaders([
                'Authorization' =>  $token,
            ])->get('http://localhost:9090/api/user/profile');

            $responseDataProfile = $responseProfile->json();
            $user = $responseDataProfile['data'];

            $response = Http::get('http://localhost:9092/api/categories');
            $responseCategories = $response->json();
            $categories = $responseCategories['data'];

            $response = Http::get('http://localhost:9091/api/products');
            $responseProduct = $response->json();
            $products = $responseProduct['data'];

            if ($response->successful()) {
                return view('customer.allproduct', compact('products', 'categories', 'user'));
            } else {
                Log::error('Failed to fetch products: ' . $response->status());
                return view('customer.allproduct')->with('products', [])->with('categories', [])->with('user', []);
            }
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            Log::error('Failed to fetch data for all products: ' . $e->getMessage());
            return view('customer.allproduct')->with('products', [])->with('categories', [])->with('user', []);
        }
    }

    public function addToCart(Request $request)
    {
        try {
            // Kirim data ke backend Golang
            $response = Http::post('http://localhost:9093/api/carts', [
                'product_id' =>  intval($request->input('product_id')),
                'product_name' =>  $request->product_name,
                'product_image' =>  $request->product_image,
                'quantity' =>  intval($request->input('quantity')),
                'price' =>  intval($request->input('price')),
                'total' =>  intval($request->input('total')),
                'user_id' =>  intval($request->input('user_id')), // Gunakan user_id dari pengguna yang sedang login
            ]);

            // Periksa apakah permintaan berhasil atau tidak
            if ($response->successful()) {
                // Tambahkan logika jika permintaan berhasil
                return redirect()->route('product')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
            } else {
                // Tambahkan logika jika permintaan gagal
                return redirect()->back()->with('error', 'Gagal menambahkan produk ke keranjang.');
            }
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
        }
    }

    public function showCart()
    {
        try {
            $token = session()->get('token');
            $responseProfile = Http::withHeaders([
                'Authorization' =>  $token,
            ])->get('http://localhost:9090/api/user/profile');

            $responseDataProfile = $responseProfile->json();
            $user = $responseDataProfile['data'];

            $response = Http::get('http://localhost:9093/api/carts?user_id=' . $user['id']);
            $responseCart = $response->json();
            $cart_items = $responseCart['data'];

            $totalPrice = 0;
            foreach ($cart_items as $item) {
                $totalPrice += $item['Total'];
            }

            // Mengirim data keranjang ke halaman keranjang
            return view('customer.addtocart', compact('cart_items', 'totalPrice','user'));
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            Log::error('Failed to fetch data for cart: ' . $e->getMessage());
            return view('customer.addtocart')->with('cart_items', [])->with('totalPrice', 0);
        }
    }
    public function destroyCart($id)
    {
        try {
            $response = Http::delete('http://localhost:9093/api/carts/' . $id);

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Product deleted successfully');
            } else {
                return redirect()->back()->with('error', 'Failed to delete product');
            }
        } catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
        }
    }
    public function feedbackShow()
    {
        try {
            $token = session()->get('token');
            $responseProfile = Http::withHeaders([
                'Authorization' =>  $token,
            ])->get('http://localhost:9090/api/user/profile');

            $responseDataProfile = $responseProfile->json();
            $user = $responseDataProfile['data'];

            $response = Http::get("http://localhost:9095/api/feedbacks");
            $responseFeedback = $response->json();
            $feedback = $responseFeedback['data'];

            return view('customer.feedback', compact('feedback','user'));
        } catch (\Exception $e) {
            Log::error('Failed to fetch feedback details: ' . $e->getMessage());
            return view('customer.feedback')->with('user', [])->with('feedback', []);
        }
    }
    public function feedbackStore(Request $request)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|integer',
                'content' => 'required|string|max:255',
            ]);
            $data['user_id'] = intval($data['user_id']);
            $response = Http::post('http://localhost:9095/api/feedbacks', $data);

            if ($response->successful()) {
                return redirect()->route('feedbackshow')->with('success', 'Feedback created successfully.');
            } else {
                return redirect()->back()->with('error', 'Failed to create feedback.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to connect to the server. Please try again later.');
        }
    }


}

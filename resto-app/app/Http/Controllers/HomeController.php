<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;



class HomeController extends Controller
{

    public function index(){
        try {
            $token = session()->get('token');
            $responseProfile = Http::withHeaders([
                'Authorization' =>  $token,
            ])->get('http://localhost:9090/api/user/profile');

            $responseDataProfile = $responseProfile->json();
            $user = $responseDataProfile['data'];

        $response = Http::get('http://localhost:9092/api/categories');
        $responseData = $response->json();
        $categories = $responseData['data'];

        $response = Http::get('http://localhost:9091/api/products');
        $responseData = $response->json();
        $products = $responseData['data'];

        return view('welcome',compact('categories','products'));
        }
        catch (\Exception $e) {
            // Handle the case when endpoints are not accessible
            Log::error('Failed to fetch data for dashboard: ' . $e->getMessage());
            return view('welcome')->with('categories', [])->with('products', [])->with('user', []);
        }
    }
}
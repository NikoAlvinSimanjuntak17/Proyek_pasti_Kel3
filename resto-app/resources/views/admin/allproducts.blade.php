@extends('admin.layouts.template')
@section('title','Admin | addcategory')
@section('content')
<div class="container-fluid p-5">
    <h4 class="fw-bold py-3 mb-4"><span class="text fw-light">Pages / </span> All Product</h4>
    <div class="card">
        @if (session()->has('message'))
        <div class="alert alert-success">
            {{session()->get('message')}}
        </div>
        @endif
        <div class="table-responsive text-nowrap container pb-4">
            <h5 class="card-header">All Product Information</h5>
          <table class="table" id="dtbl">
            <thead class="table-light">
              <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Gambar</th>
                <th>Jenis Kategori</th>
                <th>Stok</th>
                <th>Deskripsi</th>
                <th>Price</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($products as $product)
              <tr>
                    <td>{{ $product['ID'] }}</td>
                    <td>{{$product['name']}}</td>
                    <td>
                            <img src="{{ $product['image'] }}" style="height:100px; width:200px;" alt="">
                            <br>

                        </div>

                    </td>


                    <td>{{ \App\Http\Controllers\Admin\ProductController::getCategoryName($product['category_id']) }}</td>
                    @if ($product['quantity'] === 0)
                    <td><p class="text-danger">Stok Habis</p></td>
                    @else
                    <td>{{$product['quantity']}}</td>
                    @endif
                    <td>{{$product['description']}}</td>
                    <td>{{$product['price']}}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', $product['ID']) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('admin.products.destroy', $product['ID']) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                        </form>                </td>
            </tr>
            @endforeach
        </tbody>
          </table>
        </div>
    </div>
    {{-- {{$products->links()}} --}}
</div>

@endsection

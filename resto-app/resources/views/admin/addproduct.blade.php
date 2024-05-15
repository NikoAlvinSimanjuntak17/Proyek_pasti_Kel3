@extends('admin.layouts.template')
@section('title','Admin | addcategory')
@section('content')
<style>

    </style>

<div class="container p-5">
    <h4 class="fw-bold py-3 mb-4"><span class="text fw-light">Pages / </span> Add Produk</h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Tambah Produk Baru</h5>
        <small class="text-muted float-end">informasi input</small>
      </div>
      <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="">
        @csrf
      <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Produk</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="product_name" name="name" placeholder="Nama Produk"/>
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Harga Produk</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="price" name="price" placeholder="Harga" name="price"/>
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Stok Produk</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="quantity"/>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Deskripsi Produk</label>
        <div class="col-sm-10">
            <textarea class="form-control" name="description" id="product_deskripsi" placeholder="deskripsi" cols="30" rows="10"></textarea>
        </div>
      </div>


      <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Pilih Categori</label>
        <div class="col-sm-10">
            <select class="form-select" id="product_category_id" name="category_id" aria-label="Default select example">
                <option value="">Select Category</option>
            @foreach ($categories['data'] as $category)
                <option value="{{ $category['ID'] }}">{{ $category['name'] }}</option>
            @endforeach
              </select>
        </div>
      </div>



      <div class="row mb-3">
        <label class="col-sm-2 col-form-label" for="basic-default-name">Kirim Gambar</label>
        <div class="col-sm-10">
            <input type="file" id="product_img" class="form-control" name="image">
        </div>
      </div>

      <div class="row justify-content-end">
        <div class="col-sm-10">
          <button type="submit" class="btn btn-primary">Add product</button>
        </div>
      </div>
    </form>

      </div>
    </div>
  </div>
</div>

@endsection

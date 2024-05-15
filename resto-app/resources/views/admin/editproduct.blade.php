@extends('admin.layouts.template')
@section('title', 'Admin | Edit Product')
@section('content')
    <div class="container p-5">
        <h4 class="fw-bold py-3 mb-4"><span class="text fw-light">Pages / </span>Edit Product</h4>
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Product</h5>
                    <small class="text-muted float-end">Input Information</small>
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
                    <form action="{{ route('updateproduct', $product['ID']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Product Name</label>
                            <div class="col-sm-10">
                                <input type="hidden" name="id" value="{{ $product['ID'] }}">

                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $product['name'] }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Price</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="price" name="price"
                                    value="{{ $product['price'] }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Quantity</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="quantity" name="quantity"
                                    value="{{ $product['quantity'] }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Description</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="description" name="description"
                                    rows="3">{{ $product['description'] }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Category</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="category_id" name="category_id">
                                    @foreach ($categories['data'] as $category)
                                    <option value="{{ $category['ID'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Current Image</label>
                            <div class="col-sm-10">
                                <img src="{{ $product['image'] }}" style="height:100px; width:200px;" alt="">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Upload New Image</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" id="image" name="image">
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

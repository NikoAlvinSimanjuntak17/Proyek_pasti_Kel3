@extends('admin.layouts.template')
@section('title','Admin | Edit Category')
@section('content')
<div class="container p-5">
    <h4 class="fw-bold py-3 mb-4"><span class="text fw-light">Pages / </span> Edit Category</h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit Kategori</h5>
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

        <form action="{{ route('admin.categories.update',  $category['ID']) }}" method="POST">
            @csrf
            @method('PUT') <!-- Tambahkan method PUT untuk update -->
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Nama Category</label>
                <div class="col-sm-10">
                <input type="hidden" value="{{ $category['ID']  }}" name="category_id">
                <input type="text" class="form-control" id="basic-default-name" value="{{ $category['name']  }}" name="category_name"/>
            </div>
          </div>

          <div class="row justify-content-end">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

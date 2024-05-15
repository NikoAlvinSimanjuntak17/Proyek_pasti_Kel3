@extends('admin.layouts.template')
@section('title','Admin | Edit Category')
@section('content')
<div class="container p-5">
    <h4 class="fw-bold py-3 mb-4"><span class="text fw-light">Pages / </span> Edit Category</h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Edit News</h5>
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

        <form action="{{ route('admin.news.update',  $news['ID']) }}" method="POST">
            @csrf
            @method('PUT') <!-- Tambahkan method PUT untuk update -->
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-default-name">Judul</label>
                <div class="col-sm-10">
                <input type="hidden" value="{{ $news['ID']  }}" name="id">
                <input type="hidden" class="form-control" id="basic-default-name" name="author" value="Pizza Andaliman"/>
                <input type="hidden" class="form-control" id="published" name="published_at" value=""/>
                <input type="text" class="form-control" id="basic-default-name" value="{{ $news['title']  }}" name="title"/>
            </div><br><br>
            <label class="col-sm-2 col-form -label" for="basic-default-name">Isi</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control" id="basic-default-name" name="content">{{ $news['content']}}</textarea>
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

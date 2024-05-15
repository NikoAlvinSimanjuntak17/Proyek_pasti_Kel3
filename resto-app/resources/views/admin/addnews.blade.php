@extends('admin.layouts.template')
@section('title','Admin | addcategory')
@section('content')
<div class="container p-5">
    <h4 class="fw-bold py-3 mb-4"><span class="text fw-light">Pages / </span> Add Categori</h4>
    <div class="col-xxl">
        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
        <h5 class="mb-0">Tambah News Baru</h5>
        <small class="text-muted float-end">informasi input</small>
      </div>
      <div class="card-body">
        @if ($errors->any())
    <div id="alert" class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<!--Template pada framework Laravel yang digunakan untuk menampilkan pesan error validasi pada form
Kode tersebut akan mengecek apakah ada pesan error yang tersedia di dalam $errors, jika iya maka pesan error tersebut akan ditampilkan dalam bentuk daftar menggunakan tag <ul> dan <li>.-->

        <form action="{{ route('admin.news.store') }}" method="POST">
            @csrf
          <div class="row mb-3">
            <label class="col-sm-2 col-form -label" for="basic-default-name">Judul</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="basic-default-name" placeholder="Judul" name="title"/>
                <input type="hidden" class="form-control" id="basic-default-name" name="author" value="Pizza Andaliman"/>
                <input type="hidden" class="form-control" id="published" name="published_at" value=""/>
            </div><br><br>
            <label class="col-sm-2 col-form -label" for="basic-default-name">Isi</label>
            <div class="col-sm-10">
                <textarea type="text" class="form-control" id="basic-default-name" placeholder="Berikan news terbaru.." name="content"></textarea>
            </div>
          </div>

          <div class="row justify-content-end">
            <div class="col-sm-10">
              <button type="submit" class="btn btn-primary">Send</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
    // Mendapatkan tanggal dan waktu saat ini
    var now = new Date();

    // Format tanggal dan waktu sesuai yang diinginkan (YYYY-MM-DDTHH:MM:SSZ)
    var formattedDate = now.toISOString();

    // Menetapkan nilai ke input
    document.getElementById('published').value = formattedDate;
  </script>

@endsection

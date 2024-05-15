@extends('admin.layouts.template')
@section('title','Admin | addcategory')
@section('content')
<div class="container-fluid p-5">
    <h4 class="fw-bold py-3 mb-4"><span class="text fw-light">Pages / </span> All Gallery</h4>
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
                <th>Judul Gallery</th>
                <th>Gambar</th>
                <th>Deskripsi</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody class="table-border-bottom-0">
                @foreach ($galleries as $gallery)
              <tr>
                    <td>{{ $gallery['id'] }}</td>
                    <td>{{$gallery['title']}}</td>
                    <td>
                            <img src="{{ $gallery['image'] }}" style="height:100px; width:200px;" alt="">
                            <br>
                    </td>


                    <td>{{$gallery['description']}}</td>
                    <td>
                        <a href="{{ route('admin.gallery.edit', $gallery['id']) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('admin.gallery.destroy', $gallery['id']) }}" method="POST">
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

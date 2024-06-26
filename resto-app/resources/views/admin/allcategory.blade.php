@extends('admin.layouts.template')
@section('title', 'Admin | All Categories')
@push('css')
    <link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet" />
@endpush
@push('js')
    <script src="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dtbl').DataTable();
        });
    </script>
@endpush
@section('content')
    <div class="container-fluid p-5">
        <h4 class="fw-bold py-3 mb-4"><span class="text fw-light">Pages / </span> All Categories</h4>
        <div class="card">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif

            <div class="table-responsive container text-nowrap">
                <h5 class="card-header">All Categories</h5>
                <table class="table" id="dtbl">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category['ID'] }}</td>
                                <td>{{ $category['name'] }}</td>
                                <td>
                                    <div class="d-flex">
                                    <a href="{{ route('admin.categories.edit', $category['ID']) }}" class="btn btn-primary">Edit</a>
                                    <form action="{{ route('admin.categories.destroy', $category['ID']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

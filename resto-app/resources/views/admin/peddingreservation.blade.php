@extends('admin.layouts.template')
@section('title','Admin | peddingreservation')
@push('css')
    <link href="{{asset('css/tables.css')}}" rel="stylesheet" />
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
    <h4 class="fw-bold py-3 mb-4"><span class="text fw-light">Pages / </span> Pedding Reservation</h4>
    <div class="card mb-5">
        <div class="table-responsive text-nowrap container pb-4">
            <h5 class="card-header">All Reservation Information</h5>
        <table class="table" >
            <tr>
    <th>User Id</th>
    <th>Nama</th>
    <th>Status</th>
    <th>ReservationDate</th>
    <th>Action</th>
            </tr>
    @foreach ($pending_reservations as $reservation)
    <tr>
        <td>{{$reservation->user_id}}</td>
        <td>{{$reservation->name}}</td>
        <td>{{$reservation->status}}</td>
        <td>{{($reservation->date)}}</td>
        <td><a href="{{route('pendingreservationdetail',$reservation->id)}}" class="btn btn-primary">view</a></td>
    </tr>
    @endforeach
        </table>
 </div>
    </div>

     <div class="card">
        <div class="table-responsive text-nowrap container pb-4">
            <h5 class="card-header">History Reservation</h5>
        <table class="table" >
            <tr>
    <th>User Id</th>
    <th>Nama</th>
    <th>Status</th>
    <th>ReservationDate</th>
    <th>Action</th>
            </tr>
    @foreach ($pending_selesai as $reservation)
    <tr>
        <td>{{$reservation->user_id}}</td>
        <td>{{$reservation->name}}</td>
        <td>{{$reservation->status}}</td>
        <td>{{($reservation->date)}}</td>
        <td><a href="{{route('pendingreservationdetail',$reservation->id)}}" class="btn btn-primary">view</a></td>
    </tr>
    @endforeach
        </table>
 </div>
    </div>
    </div>
@endsection

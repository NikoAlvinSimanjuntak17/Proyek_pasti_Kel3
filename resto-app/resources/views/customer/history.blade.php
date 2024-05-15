@extends('users.layouts.userprofile')

@section('profilecontent')
<style>
        .dropdown-menu {
    display: none !important; /* Hide the dropdown menu by default */
    background-color: rgba(0, 0, 0, 0.8); /* Black with 80% opacity */
}

.navbar .dropdown:hover .dropdown-menu {
    display: block !important; /* Show the dropdown menu when the dropdown toggle is hovered */

}
.navbar .dropdown .dropdown-menu a:hover{
    color: black;
}
    </style>
<br><br>
    <h3>Riwayat Pemesanan</h3>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{session()->get('message')}}
        </div>
    @endif
    <a href="{{ route('userprofile') }}" class="">< Kembali</a> <br><br>


    <div class="table-responsive">
    <table class="table " style="color: white;">
        <thead class="thead-dark">
        <tr>
            <th>Id Pemesanan</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>status</th>
            <th>Tanggal Pemesanan</th>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($completed_orders as $order)
        <tr style="color: white;">
            <td>{{$order->id}}</td>
                <td>@foreach (json_decode($order->product_nama) as $item)
                    <p>{{$item}}</p>
                @endforeach</td>
                <td>@foreach (json_decode($order->quantity) as $item)
                    <p>{{$item}}</p>
                @endforeach</td>
                <td>{{$order->status}}</td>
                <td>{{ \Carbon\Carbon::parse($order->updated_at)->format('d M Y')}}</td>
                <td><a href="{{route('historidetil',$order->id)}}" class="btn btn-info">Detil</button></td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>

    <br><br><br><br>
    <hr>

@endsection

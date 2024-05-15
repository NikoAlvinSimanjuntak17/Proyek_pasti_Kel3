@extends('users.layouts.userprofile')


@section('profilecontent')
<style>
    .dropdown-menu {
        display: none !important; /* Hide the dropdown menu by default */
        background-color: rgba(0, 0, 0, 0.8); /* Black with 80% opacity */
    }

    .navbar .dropdown:hover .dropdown-menu {
        display: block !important;
    }
    .dropdown-menu:hover a:hover{
        color: black !important;
    }

    </style>

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
     <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
     <script type="text/javascript"
     src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{config('services.midtrans.client_key')}}"></script>
    <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->

    <!------ Include the above in your HEAD tag ---------->
<br>
    <h3>Pemesanan</h3>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{session()->get('message')}}
        </div>
    @endif
    <div class="table-responsive">

    <table class="table" style="color: white;">
        <tr>
            <th>Id Order</th>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>status</th>
            <th>Tanggal Pemesanan</th>
            <th></th>
            <th></th>
            <th></th>
        </tr>
        @foreach ($pending_orders as $order)
            <tr>
                <td>{{$order->id}}</td>
                <td>@foreach (json_decode($order->product_nama) as $item)
                    <p>{{$item}}</p>
                @endforeach</td>
                <td>@foreach (json_decode($order->quantity) as $item)
                    <p>{{$item}}</p>
                @endforeach</td>
                <td>{{$order->status}}</td>
                <td>{{ \Carbon\Carbon::parse($order->date)->format('d M Y')}}</td>
                <td><a href="{{route('peddingordersdetil',$order->id)}}" class="btn btn-info">Detail</button></td>
                <td><a href="{{route('orderdelete',$order->id)}}" class="btn btn-danger">batal</a></td>
                <td>  <button style="background-color:white;" class="pay-button" data-snap-token="{{ $order->snap_token }}">Bayar</button></td>
            </tr>
        @endforeach
    </table>
    </div>
    <br><br><br><br>
      <hr>



      <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function(event) {
       var payButtons = document.querySelectorAll('.pay-button');
       payButtons.forEach(function(button) {
           button.addEventListener('click', function (event) {
               event.preventDefault(); // Mencegah aksi default button

               var snapToken = this.getAttribute('data-snap-token');
               snap.pay(snapToken, {
                   onSuccess: function (result) {
                        alert("Pembayaran berhasil!");
                        console.log(result);
                        updateOrderStatus(result.transaction_status);
                    },

                   onPending: function (result) {
                       alert("Menunggu pembayaran Anda!");
                       console.log(result);
                   },
                   onError: function (result) {
                       alert("Pembayaran gagal!");
                       console.log(result);
                   },
                   onClose: function () {
                       alert('Anda menutup popup tanpa menyelesaikan pembayaran');
                   }
               });
           });
       });
       function updateOrderStatus(transactionStatus) {
            $.ajax({
                url: "{{ route('updateOrderStatus') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    transaction_status: transactionStatus
                },
                success: function (response) {
                    console.log(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        }
   });

         </script>
@endsection



@extends('users.layouts.userprofile')
@section('css')
<style>
    .detail{
        color: black;
    }
    </style>
@endsection
@section('profilecontent')
<div class="p-2">
    <div class="card bg-dark text-white p-2">
        <div class="container text-center">
            <h4>Detail Pengiriman</h4>
            <div class="detail row">
                <div class="col-md-6 text-start">
                    <hr>
                    <p>Tanggal Pemesanan: {{ \Carbon\Carbon::parse($pedding->created_at)->format('d M Y ')}}</p>
                    <h5 style="border: 1px solid black;color:chartreuse" class="p-2">Status Pemesanan: {{$pedding->status}}</h5>
                </div>
                <div class="col-md-6 text-start">
                    <hr>
                    <p>Nama: {{$pedding->nama}}</p>
                    <p>Nomor Telepon: {{$pedding->shipping_phonenumber}}</p>
                    <p>Alamat: {{$pedding->address}}</p>
                    <p>Kota: {{$pedding->shipping_city}}</p>
                    <p>Kode Pos: {{$pedding->shipping_postalcode}}</p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="table-responsive container-fluid">
        <center><h4>Detail Pesanan</h4></center><br>
        <table class="table" style="color: white;">
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
            {{-- @foreach ($pedding as $pedding) --}}
            <tr>

                <td>
                    @foreach (json_decode($pedding->product_nama) as $item)
                        <p>{{$item}}</p>
                    @endforeach
                </td>

                <td>
                    @foreach (json_decode($pedding->quantity) as $item)
                        <p>{{$item}}</p>
                    @endforeach
                </td>
                <td>
                    @foreach (json_decode($pedding->totalprice) as $item)
                        <p>{{'Rp '.number_format($item,0,',','.')}}</p>
                    @endforeach
                </td>
                <td>
                    @php
                        $quantities = json_decode($pedding->quantity);
                        $totalprices = json_decode($pedding->totalprice);
                    @endphp
                    @foreach ($quantities as $key => $item)
                        @php
                            $subtotal = $item * $totalprices[$key];
                        @endphp
                        <p>{{'Rp '.number_format($subtotal,0,',', '.') }}</p>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="fw-bold">Total Harga</td>
                <td colspan="4">
                    @php
                        $quantities = json_decode($pedding->quantity);
                        $totalprices = json_decode($pedding->totalprice);
                        $total = 0;
                    @endphp

                    @foreach ($quantities as $key => $quantity)
                        @php
                            $subtotal = $quantity * $totalprices[$key];
                            $total += $subtotal;
                        @endphp
                    @endforeach

                    <p>{{ 'Rp ' . number_format($total, 0, ',', '.') }}</p>
                </td>
            </tr>

            {{-- @endforeach --}}
        </table>
    </div>

        <br><br><br>
        <div>
            <h4>Berikan Bukti Pembayaran</h4>
            @if (session()->has('message'))
                <div id="alert" class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @elseif (session()->has('error'))
                <div id="alert" class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
            <hr>
            <div class="row">
                <div class="col-md-6 mb-3">
                    @if (empty($pedding->img_bayar))
                        <label for="formFileSm" class="form-label">Kirim Gambar</label>
                        <form action="{{ route('uploadPaymentProof', ['id' => $pedding->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input class="form-control form-control-sm" name="img_bayar" id="formFileSm" type="file">
                            @error('img_bayar')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                            <input type="submit" class="btn btn-success mt-2" value="Kirim Bukti Pembayaran">
                        </form>



                    @elseif($pedding->status === "pending")
                    <div class="col-md-15 mb-3">
                        <img src="{{asset($pedding->img_bayar)}}" style="max-width: 100%; height: auto;" alt="">
                    </div>                        <br><br>
                        <a href="{{ route('deletePayment', $pedding->id) }}" class="btn btn-danger float-end">Delete pembayaran</a>
                    @else
                    <div class="col-md-15 mb-3">
                        <img src="{{asset($pedding->img_bayar)}}" style="max-width: 100%; height: auto;" alt="">
                    </div>                        <br><br>
                        <form method="POST" action="{{ route('orderDelivered', $pedding->id) }}">
                            @csrf
                            <button type="submit" class="btn btn-success">Pesanan sampai</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <a href="{{route('peddingorders')}}" class="btn btn-danger float-end mt-3 mb-3">Kembali</a>
</div>
@endsection

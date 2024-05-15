@extends('users.layouts.userprofile')

@section('profilecontent')
    <br><br>
    <h3>Reservasi Meja Resto</h3>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session()->get('message') }}
        </div>
    @endif
    <a href="{{ route('userprofile') }}" class="">< Kembali</a> <br><br><br>

    @if($all_reservations->isEmpty())
        <center><p style="font-size: 30px; color: white;">Belum ada reservasi yang dilakukan.</p></center>
    @else
        <div class="row">
            @foreach ($all_reservations as $reservation)
                <div class="col-md-4 mb-4">
                    <div class="card bg-dark text-white">
                        <div class="card-body">
                            <h4 class="card-title" style="font-weight: bolder;"> {{ $reservation->name }}</h4>
                            <p class="card-text"><strong>Tanggal:</strong> {{ $reservation->date }}</p>
                            <p class="card-text"><strong>Waktu:</strong> {{ substr($reservation->time, 0, 5) }}</p>
                            <p class="card-text"><strong>Jumlah Orang:</strong> {{ $reservation->people }}</p>
                            <p class="card-text"><strong>Pesan:</strong> {{ $reservation->message }}</p>
                            <p class="card-text"><strong>Status:</strong>
                                @if($reservation->status == 'success')
                                    <span class="badge badge-success">Success</span>
                                @elseif($reservation->status == 'pending')
                                    <span class="badge badge-danger">Pending</span>
                                @else
                                    <span class="badge badge-secondary">{{ $reservation->status }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="card-header" style="position: absolute; top: 0; right: 0; background: none; border: none;">
                            <div class="btn-group" role="group">
                                <a href="{{ route('editreservation', $reservation->id) }}" class="btn btn-primary btn-sm" style="background: none; border: none; margin-right: -10px;"><i class="fas fa-pencil-alt"></i></a>
                                <form action="{{ route('deletereservation', $reservation->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="background: none; border: none; margin-left: -20px;" onclick="return confirm('Apakah Anda yakin ingin menghapus reservasi ini?')"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <br><br><br><br>
    <hr>
@endsection

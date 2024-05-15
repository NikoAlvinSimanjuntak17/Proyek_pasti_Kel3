
    @extends('customer.layouts.userprofile')

    @section('profilecontent')
        <br><br>
        <h3>Feedback Tentang Resto</h3>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session()->get('message') }}
            </div>
        @endif
        <a href="{{ route('profile') }}" class="">< Kembali</a> <br><br>

            @foreach ($feedback as $item)
                <div class="card mb-3">
                    <div class="card-body" style="color: black;">
                        <h3 class="card-title" style="font-weight: bold; font-size:22px;">Feedback Terhadap Resto</h3>
                        <div class="card-text" id="content" contenteditable="true">{{ $item['content'] }}</div>
                        <p class="card-text"><small class="text-muted">{{ \Carbon\Carbon::parse($item['CreatedAt'])->format('d M Y, H:i') }}</small></p>

                    </div>
                </div>
            @endforeach

    <br><br><br><br>
    <hr>
@endsection

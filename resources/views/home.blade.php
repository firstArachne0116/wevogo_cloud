@extends('layout.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    {!! public_path('qrcode') !!}
                    {!! QrCode::size(300)->format('png')->generate('Make me into a QrCode!', public_path('qrcode/qrcode.png')); !!}
                    <p>Scan me to return to the original page.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

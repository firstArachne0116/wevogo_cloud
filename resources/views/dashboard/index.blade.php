@extends('layout.admin')

@section('custom-styles')
@endsection

@section('content')
    {{ var_dump(config('services.wevopbx_url')) }}
@stop

@section('custom-scripts')
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(function() {
            $('a.test-btn').click(function(e) {
                e.preventDefault();
                var jqxhr = $.post($(this).attr('href'), { '_token': CSRF_TOKEN }, function() {
                    alert( "success" );
                })
            })
        })
    </script>
@endsection
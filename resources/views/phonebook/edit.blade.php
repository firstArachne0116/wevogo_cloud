@extends('layout.admin')

@section('custom-styles')
    {!! Html::style('backend/js/plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css?'.time()) !!}
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Wevogo Servers</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{URL::route('dashboard.index')}}">Home</a>
                </li>
                <li class="active">
                    <a href="#">Wevogo Server</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Edit Wevo Server</h5>
            </div>
            <div class="ibox-content">
                @include('partial/alert_message')
                {{ Form::open(array('url' => route('wevo-servers.update', $wevoServer), 'method' => 'PUT')) }}
                <div class="row m-b">
                    <div class="col-md-6">
                        <div class="form-group {!! $errors->first('date_time', 'has-error') !!}">
                            {!! Form::label('Date Time') !!}
                            <div class='input-group date' id='date_time_wrap'>
                                {!! Form::text('date_time', $wevoServer->date_time, array('class'=>'form-control', 'id'=>'date_time')) !!}
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>

                            @if ($errors->has('date_time'))
                                <span class="help-block">
                                        <strong>{!! $errors->first('date_time', ':message') !!}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row m-b">
                    <div class="col-md-6">
                        <div class="form-group {!! $errors->first('sn', 'has-error') !!}">
                            {!! Form::label('SN') !!}
                            {!! Form::text('sn', $wevoServer->sn, array('class'=>'form-control')) !!}
                            @if ($errors->has('sn'))
                                <span class="help-block">
                                        <strong>{!! $errors->first('sn', ':message') !!}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group {!! $errors->first('mac_address', 'has-error') !!}">
                            {!! Form::label('MAC Address') !!}
                            {!! Form::text('mac_address', $wevoServer->mac_address, array('class'=>'form-control')) !!}
                            @if ($errors->has('mac_address'))
                                <span class="help-block">
                                        <strong>{!! $errors->first('mac_address', ':message') !!}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary m-t-md">Submit</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@stop

@section('custom-scripts')
    {!! Html::script('backend/js/plugins/fullcalendar/moment.min.js') !!}
    {!! Html::script('backend/js/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') !!}
    <script type="text/javascript">
        $(function () {
            $('div#date_time_wrap').datetimepicker({
                format: 'YYYY-MM-DD H:m:s'
            });
        });
    </script>
@endsection
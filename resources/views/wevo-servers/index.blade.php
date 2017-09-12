@extends('layout.admin')

@section('custom-styles')
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
        @include('partial/alert_message')
        <a href="{{ route('wevo-servers.create') }}" class="btn btn-primary pull-right m-b-sm">
            <i class="fa fa-plus"></i>
            Add </a>
        <div class="ibox float-e-margins">
            <div class="ibox-title text-right">
                <h5>
                    Wevogo Servers
                </h5>
            </div>
            <div class="ibox-content">
                @if (isset($wevoServers))
                    <table class="table user-table">
                        <thead>
                        <tr>
                            <th>Date Time</th>
                            <th>Mact Address</th>
                            <th>SN</th>
                            <th>Created At</th>
                            <th>Action+</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($wevoServers as $wevoServer)
                            <tr>
                                <td>{{ $wevoServer->date_time }}</td>
                                <td>{{ $wevoServer->mac_address }}</td>
                                <td>{{ $wevoServer->sn }}</td>
                                <td>{{ $wevoServer->created_at }}</td>
                                <td><a href="{{ route('wevo-servers.edit', $wevoServer) }}" class="btn btn-xs btn-info"><i class="fa fa-edit"></i> Edit</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@stop

@section('custom-scripts')
@endsection
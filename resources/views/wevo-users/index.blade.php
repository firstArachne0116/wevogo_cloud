@extends('layout.admin')

@section('custom-styles')
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Wevo Users</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{URL::route('dashboard.index')}}">Home</a>
                </li>
                <li class="active">
                    <a href="#">Wevogo User</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Wevogo Users</h5>
            </div>
            <div class="ibox-content">
                @if (isset($wevoUsers))
                    <table class="table user-table">
                        <thead>
                        <tr>
                            <th>FreePbx</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($wevoUsers as $wevoUser)
                            <tr>
                                <td>{{ '' }}</td>
                                <td>{{ $wevoUser->phone_number }}</td>
                                <td>{{ $wevoUser->email }}</td>
                                <td>{{ $wevoUser->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        {{ $wevoUsers->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('custom-scripts')
@endsection
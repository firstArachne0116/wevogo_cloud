@extends('layout.admin')

@section('custom-styles')
@endsection

@section('content')
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Phone Book</h2>
            <ol class="breadcrumb">
                <li>
                    <a href="{{URL::route('dashboard.index')}}">Home</a>
                </li>
                <li class="active">
                    <a href="#">Phone Book</a>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">

        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        @include('partial/alert_message')
        <div >
            {{ Form::open(array('url' => route('phonebook.sync'), 'method' => 'GET', 'class' => '')) }}
            <div class="row m-b">
                <div class="col-md-3">
                    <div class="form-group ">
                        {!! Form::label('Select Wevo Server') !!}
                        {!! Form::select('wevo_server_id', $wevoServersList, null, array('class'=>'form-control')) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-right">
                        <button class="btn btn-info m-t-md">Sync with Phonebook server</button>
                    </div>
                </div>
            </div>

            {{ Form::close() }}
        </div>
        <div class="ibox float-e-margins">
            <div class="ibox-title text-right">
                <h5>
                    Phone Book
                </h5>
            </div>
            <div class="ibox-content">
                @if (isset($phonebookList))
                    <table class="table user-table">
                        <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Extension</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($phonebookList as $phonebook)
                            <tr>
                                <td>{{ $phonebook->first_name }}</td>
                                <td>{{ $phonebook->last_name }}</td>
                                <td>{{ $phonebook->extension }}</td>
                                <td>{{ $phonebook->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-right">
                        {{ $phonebookList->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop

@section('custom-scripts')
@endsection

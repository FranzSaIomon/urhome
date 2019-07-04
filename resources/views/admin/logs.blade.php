@extends('layouts.app')

@section('header')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2@4.1.0/dist/bootstrap-confirmation.min.js"
    integrity="sha256-HLaBCKTIBg6tnkp3ORya7b3Ttkf7/TXAuL/BdzahrO0=" crossorigin="anonymous"></script>
@endsection

@section('content')

<div class="container w-75 pt-5">
    @php
    $logs = App\Log::orderBy('created_at', 'DESC')->simplePaginate(10);
    @endphp

    <h1 class="border-bottom row mb-5">Audit Logs</h1>
    <div class="row">
        <div class="col">
            <p>
                <b>Note: </b> Downloading the logs will clear all logs accrued until the point the button was clicked.
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            {{$logs->links()}}
        </div>
        <div class="col-md text-right mb-3">
            <a href="/admin/logs/download" class="btn btn-xs-block btn-sm-block btn-success" download>Download Logs</a>
            <a href="/admin/logs/download" class="btn btn-xs-block btn-sm-block btn-secondary">Get Raw</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th scope="col">Log</th>
                            <th scope="col">Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                        <tr>
                            <th scope="row">{{$log->UserID}}</th>
                            <td scope="col">{{$log->Action}}</td>
                            <td scope="col">{{$log->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-3 text-right">
            {{$logs->links()}}
        </div>

        <div class="col-md mb-3 text-right">
            <a href="/admin/logs/download" class="btn btn-xs-block btn-sm-block btn-success" download>Download Logs</a>
            <a href="/admin/logs/download" class="btn btn-xs-block btn-sm-block btn-secondary">Get Raw</a>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>
                <b>Note: </b> Downloading the logs will clear all logs accrued until the point the button was clicked.
            </p>
        </div>
    </div>
</div>
@endsection

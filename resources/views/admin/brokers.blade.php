@extends('layouts.app')

@section('header')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2@4.1.0/dist/bootstrap-confirmation.min.js"
    integrity="sha256-HLaBCKTIBg6tnkp3ORya7b3Ttkf7/TXAuL/BdzahrO0=" crossorigin="anonymous"></script>
@endsection

@section('content')
@php
$brokers = App\User::with("broker_information")->where('UserType', 2)->where('Status', 2)->simplePaginate(10);
@endphp

<div class="container w-75 pt-5">

    <h1 class="border-bottom row mb-5">Broker Verification List</h1>

    @if (Session::has('success'))
    <div class="row">
            <div class="col">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <b>Success: </b> A user has been verified.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        </div>
    @endif


    <div class="row">
        <div class="col-md-3">
            {{$brokers->links()}}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                    <th scope="row">
                        UserID
                    </th>
                    <th scope="col">
                        Name
                    </th>
                    <th scope="col">
                        Files
                    </th>
                    <th scope="col">
                        Approve
                    </th>
                    <th scope="col">
                        Contact
                    </th>
                </thead>
                <tbody>
                    @foreach ($brokers as $broker)
                    <tr>
                        <td scope="row">{{$broker->id}}</td>
                        <td scope="col">{{$broker->FirstName}} {{$broker->LastName}}</td>
                        <td scope="col">
                            @for ($i = 0; $i < count($broker->user_document->Files); $i++)
                                <a href='{{$broker->user_document->Files[$i]}}'>File {{$i + 1}}</a>,
                                @endfor
                        </td>
                        <td scope="col text-center">
                            <a href="/admin/brokers/verify/{{$broker->id}}" class="btn btn-success">Verify</a>
                        </td>
                        <td scope="col text-center">
                            <a href="mailto:{{$broker->email}}" class="btn btn-secondary">Contact</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            {{$brokers->links()}}
        </div>
    </div>
</div>
@endsection

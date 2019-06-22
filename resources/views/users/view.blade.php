@extends('layouts.app')

@section('content')
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.sticky/1.0.4/jquery.sticky.min.js'></script>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <img src="{{$user->ProfileImage}}" class="img-thumbnail rounded-circle"/>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="font-weight-bold">{{$user->FirstName}} {{$user->LastName}}</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-muted">Email Address : </span>
                        <a href="mailto:{{$user->email}}">{{$user->email}}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-muted">Contact Number : </span>
                        <a href="tel:{{$user->ContactNo}}">{{$user->ContactNo}}</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <span class="text-muted">Address : </span>
                    <span class="text-muted">{{$user->LotNo}}, {{$user->Street}}, {{$user->City}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                {{$user}}
            </div>
        </div>
        <br/>
        <div class="row">
            @if(Auth::check() && Auth::user()->id === $user->id)
            <div class="col-md-2">
                <d class="row">
                    <div class="col-md-12 list-group">
                        <a href="#" class="list-group-item list-group-item-action active">View Profile</a>
                        <a href="#" class="list-group-item list-group-item-action">
                            Messages 
                            <span class="badge badge-primary badge-pill">14</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action">Update Account Details</a>
                        <a href="#" class="list-group-item list-group-item-action">Change Password</a>
                        <a href="#" class="list-group-item list-group-item-action">Change Email</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection
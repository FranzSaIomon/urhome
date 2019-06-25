@extends('layouts.app')

@section('content')
    <script>
        var userInfo = '{{$user}}'
        userInfo = JSON.parse(userInfo.replace(/&quot;/g, "\""))
    </script>
    <div class="container-fluid" id="vue-profile-page">
        <div class="row">
            <div class="col-md-3">
                <img src="{{$user->ProfileImage}}" class="img-thumbnail rounded-circle"/>
            </div>
            <div class="col-md">
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
        </div>
        <br/>
        <div class="row">
            @if(Auth::check() && Auth::user()->id === $user->id)
            <div class="col-lg-2">
                <div class="row">
                    <div class="col-md-12 list-group">
                        <a href="#" class="list-group-item list-group-item-action active" @click.prevent="changeSegment('profile')">View Profile</a>
                        <a href="#" class="list-group-item list-group-item-action">
                            Messages 
                            <span class="badge badge-primary badge-pill">14</span>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action" @click.prevent="changeSegment('update')">Update Account Details</a>
                        <a href="#" class="list-group-item list-group-item-action">Change Password</a>
                        <a href="#" class="list-group-item list-group-item-action">Change Email</a>
                    </div>
                </div>
            </div>
            @endif
            @if ($user->user_type->id)
                <div class="{{Auth::check() && Auth::user()->id == $user->id ? "col-lg-10" : "col-md-12"}}">
                    <div id="properties_cards" class="mt-2" v-if="current_segment === 'profile'">
                        <div class="small text-muted mb-2 ml-3">Properties Owned: <b>@{{resultCount}} properties</b></div>
                        <Properties :cards="cards"></Properties>
                        <div class="text-center">
                            <div :class="'spinner-border text-muted ' + ((!loading) ? 'd-none' : '')"></div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
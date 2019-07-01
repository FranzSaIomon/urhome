@extends('layouts.app')

@section('header')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-confirmation2@4.1.0/dist/bootstrap-confirmation.min.js"
        integrity="sha256-HLaBCKTIBg6tnkp3ORya7b3Ttkf7/TXAuL/BdzahrO0=" crossorigin="anonymous"></script>
@endsection

@section('content')
<form @submit.prevent="reactivate" class="container w-50 mx-auto pt-4" id="vue-reactivate">
    @csrf
    <h2 class="row col-md-12 mb-4 pb-2 border-bottom">
        <b>Account Reactivation</b>
    </h2>
    <div class="row">
        <div class="col-lg-12">
            <input-group type="email" :errors="errors" name="email" :values="values" id="email" label="Email Address"
                         placeholder="Enter your email address..." required></input-group>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <input-group type="password" :errors="errors" name="password" :values="values" id="password"
                         label="Password" placeholder="Enter your password..." required></input-group>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <input-group type="password" :errors="errors" name="password_confirmation" :values="values" id="password"
                         label="Password Confirmation" placeholder="Enter your password again..." required>
            </input-group>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-lg-12" v-if="success">
            <div class="alert alert-success" v-html="success">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 muted mt-2">
          <b>Note:</b> Reactivating your account will allow you to login, as well as unarchive all of your properties.
        </div>
        <div class="col-md-4 mt-2">
            <button type="submit" class="px-4 btn btn-sm btn-sm-block btn-xs-block btn-md-block btn-primary float-right">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" hidden></span>
                Reactivate Account
            </button>
        </div>
    </div>
</form>
@endsection

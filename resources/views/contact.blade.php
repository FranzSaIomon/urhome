@extends('layouts.app')

@section('content')
    @include('includes.landing')
    <div class="container w-50 m-5 py-3 px-5 bg-white rounded border mx-auto">
        <h3 class="row border-bottom p-2">Contact Us</h3>
        <div class="row">
            <div class="col">
                <b>Office Number: </b> <a href="tel:09567036417">+09567036417</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <b>Email Address: </b> <a href="mailto:urhome.company@gmail.com">urhome.company@gmail.com</a>
            </div>
        </div>
        </div>
    </div>
@endsection
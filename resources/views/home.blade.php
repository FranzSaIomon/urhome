@extends('layouts.app')

@section('content')
    @include('includes.landing')
    
    <div id="properties_cards">
        <Properties :cards="cards"></Properties>
    </div>
@endsection
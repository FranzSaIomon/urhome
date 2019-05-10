@extends('layouts.app')

@section('content')
    @include('includes.landing')
    
    <div id="properties_cards">
        <Properties></Properties>
        <button @click="add">Add</button>
    </div>
@endsection
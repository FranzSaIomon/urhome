@extends('layouts.app')

@section('content')
    @include('includes.landing')
    {{App\Property::find(36)->property_type}}
@endsection

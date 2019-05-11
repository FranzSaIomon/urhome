@extends('layouts.app')
<?php
    use App\User;
    $user = new User;
?>
@section('content')
    @include('includes.landing')
    
    <div id="properties_cards">
        <Properties></Properties>
    </div>
@endsection
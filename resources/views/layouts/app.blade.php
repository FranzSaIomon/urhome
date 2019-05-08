<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'UrHome') }} - {{ $title }}</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>
<body>
    @include('includes.navigation')
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
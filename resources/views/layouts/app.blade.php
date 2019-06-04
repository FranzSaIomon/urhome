<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UrHome') }} {{ isset($title) ? '- ' . $title : ''}}</title>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/13.1.5/nouislider.js"></script>
    
    <script src="{{asset('js/yall.min.js')}}" type="text/javascript"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            yall({
                observeChanges: true
            });
        });
        var onloadCallback = () =>{}
    </script>

    <script src="{{asset('js/app.js')}}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="shortcut icon" href="{{ asset('img/icons/favicon.ico') }}" type="image/x-icon">

    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer>
    </script>

    @yield('header')
</head>
<body class="{{ isset($nolanding) ? $nolanding : '' }}" style="overflow-x: hidden !important">
    @include('includes.navigation')
    <div class="content">
        @yield('content')
    </div>
</body>
</html>
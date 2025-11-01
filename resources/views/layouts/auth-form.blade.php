<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}} - @yield('title')</title>
    <script src="{{asset('js/jquery.js')}}"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield("head")
</head>

<body>
    @yield("body")
    @yield("script")
    @stack('scripts')
</body>

</html>

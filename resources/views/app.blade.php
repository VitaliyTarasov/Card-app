<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Card-app') }}</title>
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        {{-- <link rel="stylesheet" href="./css/app.css"> --}}
        <script src="{{ mix('js/app.js') }}" defer></script>
    
    </head>
    <body class="text-gray-600">
        <div id="app" class="h-full bg-purple-600">
            <Board></Board> 
        </div>
    </body>
</html>

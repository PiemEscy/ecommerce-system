<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite('resources/js/app.js')
</head>
<body class="min-h-screen flex flex-col items-center justify-center bg-gray-300">
    <div id="app"></div>
</body>
</html>

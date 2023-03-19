<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LARAVEL</title>
    <link rel="stylesheet" href="/css/dist/output.css">
    <script src="https://js.stripe.com/v3/"></script>
    <link rel="shortcut icon" href="#">
</head>


<body>
<div id="app" v-cloak>
    @yield('content')
</div>
</body>
<script src="/js/app.js"></script>
</html>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Projeto educação @yield('title')</title>
    <link href="css/app.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
    <script src="https://kit.fontawesome.com/72cfc6e7a4.js" crossorigin="anonymous"></script>
</head>
<body>

    @include('layout/navbar')

    <div class="container">
    @yield('content')
    </div>

    @include('layout/footer')

    <script src="js/app.js" type="text/javascript"></script>
</body>
</html>

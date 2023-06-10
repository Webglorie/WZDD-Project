<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800" rel="stylesheet">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
    <meta name="csrf-token" content="{{ csrf_token() }}">



    <!-- Bootstrap core CSS -->
    <link href="assets/css/global.css" rel="stylesheet">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>



    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
    <body class="login-page text-center">
    <header>
        <div class="collapse bg-dark" id="navbarHeader">
            <div class="container">
                <div class="row">
                    <div class="col-sm-8 col-md-7 py-4">
                        <h4 class="text-white fw-bold">Over dit beheerdashboard</h4>
                        <p class="text-white">Dit beheerdashboard is gemaakt door Arjen Froma in opdracht van de ZIT Servicedesk van het Maxima Medisch Centrum. Voor eventuele vragen of nieuwe ideeën, kunt u eerst contact opnemen met de coördinator van de ZIT Servicedesk: Mario Willaert. Hij staat graag voor u klaar om te helpen.</p>
                    </div>
                    <div class="col-sm-4 offset-md-1 py-4">
                        <h4 class="text-white">Contact</h4>
                        <ul class="list-unstyled">
                            <li><a href="#" class="text-white">Gebruikershandleiding</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">

            <a href="#" class="navbar-brand d-flex align-items-center">
                <strong>ZIT Servicedesk Beheerdashboard</strong>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </header>

    {{ $slot }}


    </body>
</html>

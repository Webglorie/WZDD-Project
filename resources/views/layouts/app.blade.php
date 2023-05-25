<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'WZDD') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/dashboard/">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script src="https://npmcdn.com/flatpickr/dist/l10n/nl.js"></script>

        <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>



        <!-- Scripts -->
        @vite(['resources/js/app.js', 'resources/css/app.css'])
    </head>
    <body>
    <!-- Page Heading -->
    @include('layouts.header')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.navigation')

            <!-- Page Content -->

                {{ $slot }}

        </div>
    </div>

        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js" integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha" crossorigin="anonymous"></script>

    <script>
        flatpickr('input[data-flatpickr]', {
            enableTime: true,
            locale: "nl",  // locale for this instance only
            dateFormat: 'Y-m-d H:i',
            altInput: true,
            altFormat: "d-m-Y H:i",
            // Add any other configuration options as needed
        });

        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor
                .create(document.querySelector("#description"))
                .catch(error => {

                });
        });
    </script>
    </body>
</html>

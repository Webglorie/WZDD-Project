<x-app-layout>
    {{--    <x-slot name="header">--}}
    {{--        <h2 class="font-semibold text-xl text-gray-800 leading-tight">--}}
    {{--            {{ __('Dashboard') }}--}}
    {{--        </h2>--}}
    {{--    </x-slot>--}}

    {{--    <div class="py-12">--}}
    {{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
    {{--            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">--}}
    {{--                <div class="p-6 text-gray-900">--}}
    {{--                    {{ __("You're logged in!") }}--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <div class="breadcrumb-wrapper primary-wrapper first-pw">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beheerdashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Homepagina</li>
                </ol>
            </nav>
        </div>
        <div class="primary-wrapper transparent-pw snel-naar">
            <p class="top-text">Snel naar</p>
            @foreach ($menuItems as $item)
                <a class="btn btn-primary multi-buttons" href="{{ $item->url }}" role="button">{{ $item->name }}</a>
            @endforeach

        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
            <h1 class="container-header h2">Homepagina</h1>
        </div>
        <div class="container-fluid">
        <div class="row gx-5">
            <div class="primary-wrapper border p-3 col-md-6">
                <p class="lead">Welkom terug, {{ Auth::user()->name }}</p>
                <p>Met behulp van dit handige beheerdashboard heb je volledige controle over de informatie die wordt weergegeven op het wallboard van de ZIT Servicedesk. Als je niet zeker bent over hoe je een specifieke actie moet uitvoeren, is het ten zeerste aanbevolen om de gedetailleerde documentatie zorgvuldig door te nemen, zodat je eventuele fouten kunt vermijden.</p>
                <a class="btn btn-lg btn-primary" href="/docs/5.0/components/navbar/" role="button">View navbar docs »</a>
            </div>
            <div class="primary-wrapper border p-3 col-md-6">
                <p class="lead">Links naar de documentatie</p>
                     <p><a href="/docs/5.0/components/navbar/" role="button">Documentatie 1 »</a></p>
                <p><a href="/docs/5.0/components/navbar/" role="button">Documentatie 2 »</a></p>
                <p><a href="/docs/5.0/components/navbar/" role="button">Documentatie 3 »</a></p>
                <p><a href="/docs/5.0/components/navbar/" role="button">Documentatie 4 »</a></p>
            </div>
        </div>
        </div>

        <div class="wallboard-page container-fluid">

            <div class="row">
                <main class="col-md-12 ms-sm-auto col-lg-12 nopadding-class">
                    <div class="row justify-content-between">
                        <div class="card call-stats-card border-primary mb-3 mt-3" style="max-width: 55%;">
                            <div class="card-header">Live Telefoon Statistieken</div>
{{--                            <div class="call-stats">--}}
{{--                                <iframe style="max-width: 100%; width: 100%" id="myFrame" src="getcallstats.html" scrolling="no"></iframe>--}}
{{--                            </div>--}}
                            <img style="max-width: 100%;" src="http://127.0.0.1:8000/assets/images/wallboard-full.png">
                        </div>
                        <div style="max-width: 44.5%;" class="leenlaptops-container px-0">
                            <div class="card leenlaptops-column border-primary mb-3 mt-3">

                                <div class="card-header">Uitgeleende Leenlaptops</div>
                                <table id="borrowed-equipment-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th scope="col">Leenlaptop</th>
                                        <th scope="col">Ultimonummer</th>
                                        <th scope="col">Uitleen van/tot</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="row justify-content-between m-1">
                                <div class="card col-md-6 border-primary mb-2 mt-2" style="max-width: 49.5%;">
                                    <div class="card-header">Beschikbare Laptops</div>
                                    <div class="list-group beschikbare-laptops">

                                    </div>
                                </div>
                                <div class="card col-md-6 border-primary mb-2 mt-2" style="max-width: 49.5%;">
                                    <div class="card-header">Agendapunten</div>
                                    <div class="list-group agendaitems">
                                        <div class="list-group-item list-group-item-action">Geen agendapunten gevonden.</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="row justify-content-between">
                        <div class="card notifications-col border-primary mb-3 mt-3" style="max-width: 30%;height: 550px;">
                            <div class="card-header">Meldingen</div>
                            <div class="card-body">
                                <h4 class="card-title" id="notificationTitle"></h4>
                                <p class="card-text" id="notificationText"></p>
                                <div id="notificationCount"></div>
                            </div>
                        </div>

                        <div class="card border-primary mb-3 mt-3" style="max-width: 34%;">
                            <div class="card-header">Openstaande problemen</div>
                            <table id="problems-table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th scope="col">Probleem Nr</th>
                                    <th scope="col">Omschrijving</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>


                        <div class="aanwezigheid-cols px-0" style="max-width: 35%;">
                            <div class="row justify-content-between m-1">
                                <div id="servicedesk-col" class="card col-md-6 border-primary mb-2 mt-2" style="max-width: 49.5%;">
                                    <div class="card-header">Servicedesk Rooster</div>
                                    <div class="list-group">
                                        <!-- Hier worden de list-group-items dynamisch toegevoegd -->
                                    </div>
                                </div>
                                <div id="beheer-col" class="card col-md-6 border-primary mb-2 mt-2" style="max-width: 49.5%;">
                                    <div class="card-header">Beheer Rooster</div>
                                    <div class="list-group">
                                        <!-- Hier worden de list-group-items dynamisch toegevoegd -->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                </main>

            </div>
        </div>


    </main>
</x-app-layout>

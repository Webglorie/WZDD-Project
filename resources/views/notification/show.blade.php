<x-app-layout>

    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <div class="breadcrumb-wrapper primary-wrapper first-pw">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('notifications.show') }}
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
            <h1 class="container-header h2">{{ ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Wallboard meldingen' }}</h1>
        </div>
        <div class="primary-wrapper transparent-pw">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Wallboard melding') }} bekijken</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('notifications.index') }}"> {{ __('Terug') }}</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Titel:</strong>
                            {{ $notification->title }}
                        </div>
                        <div class="form-group">
                            <p><strong>Inhoud van melding:</strong></p>
                            {!! $notification->description !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</x-app-layout>

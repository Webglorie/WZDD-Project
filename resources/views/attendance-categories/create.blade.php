<x-app-layout>

    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <div class="breadcrumb-wrapper primary-wrapper first-pw">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('attendance-categories.create') }}
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
            <h1 class="container-header h2">{{ ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Aanwezigheids Categorieën' }}</h1>
        </div>
        @endisset
        <div class="primary-wrapper transparent-pw">
            <div class="row">
                <div class="col-md-12">

                    @includeif('partials.errors')

                    <div class="card card-default">
                        <div class="card-header">
                            <span class="card-title">{{ __('Nieuwe') }} Aanwezigheidscategorie toevoegen</span>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('attendance-categories.store') }}"  role="form" enctype="multipart/form-data">
                                @csrf

                                @include('attendance-categories.form')

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>

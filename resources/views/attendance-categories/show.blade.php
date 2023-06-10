<x-app-layout>

    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <div class="breadcrumb-wrapper primary-wrapper first-pw">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('attendance-categories.show') }}
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
            <h1 class="container-header h2">{{ ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Aanwezigheids Categorieën' }}</h1>
        </div>
        @endisset
        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="primary-wrapper transparent-pw">
            <div class="row">
                <div class="col-md-12">

                    @includeif('partials.errors')

                    <div class="card card-default">
                        <div class="card-header">
                            <span class="card-title">Aanwezigheidscategorie ({{ $attendanceCategory->name }}) bekijken</span>
                            </div>
                            <div class="float-right">
                                <a class="btn btn-primary" href="{{ route('attendance-categories.index') }}"> {{ __('Back') }}</a>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="form-group">
                                <strong>Name:</strong>
                                {{ $attendanceCategory->name }}
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>

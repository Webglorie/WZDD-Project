<x-app-layout>
    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <div class="breadcrumb-wrapper primary-wrapper first-pw">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item {{ $breadcrumb['classes'] }}"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
                    @endforeach
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
            <h1 class="container-header h2">{{ $pageTitle }}</h1>
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="primary-wrapper transparent-pw">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Problem</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('problems.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Problem Number:</strong>
                            {{ $problem->problem_number }}
                        </div>
                        <div class="form-group">
                            <strong>Description:</strong>
                            {{ $problem->description }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</x-app-layout>

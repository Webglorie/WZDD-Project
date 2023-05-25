<x-app-layout>
    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <div class="breadcrumb-wrapper primary-wrapper first-pw">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Beheerdashboard</li>
                    <li class="breadcrumb-item active" aria-current="page">Homepagina</li>
                </ol>
            </nav>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="primary-wrapper transparent-pw">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Menu Item</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('menu-items.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $menuItem->name }}
                        </div>
                        <div class="form-group">
                            <strong>Url:</strong>
                            {{ $menuItem->url }}
                        </div>
                        <div class="form-group">
                            <strong>Parent Id:</strong>
                            {{ $menuItem->parent_id }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
</x-app-layout>

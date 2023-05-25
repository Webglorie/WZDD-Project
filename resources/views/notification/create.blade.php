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

                @includeif('partials.errors')

                <div class="card card-default">
                    <div class="card-header">
                        <span class="card-title">{{ __('Create') }} Notification</span>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('notifications.store') }}"  role="form" enctype="multipart/form-data">
                            @csrf

                            @include('notification.form')

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </main>
    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create( document.querySelector( '#editor' ) )
                .catch( error => {
                    console.error( error );
                } );
        </script>
    @endpush
</x-app-layout>
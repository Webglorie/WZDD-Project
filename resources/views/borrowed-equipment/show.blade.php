<x-app-layout>
    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        @isset($breadcrumbs)
            <div class="breadcrumb-wrapper primary-wrapper first-pw">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        @foreach ($breadcrumbs as $breadcrumb)
                            <li class="breadcrumb-item {{ $breadcrumb['classes'] }}"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a></li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        @endisset

        @isset($pageTitle)
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
                <h1 class="container-header h2">{{ $pageTitle }}</h1>
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
                <div class="card">
                    <div class="card-header">
                        <div class="float-left">
                            <span class="card-title">{{ __('Show') }} Borrowed Equipment</span>
                        </div>
                        <div class="float-right">
                            <a class="btn btn-primary" href="{{ route('borrowed-equipments.index') }}"> {{ __('Back') }}</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <strong>Equipment Id:</strong>
                            {{ $borrowedEquipment->equipment_id }}
                        </div>
                        <div class="form-group">
                            <strong>Borrowed Date Begin:</strong>
                            {{ $borrowedEquipment->borrowed_date_begin }}
                        </div>
                        <div class="form-group">
                            <strong>Borrowed Date End:</strong>
                            {{ $borrowedEquipment->borrowed_date_end }}
                        </div>
                        <div class="form-group">
                            <strong>Borrower:</strong>
                            {{ $borrowedEquipment->borrower }}
                        </div>
                        <div class="form-group">
                            <strong>Ultimo Ticket Number:</strong>
                            {{ $borrowedEquipment->ultimo_ticket_number }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>
</x-app-layout>

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
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Borrowed Equipment') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('borrowed-equipments.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Create New') }}
                                </a>
                              </div>
                        </div>
                    </div>
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="thead">
                                    <tr>
                                        <th>No</th>

										<th>Geleende Hardware</th>
										<th>Borrowed Date Begin</th>
										<th>Borrowed Date End</th>
										<th>Borrower</th>
										<th>Ultimo Ticket Number</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($borrowedEquipments as $borrowedEquipment)
                                        <tr>
                                            <td>{{ ++$i }}</td>

											<td>{{ $borrowedEquipment->equipment->title }}</td>
											<td>{{ $borrowedEquipment->borrowed_date_begin }}</td>
											<td>{{ $borrowedEquipment->borrowed_date_end }}</td>
											<td>{{ $borrowedEquipment->borrower }}</td>
											<td>{{ $borrowedEquipment->ultimo_ticket_number }}</td>

                                            <td>
                                                <form action="{{ route('borrowed-equipments.destroy',$borrowedEquipment->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('borrowed-equipments.show',$borrowedEquipment->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('borrowed-equipments.edit',$borrowedEquipment->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <p>Equipment Category: {{ $category->name }}</p>
                        </div>
                    </div>
                </div>
{{--                {!! $borrowedEquipments->links() !!}--}}
            </div>
        </div>
    </div>
    </main>
</x-app-layout>

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
                                {{ __('Agenda Item') }}
                            </span>

                             <div class="float-right">
                                <a href="{{ route('agenda-items.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Location</th>
                                    <th>Description</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($agendaItems as $agendaItem)
                                    <tr>
                                        <td>{{ ++$i }}</td>
                                        <td>{{ $agendaItem->time }}</td>
                                        <td>{{ $agendaItem->getStatus() }} - {{ $agendaItem->getRemainingTime() }}</td>
                                        <td>{{ $agendaItem->location }}</td>
                                        <td>{{ $agendaItem->description }}</td>
                                        <td>
                                            <form action="{{ route('agenda-items.destroy',$agendaItem->id) }}" method="POST">
                                                <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#showModal{{ $agendaItem->id }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                <a class="btn btn-sm btn-success" href="{{ route('agenda-items.edit',$agendaItem->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Show Modal -->
                                    <div class="modal fade" id="showModal{{ $agendaItem->id }}" tabindex="-1" role="dialog" aria-labelledby="showModalLabel{{ $agendaItem->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="showModalLabel{{ $agendaItem->id }}">{{ __('Show') }} Agenda Item</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Time:</strong> {{ $agendaItem->time }}</p>
                                                    <p><strong>Status:</strong> {{ $agendaItem->getStatus() }} - {{ $agendaItem->getRemainingTime() }}</p>
                                                    <p><strong>Location:</strong> {{ $agendaItem->location }}</p>
                                                    <p><strong>Description:</strong></p> <p>{!! $agendaItem->description !!}</p>
                                                    <p><strong>Created by:</strong> {{ $agendaItem->createdBy->name }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    </main>
</x-app-layout>

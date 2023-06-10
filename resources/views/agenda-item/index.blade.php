<x-app-layout>

    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <div class="breadcrumb-wrapper primary-wrapper first-pw">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('agenda-items.index') }}
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
            <h1 class="container-header h2">{{ ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Agendapunten' }}</h1>
        </div>
        <div class="primary-wrapper transparent-pw">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                @if(isset($status) && !empty($status))
                                    Agendapunten met status {{ ucfirst(trans($status)) }}

                                @else
                                    {{ __('Geplande Agendapunten') }}
                                @endif
                            </span>

                             <div class="float-right">
                                <a href="{{ route('agenda-items.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Nieuwe maken') }}
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
                                    <th>#</th>
                                    <th>Tijd</th>
                                    <th>Status</th>
                                    <th>Locatie</th>
                                    <th>Beschrijving</th>
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
                                                <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#showModal{{ $agendaItem->id }}"><i class="fa fa-fw fa-eye"></i> {{ __('Bekijken') }}</a>
                                                <a class="btn btn-sm btn-success" href="{{ route('agenda-items.edit',$agendaItem->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Wijzigen') }}</a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Verwijderen') }}</button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Show Modal -->
                                    <div class="modal fade" id="showModal{{ $agendaItem->id }}" tabindex="-1" role="dialog" aria-labelledby="showModalLabel{{ $agendaItem->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="showModalLabel{{ $agendaItem->id }}">Agendapunten {{ __('Bekijken') }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>Tijd:</strong> {{ $agendaItem->time }}</p>
                                                    <p><strong>Status:</strong> {{ $agendaItem->getStatus() }} - {{ $agendaItem->getRemainingTime() }}</p>
                                                    <p><strong>Locatie:</strong> {{ $agendaItem->location }}</p>
                                                    <p><strong>Beschrijving:</strong></p> <p>{!! $agendaItem->description !!}</p>
                                                    <p><strong>Gemaakt door:</strong> {{ $agendaItem->createdBy->name }}</p>
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


    @if(isset($expiredItems) && !empty($expiredItems))
        <div class="primary-wrapper transparent-pw">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                                {{ __('Verlopen Agendapunten') }}
                            </span>


                        </div>
                    </div>

                    <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="thead">
                                    <tr>
                                        <th>#</th>
                                        <th>Tijd</th>
                                        <th>Status</th>
                                        <th>Locatie</th>
                                        <th>Beschrijving</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($expiredItems as $expiredItem)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $expiredItem->time }}</td>
                                            <td>{{ $expiredItem->getStatus() }} - {{ $expiredItem->getRemainingTime() }}</td>
                                            <td>{{ $expiredItem->location }}</td>
                                            <td>{{ $expiredItem->description }}</td>
                                            <td>
                                                <form action="{{ route('agenda-items.destroy',$expiredItem->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary" data-toggle="modal" data-target="#showModal{{ $expiredItem->id }}"><i class="fa fa-fw fa-eye"></i> {{ __('Bekijken') }}</a>

                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Verwijderen') }}</button>
                                                </form>
                                            </td>
                                        </tr>

                                        <!-- Show Modal -->
                                        <div class="modal fade" id="showModal{{ $expiredItem->id }}" tabindex="-1" role="dialog" aria-labelledby="showModalLabel{{ $expiredItem->id }}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="showModalLabel{{ $expiredItem->id }}">Agendapunten {{ __('Bekijken') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Tijd:</strong> {{ $expiredItem->time }}</p>
                                                        <p><strong>Status:</strong> {{ $expiredItem->getStatus() }} - {{ $expiredItem->getRemainingTime() }}</p>
                                                        <p><strong>Locatie:</strong> {{ $expiredItem->location }}</p>
                                                        <p><strong>Beschrijving:</strong></p>
                                                        <p>{!! $expiredItem->description !!}</p>
                                                        <p><strong>Gemaakt door:</strong> {{ $expiredItem->createdBy->name }}</p>
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
    @endif
</main>
</x-app-layout>

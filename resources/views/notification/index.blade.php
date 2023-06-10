<x-app-layout>

    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <div class="breadcrumb-wrapper primary-wrapper first-pw">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('notifications.index') }}
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
                            <div style="display: flex; justify-content: space-between; align-items: center;">

                            <span id="card_title">
                               Alle wallboard meldingen
                            </span>

                             <div class="float-right">
                                <a href="{{ route('notifications.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
                                  {{ __('Nieuwe melding toevoegen') }}
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

										<th>Titel</th>
										<th>Inhoud van melding</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notifications as $notification)
                                        <tr>
                                            <td>{{ ++$i }}</td>

											<td>{{ $notification->title }}</td>
											<td style="max-width: 800px;">{{ $notification->description }}</td>

                                            <td>
                                                <form action="{{ route('notifications.destroy',$notification->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('notifications.show',$notification->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Bekijken') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('notifications.edit',$notification->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Wijzigen') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Verwijderen') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                {!! $notifications->links() !!}
            </div>
        </div>
    </div>
    </main>
</x-app-layout>

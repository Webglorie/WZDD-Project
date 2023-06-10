<x-app-layout>

    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <div class="breadcrumb-wrapper primary-wrapper first-pw">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('attendance-employees.index') }}
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
            <h1 class="container-header h2">{{ ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Aanwezigheidsrooster Medewerkers' }}</h1>
        </div>


        <div class="primary-wrapper transparent-pw">
            <div class="row">
                <div class="col-md-12">

                    @includeif('partials.errors')

                    <div class="card card-default">
                        <div class="card-header">
                            <span class="card-title">Overzicht van medewerkers getoond op het aanwzigheidsrooster</span>

                             <div class="float-right">
                                <a href="{{ route('attendance-employees.create') }}" class="btn btn-primary btn-sm float-right"  data-placement="left">
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

										<th>Name</th>
										<th>Department Id</th>

                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendanceEmployees as $attendanceEmployee)
                                        <tr>
                                            <td>{{ $attendanceEmployee->id }}</td>

											<td>{{ $attendanceEmployee->name }}</td>
											<td>{{ $attendanceEmployee->department_id }}</td>

                                            <td>
                                                <form action="{{ route('attendance-employees.destroy',$attendanceEmployee->id) }}" method="POST">
                                                    <a class="btn btn-sm btn-primary " href="{{ route('attendance-employees.show',$attendanceEmployee->id) }}"><i class="fa fa-fw fa-eye"></i> {{ __('Show') }}</a>
                                                    <a class="btn btn-sm btn-success" href="{{ route('attendance-employees.edit',$attendanceEmployee->id) }}"><i class="fa fa-fw fa-edit"></i> {{ __('Edit') }}</a>
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-fw fa-trash"></i> {{ __('Delete') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>
</x-app-layout>

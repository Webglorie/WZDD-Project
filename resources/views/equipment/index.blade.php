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

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
            <h1 class="container-header h2">Aanwezigheid registreren</h1>
        </div>

        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="primary-wrapper">
        <h1>Equipment</h1>

        <a href="{{ route('equipment.create') }}" class="btn btn-primary mb-3">Add Equipment</a>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Ultimo ID</th>
                <th>Status</th>
                <th>Condition</th>
                <th>Last Borrowed Date</th>
                <th>Notes</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($equipment as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->ultimo_id }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->condition }}</td>
                    <td>{{ $item->lastBorrowedDate() }}</td>
                    <td>{{ $item->notes->count() }}</td>
                    <td>
                        <a href="{{ route('equipment.edit', $item->id) }}" class="btn btn-sm btn-primary" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $item->id }}" title="Delete">
                            <i class="fas fa-trash"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#changeStatusModal{{ $item->id }}" title="Change Status">
                            <i class="fas fa-exchange-alt"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#changeConditionModal{{ $item->id }}" title="Change Condition">
                            <i class="fas fa-exchange-alt"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#addNoteModal{{ $item->id }}" title="Add Note">
                            <i class="fas fa-plus"></i>
                        </button>
                    </td>
                </tr>
                <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $item->id }}" aria-hidden="true">
                    <!-- Modal content -->
                </div>

                <!-- Change Status Modal -->
                <div class="modal fade" id="changeStatusModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="changeStatusModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="changeStatusModalLabel{{ $item->id }}">Status wijzigen</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="{{ route('equipment.changeStatus', $item->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="newStatus{{ $item->id }}">Nieuwe status</label>
                                        <select class="form-control" id="newStatus{{ $item->id }}" name="new_status" required>
                                            <option value="{{ \App\Enums\EquipmentStatus::TO_BE_UPDATED }}">Moet geupdate worden</option>
                                            <option value="{{ \App\Enums\EquipmentStatus::NOT_AVAILABLE }}">Niet beschikbaar</option>
                                            <option value="{{ \App\Enums\EquipmentStatus::AVAILABLE }}">Inzetbaar</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                                    <button type="submit" class="btn btn-primary">Opslaan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Change Condition Modal -->
                    <!-- Modal -->
                    <div class="modal fade" id="changeConditionModal{{ $item->id }}" tabindex="-1" aria-labelledby="changeConditionModalLabel{{ $item->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="changeConditionModalLabel{{ $item->id }}">Conditie wijzigen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('equipment.changeCondition', $item->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="newCondition{{ $item->id }}">Nieuwe conditie</label>
                                            <select class="form-control" id="newCondition{{ $item->id }}" name="new_condition" required>
                                                <option value="{{ \App\Enums\EquipmentCondition::GOOD }}">Goed</option>
                                                <option value="{{ \App\Enums\EquipmentCondition::SLOW }}">Traag</option>
                                                <option value="{{ \App\Enums\EquipmentCondition::DEFECT }}">Defect</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                                        <button type="submit" class="btn btn-primary">Opslaan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>

                <!-- Add Note Modal -->
                <div class="modal fade" id="addNoteModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="addNoteModalLabel{{ $item->id }}" aria-hidden="true">
                    <!-- Modal -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addNoteModalLabel">Notitie toevoegen</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('equipment.addNote', $item->id) }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="content">Notitie</label>
                                            <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                                        <button type="submit" class="btn btn-primary">Toevoegen</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            @endforeach
            </tbody>
        </table>
    </div>
    </main>
</x-app-layout>>

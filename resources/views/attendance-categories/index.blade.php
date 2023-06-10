<x-app-layout>
    <main class="col-md-9 ms-sm-auto col-lg-9 px-md-4">
        <div class="breadcrumb-wrapper primary-wrapper first-pw">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('attendance-categories.index') }}
                </ol>
            </nav>
        </div>

        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
            <h1 class="container-header h2">{{ ($breadcrumb = Breadcrumbs::current()) ? $breadcrumb->title : 'Aanwezigheid categorieën' }}</h1>
            <div class="attendance-top-buttons">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addAttendanceCategoryModal">
                Nieuwe Categorie Toevoegen
            </button>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createEmployeeModal">
                Nieuwe Medewerker Toevoegen
            </button>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="createEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="createEmployeeModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createEmployeeModalLabel">Nieuwe Medewerker Toevoegen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="createEmployeeForm">
                                <div class="form-group">
                                    <label for="employeeName">Naam:</label>
                                    <input type="text" class="form-control" id="employeeName" required>
                                </div><br>
                                <div class="form-group">
                                    <label for="department">Afdeling:</label>
                                    <div id="departmentOptions">
                                        <!-- Department options will be dynamically loaded here -->
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                            <button type="button" class="btn btn-primary" id="createEmployeeBtn">Opslaan</button>
                        </div>
                    </div>
                </div>
            </div>



        </div>

        @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="primary-wrapper transparent-pw">
            <!-- Voeg hier de HTML voor de Bootstrap-modal toe -->
            <div class="modal fade" id="addAttendanceCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addAttendanceCategoryModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addAttendanceCategoryModalLabel">Nieuwe categorie toevoegen</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="{{ route('attendance-categories.store') }}" role="form" enctype="multipart/form-data">
                                @csrf
                                @include('attendance-categories.form')
                            </form>
                        </div>

                    </div>
                </div>
            </div>


            <!-- Modal for Add -->
        {{--            <div class="modal fade addemployeemodal" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">--}}
        {{--                <div class="modal-dialog modal-dialog-centered" role="document">--}}
        {{--                    <div class="modal-content">--}}
        {{--                        <div class="modal-header">--}}
        {{--                            <h5 class="modal-title" id="exampleModalLongTitle">Add Task Detail</h5>--}}
        {{--                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
        {{--                                <span aria-hidden="true">&times;</span>--}}
        {{--                            </button>--}}
        {{--                        </div>--}}
        {{--                        <form id="attendance-form">--}}
        {{--                            <div class="modal-body">--}}
        {{--                                <div class="form-group">--}}
        {{--                                    <label for="employee-name">Naam van de AttendanceEmployee:</label>--}}
        {{--                                    <input type="text" class="form-control" id="employee-name" placeholder="Voer de naam in">--}}
        {{--                                </div>--}}
        {{--                                <div class="form-group">--}}
        {{--                                    <label for="category">AttendanceCategory:</label>--}}
        {{--                                    <select class="form-control" id="category">--}}
        {{--                                        <!-- Opties voor de AttendanceCategory worden dynamisch ingevuld -->--}}
        {{--                                    </select>--}}
        {{--                                </div>--}}
        {{--                            </div>--}}
        {{--                            <div class="modal-footer">--}}
        {{--                                <button type="submit" class="btn btn-primary">Opslaan</button>--}}
        {{--                                <button type="button" class="btn btn-secondary" onclick="closePopup()">Annuleren</button>--}}
        {{--                            </div>--}}
        {{--                        </form>--}}

        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        <!-- Modal for Info -->
            <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Task Detail</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="todo-form">
                                <div class="form-group">
                                    <p class="view-card-data"></p>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>


            <div id="attendanceContainer" class="row lanes">
                @foreach ($categories as $category)
                    <div class="attendance-category-block col-12 col-lg-6 col-xl-3"  data-attendancecatid="{{ $category->id }}" id="attendance-cat-{{ $category->id }}">
                        <div class="card card-border-primary">
                            <div class="card-header">
                                <div class="card-actions float-right">
                                    <div class="dropdown show">
                                        <a href="#" data-toggle="dropdown" data-display="static">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="width: 25px; height: 22px; margin-top: 6px; color: #fff;" class="feather feather-more-horizontal align-middle">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </a>

                                        <form action="{{ route('attendance-categories.destroy',$category->id) }}" method="POST">
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item" data-toggle="modal" data-target="#categoryModal{{$category->id}}">Bekijken</a>
                                            <a class="dropdown-item" href="{{ route('attendance-categories.edit',$category->id) }}">Aanpassen</a>
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger showDeleteModal" data-categoryid="{{ $category->id }}">
                                                Verwijderen
                                            </button>
                                        </div>
                                        </form>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="card-title">{{ $category->name }}</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Button trigger modal -->

                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3 swim-lane swim-lane-card">
                                <div class="modal fade" id="categoryModal{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel{{ $category->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="categoryModalLabel{{ $category->id }}">Aanwezigheidsrooster Categorie #{{ $category->id }} bekijken</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Naam:</strong> {{ $category->name }}</p>
                                                <p><strong>ID:</strong> {{ $category->id }}</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div id="card-container" class=" card-container"style="display: none;"></div> -->
                                @foreach ($category->weeklySchedules as $schedule)

                                    <div class="card mb-3 bg-light task" draggable="true"
                                         data-attendancename="{{ $schedule->employee->name }}"
                                         data-attendanceid="{{ $schedule->employee->id }}"
                                         data-catid="{{ $category->id }}">
                                        <div class="card-body p-3 flex">




                                            <!-- Button trigger modal -->
                                            <div class="d-flex align-items-center mt-2 justify-content-between" style="width: 100%;">
                                                <span class="h6 m-0 card-data employee-name">{{ $schedule->employee->name }}</span>
                                                <div class="employee-buttons">
                                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#scheduleModal{{ $schedule->employee->id }}">
                                                <i class="fa fa-calendar"></i>
                                            </button>

                                                <button type="button" class="btn btn-primary btn-sm edit-btn" data-toggle="modal" data-target="#editModal-{{ $schedule->employee->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>

                                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-attendanceid="{{ $schedule->employee->id }}" data-attendancename="{{ $schedule->employee->name }}" data-target="#removeModal-{{ $schedule->employee->id }}">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="scheduleModal{{ $schedule->employee->id }}" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel{{ $schedule->employee->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scheduleModalLabel{{ $schedule->employee->id }}">Rooster - {{ $schedule->employee->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5>Aanwezigheidsrooster van {{ $schedule->employee->name }}</h5>
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>Dag</th>
                                                            <th>Aanwezigheidsrooster Categorie</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($employees as $employee)
                                                            @foreach ($employee->weeklySchedules as $employeeSchedule)
                                                                @if ($schedule->employee->id === $employee->id)
                                                                    <tr>
                                                                        <td>{{ ucfirst(__($employeeSchedule->getDayOfWeekNameAttribute())) }}</td>
                                                                        <td>{{ $employeeSchedule->category->name }}</td>
                                                                    </tr>
                                                                @endif
                                                            @endforeach
                                                        @endforeach
                                                        </tbody>
                                                    </table>



                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Sluiten</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="editModal-{{ $schedule->employee->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel-{{ $employee->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel-{{ $employee->id }}">Bewerk Aanwezigheidsrooster van {{ $schedule->employee->name }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form action="{{ route('schedules.updateAllCategories') }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <table>
                                                            <thead>
                                                            <tr>
                                                                <th>Dag</th>
                                                                <th>Huidige Categorie</th>
                                                                <th>Nieuwe Categorie</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>

                                                            @foreach ($employees as $employee)
                                                                @if ($schedule->employee->id === $employee->id)
                                                                    @foreach ($employee->weeklySchedules as $schedule)
                                                                        <tr>
                                                                            <td>{{ ucfirst(__($schedule->getDayOfWeekNameAttribute())) }}</td>
                                                                            <td>{{ $schedule->category->name }}</td>
                                                                            <td>
                                                                                <select name="schedules[{{ $schedule->id }}]" class="form-control">
                                                                                    @foreach ($categories as $category)
                                                                                        <option value="{{ $category->id }}" {{ $category->id === $schedule->category->id ? 'selected' : '' }}>
                                                                                            {{ $category->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                            @endforeach

                                                            </tbody>
                                                        </table>
                                                        <div class="modal-footer">
                                                            <button type="submit" name="saveSchedulesBtn" class="btn btn-primary">Opslaan</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal -->
                                    <div class="modal fade" id="removeModal-{{ $schedule->employee->id }}" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel-{{ $schedule->employee->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="removeModalLabel-{{ $schedule->employee->id }}">Medewerker verwijderen</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Weet je zeker dat je medewerker "{{ $schedule->employee->name }}" wilt verwijderen?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                                                    <button type="button" class="btn btn-danger" onclick="removeEmployee({{ $schedule->employee->id }})">Verwijderen</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                        </div>
                    </div>


                @endforeach




            </div>
        </div>
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">{{ __('Edit Category') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Category edit form goes here -->
                        <div id="editForm"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                        <button type="button" class="btn btn-primary" id="saveChangesBtn">{{ __('Save Changes') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="categoryModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoryModalLabel">{{ __('Category Details') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Category details content goes here -->
                        <div id="categoryDetails"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">{{ __('Confirm Deletion') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('Close') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>{{ __('Are you sure you want to delete this category?') }}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">{{ __('Delete') }}</button>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- Laad de categorieën en vul de dropdown-opties -->
    <script>

        function closePopup() {
            // Sluit de modal
            const modal = document.getElementById('addModal');
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.hide();

            // Ververs de pagina
            location.reload();
        }


        // Hulpfunctie om het modaal venster te sluiten
        function closePopup() {
            $('#addModal').modal('hide');
        }

            $(document).ready(function() {
            $('.showCategoryModal').click(function(e) {
                e.preventDefault();
                var categoryId = $(this).data('categoryid');
                var url = '/attendance-categories/' + categoryId;

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#categoryDetails').html(response);
                        $('#categoryModal').modal('show');
                    },
                    error: function(xhr) {
                        // Handel de foutmelding af
                    }
                });
            });
                loadAttendanceDepartments();


                $('#saveChangesBtn').click(function() {
                    var categoryId = $(this).data('categoryid');
                    var url = '/attendance-categories/' + categoryId;

                    // Verzamel de gewijzigde gegevens van het formulier

                    $.ajax({
                        url: url,
                        type: 'PUT',
                        data: {
                            // Stuur de gewijzigde gegevens mee
                        },
                        success: function(response) {
                            // Voer acties uit na succesvol opslaan van wijzigingen
                        },
                        error: function(xhr) {
                            // Handel de foutmelding af
                        }
                    });
                });
                $('.showDeleteModal').click(function(e) {
                    e.preventDefault();
                    var categoryId = $(this).data('categoryid');
                    var url = '/attendance-categories/' + categoryId;
                    var token = $('meta[name="csrf-token"]').attr('content');

                    // Open de delete modal
                    $('#deleteModal').modal('show');

                    $('#confirmDeleteBtn').click(function() {
                        // Voer de update van de weekly schedules uit
                        $.ajax({
                            url: '/api/weekly-schedules/category/' + categoryId,
                            type: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': token
                            },
                            success: function(response) {
                                // Voer acties uit na succesvolle update van de weekly schedules

                                // Voer vervolgens de delete-actie uit
                                deleteCategory(url, token);
                            },
                            error: function(xhr) {
                                // Handel de foutmelding af voor de update van de weekly schedules
                                console.error('Fout bij het bijwerken van de wekelijkse schema\'s:', xhr.responseText);
                            }
                        });
                    });
                });

                function deleteCategory(url, token) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        success: function(response) {
                            // Voer acties uit na succesvol verwijderen van de categorie

                            // Ververs de pagina
                            window.location.reload();
                        },
                        error: function(xhr) {
                            // Handel de foutmelding af
                            window.location.reload();
                        }
                    });
                }


// Open de modal wanneer de "Nieuwe Employee" knop wordt geklikt
                $('#createEmployeeModal').on('shown.bs.modal', function() {
                    // Laad de AttendanceDepartments en voeg ze toe als radio-buttons
                    loadAttendanceDepartments();
                });

// Laad de AttendanceDepartments en voeg ze toe als radio-buttons in het formulier
                function loadAttendanceDepartments() {
                    $.ajax({
                        url: '/api/employee/departments', // Vervang met de juiste URL voor het ophalen van de AttendanceDepartments
                        type: 'GET',
                        success: function(response) {
                            // Verwijder eventuele bestaande opties
                            $('#departmentOptions').empty();

                            // Voeg elke AttendanceDepartment toe als een radio-button
                            response.departments.forEach(function(department) {
                                var optionHtml = '<div class="form-check">';
                                optionHtml += '<input class="form-check-input" type="radio" name="department" value="' + department.id + '" required>';
                                optionHtml += '<label class="form-check-label">' + department.name + '</label>';
                                optionHtml += '</div>';

                                $('#departmentOptions').append(optionHtml);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.log("hier 1");
                            console.log(xhr.responseJSON.message);
                        }
                    });
                }

// Verwerk het formulier wanneer op de "Opslaan" knop wordt geklikt
                $('#createEmployeeBtn').click(function() {
                    // Haal de ingevoerde waarden uit het formulier
                    var employeeName = $('#employeeName').val();
                    var departmentId = $('input[name="department"]:checked').val();

                    // Maak een nieuwe AttendanceEmployee via de API
                    createAttendanceEmployee(employeeName, departmentId);
                    console.log("hier 2");
                });

// Maak een nieuwe AttendanceEmployee via de API
                function createAttendanceEmployee(name, departmentId) {
                    $.ajax({
                        url: '/api/attendance/employees', // Vervang met de juiste URL voor het aanmaken van een nieuwe AttendanceEmployee
                        type: 'POST',
                        data: {
                            name: name,
                            department_id: departmentId
                        },
                        success: function(response) {
                            // Succesvol aangemaakt, genereer AttendanceWeeklySchedule-regels
                            generateAttendanceWeeklySchedules(response.employeeId);
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseJSON.message);
                            console.log("hier 3");
                        }
                    });
                }
                function generateAttendanceWeeklySchedules(employeeId) {
                    var requests = [];

                    for (var dayOfWeek = 1; dayOfWeek <= 5; dayOfWeek++) {
                        var request = $.ajax({
                            url: '/api/attendance/employees/' + employeeId + '/weekly-schedules',
                            type: 'POST',
                            data: {
                                employee_id: employeeId,
                                category_id: 1,
                                day_of_week: dayOfWeek
                            }
                        });

                        requests.push(request);
                    }

                    Promise.all(requests)
                        .then(function (responses) {
                            responses.forEach(function (response) {

                            });

                            location.reload(); // Vernieuw de pagina
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }


            });
        function removeEmployee(employeeId) {
            // Stuur een DELETE-verzoek naar de backend
            fetch(`/employees/${employeeId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ employeeId: employeeId })
            })
                .then(response => response.json())
                .then(data => {
                    // Verwerk de response van de backend
                    if (data.success) {
                        // Herlaad de pagina of update de lijst met medewerkers
                        window.location.reload(); // Herlaad de pagina
                        // Voeg eventueel hier je eigen logica toe voor het bijwerken van de lijst met medewerkers
                    } else {
                        console.error(data.error);
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }

    </script>
</x-app-layout>

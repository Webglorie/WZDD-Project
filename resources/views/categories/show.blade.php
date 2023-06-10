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
            <!-- Voeg hier de HTML voor de Bootstrap-modal toe -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addModalLabel">Nieuwe Attendance Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="attendance-form" action="{{ route('attendance.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="employee-name">Naam</label>
                                    <input type="text" class="form-control" id="employee-name" name="employee-name" required>
                                </div>
                                <div class="form-group">
                                    <label for="department">Groep</label>
                                    <select class="form-control" id="department" name="department" required>
                                        <!-- Dynamisch laden van AttendanceCategory opties -->
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Voeg hier de overige formuliervelden toe -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuleren</button>
                                <button type="submit" class="btn btn-primary">Opslaan</button>
                            </div>
                        </form>
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
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
                                                <circle cx="12" cy="12" r="1"></circle>
                                                <circle cx="19" cy="12" r="1"></circle>
                                                <circle cx="5" cy="12" r="1"></circle>
                                            </svg>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="#">Sort</a>
                                            <a class="dropdown-item" href="#">Rename</a>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5 class="card-title">{{ $category->name }}</h5>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-success btn-floating rounded-circle btn-sm showAddModal" data-toggle="modal" data-target="#addModal">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-3 swim-lane swim-lane-card">
                                <!-- <div id="card-container" class=" card-container"style="display: none;"></div> -->
                                @foreach ($category->weeklySchedules as $schedule)

                                        <div class="card mb-3 bg-light task" draggable="true"
                                             data-attendancename="{{ $schedule->employee->name }}"
                                             data-attendanceid="{{ $schedule->employee->id }}"
                                             data-catid="{{ $category->id }}">
                                            <div class="card-body p-3">

                                                <p class="card-data employee-name">{{ $schedule->employee->name }}</p>


                                                <!-- Button trigger modal -->
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#scheduleModal{{ $schedule->employee->id }}">
                                                    Bekijk Rooster
                                                </button>
                                                <div class="d-flex align-items-center mt-2">
                                                    <button type="button" class="btn btn-primary btn-sm edit-btn" data-toggle="modal" data-target="#modal-{{ $schedule->employee->id }}">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <span class="m-1"><i data-attendanceid="{{ $schedule->employee->id }}" class="fa fa-trash remove-card"></i></span>
                                                </div>
                                            </div>
                                        </div>
{{--                                        <!-- Modal -->--}}
{{--                                        @php--}}
{{--                                            $schedule = json_decode($assignedEmployee->weekSchedule->schedule, true);--}}
{{--                                        @endphp--}}

{{--                                        <div class="modal fade" id="modal-{{ $assignedEmployee->id }}" tabindex="-1" role="dialog" aria-labelledby="modal-{{ $assignedEmployee->id }}-label" aria-hidden="true">--}}
{{--                                            <div class="modal-dialog" role="document">--}}
{{--                                                <div class="modal-content">--}}
{{--                                                    <div class="modal-header">--}}
{{--                                                        <h5 class="modal-title" id="modal-{{ $assignedEmployee->id }}-label">Edit Schedule for {{ $assignedEmployee->name }}</h5>--}}
{{--                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                                            <span aria-hidden="true">&times;</span>--}}
{{--                                                        </button>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-body">--}}
{{--                                                        <form id="schedule-form" class="schedule-form" data-employee-id="{{ $assignedEmployee->id }}">--}}
{{--                                                            @csrf--}}
{{--                                                            <div class="form-group">--}}
{{--                                                                <label for="monday">Monday</label>--}}
{{--                                                                <select name="monday" id="monday-dropdown-{{ $assignedEmployee->id }}" class="form-control">--}}
{{--                                                                    @foreach ($categories as $category)--}}
{{--                                                                        <option value="{{ $category->id }}" {{ $category->id == $schedule['monday'] ? 'selected' : '' }}>--}}
{{--                                                                            {{ $category->name }}--}}
{{--                                                                        </option>--}}
{{--                                                                    @endforeach--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="form-group">--}}
{{--                                                                <label for="tuesday">Tuesday</label>--}}
{{--                                                                <select name="tuesday" id="tuesday-dropdown-{{ $assignedEmployee->id }}" class="form-control">--}}
{{--                                                                    @foreach ($categories as $category)--}}
{{--                                                                        <option value="{{ $category->id }}" {{ $category->id == $schedule['tuesday'] ? 'selected' : '' }}>--}}
{{--                                                                            {{ $category->name }}--}}
{{--                                                                        </option>--}}
{{--                                                                    @endforeach--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="form-group">--}}
{{--                                                                <label for="wednesday">Wednesday</label>--}}
{{--                                                                <select name="wednesday" id="wednesday-dropdown-{{ $assignedEmployee->id }}" class="form-control">--}}
{{--                                                                    @foreach ($categories as $category)--}}
{{--                                                                        <option value="{{ $category->id }}" {{ $category->id == $schedule['wednesday'] ? 'selected' : '' }}>--}}
{{--                                                                            {{ $category->name }}--}}
{{--                                                                        </option>--}}
{{--                                                                    @endforeach--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="form-group">--}}
{{--                                                                <label for="thursday">Thursday</label>--}}
{{--                                                                <select name="thursday" id="thursday-dropdown-{{ $assignedEmployee->id }}" class="form-control">--}}
{{--                                                                    @foreach ($categories as $category)--}}
{{--                                                                        <option value="{{ $category->id }}" {{ $category->id == $schedule['thursday'] ? 'selected' : '' }}>--}}
{{--                                                                            {{ $category->name }}--}}
{{--                                                                        </option>--}}
{{--                                                                    @endforeach--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                            <div class="form-group">--}}
{{--                                                                <label for="friday">Friday</label>--}}
{{--                                                                <select name="friday" id="friday-dropdown-{{ $assignedEmployee->id }}" class="form-control">--}}
{{--                                                                    @foreach ($categories as $category)--}}
{{--                                                                        <option value="{{ $category->id }}" {{ $category->id == $schedule['friday'] ? 'selected' : '' }}>--}}
{{--                                                                            {{ $category->name }}--}}
{{--                                                                        </option>--}}
{{--                                                                    @endforeach--}}
{{--                                                                </select>--}}
{{--                                                            </div>--}}
{{--                                                            <button type="submit" class="btn btn-primary">Save Schedule</button>--}}
{{--                                                        </form>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <!-- Bootstrap Modal -->--}}
{{--                                        <div class="modal fade" id="scheduleModal{{ $assignedEmployee->id }}" tabindex="-1" role="dialog" aria-labelledby="scheduleModal{{ $assignedEmployee->id }}Label" aria-hidden="true">--}}
{{--                                            <div class="modal-dialog" role="document">--}}
{{--                                                <div class="modal-content">--}}
{{--                                                    <div class="modal-header">--}}
{{--                                                        <h5 class="modal-title" id="scheduleModalLabel">Rooster van {{ $assignedEmployee->name }}</h5>--}}
{{--                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                                                            <span aria-hidden="true">&times;</span>--}}
{{--                                                        </button>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="modal-body">--}}
{{--                                                        <table class="table">--}}
{{--                                                            <thead>--}}
{{--                                                            <tr>--}}
{{--                                                                <th>Dag</th>--}}
{{--                                                                <th>Categorie</th>--}}
{{--                                                            </tr>--}}
{{--                                                            </thead>--}}
{{--                                                            <tbody>--}}
{{--                                                            @php--}}
{{--                                                                $categories = $categories->keyBy('id');--}}
{{--                                                                $schedule = json_decode($assignedEmployee->weekSchedule->schedule, true);--}}
{{--                                                            @endphp--}}

{{--                                                            @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)--}}
{{--                                                                <tr>--}}
{{--                                                                    <td>{{ ucfirst($day) }}</td>--}}
{{--                                                                    <td>--}}
{{--                                                                        @php--}}
{{--                                                                            $categoryId = $schedule[$day] ?? null;--}}
{{--                                                                            $categoryName = optional($categories->get($categoryId))->name;--}}
{{--                                                                        @endphp--}}
{{--                                                                        {{ $categoryName }}--}}
{{--                                                                    </td>--}}
{{--                                                                </tr>--}}
{{--                                                            @endforeach--}}
{{--                                                            </tbody>--}}
{{--                                                        </table>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    @endforeach
                                @else
                                    <p>No employees assigned to this category.</p>
                                @endif

                            </div>
                        </div>
                    </div>

                @endforeach




            </div>
        </div>
    </main>
    <!-- Laad de categorieën en vul de dropdown-opties -->
    <script>
        // Voeg een event listener toe aan alle elementen met de class 'remove-card'
        $('.remove-card').on('click', function () {
            // Haal de attendance ID op van het geklikte element
            const attendanceId = $(this).data('attendanceid');

            // Stuur een DELETE-verzoek naar de API om de employee te verwijderen
            $.ajax({
                url: `/api/attendance-employees/${attendanceId}`,
                type: 'DELETE',
                success: function (data) {
                    console.log(data); // Doe hier iets met de response, zoals een melding weergeven
                    // Vervolgens kun je de gewenste acties uitvoeren, zoals het bijwerken van de UI
                    // Bijvoorbeeld: verwijder de verwijderde AttendanceEmployee uit de UI
                    $(`[data-attendanceid="${attendanceId}"]`).closest('.task').remove();
                },
                error: function (error) {
                    console.error(error);
                    // Doe hier iets met de fout, zoals een foutmelding weergeven
                }
            });
        });


        // // Event handler voor het formulierinzending
        // document.getElementById('attendance-form').addEventListener('submit', function (event) {
        //     event.preventDefault(); // Voorkom standaardformulierinzending
        //
        //     const employeeName = document.getElementById('employee-name').value;
        //     const department = document.getElementById('department').value;
        //     const today = new Date().toISOString().split('T')[0]; // Datum van vandaag
        //
        //     // Maak een nieuwe AttendanceEmployee aan
        //     fetch('/api/attendance-employees', {
        //         method: 'POST',
        //         headers: {
        //             'Content-Type': 'application/json',
        //             'Accept': 'application/json',
        //         },
        //         body: JSON.stringify({name: employeeName})
        //     })
        //         .then(response => response.json())
        //         .then(data => {
        //             const employeeId = data.id;
        //             console.log(data);
        //
        //             // Maak een nieuwe Attendance aan
        //             fetch('/api/attendances', {
        //                 method: 'POST',
        //                 headers: {
        //                     'Content-Type': 'application/json',
        //                     'Accept': 'application/json',
        //                 },
        //                 body: JSON.stringify({
        //                     employee_id: employeeId,
        //                     department_id: department,
        //                 })
        //             })
        //                 .then(response => response.json())
        //                 .then(data => {
        //                     // Do something with the response data if needed
        //                     console.log('Attendance created:', data);
        //                     closePopup(); // Sluit de popup
        //                 })
        //         })
        // });
        function closePopup() {
            // Sluit de modal
            const modal = document.getElementById('addModal');
            const bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.hide();

            // Ververs de pagina
            location.reload();
        }

        // JavaScript code om drag-and-drop gebeurtenissen af te handelen
        const tasks = document.querySelectorAll('.card.task');

        tasks.forEach(task => {
            task.addEventListener('dragstart', handleDragStart);
            task.addEventListener('dragend', handleDragEnd);
        });

        const lanes = document.querySelectorAll('.lane');

        lanes.forEach(lane => {
            lane.addEventListener('dragover', handleDragOver);
            lane.addEventListener('drop', handleDrop);
        });

        let draggedTask = null;

        function handleDragStart(event) {
            draggedTask = event.target;
        }

        function handleDragEnd(event) {
            draggedTask = null;
        }

        function handleDragOver(event) {
            event.preventDefault();
        }

        function handleDrop(event) {
            event.preventDefault();
            const targetLane = event.target.closest('.lane');
            const targetLaneId = targetLane.getAttribute('id');
            const attendanceCatId = targetLane.getAttribute('data-attendancecatid');
            const attendanceId = draggedTask.getAttribute('data-attendanceid');

            console.log('Target Lane ID:', targetLaneId);
            console.log('Attendance Category ID:', attendanceCatId);
            console.log('Dragged Task Attendance ID:', attendanceId);

            // Voer hier verdere acties uit op basis van de verplaatste taak en de doellane
        }



        // Voeg een event listener toe aan alle elementen met de class 'remove-card'
        // const removeButtons = document.querySelectorAll('.remove-card');
        // removeButtons.forEach((button) => {
        //     button.addEventListener('click', function () {
        //         // Haal de attendance ID op van het geklikte element
        //         const attendanceId = this.closest('.task').getAttribute('data-attendanceid');
        //
        //         // Stuur een DELETE-verzoek naar de API om de employee te verwijderen
        //         fetch(`/api/attendances/${attendanceId}`, {
        //             method: 'DELETE',
        //         })
        //             .then((response) => response.json())
        //             .then((data) => {
        //                 console.log(data); // Doe hier iets met de response, zoals een melding weergeven
        //                 // Vervolgens kun je de gewenste acties uitvoeren, zoals het bijwerken van de UI
        //             })
        //             .catch((error) => {
        //                 console.error(error);
        //                 // Doe hier iets met de fout, zoals een foutmelding weergeven
        //             });
        //     });
        // });
        // // Event listener voor nav-links
        // var navLinks = document.querySelectorAll('.nav-link');
        // navLinks.forEach(function(link) {
        //     link.addEventListener('click', function(event) {
        //         event.preventDefault(); // Voorkom standaardgedrag van de link
        //
        //         // Haal de ID van de geklikte link op
        //         var target = this.getAttribute('href');
        //
        //         // Verwijder de active-klasse van alle nav-links
        //         navLinks.forEach(function(navLink) {
        //             navLink.classList.remove('active');
        //         });
        //
        //         // Voeg de active-klasse toe aan de geklikte nav-link
        //         this.classList.add('active');
        //
        //         // // Verberg alle tab-panes
        //         // var tabPanes = document.querySelectorAll('.tab-pane');
        //         // tabPanes.forEach(function(pane) {
        //         //     pane.classList.remove('show', 'active');
        //         // });
        //
        //         // Maak de juiste tab-pane zichtbaar
        //         var targetPane = document.querySelector(target);
        //         targetPane.classList.add('show', 'active');
        //     });
        // });
        $(document).ready(function() {
            // Handle form submission
            $('.schedule-form').on('submit', function(e) {
                e.preventDefault();

                // Get the employee ID and schedule data
                var employeeId = $(this).data('employee-id');
                var scheduleData = {
                    monday: $('#monday-dropdown-' + employeeId).val(),
                    tuesday: $('#tuesday-dropdown-' + employeeId).val(),
                    wednesday: $('#wednesday-dropdown-' + employeeId).val(),
                    thursday: $('#thursday-dropdown-' + employeeId).val(),
                    friday: $('#friday-dropdown-' + employeeId).val(),
                };

                // Perform an AJAX request to update the schedule
                $.ajax({
                    url: '/api/attendance/' + employeeId + '/update-schedule',
                    type: 'POST',
                    data: { schedule: JSON.stringify(scheduleData) },
                    success: function(response) {
                        // Handle the success response
                        location.reload();
                        // Optionally, update the UI or show a success message
                    },
                    error: function(xhr) {
                        // Handle the error response
                        console.log(xhr.responseText);
                        console.log(scheduleData);
                        // Optionally, show an error message
                    }
                });
            });
        });

        // // Event listener voor het klikken op de 'Add' knop
        // $('#addModal').on('shown.bs.modal', function () {
        //     // Laad de AttendanceCategory-opties in de dropdown
        //     $.ajax({
        //         url: '/api/categories',
        //         type: 'GET',
        //         success: function (data) {
        //             const categoryDropdown = $('#category');
        //             categoryDropdown.empty();
        //
        //             // Voeg elke AttendanceCategory toe als een optie in de dropdown
        //             data.forEach(function (category) {
        //                 const option = $('<option></option>').attr('value', category.id).text(category.name);
        //                 categoryDropdown.append(option);
        //             });
        //         },
        //         error: function (error) {
        //             console.error(error);
        //             // Doe hier iets met de fout, zoals een foutmelding weergeven
        //         }
        //     });

        $(document).ready(function() {
            // Laad de AttendanceCategory-opties bij het openen van de modal

            // Stuur een AJAX-verzoek naar de server om de AttendanceCategory-gegevens op te halen
            $.ajax({
                url: '/api/attendance-categories', // De URL naar de route die de categorieën teruggeeft
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log("succes");
                    // Verwijder bestaande opties
                    $('#category').empty();

                    // Voeg de nieuwe opties toe aan de select
                    $.each(response.data, function(index, category) {
                        $('#category').append('<option value="' + category.id + '">' + category.name + '</option>');
                    });
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    // Toon een foutmelding als het ophalen van de categorieën mislukt
                }
            });


            // Event listener voor het indienen van het formulier
            $('#attendance-form').on('submit', function (e) {
                e.preventDefault();

                // Verzamel de gegevens uit het formulier
                const employeeName = $('#employee-name').val();
                const department = $('#department').val();

                // Stuur een POST-verzoek naar de API om een nieuwe AttendanceEmployee toe te voegen
                $.ajax({
                    url: '/api/attendances',
                    type: 'POST',
                    data: {
                        employee_name: employeeName,
                        department_id: department,
                    },
                    success: function (data) {
                        console.log(data); // Doe hier iets met de response, zoals een melding weergeven
                        // Sluit het modaal venster
                        $('#addModal').modal('hide');
                        // Ververs de pagina
                        location.reload();
                    },
                    error: function (error) {
                        console.error(error);
                        // Doe hier iets met de fout, zoals een foutmelding weergeven
                    }
                });


            });
        });

        // Hulpfunctie om het modaal venster te sluiten
        function closePopup() {
            $('#addModal').modal('hide');
        }

    </script>
</x-app-layout>

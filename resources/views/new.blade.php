<x-app-layout>
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



        <div class="primary-wrapper transparent-pw">
            <!-- Modal for Add -->
            <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Task Detail</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="todo-form">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="">Task Description: </label>
                                    <input type="text" class="form-control" id="todo-input" placeholder="Enter Task Description">
                                    <label class="task-empty-info text-danger" id="task-empty-info" style="display: none;">This field can not be null!</label>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary addBtn" id="addBtn" >Add</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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



            <div class="row lanes">
                <div class="col-12 col-lg-6 col-xl-3" id="todo-lane">
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
                                    <h5 class="card-title">TODO</h5>
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

                            <div class="card mb-3 bg-light task" draggable="true">
                                <div class="card-body p-3">

                                    <p class="card-data employee-name">Arjen Froma</p>


                                    <!-- Button trigger modal -->
                                    <button type="button"  class="btn btn-outline-primary btn-sm view-details" data-toggle="modal" data-target="#viewModal">
                                        Bekijk Rooster
                                    </button>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="m-1"><i class="fa fa-star favourite-card"></i></span>
                                        <span class="m-1"><i class="fa fa-trash remove-card"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3 bg-light task" draggable="true">
                                <div class="card-body p-3">

                                    <p class="card-data employee-name">Arjen Froma</p>


                                    <!-- Button trigger modal -->
                                    <button type="button"  class="btn btn-outline-primary btn-sm view-details" data-toggle="modal" data-target="#viewModal">
                                        Bekijk Rooster
                                    </button>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="m-1"><i class="fa fa-star favourite-card"></i></span>
                                        <span class="m-1"><i class="fa fa-trash remove-card"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="card card-border-danger">
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
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title">DOING</h5>
                            <!-- <h6 class="card-subtitle text-muted"></h6> -->
                        </div>
                        <div class="card-body swim-lane">

                            <div class="card mb-3 text-white task bg-danger" draggable="true">
                                <div class="card-body p-3">

                                    <p class="card-data employee-name">Arjen Froma</p>


                                    <!-- Button trigger modal -->
                                    <button type="button"  class="btn btn-outline-light text-white btn-sm view-details" data-toggle="modal" data-target="#viewModal">
                                        Bekijk Rooster
                                    </button>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="m-1"><i class="fa fa-star favourite-card"></i></span>
                                        <span class="m-1"><i class="fa fa-trash remove-card"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3 text-white task bg-danger" draggable="true">
                                <div class="card-body p-3">

                                    <p class="card-data employee-name">Arjen Froma</p>


                                    <!-- Button trigger modal -->
                                    <button type="button"  class="btn btn-outline-light text-white btn-sm view-details" data-toggle="modal" data-target="#viewModal">
                                        Bekijk Rooster
                                    </button>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="m-1"><i class="fa fa-star favourite-card"></i></span>
                                        <span class="m-1"><i class="fa fa-trash remove-card"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="card card-border-warning">
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
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title">POSTPONED</h5>
                            <!-- <h6 class="card-subtitle text-muted">.</h6> -->
                        </div>
                        <div class="card-body swim-lane">

                            <div class="card mb-3 bg-warning text-white task" draggable="true">
                                <div class="card-body p-3">

                                    <p class="card-data employee-name">Arjen Froma</p>


                                    <!-- Button trigger modal -->
                                    <button type="button"  class="btn btn-outline-light text-white btn-sm view-details" data-toggle="modal" data-target="#viewModal">
                                        Bekijk Rooster
                                    </button>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="m-1"><i class="fa fa-star favourite-card"></i></span>
                                        <span class="m-1"><i class="fa fa-trash remove-card"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3 bg-warning text-white task" draggable="true">
                                <div class="card-body p-3">

                                    <p class="card-data employee-name">Arjen Froma</p>


                                    <!-- Button trigger modal -->
                                    <button type="button"  class="btn btn-outline-light text-white btn-sm view-details" data-toggle="modal" data-target="#viewModal">
                                        Bekijk Rooster
                                    </button>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="m-1"><i class="fa fa-star favourite-card"></i></span>
                                        <span class="m-1"><i class="fa fa-trash remove-card"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <a href="#" class="btn btn-primary btn-block">Add new</a> -->
                    </div>
                </div>
                <div class="col-12 col-lg-6 col-xl-3">
                    <div class="card card-border-success">
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
                                        <a class="dropdown-item" href="#">Action</a>
                                        <a class="dropdown-item" href="#">Another action</a>
                                        <a class="dropdown-item" href="#">Something else here</a>
                                    </div>
                                </div>
                            </div>
                            <h5 class="card-title">DONE</h5>
                            <!-- <h6 class="card-subtitle text-muted"></h6> -->
                        </div>
                        <div class="card-body swim-lane">

                            <div class="card mb-3 bg-success text-white task" draggable="true">
                                <div class="card-body p-3">

                                    <p class="card-data employee-name">Arjen Froma</p>


                                    <!-- Button trigger modal -->
                                    <button type="button"  class="btn btn-outline-dark text-white btn-sm view-details" data-toggle="modal" data-target="#viewModal">
                                        Bekijk Rooster
                                    </button>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="m-1"><i class="fa fa-star favourite-card"></i></span>
                                        <span class="m-1"><i class="fa fa-trash remove-card"></i></span>
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3 bg-success text-white task" draggable="true">
                                <div class="card-body p-3">

                                    <p class="card-data employee-name">Arjen Froma</p>


                                    <!-- Button trigger modal -->
                                    <button type="button"  class="btn btn-outline-dark text-white btn-sm view-details" data-toggle="modal" data-target="#viewModal">
                                        Bekijk Rooster
                                    </button>
                                    <div class="d-flex align-items-center mt-2">
                                        <span class="m-1"><i class="fa fa-star favourite-card"></i></span>
                                        <span class="m-1"><i class="fa fa-trash remove-card"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <a href="#" class="btn btn-primary btn-block">Add new</a> -->
                    </div>
                </div>
            </div>

        </div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center primary-wrapper less-padding">
            <h1 class="container-header h2">Week rooster</h1>
        </div>
        <div class="primary-wrapper">
            <div class="idance">
                <div class="schedule content-block">



                    <div class="timetable">

                        <!-- WeekSchedule Top Navigation -->
                        <nav class="nav nav-tabs">
                            <a class="nav-link active">Mon</a>
                            <a class="nav-link">Tue</a>
                            <a class="nav-link">Wed</a>
                            <a class="nav-link">Thu</a>
                            <a class="nav-link">Fri</a>
                            <a class="nav-link">Sat</a>
                            <a class="nav-link">Sun</a>
                        </nav>

                        <div class="tab-content">
                            <div class="tab-pane show active">
                                <div class="row">

                                    <!-- WeekSchedule Item 1 -->
                                    <div class="col-md-6">
                                        <div class="timetable-item">
                                            <div class="timetable-item-img">
                                                <img src="https://www.bootdey.com/image/100x80/FFB6C1/000000" alt="Contemporary Dance">
                                            </div>
                                            <div class="timetable-item-main">
                                                <div class="timetable-item-time">4:00pm - 5:00pm</div>
                                                <div class="timetable-item-name">Contemporary Dance</div>
                                                <a href="#" class="btn btn-primary btn-book">Book</a>
                                                <div class="timetable-item-like">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                    <div class="timetable-item-like-count">11</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- WeekSchedule Item 2 -->
                                    <div class="col-md-6">
                                        <div class="timetable-item">
                                            <div class="timetable-item-img">
                                                <img src="https://www.bootdey.com/image/100x80/00FFFF/000000" alt="Break Dance">
                                            </div>
                                            <div class="timetable-item-main">
                                                <div class="timetable-item-time">5:00pm - 6:00pm</div>
                                                <div class="timetable-item-name">Break Dance</div>
                                                <a href="#" class="btn btn-primary btn-book">Book</a>
                                                <div class="timetable-item-like">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                    <div class="timetable-item-like-count">28</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- WeekSchedule Item 3 -->
                                    <div class="col-md-6">
                                        <div class="timetable-item">
                                            <div class="timetable-item-img">
                                                <img src="https://www.bootdey.com/image/100x80/8A2BE2/000000" alt="Street Dance">
                                            </div>
                                            <div class="timetable-item-main">
                                                <div class="timetable-item-time">5:00pm - 6:00pm</div>
                                                <div class="timetable-item-name">Street Dance</div>
                                                <a href="#" class="btn btn-primary btn-book">Book</a>
                                                <div class="timetable-item-like">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                    <div class="timetable-item-like-count">28</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- WeekSchedule Item 4 -->
                                    <div class="col-md-6">
                                        <div class="timetable-item">
                                            <div class="timetable-item-img">
                                                <img src="https://www.bootdey.com/image/100x80/6495ED/000000" alt="Yoga">
                                            </div>
                                            <div class="timetable-item-main">
                                                <div class="timetable-item-time">7:00pm - 8:00pm</div>
                                                <div class="timetable-item-name">Yoga</div>
                                                <a href="#" class="btn btn-primary btn-book">Book</a>
                                                <div class="timetable-item-like">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                    <div class="timetable-item-like-count">23</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- WeekSchedule Item 5 -->
                                    <div class="col-md-6">
                                        <div class="timetable-item">
                                            <div class="timetable-item-img">
                                                <img src="https://www.bootdey.com/image/100x80/00FFFF/000000" alt="Stretching">
                                            </div>
                                            <div class="timetable-item-main">
                                                <div class="timetable-item-time">6:00pm - 7:00pm</div>
                                                <div class="timetable-item-name">Stretching</div>
                                                <a href="#" class="btn btn-primary btn-book">Book</a>
                                                <div class="timetable-item-like">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                    <div class="timetable-item-like-count">14</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- WeekSchedule Item 6 -->
                                    <div class="col-md-6">
                                        <div class="timetable-item">
                                            <div class="timetable-item-img">
                                                <img src="https://www.bootdey.com/image/100x80/008B8B/000000" alt="Street Dance">
                                            </div>
                                            <div class="timetable-item-main">
                                                <div class="timetable-item-time">8:00pm - 9:00pm</div>
                                                <div class="timetable-item-name">Street Dance</div>
                                                <a href="#" class="btn btn-primary btn-book">Book</a>
                                                <div class="timetable-item-like">
                                                    <i class="fa fa-heart-o" aria-hidden="true"></i>
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                    <div class="timetable-item-like-count">9</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

</x-app-layout>

@extends('layouts.admin')
@section('content')
    <style>
        .select2-container {
            width: 100% !important;
        }

        .rating {
            display: flex;
        }

        .rate {
            float: left;
            height: 46px;
            padding: 0 10px;
            margin-left: 50px;
        }

        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }
    </style>
    @can('nationality_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <button class="btn btn-outline-success" onclick="openModal()">
                    Create Schedule
                </button>
            </div>
        </div>
    @endcan

    <div class="card">
        <div class="card-header">
            FeedBack Schedule Lists
        </div>

        <div class="card-body">
            <table
                class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-FeedBack text-center">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            S.No
                        </th>
                        <th>
                            FeedBack Name
                        </th>
                        <th>
                            Type
                        </th>
                        <th>
                            Expiry Date
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Created By
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="modal fade" id="scheduleFeedbackModel" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" style="outline: none;" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="row gutters">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 form-group">
                                <label for="result" class="required">FeedBack Name</label>
                                <input type="hidden" name="feedback_id" id="feedback_id" value="">
                                <select name="feedback" id="feedback" class="form-control select2">
                                    <option value="">Select Feedback Name</option>
                                    @foreach ($feedback as $id => $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                <span id="feedback_span" class="text-danger text-center"
                                    style="display:none;font-size:0.9rem;"></span>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group">
                                <label for="result" class="required">Feedback Participant</label>
                                <select name="participant" id="participant" class="form-control select2">
                                    <option value="">Select Type</option>
                                    <option value="Student">Student</option>
                                    <option value="Staff">Staff</option>
                                    <option value="External">External</option>
                                </select>
                                <span id="participant_span" class="text-danger text-center"
                                    style="display:none;font-size:0.9rem;"></span>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group type">
                                <label for="result" class="required">Feedback Type</label>
                                <select name="type" id="type" class="form-control select2">
                                    <option value="">Select Type</option>
                                    <option value="Course">Course Feedback</option>
                                    <option value="Training">Training Feedback</option>
                                    <option value="Faculty">Faculty Feedback</option>
                                </select>
                                <span id="type_span" class="text-danger text-center"
                                    style="display:none;font-size:0.9rem;"></span>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group training">
                                <label for="type_training" class="required">Type of Training</label>
                                <select name="type_training" id="type_training" class="form-control select2">
                                    <option value="">Select Type</option>
                                    <option value="Seminar">Seminar</option>
                                    <option value="Workshop">Workshop</option>
                                </select>
                                <span id="type_training_span" class="text-danger text-center"
                                    style="display:none;font-size:0.9rem;"></span>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group training">
                                <label for="title_training" class="required">Title</label>
                                <input type="text" name="title_training" id="title_training" class="form-control">
                                <span id="title_training_span" class="text-danger text-center"
                                    style="display:none;font-size:0.9rem;"></span>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group training">
                                <label for="duration_training" class="required">Duration</label>
                                <input type="text" name="duration_training" id="duration_training" class="form-control"
                                    placeholder="2 hrs">
                                <span id="duration_training_span" class="text-danger text-center"
                                    style="display:none;font-size:0.9rem;"></span>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group training">
                                <label for="person_training" class="required">Resource Person</label>
                                <input type="text" name="person_training" id="person_training" class="form-control">
                                <span id="person_training_span" class="text-danger text-center"
                                    style="display:none;font-size:0.9rem;"></span>
                            </div>

                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group">
                                <label for="start_date" class="required">Start Date</label>
                                <input type="date" name="start_date" id="start_date" class="form-control">
                                <span id="start_date_span" class="text-danger text-center"
                                    style="display:none;font-size:0.9rem;"></span>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group">
                                <label for="expiry_date" class="required">Expire Date</label>
                                <input type="date" name="expiry_date" id="expiry_date" class="form-control"
                                    onblur="getDays(this)">
                                <span id="expiry_date_span" class="text-danger text-center"
                                    style="display:none;font-size:0.9rem;"></span>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group">
                                <label for="result">No. of Days</label>
                                <input type="text" name="days" id="days" class="form-control" disabled>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group">
                                <label for="result" class="required">Status</label>
                                <select name="status" id="status" class="form-control select2">
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Disabled">Disabled</option>
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group filter">
                                <label for="result">Degree</label>
                                <select name="degree" id="degree" class="form-control select2">
                                    <option value="">Select Degree</option>
                                    <option value="All">All</option>
                                    @foreach ($degree as $id => $item)
                                        <option value="{{ $id }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12 form-group filter">
                                <label for="course">Course</label>
                                <select name="course[]" id="course" class="form-control select2" multiple>
                                    <option value="All">All</option>
                                    @foreach ($course as $id => $item)
                                        <option value="{{ $id }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 form-group filter">
                                <label for="batch">Batch</label>
                                <select name="batch" id="batch" class="form-control select2">
                                    <option value="">Select Academic Year</option>
                                    @foreach ($batch as $id => $item)
                                        <option value="{{ $id }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 form-group filter">
                                <label for="ay">Ay</label>
                                <select name="ay" id="ay" class="form-control select2">
                                    <option value="">Select Academic Year</option>
                                    @foreach ($ay as $id => $item)
                                        <option value="{{ $id }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 form-group filter">
                                <label for="sem">Semester</label>
                                <select name="sem" id="sem" class="form-control select2">
                                    <option value="">Select Semester</option>
                                    <option value="All">All</option>
                                    @foreach ($sem as $id => $item)
                                        <option value="{{ $id }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12 form-group filter">
                                <label for="sec">Section</label>
                                <select name="sec" id="sec" class="form-control select2">
                                    <option value="">Select Section</option>
                                    <option value="All">All</option>
                                    @foreach ($sec as $id => $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 form-group dept">
                                <label for="dept">Department</label>
                                <select name="dept[]" id="dept" class="form-control select2" multiple>
                                    <option value="All">All</option>
                                    @foreach ($dept as $id => $item)
                                        <option value="{{ $item }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div id="save_div">
                            <button type="button" id="save_btn" class="btn btn-outline-success"
                                onclick="saveFeedback()">Save</button>
                        </div>
                        <div id="loading_div">
                            <span class="theLoader"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="secondLoader"></div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            callAjax();

            function cpyLink(e) {
                var decode = atob($(e).data('link'));
                var tempInput = $('<input>').val(decode).appendTo('body').select();
                document.execCommand('copy');
                tempInput.remove();
                Swal.fire('', 'Link Copied...', 'success');
            }
        });

        const tool_course = `@foreach ($course as $id => $item)
                                        <option value="{{ $id }}">{{ $item }}</option>
                                    @endforeach`

        function callAjax() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            if ($.fn.DataTable.isDataTable('.datatable-FeedBack')) {
                $('.datatable-FeedBack').DataTable().destroy();
            }
            let dtOverrideGlobals = {
                buttons: dtButtons,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.schedule-feedback.index') }}",
                columns: [{
                        data: 'placeholder',
                        name: 'placeholder'
                    },
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'expiry',
                        name: 'expiry'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'createdBy',
                        name: 'createdBy'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        render: function(data, type, row) {
                            let link = row.token_link;
                            if (link != null) {
                                return data +=
                                    `<button class="newCopyBtn" data-link="${link}" onclick="cpyLink(this)" title="Copy Link"><i class="fa-fw nav-icon fas fa-copy"></i></button>`;
                            } else {
                                return data;
                            }
                        }
                    }
                ],
                orderCellsTop: true,
                order: [
                    [1, 'desc']
                ],
                pageLength: 10,
            };
            let table = $('.datatable-FeedBack').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        };

        $('#participant').change(function() {
            let value = $('#participant option:selected').val();
            console.log(value);
            if (value == 'External') {
                $('.type').hide();
                $('.filter').hide();
            } else {
                $('.type').show();
                $('.filter').show();
            }
        })

        $('#type').change(function() {
            let value = $('#type option:selected').val();
            console.log(value);
            if (value == 'Faculty') {
                $('.dept').show();
                $('.filter').hide();
                $('.training').hide();
            } else if (value == 'Training') {
                $('.training').show();
                $('.filter').show();
                $('.dept').hide();
            } else {
                $('.dept').hide();
                $('.training').hide();
                $('.type').show();
                $('.filter').show();
            }
        })

        function cpyLink(e) {
            var decode = atob($(e).data('link'));
            var tempInput = $('<input>').val(decode).appendTo('body').select();
            document.execCommand('copy');
            tempInput.remove();
            Swal.fire('', 'Link Copied...', 'success');
        }

        function openModal() {
            $("#feedback_id").val('');
            $("#feedback").val('').select2();
            $("#participant").val('').select2();
            $("#participant").prop('disabled', false);
            $("#start_date").val('');
            $("#expiry_date").val('');
            $("#type_training").val('');
            $("#title_training").val('');
            $("#duration_training").val('');
            $("#person_training").val('');
            $("#dept").val('');
            $("#status").val('').select2();
            $("#sem").val('').select2();
            $("#ay").val('').select2();
            $("#batch").val('').select2();
            $("#degree").val('').select2();
            $("#sec").val('').select2();
            $("#course").val('').select2();
            $('#days').val('')
            $("#loading_div").hide();
            $(".training").hide();
            $(".dept").hide();
            $("#save_btn").html(`Save`);
            $("#save_div").show();
            $(".type").show();
            $("#scheduleFeedbackModel").modal();
        }



        function getDays(e) {
            let start_date = new Date($('#start_date').val());
            let expiry = new Date($('#expiry_date').val());
            let diffInTime = expiry.getTime() - start_date.getTime();
            let diffInDays = Math.ceil(diffInTime / (1000 * 3600 * 24));
            if (diffInDays) {
                $('#days').val(diffInDays + ' Days')
            }
        }

        $('#degree').change(function() {
            let course = $('#course').html(`<option value="">Loading...</option>`)
            $.ajax({
                url: '{{ route('admin.schedule-feedback.fetch_course') }}',
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'id': $('#degree').val(),
                },
                success: function(response) {
                    let status = response.status;
                    let data = response.data;
                    if (status == true) {
                        course = $('#course').empty()
                        course.prepend(
                            `<option value="All">All</option>`)
                        $.each(data, function(index, value) {
                            course.append(
                                `<option value="${index}">${value}</option>`)
                        })
                    } else {
                        Swal.fire('', response.data, 'error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.status) {
                        if (jqXHR.status == 500) {
                            Swal.fire('', 'Request Timeout / Internal Server Error', 'error');
                        } else {
                            Swal.fire('', jqXHR.status, 'error');
                        }
                    } else if (textStatus) {
                        Swal.fire('', textStatus, 'error');
                    } else {
                        Swal.fire('', 'Request Failed With Status: ' + jqXHR.statusText,
                            "error");
                    }
                    $("#save_div").show();
                    $("#loading_div").hide();
                }
            })
        })


        function saveFeedback() {
            if ($('#feedback').val() == '') {
                $("#feedback_span").html(`Fees Components Is Required.`);
                $("#feedback_span").show();
                $("#participant_span").hide();
                $("#expiry_date_span").hide();
                $("#start_date_span").hide();
            } else if ($('#participant').val() == '') {
                $("#participant_span").html(`Participant Is Required.`);
                $("#participant_span").show();
                $("#feedback_span").hide();
                $("#expiry_date_span").hide();
                $("#start_date_span").hide();
            } else if ($('#start_date').val() == '') {
                $("#start_date_span").html(`Start Date Is Required.`);
                $("#start_date_span").show();
                $("#feedback_span").hide();
                $("#expiry_date_span").hide();
                $("#participant_span").hide();
            } else if ($('#expiry_date').val() == '') {
                $("#expiry_date_span").html(`Expiry Date Is Required.`);
                $("#expiry_date_span").show();
                $("#participant_span").hide();
                $("#start_date_span").hide();
                $("#feedback_span").hide();
            } else {
                $("#save_div").hide();
                $("#loading_div").show();
                $.ajax({
                    url: '{{ route('admin.schedule-feedback.store') }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': $('#feedback_id').val(),
                        'name': $('#feedback').val(),
                        'participant': $('#participant').val(),
                        'type': $('#type').val(),
                        'type_training': $('#type_training').val(),
                        'title_training': $('#title_training').val(),
                        'duration_training': $('#duration_training').val(),
                        'person_training': $('#person_training').val(),
                        'start': $('#start_date').val(),
                        'expiry': $('#expiry_date').val(),
                        'status': $('#status').val(),
                        'degree': $('#degree').val(),
                        'course': $('#course').val(),
                        'batch': $('#batch').val(),
                        'ay': $('#ay').val(),
                        'sem': $('#sem').val(),
                        'sec': $('#sec').val(),
                        'dept': $('#dept').val(),
                    },
                    success: function(response) {
                        let status = response.status;
                        if (status == true) {
                            Swal.fire('', response.data, 'success');
                        } else {
                            Swal.fire('', response.data, 'error');
                        }
                        $("#scheduleFeedbackModel").modal('hide');
                        $("#save_div").show();
                        $("#loading_div").hide();
                        callAjax();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status) {
                            if (jqXHR.status == 500) {
                                Swal.fire('', 'Request Timeout / Internal Server Error', 'error');
                            } else {
                                Swal.fire('', jqXHR.status, 'error');
                            }
                        } else if (textStatus) {
                            Swal.fire('', textStatus, 'error');
                        } else {
                            Swal.fire('', 'Request Failed With Status: ' + jqXHR.statusText,
                                "error");
                        }
                        $("#save_div").show();
                        $("#loading_div").hide();
                    }
                })
            }
        }

        function viewfeedback(id) {
            if (id == undefined) {
                Swal.fire('', 'ID Not Found', 'warning');
            } else {
                $('.secondLoader').show()
                $.ajax({
                    url: "{{ route('admin.schedule-feedback.view') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('.secondLoader').hide()
                        let status = response.status;
                        if (status == true) {
                            var data = response.data;
                            $("#feedback_id").val(data.id);
                            $("#feedback").val(data.feedback_id).select2();
                            $("#participant").val(data.feedback_participant).select2();
                            $("#participant").prop('disabled', true);
                            // console.log(data.feedback_type);
                            if (data.feedback_type == 'Training' && data.feedback_type != null) {
                                let training_details = JSON.parse(data.training);
                                $("#type").val(data.feedback_type).select2();
                                $("#duration_training").val(training_details.duration_training);
                                $("#person_training").val(training_details.person_training);
                                $("#title_training").val(training_details.title_training);
                                $("#type_training").val(training_details.type_training).select2();

                                $(".training").show();
                                $(".type").show();
                                $(".dept").hide();
                                $(".filter").show();

                            } else if (data.feedback_type == 'Course' && data.feedback_type != null) {

                                $("#type").val(data.feedback_type).select2();
                                $(".type").show();
                                $(".training").hide();
                                $(".dept").hide();
                                $(".filter").show();

                            } else if (data.feedback_type == 'Faculty' && data.feedback_type != null) {
                                $("#type").val(data.feedback_type).select2();
                                $(".dept").show();
                                $(".type").show();
                                $(".training").hide();
                                $(".filter").hide();

                            } else {
                                $(".type").hide();
                                $(".dept").hide();
                                $(".training").hide();
                                $(".filter").hide();

                            }

                            if (data.feedback_participant != 'External') {
                                $("#degree").val(data.degree_id).select2();
                                $("#batch").val(data.batch_id).select2();
                                $("#sem").val(data.semester).select2();
                                $("#ay").val(data.academic_id).select2();
                                $("#sec").val(data.section).select2();
                                $("#course").val('');
                                let decode = JSON.parse(data.course_id)
                                console.log(decode);
                                $.each(decode, function(index, value) {
                                    $("#course option[value='" + value + "']").prop("selected", true);
                                })

                                let dept = JSON.parse(data.department_id)
                                $.each(dept, function(id, val) {
                                    $("#dept option[value='" + val + "']").prop("selected", true);
                                })
                                $("#course").select2();
                                $("#dept").select2();
                            }

                            $("#expiry_date").val(data.expiry_date);
                            $("#start_date").val(data.start_date);
                            $("#status").val(data.status).select2();
                            getDays(data.expiry_date)
                            $('.tbl').show();
                            $('.questions').hide();
                            $('.buttons').hide();
                            $("#save_div").hide();
                            $("#fee_components_span").hide();
                            $("#loading_div").hide();
                            $("#scheduleFeedbackModel").modal();
                        } else {
                            Swal.fire('', response.data, 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status) {
                            if (jqXHR.status == 500) {
                                Swal.fire('', 'Request Timeout / Internal Server Error', 'error');
                            } else {
                                Swal.fire('', jqXHR.status, 'error');
                            }
                        } else if (textStatus) {
                            Swal.fire('', textStatus, 'error');
                        } else {
                            Swal.fire('', 'Request Failed With Status: ' + jqXHR.statusText,
                                "error");
                        }
                    }
                })
            }
        }

        function editfeedback(id) {
            if (id == undefined) {
                Swal.fire('', 'ID Not Found', 'warning');
            } else {
                $('.secondLoader').show()
                $.ajax({
                    url: "{{ route('admin.schedule-feedback.edit') }}",
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id
                    },
                    success: function(response) {
                        $('.secondLoader').hide()
                        let status = response.status;
                        if (status == true) {
                            var data = response.data;
                            $("#feedback_id").val(data.id);
                            $("#feedback").val(data.feedback_id).select2();
                            $("#participant").val(data.feedback_participant).select2();
                            $("#participant").prop('disabled', true);
                            // console.log(data.feedback_type);
                            if (data.feedback_type == 'Training' && data.feedback_type != null) {
                                let training_details = JSON.parse(data.training);
                                $("#type").val(data.feedback_type).select2();
                                $("#duration_training").val(training_details.duration_training);
                                $("#person_training").val(training_details.person_training);
                                $("#title_training").val(training_details.title_training);
                                $("#type_training").val(training_details.type_training).select2();

                                $(".training").show();
                                $(".type").show();
                                $(".dept").hide();
                                $(".filter").show();

                            } else if (data.feedback_type == 'Course' && data.feedback_type != null) {

                                $("#type").val(data.feedback_type).select2();
                                $(".type").show();
                                $(".training").hide();
                                $(".dept").hide();
                                $(".filter").show();

                            } else if (data.feedback_type == 'Faculty' && data.feedback_type != null) {
                                $("#type").val(data.feedback_type).select2();
                                $(".dept").show();
                                $(".type").show();
                                $(".training").hide();
                                $(".filter").hide();

                            } else {
                                $(".type").hide();
                                $(".dept").hide();
                                $(".training").hide();
                                $(".filter").hide();

                            }

                            if (data.feedback_participant != 'External') {
                                $("#degree").val(data.degree_id).select2();
                                $("#batch").val(data.batch_id).select2();
                                $("#sem").val(data.semester).select2();
                                $("#ay").val(data.academic_id).select2();
                                $("#sec").val(data.section).select2();
                                $("#course").val('');
                                let decode = JSON.parse(data.course_id)
                                console.log(decode);
                                $.each(decode, function(index, value) {
                                    $("#course option[value='" + value + "']").prop("selected", true);
                                })

                                let dept = JSON.parse(data.department_id)
                                $.each(dept, function(id, val) {
                                    $("#dept option[value='" + val + "']").prop("selected", true);
                                })
                                $("#course").select2();
                                $("#dept").select2();
                            }

                            $("#expiry_date").val(data.expiry_date);
                            $("#start_date").val(data.start_date);
                            $("#status").val(data.status).select2();
                            getDays(data.expiry_date)
                            $('.tbl').hide()
                            $('.questions').show()
                            $('.buttons').show()
                            $("#save_div").show();
                            $("#save_btn").html(`Update`);
                            $("#fee_components_span").hide();
                            $("#loading_div").hide();
                            $("#scheduleFeedbackModel").modal();
                        } else {
                            Swal.fire('', response.data, 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        if (jqXHR.status) {
                            if (jqXHR.status == 500) {
                                Swal.fire('', 'Request Timeout / Internal Server Error', 'error');
                            } else {
                                Swal.fire('', jqXHR.status, 'error');
                            }
                        } else if (textStatus) {
                            Swal.fire('', textStatus, 'error');
                        } else {
                            Swal.fire('', 'Request Failed With Status: ' + jqXHR.statusText,
                                "error");
                        }
                    }
                })
            }
        }

        function deletefeedback(id) {
            if (id == undefined) {
                Swal.fire('', 'ID Not Found', 'warning');
            } else {
                Swal.fire({
                    title: "Are You Sure?",
                    text: "Do You Really Want To Delete !",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    reverseButtons: true
                }).then(function(result) {
                    if (result.value) {
                        $('.secondLoader').show()
                        $.ajax({
                            url: "{{ route('admin.schedule-feedback.delete') }}",
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            data: {
                                'id': id
                            },
                            success: function(response) {
                                $('.secondLoader').hide()
                                Swal.fire('', response.data, response.status);
                                callAjax();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                if (jqXHR.status) {
                                    if (jqXHR.status == 500) {
                                        Swal.fire('', 'Request Timeout / Internal Server Error',
                                            'error');
                                    } else {
                                        Swal.fire('', jqXHR.status, 'error');
                                    }
                                } else if (textStatus) {
                                    Swal.fire('', textStatus, 'error');
                                } else {
                                    Swal.fire('', 'Request Failed With Status: ' + jqXHR.statusText,
                                        "error");
                                }
                            }
                        })
                    }
                })
            }
        }
    </script>
@endsection

@extends('layouts.header')
@section('content')
    <style>
        body {
            font-family: Arial;
        }

        .previous {
            display: none;
        }
    </style>

    <h2 class="heads">Upload
        <span class="ui_close_btn">
            <a href="{{url($pageMethod)}}" class="collapse-close pull-right btn-danger"></a>
        </span>
    </h2>

    <div class="ajaxLoading"></div>
    <div class="card">

        <div class="card-body card-block">
            <form method="post" action="" id="uploadform" class="uploadform" enctype="multipart/form-data">
                {{ csrf_field() }}

                <div class="row upload_data">
                    <div class="col-md-12">
                        <div class="col-md-5">


                            <div class="form-group row">
                                <label for="assigned_to" class="form-control-label col-md-4"><span style="color: red;"> *
                                    </span>Module</label>
                                <div class="col-md-4" style="pointer-events:none;">
                                    <select class="form-control module_name select2" id="module_name" name="module_name">
                                        {!! $module_name !!}
                                    </select>
                                </div>
                                <div class="col-md-2 showinline dwnld">
                                    <span class="showspan"> <i class="fa fa-download download1"></i></span><a
                                        class="download_csv_n2"></a>
                                </div>

                            </div>





                            <h4><b>Upload a File:</b></h4></br>
                            <input type="file" name="upload_file" class="upload" id="file_upload" required>

                            <br>
                            <div class="import_option">
                                <b>Import Option:</b></br>
                                </br>
                                <input type="radio" name="read_option" value="skip" checked> Skip </br></br>
                                <input type="radio" name="read_option" value="overwrite"> Overwrite </br></br>
                                <input type="radio" name="read_option" value="clone" class="clone"> Clone </br></br>
                                <!-- <input type="radio" name="read_option" value="novalidate" class="novalidate"> No Validate </br></br> -->
                            </div>
                            <br>
                            <div class="duplication_div">

                                <b>Find duplicates with:</b></br></br>
                                <div class="col-md-4">
                                    <select multiple id="find_duplicate" name="find_duplicate[]"
                                        class="select2 find_duplicate">
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">

                            @if($pageMethod != "ticketgenerateupload")
                                <h4>Supported File Format:</h4>
                                <ul>
                                    <li>You can import using <b>.csv</b> file format</li>
                                </ul>
                                <h4>Maximum Limits:</h4>
                                <ul>
                                    <li>Maximum <b>1000 rows</b> can be imported.Others will be skipped</li>
                                </ul>
                                <h4>Important Notes:</h4>
                                <ul>
                                    <li>File size cannot exceed <b>5 MB</b></li>
                                    <li>All duplicate records will be ignored when importing.</li>
                                    <li>Checkbox value should be<b> 1</b> or <b>0</b>.</li>
                                    <li>Dates must be in the format <b>YYYY-MM-DD</b>. Records that use other date formats will
                                        be ignored.
                                    </li>
                                    <li>Date Time must be in the format <b>YYYY-MM-DD H:i:s</b>. Records that use other date
                                        formats will be
                                        ignored.</li>
                                    <li>By default, the character encoding is UTF-8 (Unicode). Make sure you provide the correct
                                        character
                                        encoding if your import file has special characters.</li>
                                    <li>We recommend doing a test import with a sample file before importing your actual data.
                                    </li>
                                </ul>
                                <h4>Find Duplicate:</h4>

                                <ul>
                                    <li> <b>Skip</b> -Skips the rows which already exists. Other rows will be inserted.</li>
                                    <li><b>Overwrite</b> - Overwrite the existing records, if anything exists.</li>
                                    <li><b>Clone</b> - Create duplicate records, even though already exists.</li>
                                </ul>

                            @else

                                <h4>Validation Rules for Ticket Upload:</h4>


                                <h5><b>Field Validation Rules:</b></h5>
                                <ul>
                                    <li><b>Department:</b> Must match existing Department Name in master table (Required)</li>
                                    <li><b>Machine:</b> Must match existing Machine No in master table (Required)</li>
                                    <li><b>Breakdown Type:</b> Must match existing breakdown type in master table (Required)
                                    </li>
                                    <li><b>Issue Date:</b> Must be in format <b>d-m-y H:i</b> e.g. 15-01-26 10:30 (Required)
                                    </li>
                                    <li><b>Breakdown Severity:</b> Text field describing the breakdown severity</li>
                                    <li><b>Causes of Breakdown:</b> Text field describing breakdown causes</li>
                                    <li><b>Maintenance Type:</b> Value should be <b>Machine</b> or <b>Facility</b></li>
                                    <li><b>Shift:</b> Shift during which breakdown occurred</li>
                                    <li><b>Issue Created By:</b> Employee who reported the issue</li>
                                    <li><b>Priority Option:</b> Value should be <b>Low</b>, <b>Medium</b>, <b>High</b>, or
                                        <b>Critical/Emergency</b> (Defaults to "Low")
                                    </li>
                                    <li><b>Technician:</b> <b>All technicians from technician department will be
                                            auto-assigned</b></li>
                                    <li><b>Repair Start Date:</b> Must be in format <b>d-m-y H:i</b> (Repair start date)</li>
                                    <li><b>Repair End Date:</b> Must be in format <b>d-m-y H:i</b> (Repair end/closure date)
                                    </li>
                                    <li><b>Request Remarks:</b> Text field (Optional)</li>
                                    <li><b>Preventive Action:</b> Text field - Required for CLOSED status</li>
                                    <li><b>Corrective Action:</b> Text field - Required for CLOSED status</li>
                                    <li><b>Approve Remarks:</b> Text field (Optional)</li>
                                    <li><b>Critical Spares Used:</b> Value should be <b>Yes</b>, <b>No</b>, or <b>Other</b>
                                        <ul>
                                            <li><b>Yes:</b> Spare Name and Quantity become <b>mandatory</b></li>
                                            <li><b>No:</b> No additional fields required</li>
                                            <li><b>Other:</b> Other Spares column becomes <b>mandatory</b></li>
                                        </ul>
                                    </li>
                                    <li><b>Other Spares:</b> Text field (Required if Critical Spares Used = Other)</li>
                                    <li><b>Spare Name:</b> Must match spare name in spares master table (Required if Critical
                                        Spares Used = Yes)</li>
                                    <li><b>Quantity:</b> Numeric value for spare quantity (Required if Critical Spares Used =
                                        Yes)</li>
                                </ul>

                                <h5><b>Status Determination:</b></h5>
                                <ul>
                                    <li><b>CLOSED:</b> Set when <b>Repair End Date</b>, <b>Corrective Action</b>, and
                                        <b>Preventive Action</b> are all provided
                                    </li>
                                    <li><b>INITIATED:</b> Set when any closure fields are missing</li>
                                </ul>

                                <h5><b>Important Notes:</b></h5>
                                <ul>
                                    <li>Department, Machine, and Breakdown Type must match existing master data or record will
                                        be skipped</li>
                                    <li>Technicians are auto-assigned if not specified in CSV</li>
                                    <li>Spare stock is automatically deducted when Critical Spares Used is "Yes"</li>
                                    <li>Test import with a sample file before importing actual data</li>
                                </ul>

                            @endif
                        </div>

                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <!--<button type="button" name="next" id="next" class="btn btn-primary btn-sm saveform"><i class="fa  fa-save "></i>  Map Fields </button>                              -->
                            </div>
                            <div class="col-md-6 text-center">

                                <button type="button" class="btn btn-info previous tab_change" value="previous">
                                    < Prev</button>
                                        <button type="button" name="next" id="next"
                                            class="btn btn-info next tab_change saveform" value="next"> Next ></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class='row mapping_data'></div>
                <input type='hidden' name='stage' class='stage'>

            </form>

        </div>

    </div>
    <!--Deepika purpose Upload Details model-->
    <div class="modal fade" id="uploaddetailsModal">
        <div class="modal-dialog" style="width:40%">
            <div class="modal-content">
                <!--Moda Header-->
                <div class="modal-header">
                    <h4 class="modal-title"> Upload Details </h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body uploaddetail text-center">
                    <table class="center">
                        <tbody>
                            <tr>
                                <th>Total Records</th>
                                <td>:</td>
                                <td width="50%"><span class="totrec"></span></td>
                            </tr>
                            <tr>
                                <th>Skip</th>
                                <td>:</td>
                                <td width="50%"><span class="skip"></span></td>
                            </tr>
                            <tr>
                                <th>Overwrite</th>
                                <td>:</td>
                                <td width="50%"><span class="overwr"></span></td>
                            </tr>
                            <tr>
                                <th>Clone</th>
                                <td>:</td>
                                <td width="50%"><span class="cln"></span></td>
                            </tr>
                            <tr>
                                <th>New</th>
                                <td>:</td>
                                <td width="50%"><span class="newdata"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div style="text-align:center;"> <span class="showspan"> <i class="fa fa-download download1"></i><a download
                            href="{{asset('uploads/upload_log.csv')}}"> Download Report</a></span> </div>

                <div class="modal-footer">
                </div>
            </div>


        </div>
    </div>
    <style>
        table.center {
            margin-left: auto;
            margin-right: auto;
        }
    </style>
    <!--end-->
    <script>
        $(document).ready(function () {
            $(".import_option").hide();
            $(".duplication_div").hide();
            $("#next").hide();
            $("#file_upload").on("click", function () {

                var isclone = $('input:radio[name=read_option]:checked').val();
                $(".import_option").show();
                $(".duplication_div").show();
                $("#next").show();

            });
            $("#next").on("click", function () {
                $(".stage").val(1);
            });

            $(document).on('click', '.upload', function () {
                $(".stage").val(2);
            });


            $('input[type="file"]').change(function (e) {
                var filename = e.target.files[0].name;
                var size = e.target.files[0].size;
                var extension = filename.substr((filename.lastIndexOf('.') + 1));
                console.log(size);
                if (extension != "csv") {
                    notyMsg("info", "Please select CSV file");
                    $("#file_upload").val('');
                } else {
                    if (size > 5e+6) {
                        notyMsg("info", "Please select CSV file with 5MB");
                        $("#file_upload").val('');
                    }
                }
            });
            $('.module_name').change(function () {
                var moduleid = $('.module_name').select2('val');
                var condition = " config_hdr_id=" + moduleid + " and `show`='Yes'";
                $('.find_duplicate').jCombo(
                    "{{ URL::to('jcomboformcomp?table=c_config_lines_t:field:title')}}&parent=" +
                    condition, {
                    selected_value: ""
                });
            });
            var moduleid = $('.module_name').select2('val');
            var condition = " config_hdr_id=" + moduleid + " and `show`='Yes'";
            $('.find_duplicate').jCombo("{{ URL::to('jcomboformcomp?table=c_config_lines_t:field:title')}}&parent=" +
                condition, {
                selected_value: ""
            });

            $(document).on('click', '.saveform', function () {


                var urls = "{{ URL::to('uploadconfigsave')}}";

                validationrule('uploadform');

                var form = $('#uploadform');
                form.parsley().validate();


                var form_data = new FormData(document.getElementById('uploadform'));
                $('.ajaxLoading').show();
                $.ajax({
                    url: "{{ URL::to('uploadconfigsave') }}",
                    type: "POST",
                    data: form_data,
                    enctype: 'multipart/form-data',
                    processData: false,
                    /*tell jQuery not to process the data*/
                    contentType: false,
                    /*tell jQuery not to set contentType*/
                    async: true,
                    xhr: function () {
                        var xhr = $.ajaxSettings.xhr();
                        if (xhr.upload) {
                            xhr.upload.addEventListener('progress', function (event) {
                                var percent = 0;
                                var position = event.loaded || event.position;
                                var total = event.total;
                                if (event.lengthComputable) {
                                    percent = Math.ceil(position / total * 100);
                                }
                            }, true);
                        }
                        return xhr;

                    }
                }).done(function (data, status) {
                    // console.log(data);
                    $('.ajaxLoading').hide();
                    if (data.status == 'mapping') {
                        $(".upload_data").hide();
                        $(".mapping_data").html(data.table_fields);
                        $('.previous').show();
                        $.each(data.filesop, function (index, val) {
                            $(".field" + index).val(val.position)
                        })
                    } else if (data.status == "Success") {
                        $(".upload_data").hide();
                        $(".mapping_data").hide();
                        $("#uploaddetailsModal").modal('show');
                        $('#uploaddetailsModal').on('shown.bs.modal', function () {
                            $('.totrec').append(data.totalrecords);
                            $('.skip').append(data.skip);
                            $('.newdata').append(data.new);
                            $('.cln').append(data.clone);
                            $('.overwr').append(data.overwrite);
                        });
                    }
                    console.log(data);
                }).fail(function (data, status) {
                    $(".alert-success").hide();
                    $(".alert-danger").fadeIn(800);

                });




            });

            $('.tab_change').click(function () {
                var val = $(this).val();
                if (val == 'previous') {
                    $(".upload_data").show();
                    $(".mapping_data").hide();
                }

            });

            $('.download1').click(function () {
                var modulename = $('.module_name option:selected').text();
                var moduleid = $('.module_name').select2('val');
                if (moduleid != "") {
                    var form_data = new FormData();
                    $.ajax({
                        url: "{{URL::to('downloadtemplate')}}/" + moduleid,
                        contentType: false,
                        processData: false,
                        type: 'get',
                        success: function (data) {
                            console.log(data['status']);
                            if (data['status'] == 1) {
                                $('.ajaxLoading').hide();
                                var file_name = modulename + ' TEMPLATE.csv';
                                $('.download_csv_n2').attr('download', file_name);
                                $('.download_csv_n2').attr('href', 'uploads/' + file_name);

                                $('.download_csv_n2')[0].click();
                            }


                        }

                    });
                    $('.ajaxLoading').hide();
                    return true;
                } else {
                    notyMsg("info", "Please Select Module Name");
                }

                return false;

            });

        });
    </script>
    @include('layouts.php_js_validation')
@endsection
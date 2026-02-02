@extends('layouts.header')
@section('content')

<h2 class="heads">Department</h2>

<div class="card">


    <div class="card-body card-block">

        <form action="" id="save">
            <input type="hidden" name="edit_id" value="" id="edit_id" />
            {{ csrf_field()}}
            <div class="row">
                <div class="col-md-6">
                    <div class=" form-group row">
                        <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Department Name</label>
                        <div class="col-md-7">

                            <input type="text" id="department_name" name="department_name" class="form-control department_name" value="" required style="width:100%;" tabindex="1">
                        </div>
                        <div>
                            <span class="btn btn-danger dup_name" style="display:none;"></span>
                        </div>
                    </div>

                </div>

                <div class="col-md-6">



                    <div class="form-group row">
                        <label for="active" class="form-control-label col-md-5 ">Department No</label>
                        <div class="col-md-7">
                            <input type="text" id="department_no" name="department_no" maxlength="10" class="form-control department_no">
                        </div>
                    </div>


                </div>
                <div class="col-md-6">



                    <div class="form-group row">
                        <label for="active" class="form-control-label col-md-5 "><span style="color:red;">*</span>Is Technicaian?</label>
                        <div class="col-md-7">
                            <!-- <input type="text" id="department_no" name="department_no" maxlength="10" class="form-control department_no"  > -->
                            <select name='is_technician' rows='5' class='form-control select2 is_technician' id="is_technician" required>
                                <option value="">--Please Select--</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>


                </div>
                <div class="col-md-6">


                    <div class="form-group row">
                        <label for="active" class="form-control-label col-md-5">Description</label>
                        <div class="col-md-7">

                            <textarea name="description" id="description" class="form-control"> </textarea>
                        </div>
                    </div>



                </div>

            </div>
            <div class="row text-center">
                <a href="{{url('departmentupload')}}"><button type="button" class="btn upload  upload-image" tabindex="5">Upload</button></a>
                <button type="button" class="btn save saveform" tabindex="5">Save</button>
                <?php include('toolbar.php'); ?>
            </div>

        </form>



        <div class="row">
            <div class="col-md-12" style="padding:15px;">
                <table id="grid1"></table>
            </div>
        </div>
    </div>
</div>

<script>
    var dup_chk = true;

    function duplicate_validate() {
        var department_name = $(".department_name").val();
        var edit_id = $("#department_id").val();
        $.ajax({
            cache: false,
            url: 'departmentnamechk',
            type: 'GET',
            dataType: 'json',
            async: false,
            data: {
                department_name: department_name,
                edit_id: edit_id
            },
            success: function(response) {
                if (response == 1) {
                    $('.dup_name').html('Department Name:' + department_name + ' Already Exists');
                    $('.dup_name').show();

                    $(".department_name").val('');
                    dup_chk = false;
                } else if (response == 0) {
                    var html = "";
                    $('.dup_name').hide();
                    dup_chk = true;
                }
            },
            error: function(xhr, resp, text) {
                console.log(xhr, resp, text);
            }
        });
    }
    /*End*/


    $(document).ready(function() {


        $("#grid1").jqGrid({
            url: "departmentgrid",
            datatype: "json",
            mtype: "GET",
            colModel: [{
                    name: "department_id",
                    label: "department_id",
                    width: 250,
                    hidden: true
                },
                {
                    name: "department_name",
                    label: "Department Name",
                    width: 250,
                    editable: true
                },
                {
                    name: "department_no",
                    label: "Department No",
                    width: 250,
                    editable: true
                },
                {
                    name: "is_technician",
                    label: "Is Technician?",
                    width: 250,
                    editable: true
                },
                {
                    name: "description",
                    label: "Description",
                    width: 250,
                    editable: true
                },

            ],

            iconSet: "fontAwesome",
            rowNum: 10,
            rowList: [10, 20, 50, 100, 250, 500, 1000, 2000],
            sortname: "department_id",
            sortorder: "desc",
            viewrecords: true,
            gridview: true,
            rownumbers: true,
            pager: "#grid1",
            multiselect: false,
            multipageselection: true,
            searching: {
                defaultSearch: "cn",
            },
        });
        jQuery("#grid1").jqGrid('filterToolbar', {
            stringResult: true,
            searchOnEnter: false
        });
        showcolumn('grid1');


        $(document).on('click', ".exportpdf", function() {
            $("#grid1").jqGrid('exportToPdf', {
                title: null,
                orientation: 'portrait',
                pageSize: 'A4',
                description: null,
                onBeforeExport: null,
                download: 'download',
                includeLabels: true,
                includeGroupHeader: true,
                includeFooter: true,
                fileName: "Department.pdf",
                mimetype: "application/pdf"
            });
        });
        /*Karthigaa Purpose For Excel Download*/
        $(document).on('click', ".exportexcel", function() {
            $("#grid1").jqGrid("exportToExcel", {
                includeLabels: true,
                includeGroupHeader: true,
                includeFooter: true,
                fileName: "Department.xlsx"
            })
        });


        $(".clearsearch").click(function() {
            var grid = $("#grid1");
            grid.jqGrid('setGridParam', {
                search: false
            });
            var postData = grid.jqGrid('getGridParam', 'postData');
            $.extend(postData, {
                filters: ""
            });
            grid.trigger("reloadGrid", [{
                page: 1
            }]);
            $('input[id*="gs_"]').val("");

        });
        /* end */

        $(document).on('click', '.saveform', function() {

            var formData = $('#save').serialize();
            $.ajax({
                url: "{{ url('department/save') }}",
                type: 'post',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response == 1) {
                        notyMsg("success", "Saved Successfullly");
                        $("#grid1")[0].triggerToolbar();
                        $('#edit_id').val('');
                        $('#department_name').val('');
                        $('.department_no').val('');
                        $('#description').val('');
                    } else {
                        notyMsg("success", "Updated Successfullly");
                        $("#grid1")[0].triggerToolbar();
                        $('#edit_id').val('');
                        $('#department_name').val('');
                        $('.department_no').val('');
                        $('#description').val('');
                    }
                },
                error: function(response) {
                    //  console.log(response);
                    var errors = response.responseJSON.errors;

                    var errorsHtml = '';

                    $.each(errors, function(key, value) {
                        errorsHtml += '<p>' + value[0] + '</p>';
                    });
                    // errorsHtml += '</ul></div';
                    notyMsg("error", errorsHtml);
                    //  $('.messages').html(errorsHtml);
                }
            });
        });

        $("#editdata").click(function() {
            var gr = jQuery("#grid1").jqGrid('getGridParam', 'selrow');
            var department_id = jQuery("#grid1").jqGrid('getCell', gr, 'department_id');
            var department_name = jQuery("#grid1").jqGrid('getCell', gr, 'department_name');
            var department_no = jQuery("#grid1").jqGrid('getCell', gr, 'department_no');
            var description = jQuery("#grid1").jqGrid('getCell', gr, 'description');
            var is_technician = jQuery("#grid1").jqGrid('getCell', gr, 'is_technician');
            if (department_id) {
                $('#edit_id').val(department_id);
                $('#department_id').val(department_id);
                $('#description').val(description);
                $('#department_name').val(department_name);
                $('#department_no').val(department_no);
                $('#is_technician').select2('val', [is_technician]);

            } else {
                notyMsg('INFO', 'Please Select a Row');
            }
        });

        $(".department_name").keyup(function() {
            $(this).val($(this).val().toUpperCase());
        });

        /* Purpose For Delete Function*/
        $('.del').click(function() {
            // alert("dfhgfd");
            var gr = jQuery("#grid1").jqGrid('getGridParam', 'selrow');
            var id = jQuery("#grid1").jqGrid('getCell', gr, 'department_id');
            if (gr) {
                swal({
                    title: "Are you sure?",
                    text: "You want to delete!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnCancel: !1
                }, function(e) {
                    if (e == true) {
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.post("{{url('departmentdelete')}}", {
                            id: id
                        }, function(data) {
                            if (data == 1) {
                                notyMsg("success", "Deleted successfully");
                                setTimeout(function() {
                                    location.reload();
                                }, 300);
                            }else{
                                notyMsgs('info', "You Can't delete  Used in SomeWhere");
                                $('.clearsearch').trigger('click');
                                setTimeout(function() {
                                    $("#grid1")[0].triggerToolbar();
                                }, 1500);
                            }
                        });
                    } else {
                        $('.apply').css('display', 'none');
                        $('.clearsearch').trigger('click');
                        swal("Cancelled");
                    }
                });
                $('.apply').css('display', 'none');
            } else {
                notyMsg("info", "Please Select a Row");
            }
        });
        /*End*/


        // $(document).on('click','.del',function(e){
        //         e.preventDefault();
        //         var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
        //         var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'department_id');
        //         if(cellValue)
        //         {
        //             swal({
        //                 title: 'Are you sure?',
        //                 text: "You won't be able to revert this!",
        //                 type: 'warning',
        //                 showCancelButton: !0,
        //                 confirmButtonColor: '#DD6B55',
        //                 confirmButtonText: 'Yes',
        //                 cancelButtonText: 'No',
        //             }, function(e) {
        //                var red_url     ="{{ url('department') }}";
        //                  if(e == true)
        //                  {
        //                      $.get('departmentdelete?del_id='+cellValue, function(data,status)
        //                     {
        //                         var data = $.trim(data);
        //                         if(data =='0')
        //                         {
        //                             notyMsg('success','Deleted Successfully',red_url);

        //                             setTimeout(function(){
        //                                  var red_url     ="{{ url('department') }}";
        //                             window.location.href=red_url;

        //                             }, 100);
        //                         }
        //                         if(data =='1')
        //                         {
        //                             notyMsg('error',"You Cant't delete  Used in SomeWhere");
        //                              $('.clearsearch').trigger('click');
        //                             setTimeout(function(){
        //                             $("#grid1")[0].triggerToolbar();
        //                             }, 1500);
        //                         }
        //                     });
        //                 }
        //                 else{
        //                   $('.apply').css('display','none');
        //                    $('.clearsearch').trigger('click');
        //                   swal("Cancelled");
        //                 }
        //             })
        //              $('.apply').css('display','none');
        //         }
        //         else
        //         {
        //             notyMsg('info',"Please Select a Row");
        //         }
        //    });




        $('.reset').click(function() {

            $('#department_id').val('');
            $('#department_name').val('');
            $('.department_no').val('');
            $('#description').val('');
            $('#is_technician').select2('val', ['']);

        });




    });
</script>
@endsection
@extends('layouts.header')
@section('content')

<style type="text/css">

</style>

<form id="create-user" action="{{URL::to('createuser')}}" method="POST" style="display: none;">
  {{ csrf_field() }}
  <input type='hidden' name='id' value='0' id='id' class='id'>

</form>


<form id="view-user" action="{{URL::to('userviews')}}" method="POST" style="display: none;">
  {{ csrf_field() }}
  <input type='hidden' name='id' value='0' id='id' class='id'>

</form>


<form id="block-unblock" action="{{URL::to('blockunblockuser')}}" method="POST" style="display: none;">
  {{ csrf_field() }}
  <input type='hidden' name='id' value='0' id='id' class='id'>

</form>






<div id="accordion">
  <div class="panel-heading" role="tab" id="headingOne">

    <h4 class="panel-title">
      <a role="button">

        User
      </a>
    </h4>


  </div>

</div>



<div class="panel panel-visible" id="spy1">


  <div class="panel-title">
    <div class="row">
      <div class="col-md-12">
        <a href="{{url('userupload')}}"><button type="button" class="btn upload  upload-image" tabindex="5">Upload</button></a>
        <?php include('toolbar.php'); ?>
        <!--a> <button type="button" class="btn add Delete" >Delete</button></a-->
        <!-- <a id="clearsearch"><button type="button" class="btn clearsearch">Clear Search</button></a> -->
      </div>
    </div>
  </div>


  <div class="row">
    <div class="col-md-12">
      <hr class="xlg">
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">

      <table id="grid1"></table>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <hr class="xlg">
    </div>
  </div>


</div>

<script type="text/javascript">
  $(document).ready(function() {


    $("#grid1").jqGrid({
      url: "{{URL::to('userData')}}",
      mtype: 'GET',
      datatype: 'json',

      colModel: [{
          name: "id",
          label: "S.NO",
          hidden: true
        },
        {
          name: "user_id",
          label: "User Name",
          hidden: true
        },
        {
          name: "username",
          label: "User Name"
        },
        {
          name: "email",
          label: "Email"
        },
        {
          name: "mobile_no",
          label: "Mobile No",
          editable: true,
          editrules: {
            date: true
          }
        },
        {
          name: "group_name",
          label: "Group Name",
          editable: true,
          editrules: {
            date: true
          }
        },
        {
          name: "department_name",
          label: "Department Name",
          editable: true,
          editrules: {
            date: true
          }
        },
        {
          name: "designation_name",
          label: "Designation Name",
          editable: true,
          editrules: {
            date: true
          }
        },
        {
          name: "location_name",
          label: "Location Name",
          editable: true,
          editrules: {
            date: true
          }
        },
        {
          name: "block_unblock",
          label: "Block / Unblock",
          editable: true,
          editrules: {
            date: true
          }
        },

      ],
      iconSet: "fontAwesome",
      rowNum: 10,
      rowList: [10, 20, 50, 100, 250, 500, 1000],
      sortorder: "desc",
      viewrecords: true,
      gridview: true,
      rownumbers: true,
      pager: "#grid1",
      autowidth: true,
      viewrecords: true,
      searching: {
        defaultSearch: "cn"
      }
    });
    jQuery("#grid1").jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn'
    });
    $("#grid1").jqGrid("setLabel", "rn", "S.No");


    $('.edit').on('click', function() {
      var index = $("#grid1").jqGrid('getGridParam', 'selrow');
      var edit_id = $("#grid1").jqGrid('getCell', index, 'id');

      if (index) {
        var id = $('.id').val(edit_id);
        document.getElementById('create-user').submit();

      } else {
        notyMsgs("info", "Please Select one row");
      }
    })
    // $(".edit").click(function(){
    //     var index = $("#grid1").jqGrid('getGridParam','selrow');
    // 	var edit_id = $("#grid1").jqGrid ('getCell', index, 'id');
    //       if( edit_id){
    // 		window.location.replace('useredit/'+edit_id);
    // 	}
    // 	else
    // 	{
    // 		 notyMsgs("info","Please Select a Row");
    // 	}

    // });
    // $(document).on('click','.create',function()
    // {
    // var inquirytype = $(this).val();
    // var url="{{ url('createuser') }}";

    // window.location.replace(url);
    // });
    $('.create').on('click', function() {
       var id = $('.id').val(0);
      document.getElementById('create-user').submit();
    })

    showcolumn('grid1');

    //       $(".view").click(function(){
    // 	var index = $("#grid1").jqGrid('getGridParam','selrow');
    // 	var id = $("#grid1").jqGrid ('getCell', index, 'id');
    // 	if(id)
    // 	{
    // 		window.location.replace('userviews/'+id );
    // 	}
    // 	else
    // 	{
    // 			 notyMsgs("info","Please Select a Row");
    // 	}
    // });
    $('.view').on('click', function() {
      var index = $("#grid1").jqGrid('getGridParam', 'selrow');
      var id1 = $("#grid1").jqGrid('getCell', index, 'id');

      if (index) {
        var id = $('.id').val(id1);
        document.getElementById('view-user').submit();
      } else {
        notyMsgs("info", "Please Select one row");
      }
    })
    $('.userblock').on('click', function () {
    var index = $("#grid1").jqGrid('getGridParam', 'selrow');
    
    if (index) {
        var id1 = $("#grid1").jqGrid('getCell', index, 'id');
        var status = $("#grid1").jqGrid('getCell', index, 'block_unblock'); 

        $.ajax({
            url:"{{ url('blockunblockuser') }}",
            type: 'POST',
            data: {
                id: id1,
                status: status,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
              console.log(response);
                notyMsgs("success", response.message);
                setTimeout(function() {
                    $("#grid1")[0].triggerToolbar();
                  }, 1500);
            },
            error: function (xhr) {
                var errorMsg = xhr.responseJSON?.errors?.general?.[0] || "An error occurred";
                notyMsgs("error", errorMsg);
            }
        });
    } else {
        notyMsgs("info", "Please select one row");
    }
});

    
    // $('.userblock').on('click', function() {
    //   var index = $("#grid1").jqGrid('getGridParam', 'selrow');
    //   var id1 = $("#grid1").jqGrid('getCell', index, 'id');
    //   if (index) {
    //     var id = $('.id').val(id1);
    //     $.ajaxSetup({
    //       headers: {
    //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //       }
    //     });
    //     $.post("{{url('userblock')}}", {
    //       id: id1
    //     }, function(data) {
    //       if (data == '1' || data == 1) {
    //         notyMsg('success', 'Blocked Successfully');
    //         setTimeout(function() {
    //           $("#grid1")[0].triggerToolbar();
    //         }, 1500);
    //       }
    //       if (data == '3' || data == 3) {
    //         notyMsg('error', "Something Went Wrong!!");
    //         setTimeout(function() {
    //           $("#grid1")[0].triggerToolbar();
    //         }, 1500);
    //       }
    //     });
    //   } else {
    //     notyMsgs("info", "Please Select one row");
    //   }
    // });
    $(document).on('click', '.delete', function(e) {
      e.preventDefault();
      var gr = jQuery("#grid1").jqGrid('getGridParam', 'selrow');
      var cellValue = jQuery("#grid1").jqGrid('getCell', gr, 'id');
      if (cellValue) {
        swal({
          title: 'Are you sure?',
          text: "You won't be able to revert this!",
          type: 'warning',
          showCancelButton: !0,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes',
          cancelButtonText: 'No',
        }, function(e) {
          if (e == true) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.post("{{url('userdelete')}}", {
                id: cellValue
            }, function(data) {
              // alert(data);
                if (data == '1' || data == 1) {
                  // alert(data);
                  notyMsg('success', 'Deleted Successfully');
                  setTimeout(function() {
                    $("#grid1")[0].triggerToolbar();
                  }, 1500);
                }
                if (data == '3' || data == 3) {
                  notyMsg('error', "Something Went Wrong!!");
                  setTimeout(function() {
                    $("#grid1")[0].triggerToolbar();
                  }, 1500);
                }
            });
            // $.get('userdelete/' + cellValue, function(data, status) {
            //   var data = $.trim(data);
            //   if (data == '0') {
            //     notyMsg('success', 'Deleted Successfully');
            //     setTimeout(function() {
            //       $("#grid1")[0].triggerToolbar();
            //     }, 1500);
            //   }
            //   if (data == '3') {
            //     notyMsg('error', "Something Went Wrong!!");
            //     setTimeout(function() {
            //       $("#grid1")[0].triggerToolbar();
            //     }, 1500);
            //   }

            // });
          } else {
            $('.apply').css('display', 'none');
            swal("Cancelled");
          }
        })
        $('.apply').css('display', 'none');
      } else {
        notyMsg('info', "Please Select a Row");
      }
    });

    /***** Delete Row ********/

    $("#clearsearch").click(function() {
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
      $('select[id*="gs_"]').select2('val', ['']);
    });
    /*End*/

    $("#exportpdf").on("click", function() {

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
        fileName: "User.pdf",
        mimetype: "application/pdf"
      });
    });

    $("#exportexcel").on("click", function() {
      $("#grid1").jqGrid("exportToExcel", {
        includeLabels: true,
        includeGroupHeader: true,
        includeFooter: true,
        fileName: "User.xlsx",
        maxlength: 40000
      })


    })

  });
</script>
@endsection
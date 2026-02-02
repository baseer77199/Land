@extends('layouts.header')
@section('content')
<span class="ui_close_btn"></span>

<h2 class="heads">Group</h2>

    <div class="card">
      
           <div class="card-body card-block">

          <form  action=""  id="save" >

              <input type="hidden" name="edit_id" value="" id="edit_id" />
              {{ csrf_field()}}
              <div class="row">
              <div class="col-md-12">
                <div class="form-group row">
                  <label for="inputIsValid" class="form-control-label col-md-2"><span class="req">*</span>Group Name</label>
                  <div class="col-md-4">
                    <input type="text" id="group_name" name="group_name" class="form-control group_name" value="" required style="width:100%;">
                    <span class="btn btn-danger dup_name" style="display:none;"></span>
                  </div>

                  <label for="inputIsValid" class="form-control-label col-md-2">Description</label>
                  <div class="col-md-4">
                    <input type="text" id="description" name="description" class="form-control  description" value="" style="width: 100%;">
                  </div>
                </div>
              </div>
            </div>

            <div class="row text-center">
          			 <?php include('toolbar.php'); ?>
            </div>
          </form>

          <div class="row">
          <div class="col-md-12">
            <table id="grid1"></table>
          </div>
        </div>


        </div>

  </div>

<script>
  $(document).ready(function(){
     var data="{{ $datas }}";
    var result = jQuery.parseJSON(data.replace(/&quot;/g, '"' ));
    $("#grid1").jqGrid({
		url:"getgroup",
	 datatype: "json",
      mtype: "GET",
      colModel: [
        {
          name: "group_id", label: "Sno",hidden:true, width: 100 },
        {
          name: "group_name", label: "Group Name", width: 250,editable:true, editrules:{
            date:true}
        },
        { name: "description", label: "Description", width: 250,editable:true, editrules:{
            date:true}
        },
      ],
      data:result,
      iconSet: "fontAwesome",
      rownumbers: true,
      sortname: "group_id",
      sortorder: "desc",
      threeStateSort: true,
      sortIconsBeforeText: true,
      headertitles: true,
       rowList: [10,20,50,100,250,500,1000],
      pager: '#grid1',
      rowNum: 10,
      viewrecords: true,
      searching: {
        defaultSearch: "cn"
      }
    }
                      );
	  $("#grid1").jqGrid("setLabel", "rn", "S.No");
    jQuery("#grid1").jqGrid('filterToolbar',{
      stringResult: true,searchOnEnter : false}
                           );
    $("#edit").click(function()
                         {
      var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
      var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'group_id');
      if(gr)
      {
        $.get('groupaccess/edit?group_id='+cellValue,function(data)
              {
          $('#group_name').val(data['group_name']);
          $('#description').val(data['description']);
          $('#edit_id').val(data['group_id']);
        }
             );
      }
      else
      {
        notyMsg('info','Please Select a Row');
      }
    }
				
                        );
	  
	  		 
 $(document).on('click',".exportpdf",function() {
   	$("#grid1").jqGrid('exportToPdf', {
  title: null,
  orientation: 'portrait',
  pageSize: 'A4',
  description: null,
  onBeforeExport: null,
  download: 'download',
  includeLabels : true,
  includeGroupHeader : true,
  includeFooter: true,
  fileName : "Group.pdf",
  mimetype : "application/pdf"  
});
	 
	});
$(document).on('click',".exportexcel",function() {
$("#grid1").jqGrid("exportToExcel",{
					includeLabels : true,
    					includeGroupHeader : true,
    					includeFooter: true,
    					fileName : "Group.xlsx"
    					
				})		 
	});
	  showcolumn('grid1');
    $('#viewdata').click(function(){
      //alert('hhhh');
      var gr=$('#grid1').jqGrid('getGridParam','selrow');
      var cellValue = $("#grid1").jqGrid ('getCell', gr, 'department_id');
      //alert(cellValue);
      if(gr)
      {
        var url="employeedepartment";
        var viewurl = url+'/'+cellValue+'/view';
        window.location.replace('employeedepartment/' +cellValue);
      }
      else
      {
       notyMsg('info','Please Select a Row');
      }
    }
                        );
    $('#reset').click(function(){
      $('#group_name').val('');
      $('#description').val('');
      $('#edit_id').val('');
    });
	  /***** Purpose For CLEAR search ********/
	$("#clearsearch").click(function() {
		var grid = $("#grid1");
		grid.jqGrid('setGridParam',{search:false});

		var postData = grid.jqGrid('getGridParam','postData');
		$.extend(postData,{filters:""});
		grid.trigger("reloadGrid",[{page:1}]);
        $('input[id*="gs_"]').val("");
               
	});
/*End*/
    var dup_chk = true;
    function duplicate_validate()
    {
      var group_name = $(".group_name").val();
      var edit_id = $("#edit_id").val();
      $.ajax({
        cache: false,
        url: 'groupname/checkname', //this is your uri
        type: 'GET',
        dataType: 'json',
        async : false,
        data: {
          group_name : group_name,edit_id : edit_id}
        ,
        success: function(response)
        {
          console.log(response);
          if(response == 1)
          {
            $('.dup_name').html('Group Name:'+group_name+' Already Exists');
            $('.dup_name').show();
            $(".department_name").val('');
            dup_chk = false;
          }else if(response == 3)
          {
            notyMsg("error","Something went wrong!!");
            $(".department_name").val('');
            dup_chk = false;
          }
          else if(response == 0)
          {
            var html ="";
            $('.dup_name').hide();
            dup_chk = true;
          }
        }
        ,
        error: function(xhr, resp, text)
        {
          console.log(xhr, resp, text);
        }
      }
            );
    }

$(document).on('click','.save',function(e) {

    e.preventDefault();
      var data;
      data = $("#save").serialize();
      duplicate_validate();
	//validationrule('save');
    var form = $('#save');
    form.parsley().validate();
      if(dup_chk == true)
      {
		  if (form.parsley().isValid())
        {

       var formData = $('#save').serialize();
            $.ajax({
          url:     "{{ url('groupaccess/save') }}",
          type:     'post',
          data:     formData,
          dataType: 'json',
          success: function (response) {
           if(response == 1){
            notyMsg("success","Saved Successfullly");
           $('#group_name').val('');
             $('#description').val('');
             $("#grid1")[0].triggerToolbar();
                        }
                        else{
                            notyMsg("success","Updated Successfullly");
             $('#group_name').val('');
             $('#description').val('');
             $("#grid1")[0].triggerToolbar();
                        }
           },
         error: function(response) {
             console.log(response);
               var errors = response.responseJSON.errors;

               var errorsHtml = '';

               $.each( errors, function( key, value ) {
                   errorsHtml += '<p>'+ value[0] + '</p>';
               });
              // errorsHtml += '</ul></div';
    notyMsg("error",errorsHtml);
   //  $("#grid1")[0].triggerToolbar();
  // $(".clear").trigger('click');
             //  $('.messages').html(errorsHtml);
           }
       });
        }
          
      }
           
});    
    
//     $(document).on('click','.save',function(e){
//       e.preventDefault();
//       var data;
//       data = $("#save").serialize();
//       duplicate_validate();
// 	//validationrule('save');
//     var form = $('#save');
//     form.parsley().validate();
//       if(dup_chk == true)
//       {
// 		  if (form.parsley().isValid())
//         {
//         $.post('groupaccess/save', data, function(data)
//               {
//           if(data == 1){
//             notyMsg('success','saved successfully');
//              $('#group_name').val('');
//              $('#description').val('');
//              $("#grid1")[0].triggerToolbar();
            
//           }
//           else if(data == 2)
//           {
//             notyMsg('success','updated  successfully');
//              $('#group_name').val('');
//              $('#description').val('');
//              $("#grid1")[0].triggerToolbar();
//           }
//         }
//               );
//       }
// 	  }
//     });
    
    
    
    $(document).on('click','.delete',function(e){
      e.preventDefault();
      var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
      var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'group_id');
      if(gr)
       {
            swal({
                 title: "Are you sure?",
                    text: "You want to delete!",
                    type: "warning",
                     showCancelButton: !0,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes",
                    cancelButtonText: "No"
            }, function (e)
            {
                if (e == true)
                {
        $.get('groupaccess/delete?del_id='+cellValue, function(data,status)
              {
          if(data == 1)
          {
            notyMsg('info','Deletion Error Already Used In Somewhere');
            $("#grid1")[0].triggerToolbar();
          }
          else if(data == 2)
          {
            notyMsg('info','Deleted Successfully');
            $("#grid1")[0].triggerToolbar();
          }
        }
             );
      } else
                {
                    $('.apply').css('display', 'none');
                    swal("Cancelled");
                }
            })
            $('.apply').css('display', 'none');
        }
      else
      {
        notyMsg('info','Please Select a Row');
      }
    }
                  );
  }
                   );



$(".edit,.clear").click(function(){
var form=$("#save");
   form.parsley().destroy();

 });


</script>
@endsection

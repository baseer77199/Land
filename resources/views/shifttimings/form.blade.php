@extends('layouts.header')
@section('content')


<span class="ui_close_btn"></span>

<h2 class="heads">Shift Timings</h2>
<div class="card">

            
                <div class="card-body card-block">
                    <form  action=""  id="save" >
						
                    <input type="hidden" name="edit_id" value="" id="edit_id" />
                {{ csrf_field()}}
                <div class="row">
                    <div class="col-md-4">
                         <div class="form-group row">
                            <label for="inputIsValid" class="form-control-label col-md-5"><span style="color:red;">*</span>Shift Name</label>
                            <div class="col-md-7">
                                <input type="text" id="shift_name" name="shift_name" class="form-control shift_name" value="" required >
                            </div>
                            <span class="btn btn-danger dup_name" style="display:none;"></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                    <div class="form-group row">
                            <label for="inputIsValid" class="form-control-label col-md-5"><span style="color:red;">*</span>Start Time</label>
                            <div class="col-md-7">
                                <input type="text" id="start_time" name="start_time" class="form-control start_time datetimepickers" value="" required readonly>
                            </div>
                    </div>
                </div>
                    <div class="col-md-4">
                    <div class="form-group row">
                            <label for="inputIsValid" class="form-control-label col-md-5"><span style="color:red;">*</span>End Time</label>
                            <div class="col-md-7">
                                <input type="text" id="end_time" name="end_time" class="form-control end_time datetimepickers" value="" required readonly>
                            </div>
                    </div>
                </div>
            </div>
                
                
                <div class="row">
                <div class="col-md-12 text-center ">
                    <button type="button" id="save" class="btn save  ">Save</button> 
                    <a> <button type="button" class="btn del delete" id="delete" value="">Delete</button></a>
                    <?php include('toolbar.php'); ?>
                </div>
              </div>
              <div class="row">
                  <div class=" col-md-12">
                      


                      
                  </div>
              </div>
 
        
</form>
<div class="row">
              <div class="col-md-12">
                <table id="grid1"></table>
              </div>
              </div>
</div>
		
		</div>
    
    

<!--        <div class="col-xs-6">
            <button class="btn btn-default waves-effect waves-light" id="sa-warning">Click me</button>
        </div>-->



<style type="text/css">
.panel, .card {
    margin-bottom: 230px;
}
.ui-pg-selbox.ui-widget-content.ui-corner-all {
    width: 55px;
}
</style>


	<script>
	$(document).ready(function(){

        /** Jqgrid Load data Start  **/   
        $("#grid1").jqGrid(
        {
            url: "shifttiminggrid",
            datatype: "json",
            mtype: "GET",
            colModel: [
                { name: "shift_id", label: "id", width: 250, hidden: true },
                { name: "shift_name", label: "Shift  Name", width: 250},
                { name: "start_time", label: "Start Time", width: 250,},
                { name: "end_time", label: "End Time", width: 250},
            ],

            iconSet: "fontAwesome",
            rowNum: 10,
            rowList: [10,20,100,1000,2000],
            sortorder: "desc",
            viewrecords: true,
            gridview: true,
            rownumbers:true,
            pager:"#grid1",
            multiselect:false,
            multipageselection:true,
            searching: {
            defaultSearch: "cn",
            },
        });
       jQuery("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
       /** Jqgrid Load data End  **/   

/************  job title name duplicate validation start ***********/
            var dup_chk = true;
            function duplicate_validate()
            {
                var shift_name = $(".shift_name").val();
                var edit_id = $("#edit_id").val();
                $.ajax({
                    cache: false,
                    url: 'shifttiming/checkname', //this is your uri
                    type: 'GET',
                    dataType: 'json',
                    async : false,
                    data: {shift_name : shift_name,edit_id : edit_id},
                    success: function(response)
                    {
                        if(response == 1)
                        {
                            $('.dup_name').html('Shift Name: '+shift_name+' Already Exists');
                            $('.dup_name').show();
                            $(".shift_name").val('');
                            dup_chk = false;
                        }
                        else if(response == 0)
                        {
                            var html ="";
                            $('.dup_name').hide();
                            dup_chk = true;
                        }
                    },
                    error: function(xhr, resp, text)
                    {
                        console.log(xhr, resp, text);
                    }
                });
            }
            $(".shift_name").keyup(function()
            {
                $('.dup_name').hide();
            });
         
  /************  job title name duplicate validation end ***********/

        /** Edit Shift Timing Load data Start  **/   
       $("#grid1").jqGrid("setLabel", "rn", "S.No");
            $(".edit").click(function()
            {
                var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
                var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'shift_id');
                var shift_name = jQuery("#grid1").jqGrid ('getCell', gr, 'shift_name');
                var start_time = jQuery("#grid1").jqGrid ('getCell', gr, 'start_time');
                var end_time = jQuery("#grid1").jqGrid ('getCell', gr, 'end_time');
               
            

            if(gr)
            {
                
                $('#edit_id').val(cellValue);
                $('#shift_name').val(shift_name);
                var start_time_new=start_time.split(" ");
                var start=start_time_new[0].split("-");
                var start_date=start[2]+"-"+start[1]+"-"+start[0]+" "+start_time_new[1];
                var end_time_new=end_time.split(" ");
                var end=end_time_new[0].split("-");
                var end_date=end[2]+"-"+end[1]+"-"+end[0]+" "+end_time_new[1];
                $('#start_time').val(start_date);
                
                $('#end_time').val(end_date);
                
            }
            else
            {
                notyMsg('info','Please Select a Row');
            }
            });
           /** Edit Shift Timing Load data End  **/   
            


            /** Reset Shift Timing Load data Start  **/   
            $('.reset').click(function(){
                var form=$("#save");
   form.parsley().destroy();
                $('#shift_name').val('');
                $('#start_time').val('');
                $('#end_time').val('');
                $('#edit_id').val('');
                $('.dup_name').hide();
                 $("#grid1")[0].triggerToolbar();
            });
            /** Reset Shift Timing Load data Start  **/

showcolumn('grid1');
/*purpose:clear search the jqgrid*/
  $(".clearsearch").click(function()
  {
    var grid = $("#grid1");
    grid.jqGrid('setGridParam',{search:false});
    var postData = grid.jqGrid('getGridParam','postData');
    $.extend(postData,{filters:""});
    grid.trigger("reloadGrid",[{page:1}]);
    $('input[id*="gs_"]').val("");
    
  });
  /*end*/
          
    /** Jqgrid Export to Pdf Start **/
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
  fileName : "Shift Timings.pdf",
  mimetype : "application/pdf"  
});
     });                    
/** Jqgrid Export to Pdf End **/    

/** Jqgrid Export to Excel Start **/
         $(document).on('click',".exportexcel",function() {
$("#grid1").jqGrid("exportToExcel",{
                    includeLabels : true,
                        includeGroupHeader : true,
                        includeFooter: true,
                        fileName : "Shift Timings.xlsx"
                        
                })  
});     
/** Jqgrid Export to Excel End **/

            /** Shiftiming Save Start  **/
    //         $(document).on('click','.save',function(e)
    //         {
    //             e.preventDefault();
    //             var data;
    //             duplicate_validate();
    //             data = $("#save").serialize();
    //             var form = $('#save');
				// form.parsley().validate();
				// if (form.parsley().isValid() && dup_chk)
				// {
                                    
				// 	$.post('shifttimingssave', data, function(data)
				// 	{
				// 		if(data == 1)
				// 		{
				// 			$("#grid1")[0].triggerToolbar();
				// 			notyMsg('success','Saved Successfully');
				// 			$('.reset').trigger('click');
				// 		}
				// 		else if(data == 2)
				// 		{
				// 			$("#grid1")[0].triggerToolbar();
				// 			notyMsg('success','Update Successfully');
				// 			$('.reset').trigger('click');

				// 		}
				// 	});
    //             }

    //         });
            /** Shiftiming Save End  **/    
          $(document).on('click','.save',function(e)
            {
                e.preventDefault();
               // var data;
                duplicate_validate();
                formData = $("#save").serialize();
                var form = $('#save');
				form.parsley().validate();
				if (form.parsley().isValid() && dup_chk)
				{
                   $.ajax({
          url:     "{{ url('shifttimingssave') }}",
          type:     'post',
          data:     formData,
          dataType: 'json',
          success: function (response) {
           if(response == 1){
            notyMsg("success","Saved Successfullly");
            $("#grid1")[0].triggerToolbar();
                $('#edit_id').val('');
                $('#shift_name').val('');
                $('#start_time').val('');
                $('#end_time').val('');
                $('#edit_id').val('');
                        }
                        else{
                            notyMsg("success","Updated Successfullly");
                            $("#grid1")[0].triggerToolbar();
                $('#shift_name').val('');
                $('#start_time').val('');
                $('#end_time').val('');
                $('#edit_id').val('');
                        }
           },
         error: function(response) {
        
               var errors = response.responseJSON.errors;

               var errorsHtml = '';

               $.each( errors, function( key, value ) {
                   errorsHtml += '<p>'+ value[0] + '</p>';
               });
             
    notyMsg("error",errorsHtml);
            
           }
       });
                }

            });


            /** Shiftiming Cancel Start  **/
            $(document).on('click','.cancel',function()
            {
                 $("#grid1")[0].triggerToolbar();
                $('#component').val('').select2();
                $('.limits').val('');
                $('.date').val('');
                $('.employeer_contribute').val('');
                $('.company_contribute').val('');
                $('#edit_id').val('');
                $('.contribute').hide();
            })
            /** Shiftiming Cancel End  **/
    $(document).on('click','.reset',function()
    {
    var form=$("#save");
   form.parsley().destroy();
        $(':input')
        .not(':button, :submit, :reset')
        .val('')
        .prop('checked', false);

        
    });
            /*** deletetion pending Delete Start ***/
           $(document).on('click','.delete',function(e){
               
                e.preventDefault();
                var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
                var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'shift_id');
                alert(cellValue);
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
                    $.get('timing/delete?del_id='+cellValue, function(data,status)
                    {
                        if(data == 1)
                        {  
                            notyMsg('warning','Deletion Error Already Used In Somewhere');
                            $("#grid1")[0].triggerToolbar();
                        }
                        else if(data == 2)
                        {
                            notyMsg('info','Deleted Successfully');
                            $("#grid1")[0].triggerToolbar();
                        }
                    });
                } else
                {
                     $("#grid1")[0].triggerToolbar();
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


            }); 

	});
/*** deletetion pending Delete End ***/
$('.cancel').hide();
/*** Edit  Start ***/
$(".edit").click(function(){
var form=$("#save");
   form.parsley().destroy();

 });
/*** Edit  End ***/
		// validate alphabets only 
  $(document).on('keypress', '#shift_name', function(ev){
        var regex = new RegExp("^[a-z,A-Z.,' ']+$");
                var str = String.fromCharCode(!ev.charCode ? ev.which : ev.charCode);
                if (regex.test(str)) {
                    return true;
                }
                ev.preventDefault();
                return false;
    }); 
		// ***validate alphabets only ***//
	</script>
@include('layouts.php_js_validation')
@endsection

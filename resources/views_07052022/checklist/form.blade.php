@extends('layouts.header')
@section('content')

<style type="text/css">
  
#file{
  width: 200px;
}
</style>

<h2 class="heads">Check List</h2>

<div class="card">


    <div class="card-body card-block">

      <form  action="" id="save" enctype="multipart/form-data">
     
        <input type="hidden" name="edit_id" value="" id="edit_id" />
                {{ csrf_field()}}

<div class="row">
   


  <div class="col-md-4">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Checklist Name</label>
          <div class="col-md-7">
             
              <input type="text" id="checklist_name" name="checklist_name" class="form-control checklist_name" value="" required style="width:100%;" tabindex="1">
      </div>
      <div>
              <span class="btn btn-danger dup_name" style="display:none;"></span>
          </div>
      </div>
     
  </div>

 


<div class="col-md-4">
  
   
     <div class="form-group row">
          <label for="active" class="form-control-label col-md-5">Terms and Condition</label>
          <div class="col-md-7">

              <textarea name="terms" id="terms" class="form-control"> </textarea>
          </div>
      </div>
       
      
        
</div>



<div class="col-md-4">
  
   
     <div class="form-group row">
          <label for="active" class="form-control-label col-md-3">File Upload</label>
          <div class="col-md-6">

              <input type="file" name="file" id="file" accept="image/x-png,image/gif,image/jpeg" >
          </div>

          <!-- <div class="form-group row" id="img_block" style="display: none;">
           
           <div class="col-md-12 text-center ">
             <img id="existing_img" src="" width="100" height="100">
             <label id="uploaded_image" class="uploaded_image"></label>
          </div>
       </div> -->
      </div>
       
      
        
</div>

 </div>

        
</form>
<div class="row text-center">
            <button type="button"  class="btn save saveform" tabindex="5">Save</button>
            <?php include('toolbar.php'); ?>
        </div>


<div class="row">
  <div class="col-md-12" style="padding:15px;">
    <table id="checklistgrid1"></table>
  </div>
</div>
</div>
</div>

<script>
        



  $(document).ready(function(){



 
  
    
  $("#checklistgrid1").jqGrid(
            {
                url: "checklistgrid",
                datatype: "json",
                mtype: "GET",
                colModel: [
                    { name: "checklist_id", label: "checklist_id", width: 250, hidden: true },
                    { name: "checklist_name", label: "Checklist Name", width: 250,editable: true},
                                     
                    { name: "terms", label: "Terms and Condition", width: 250,editable:true},
                    { name: "file", label: "File", width: 250,hidden:true},
                    
                ],

                iconSet: "fontAwesome",
                rowNum: 10,
                rowList: [10,20,100,1000,2000],
                sortname: "checklist_id",
                sortorder: "desc",
                viewrecords: true,
                gridview: true,
                rownumbers:true,
                pager: "#checklistgrid1",
                multiselect:false,
                multipageselection:true,
                searching: {
                defaultSearch: "cn",
                },
            });
     jQuery("#checklistgrid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
  $("#checklistgrid1").jqGrid("setLabel", "rn", "S.No");
   showcolumn("checklistgrid1");
   
  /*Karthigaa Purpose For PDF Download*/
  $(document).on('click',".exportpdf",function() {
    $("#checklistgrid1").jqGrid('exportToPdf', {
  title: null,
  orientation: 'portrait',
  pageSize: 'A4',
  description: null,
  onBeforeExport: null,
  download: 'download',
  includeLabels : true,
  includeGroupHeader : true,
  includeFooter: true,
  fileName : "checklist.pdf",
  mimetype : "application/pdf"  
});   
});
/*Karthigaa Purpose For Excel Download*/  
  $(document).on('click',".exportexcel",function() {
            $("#checklistgrid1").jqGrid("exportToExcel",{
          includeLabels : true,
              includeGroupHeader : true,
              includeFooter: true,
              fileName : "checklist.xlsx"
        })     
  });
  

  $(".clearsearch").click(function()
  {
    var grid = $("#checklistgrid1");
    grid.jqGrid('setGridParam',{search:false});
    var postData = grid.jqGrid('getGridParam','postData');
    $.extend(postData,{filters:""});
    grid.trigger("reloadGrid",[{page:1}]);
    $('input[id*="gs_"]').val("");
    
  });


   $('#clear').click(function(){
        var form=$('#save');
        form.parsley().destroy();
        // $(':input','#save').not(':button, :submit, :reset').val('').prop('checked', false); 
        $(".dup_name").hide();
      //  $('#active').select2('val',['Yes']);
    });

  
        /* end */


//             $(document).on('click', '.saveform', function() {
              
//                 var url = "{{ url('checklistsave') }}";
//                 var form = $('#save');
//                 form.parsley().validate();
//                // var form = $('#save');
//                // form.parsley().validate();
//                 if (form.parsley().isValid()) {
//                     change_date();
//                     var formdata = $('#save').serialize();
//                     alert(formdata);
//                     $.post(url,formdata, function(data) {
//                         var data = $.trim(data);
                           
//                         if(data == 1){

//                             notyMsg("success","Saved Successfullly");
//                             $("#checklistgrid1")[0].triggerToolbar();
                         
//                         $( '#save' ).each(function(){
//                              this.reset();
                             


// });

//                         }
//                         else{
//                             notyMsg("success","Updated Successfullly");
//                             $("#checklistgrid1")[0].triggerToolbar();
                

//                             $( '#save' ).each(function(){
//                              this.reset();
                          
// });
//                         }
                       
//                     });
//                 }
//             });
            

 $(document).on('click','.saveform',function()
                {
                    var url	="{{url('checklistsave')}}";
                    var data	= $('#save').serialize();
                    var form = $('#save');
					var form_data = new FormData(document.getElementById('save'));
                    form.parsley().validate();
                    var form = $('#save');
                    form.parsley().validate();
					  
                    if (form.parsley().isValid())
                    {
						
						
						   $.ajax({
                          url: "{{ url('checklistsave')}}",
                          type: "POST",
                          data: form_data,
                          enctype: 'multipart/form-data',
                          processData: false,  // tell jQuery not to process the data
                          contentType: false,   // tell jQuery not to set contentType
                          async:true,
                          xhr: function(){
                            var xhr = $.ajaxSettings.xhr();
                            if (xhr.upload) {
                                xhr.upload.addEventListener('progress', function(event) {
                                }, true);
                                }
                                return xhr;
                        }
                        }).done(function(data,status)
                        {
                           
                            if(data == 1)
                            {
                                notyMsgs('success','Saved Successfully');
                                    $("#checklistgrid1")[0].triggerToolbar();
                                $('#save')[0].reset();
								$('.clear').trigger('click');
                            }
                            if(data == 2)
                            {
                                notyMsgs('success','Updated Successfully');
                                   $("#checklistgrid1")[0].triggerToolbar();
                                $('#save')[0].reset();
                                 $("#edit_id").val('');
								$('.clear').trigger('click');
                            }
                            else
                            {
                                  $('#save')[0].reset();
                                 $("#edit_id").val('');
								$('.clear').trigger('click');
                                $(".alert-success").hide();
                                $(".alert-danger").fadeIn(800);

                            }
                        }).fail(function(data,status)
                        {
                          console.log(data);
               var errors = data.responseJSON.errors;

               var errorsHtml = '';

               $.each( errors, function( key, value ) {
                   errorsHtml += '<p>'+ value[0] + '</p>';
               });
              // errorsHtml += '</ul></div';
    notyMsg("error",errorsHtml);
  
                        });
					
                    }
		});



            $("#editdata").click(function()
            {

                var gr = jQuery("#checklistgrid1").jqGrid('getGridParam','selrow');
                var checklist_id = jQuery("#checklistgrid1").jqGrid ('getCell', gr, 'checklist_id');
                var checklist_name = jQuery("#checklistgrid1").jqGrid ('getCell', gr, 'checklist_name');
                var terms = jQuery("#checklistgrid1").jqGrid ('getCell', gr, 'terms');
                var file = jQuery("#checklistgrid1").jqGrid ('getCell', gr, 'file');
                 
               if( checklist_id)
                {
                     $('#edit_id').val(checklist_id);
                  //  $('#checklist_id').val(checklist_id);
                   
                    $('#checklist_name').val(checklist_name);
                    $('#terms').val(terms);

                    $('#file').text(file);
            //          $("#img_block").css("display", "block");
            // $("#existing_img").show();
            // $('#existing_img').attr('src','{{ asset("/uploads/checklist") }}/'+file);
            // $("#existing_img").error(function() { $(this).hide(); });

            // $('#uploaded_image').text(file);
                 

                }
                else
                {
                    notyMsg('INFO','Please Select a Row');
                }
            });

           $('#delete').click(function(){
 // alert("dfhgfd");
  var gr = jQuery("#checklistgrid1").jqGrid('getGridParam','selrow');
  var id = jQuery("#checklistgrid1").jqGrid ('getCell', gr,'checklist_id');
    

  if(gr ){
    swal({
                title: "Are you sure?",
                text: "You want to delete!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
            closeOnCancel:!1
            }, function(e) {
      if(e == true)
      {
        var url ="{{ url('checkdelete') }}/" +id;
       
        $.get(url,function(data)
        {
          var data = $.trim(data);
          //location.reload();
          if(data =='0')
          {
            notyMsgs('success','Deleted Successfully');
            //location.reload();
             $('.clearsearch').trigger('click');
              $(".reset").trigger('click');
           

              $("#frequencygrid1")[0].triggerToolbar();
           
          }
          if(data =='1')
          {
            notyMsgs('info',"You Can't delete  Used in SomeWhere");
            $('.clearsearch').trigger('click');
          }

        });
            }
            else
            {
            $('.apply').css('display','none');
            $('.clearsearch').trigger('click');
            swal("Cancelled");
            }
            });
             $('.apply').css('display','none');
          }
      else{
            notyMsg("info","Please Select a Row");
        }
    });

    
            $('.reset').click(function(){
              //alert('sffdsf');
               $('#frequency_id').val('');
               $('#frequency_name').val('');
              
                
            });




  });
  </script>
@endsection

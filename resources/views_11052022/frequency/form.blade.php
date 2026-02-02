@extends('layouts.header')
@section('content')
<head>
  <style type="text/css">
  .frequency_name {
    text-transform: capitalize;   
  }
#description{

  text-transform: capitalize;
}

</style>
</head>
<h2 class="heads">Maintenance Frequency</h2>

<div class="card">


    <div class="card-body card-block">

      <form  action="" id="save">
        <input type="hidden" name="edit_id" value="" id="edit_id" />
                {{ csrf_field()}}

<div class="row">
  <div class="col-md-6">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Frequency Name</label>
          <div class="col-md-7">
             
              <input type="text" id="frequency_name" name="frequency_name" class="form-control frequency_name" value="" required style="width:100%;" tabindex="1" >
      </div>
      <div>
              <span class="btn btn-danger dup_name" style="display:none;"></span>
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
            <button type="button"  class="btn save saveform" tabindex="5">Save</button>
            <?php include('toolbar.php'); ?>
        </div>
</form>



<div class="row">
  <div class="col-md-12" style="padding:15px;">
    <table id="frequencygrid1"></table>
  </div>
</div>
</div>
</div>

<script>
        



  $(document).ready(function(){
    
  $("#frequencygrid1").jqGrid(
            {
                url: "frequencygrid",
                datatype: "json",
                mtype: "GET",
                colModel: [
                    { name: "frequency_id", label: "frequency_id", width: 250, hidden: true },
                    { name: "frequency_name", label: "Frequency Name", width: 250,editable: true},
                  
                    { name: "description", label: "Description", width: 250,editable:true},
                    
                ],

                iconSet: "fontAwesome",
                rowNum: 10,
                rowList: [10,20,100,1000,2000],
                sortname: "frequency_id",
                sortorder: "desc",
                viewrecords: true,
                gridview: true,
                rownumbers:true,
                pager: "#frequencygrid1",
                multiselect:false,
                multipageselection:true,
                searching: {
                defaultSearch: "cn",
                },
            });
     jQuery("#frequencygrid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
  $("#frequencygrid1").jqGrid("setLabel", "rn", "S.No");
   showcolumn("frequencygrid1");
   
  /*Karthigaa Purpose For PDF Download*/
  $(document).on('click',".exportpdf",function() {
    $("#frequencygrid1").jqGrid('exportToPdf', {
  title: null,
  orientation: 'portrait',
  pageSize: 'A4',
  description: null,
  onBeforeExport: null,
  download: 'download',
  includeLabels : true,
  includeGroupHeader : true,
  includeFooter: true,
  fileName : "Frequency.pdf",
  mimetype : "application/pdf"  
});   
});
/*Karthigaa Purpose For Excel Download*/  
  $(document).on('click',".exportexcel",function() {
            $("#frequencygrid1").jqGrid("exportToExcel",{
          includeLabels : true,
              includeGroupHeader : true,
              includeFooter: true,
              fileName : "Frequency.xlsx"
        })     
  });
  

  $(".clearsearch").click(function()
  {
    var grid = $("#frequencygrid1");
    grid.jqGrid('setGridParam',{search:false});
    var postData = grid.jqGrid('getGridParam','postData');
    $.extend(postData,{filters:""});
    grid.trigger("reloadGrid",[{page:1}]);
    $('input[id*="gs_"]').val("");
    
  });
  
        /* end */

 var dup_chk = true;
    function duplicate_validate()
    {
        var frequency_name = $(".frequency_name").val();
        var edit_id = $("#frequency_id").val();
        $.ajax({
            cache: false,
            url: 'amcname',
            type: 'GET',
            dataType: 'json',
            async : false,
            data: {frequency_name : frequency_name,edit_id : edit_id},
            success: function(response)
            {
                if(response == 1)
                {
                    $('.dup_name').html('Frequency Name:'+frequency_name+' Already Exists');
                    $('.dup_name').show();

                    $(".frequency_name").val('');
                    dup_chk = false;
                }
                else if(response == 0)
                {
                    var html ="";
                    $('.dup_name').hide();
                    dup_chk  = true;
                }
            },
            error: function(xhr, resp, text)
            {
                console.log(xhr, resp, text);
            }
        });
    }
    $(document).on('click', '.saveform', function() {
        
       var form=$("#save");
             form.parsley();
             $('input[name=_token]').val("{{csrf_token()}}");
            form.parsley().validate();
              var data = form.serialize();
              duplicate_validate();
       
var url="{{ URL::to('frequencysave/{id}') }}";

if (form.parsley().isValid())
        {

       var formData = $('#save').serialize();
            $.ajax({
          url:  url,
          type:     'post',
          data:     formData,
          dataType: 'json',
          success: function (response) {
           if(response == 1){
            notyMsg("success","Saved Successfullly");
                               $("#frequencygrid1")[0].triggerToolbar();
                             $("#edit_id").val('');
                            $( '#save' ).each(function(){
    this.reset();
});
                        }
                        else{
                            notyMsg("success","Updated Successfullly");
                        $("#frequencygrid1")[0].triggerToolbar();
                             $("#edit_id").val('');
                            $( '#save' ).each(function(){
    this.reset();
});
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
        
    });


//             $(document).on('click', '.saveform', function() {

//                 var url = "{{ url('frequencysave/{id}') }}";
//                 var form = $('#save');
//                 form.parsley().validate();
//                 var form = $('#save');
//                 form.parsley().validate();
//                 if (form.parsley().isValid()) {
//                     change_date();
//                     var formdata = $('#save').serialize();
//                     $.post(url, formdata, function(data) {
//                         var data = $.trim(data);
//                         if(data == 1){
//                             notyMsg("success","Saved Successfullly");
//                             $("#frequencygrid1")[0].triggerToolbar();
//                               $("#edit_id").val('');
//                         $( '#save' ).each(function(){
                          
//     this.reset();
// });

//                         }
//                         else{
//                             notyMsg("success","Updated Successfullly");
//                             $("#frequencygrid1")[0].triggerToolbar();
//                              $("#edit_id").val('');
//                             $( '#save' ).each(function(){
//     this.reset();
// });
//                         }
                       
//                     });
//                 }
//             });
  
            
            $("#editdata").click(function()
            {

                var gr = jQuery("#frequencygrid1").jqGrid('getGridParam','selrow');
                var frequency_id = jQuery("#frequencygrid1").jqGrid ('getCell', gr, 'frequency_id');
                var frequency_name = jQuery("#frequencygrid1").jqGrid ('getCell', gr, 'frequency_name');
               //alert(frequency_name);
                var description = jQuery("#frequencygrid1").jqGrid ('getCell', gr, 'description');
               if( frequency_id)
                {
                     $('#edit_id').val(frequency_id);
                  //  $('#department_id').val(department_id);
                    $('#description').val(description);
                    $('#frequency_name').val(frequency_name);
                 

                }
                else
                {
                    notyMsg('INFO','Please Select a Row');
                }
            });

            $('.clear').click(function(){
      var form=$('#save');
       form.parsley().destroy();
        $(':input','#save').not(':button, :submit, :reset').val('').prop('checked', false); 
  
   
    });

            

$('#delete').click(function(){
 // alert("dfhgfd");
  var gr = jQuery("#frequencygrid1").jqGrid('getGridParam','selrow');
  var id = jQuery("#frequencygrid1").jqGrid ('getCell', gr,'frequency_id');
    

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
        var url ="{{ url('frequencydelete') }}/" +id;
       
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
               $('#description').val('');
                
            });




  });
  </script>
@endsection

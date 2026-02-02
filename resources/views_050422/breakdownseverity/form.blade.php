@extends('layouts.header')
@section('content')

<h2 class="heads">Breakdown Severity</h2>

<div class="card">


    <div class="card-body card-block">

      <form  action="" id="save">
        <input type="hidden" name="edit_id"  id="edit_id" />
                {{ csrf_field()}}
<div class="row">
  <div class="col-md-6">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Severity Name</label>
          <div class="col-md-7">
              <input type="hidden" class="form-control breakdownseverity_id" id="breakdownseverity_id" name="breakdownseverity_id" value="" size="16" type="hidden" readonly>
              
              <input type="text" id="severity_name" name="severity_name" class="form-control severity_name" tabindex="1" value="" required style="width:100%;" tabindex="1">
		  </div>
		  <div>
              <span class="btn btn-danger dup_name" style="display:none;"></span>
          </div>
      </div>
      </div>
      <div class="col-md-6">
      <div class="form-group row">
          <label for="active" class="form-control-label col-md-5 ">Description</label>
          <div class="col-md-7">
              <input type="text" id="description" name="description" class="form-control description" tabindex="2" >
             
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
    <table id="grid1"></table>
  </div>
</div>


    </div>

</div>

</div>
</div>
<script>
/*Karthigaa Purpose for Duplicate Function for Payment term Name*/
  
  $(document).ready(function(){
      
  $("#grid1").jqGrid(
            {
                url: "severitygrid",
                datatype: "json",
                mtype: "GET",
                colModel: [
                    { name: "breakdownseverity_id", label: "breakdownseverity_id", width: 250, hidden: true },
                    { name: "severity_name", label: "Severity Name", width: 250,editable: true},
                    { name: "description", label: "Description", width: 250,editable:true},
                    
                ],
                iconSet: "fontAwesome",
                rowNum: 10,
                rowList: [10,20,100,1000,2000],
                sortname: "breakdownseverity_id",
                sortorder: "desc",
                viewrecords: true,
                gridview: true,
                rownumbers:true,
                pager: "#grid1",
                multiselect:false,
                multipageselection:true,
                searching: {
                defaultSearch: "cn",
                },
            });
     jQuery("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
showcolumn("grid1");
   /*Karthigaa Purpose For PDF Download*/
   
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
  fileName : "Severity.pdf",
  mimetype : "application/pdf"  
});   
}); 
  $(document).on('click',".exportexcel",function() {
            $("#grid1").jqGrid("exportToExcel",{
          includeLabels : true,
              includeGroupHeader : true,
              includeFooter: true,
              fileName : "Severity.xlsx"
        })     
  });
  
$(".clearsearch").click(function(){
            var grid = $("#grid1");
            grid.jqGrid('setGridParam',{search:false});

            var postData = grid.jqGrid('getGridParam','postData');
            $.extend(postData,{filters:""});

            grid.trigger("reloadGrid",[{page:1}]);
              $('input[id*="gs_"]').val("");
              $('select[id*="gs_"]').select2('val',['']);
    });
  
        /* end */
// $(document).on('click', '.saveform', function() {

//                 var url = "{{ url('severitysave') }}";
//                 var form = $('#save');
//                 form.parsley().validate();
//                 var form = $('#save');
//                 form.parsley().validate();
//                 if (form.parsley().isValid()) {
//                     change_date();
//                     var formdata = $('#save').serialize();
//                   //  alert(formdata);
//                     $.post(url,formdata, function(data) {
//                         var data = $.trim(data);
//                       //alert(data);
//                         if(data == 1){
//                             notyMsg("success","Saved Successfullly");
//                             $("#grid1")[0].triggerToolbar();
//                             $("#edit_id").val('');
//                         $( '#save' ).each(function(){
//                          // alert("cvcv");
//     this.reset();
// });

//                         }
//                         else{
//                             notyMsg("success","Updated Successfullly");
//                             $("#grid1")[0].triggerToolbar();
//                                 $("#edit_id").val('');
                           
//                             $( '#save' ).each(function(){
//     this.reset();
// });
//                         }
                       
//                     });
//                 }
//             });
            $(document).on('click', '.saveform', function() {

                var url = "{{ url('severitysave') }}";
                var form = $('#save');
                form.parsley().validate();
                var form = $('#save');
                form.parsley().validate();
                if (form.parsley().isValid()) {
                    change_date();
                //    var formdata = $('#save').serialize();
             
                var formData = $('#save').serialize();
            $.ajax({
          url:  url,
          type:     'post',
          data:     formData,
          dataType: 'json',
          success: function (response) {
               var data = $.trim(response);
                      //alert(data);
                        if(data == 1){
                            notyMsg("success","Saved Successfullly");
                            $("#grid1")[0].triggerToolbar();
                            $("#edit_id").val('');
                            $("#description").val(' ');
                        $( '#save' ).each(function(){
                         // alert("cvcv");
    this.reset();
});
}                     else{
                            notyMsg("success","Updated Successfullly");
                            $("#grid1")[0].triggerToolbar();
                                $("#edit_id").val('');
                             $("#description").val(' ');
                            $( '#save' ).each(function(){
    this.reset();
});
                        }

           },
         error: function(response) {
        
               var errors = response.responseJSON.errors;
  $("#description").val(' ');
               var errorsHtml = '';

               $.each( errors, function( key, value ) {
                   errorsHtml += '<p>'+ value[0] + '</p>';
               });
             
    notyMsg("error",errorsHtml);
            
           }
       });        
                    
                }              

});
            $("#editdata").click(function()
            {
             //lert("hai");
                var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
                var breakdownseverity_id = jQuery("#grid1").jqGrid ('getCell', gr, 'breakdownseverity_id');
               //lert(breakdownseverity_id);
                var severity_name = jQuery("#grid1").jqGrid ('getCell', gr, 'severity_name');
                var description = jQuery("#grid1").jqGrid ('getCell', gr, 'description');
               if( breakdownseverity_id)
                {
                     $('#edit_id').val(breakdownseverity_id);
                  //  $('#department_id').val(department_id);
                    $('#description').val(description);
                    $('#severity_name').val(severity_name);
                    

                }
                else
                {
                    notyMsg('INFO','Please Select a Row');
                }
            });

   /* Purpose For Delete Function*/ 
$('.del').click(function(){
 // alert("dfhgfd");
  var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
  var id = jQuery("#grid1").jqGrid ('getCell', gr,'breakdownseverity_id');
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
        var url ="{{ url('severitydelete') }}/" +id;
        $.get(url,function(data)
        {
          var data = $.trim(data);
          if(data =='2')
          {
            notyMsgs('success','Deleted Successfully');
         //    $('.clearsearch').trigger('click');
          //    $(".reset").trigger('click');
               setTimeout(function(){
                     var red_url     ="{{ url('breakdownseverity') }}";
                     window.location.href=red_url;
                            }, 100);
           
          }
          if(data =='1')
          {
            notyMsgs('info',"You Can't delete  Used in SomeWhere");
            $('.clearsearch').trigger('click');
                             setTimeout(function(){
                             $("#grid1")[0].triggerToolbar();
                             }, 1500);
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
    /*End*/

              
            // $(document).on('click','.del',function(e){
            //     e.preventDefault();
            //     var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
            //     var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'breakdownseverity_id');
             
            //     if(cellValue )
            //     {
            //         $.get('severitydelete?del_id='+cellValue, function(data,status)
            //         {
            //             if(data == 0)
            //             {
            //                 notyMsg('Warning','Deleted Successfully');
            //                 $("#grid1")[0].triggerToolbar();
            //             }
            //             else if(data == 2)
            //             {
            //                 notyMsg('SUCCESS','Deleted Successfully');
            //                 $("#grid1")[0].triggerToolbar();
            //             }
            //         });
            //     }
            //     else
            //     {
            //         notyMsg('Info','Please Select a Row');
            //     }


            // });
             /***** Clear Function Start  ****/
        $(document).on('click','#clear',function()
        {
            //alert("hai");
            $('#severity_name').val('');
            $('#description').val('');
            
          //  location.reload();
        });
               /***** Clear Function End  ****/ 



  });
  </script>
@endsection

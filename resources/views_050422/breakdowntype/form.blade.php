@extends('layouts.header')
@section('content')

<h2 class="heads">Breakdown Type</h2>

<div class="card">


    <div class="card-body card-block">

      <form  action="" id="save">
        <input type="hidden" name="" value="" id="edit_id" />
                {{ csrf_field()}}
<div class="row">
  <div class="col-md-6">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Breakdown Name</label>
          <div class="col-md-7">
              <input type="hidden" class="form-control breakdowntype_id" id="breakdowntype_id" name="breakdowntype_id" value="" size="16" type="hidden" readonly>
              
              <input type="text" id="breakdown_name" name="breakdown_name" class="form-control breakdown_name" tabindex="1" value="" required style="width:100%;" tabindex="1">
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
	  <a href="{{url('breakdowntypeupload')}}"><button type="button"  class="btn upload  upload-image" tabindex="5">Upload</button></a>
	 	  <button type="submit"  class="btn save" tabindex="6">Save</button>
       <?php include('toolbar.php'); ?>
	   </div>
  
</form>
<div class="row">
  <div class="col-md-12" style="padding:15px;">
    <table id="breakdowntypegrid"></table>
  </div>
</div>
</div>
  </div>

</div>
</div>
<script>
/* Purpose for Duplicate Function for Payment term Name*/
    var dup_chk = true;
    function duplicate_validate()
    {
        var breakdown_name = $(".breakdown_name").val();
        var edit_id = $("#breakdowntype_id").val();
        $.ajax({
            cache: false,
            url: 'breakdowntypechkname',
            type: 'GET',
            dataType: 'json',
            async : false,
            data: {breakdown_name : breakdown_name,edit_id : edit_id},
            success: function(response)
            {
                if(response == 1)
                {
                    $('.dup_name').html('Breakdown Name:'+breakdown_name+' Already Exists');
                    $('.dup_name').show();

                    $(".breakdown_name").val('');
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
/*End*/
$(document).ready(function()
{
    /* Purpose For Upper Case*/
  $('.breakdown_name').on('keyup',function(){
  this.value= this.value.toUpperCase();
  $('.dup_name').hide();
  });
    /*End*/

/* Purpose for Submit Function*/
    var form=$("#save");
    form.parsley();
    form.submit(function(){
        $('input[name=_token]').val("{{csrf_token()}}");
        var data;
        change_date();
        form.parsley().validate();
    if (form.parsley().isValid())
    {
        data = form.serialize();
        var url="{{ URL::to('breakdowntype/save') }}";
        duplicate_validate();
         if(dup_chk==true){
        $.post(url, data, function(data1)
        {
         var msg    = data1.message;
         notyMsg('success',"<i class='' style='font-size:16px'></i>"+msg+"");
            $("#breakdowntypegrid")[0].triggerToolbar();
            $(".clear").trigger('click');
            //  $('#active').select2('val',['Yes']);
              /*$('#payment_term_name').select2({
          disabled: true
          });*/
        });
      }
        return false;
        }
    return false;
    });

           var form=$("#save");
    form.parsley();
    form.submit(function(){
         $('input[name=_token]').val("{{csrf_token()}}");
          var data;
        change_date();
        form.parsley().validate();
        duplicate_validate();
         if (form.parsley().isValid() && dup_chk == true)
    {
        
         var url="{{ URL::to('breakdowntype/save') }}";
                var formData = $('#save').serialize();
                  
    if(dup_chk==true){              
            $.ajax({
          url:  url,
          type:     'post',
          data:     formData,
          dataType: 'json',
          success: function (data1) {
            var msg    = data1.message;
         notyMsg('success',"<i class='' style='font-size:16px'></i>"+msg+"");
            $("#breakdowntypegrid")[0].triggerToolbar();
            $(".clear").trigger('click');
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
    } } 
    });



$("#breakdowntypegrid").jqGrid({

      url: "getbreakdowntypegridData",
      datatype: "json",
      mtype: "GET",
     
      colModel: [
    { name: "breakdowntype_id", label: "id" ,hidden:true},
    { name: "breakdown_name", label: "Breakdown Name" ,editable:true, editrules:{date:true}},
    { name: "description", label: "Description",editable:true, editrules:{date:true}},
     { name: "username", label: "Created By",hidden:true,editable:true, editrules:{date:true}},
    
 ],
                iconSet: "fontAwesome",
                rowNum: 10,
                rowList: [10,20,50,100,150,500,1000],
               // sortname: "breakdowntype_id",
                sortorder: "desc",
                viewrecords: true,
                gridview: true,
                rownumbers:true,
                pager: "#breakdowntypegrid",
                multiselect:false,
                multipageselection:true,
                searching: {
                defaultSearch: "cn",
                },
           });
      /*End*/     
   jQuery("#breakdowntypegrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});        
  showcolumn("breakdowntypegrid");
  /* Purpose For PDF Download*/
  $(document).on('click',".exportpdf",function() {
    $("#breakdowntypegrid").jqGrid('exportToPdf', {
  title: null,
  orientation: 'portrait',
  pageSize: 'A4',
  description: null,
  onBeforeExport: null,
  download: 'download',
  includeLabels : true,
  includeGroupHeader : true,
  includeFooter: true,
  fileName : "Breakdown Type.pdf",
  mimetype : "application/pdf"  
});   
});
/*Karthigaa Purpose For Excel Download*/  
  $(document).on('click',".exportexcel",function() {
            $("#breakdowntypegrid").jqGrid("exportToExcel",{
              includeLabels : true,
              includeGroupHeader : true,
              includeFooter: true,
              fileName : "Breakdown Type.xlsx"
        })     
  });

 $("#editdata").click(function(){

        var form=$("#save");

        form.parsley().destroy();
  var index = $("#breakdowntypegrid").jqGrid('getGridParam','selrow');
        var id = $("#breakdowntypegrid").jqGrid ('getCell', index, 'breakdowntype_id');
        var name = $("#breakdowntypegrid").jqGrid ('getCell', index, 'breakdown_name');
        var des = $("#breakdowntypegrid").jqGrid ('getCell', index, 'description');
  var created_by = jQuery("#breakdowntypegrid").jqGrid ('getCell', index, 'created by');
 //alert(index);
  

        if(index){
          var url ="{{ url('bkdwntypeedit') }}/" +id;
        $.get(url,function(data){
     if($.trim(data) =='1'){
        notyMsgs('info',"You Can't Edit  Used in SomeWhere");
      } else {

       $('#edit_id').val(id);
                        $('#breakdowntype_id').val(id);
                        $('#breakdown_name').val(name);
                        $('#description').val(des);  
                        $('#created by').select2('val',[created_by]);
                        $("#breakdowntypegrid").trigger('reloadGrid');
                        
      }
    });
                }
            else{
                    notyMsgs("info","Please Select a Row");
                }
            });
        /*End*/

/*purpose:clear search the jqgrid*/
  $(".clearsearch").click(function()
  {
    var grid = $("#breakdowntypegrid");
    grid.jqGrid('setGridParam',{search:false});
    var postData = grid.jqGrid('getGridParam','postData');
    $.extend(postData,{filters:""});
    grid.trigger("reloadGrid",[{page:1}]);
    $('input[id*="gs_"]').val("");
    
  });
  /*end*/
   /*purpose:clear the Input Fields*/
    $('.clear').click(function(){
      var form=$('#save');
       form.parsley().destroy();
       $('.breakdown_name').val();
        $('.description').val();
        $(':input','#save').not(':button, :submit, :reset').val('').prop('checked', false); 
  $(".dup_name").hide();
   
    });

   /* Purpose For Delete Function*/ 
$('.delete').click(function(){
 // alert("dfhgfd");
  var gr = jQuery("#breakdowntypegrid").jqGrid('getGridParam','selrow');
  var id = jQuery("#breakdowntypegrid").jqGrid ('getCell', gr,'breakdowntype_id');
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
          
        var url ="{{ url('bkdwntypedelete') }}/" +id;

        $.get(url,function(data)
        {
           
          var data = $.trim(data);
          if(data =='0')
          {
            notyMsgs('success','Deleted Successfully');
             $('.clearsearch').trigger('click');
              $(".reset").trigger('click');
              $("#breakdowntypegrid")[0].triggerToolbar();
           
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
    /*End*/

      $('.reset').click(function(){

               $('#breakdowntype_id').val('');
               $('#breakdown_name').val('');
               $('.created_by').val('');
               $('#description').val('');
                
            });


   });

</script>
@endsection

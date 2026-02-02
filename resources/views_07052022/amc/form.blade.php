@extends('layouts.header')
@section('content')
<div id="accordion">
<div class="panel-heading" role="tab" id="headingOne">
	<h4 class="panel-title">
     <a role="button">Create Vendor </a>
     </h4>
     </div>
 </div>
    <div class="card">
    <div class="card-body card-block">
	 <form id="save1" action="">
	
   {{ csrf_field()}}
<div class="row">
    <div class="col-md-6">
      <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-5"><span style="color:red;">*</span>Vendor Name</label>
            <div class="col-md-7">
                <input class="form-control vendor_id" id="vendor_id" name="vendor_id" size="16" type="hidden" value="" readonly>
                <input type="text" id="vendor_name" name="vendor_name" class="form-control vendor_name" value="" tabindex="1" required>
                <span class="btn btn-danger dup_name" style="display:none;"></span>
            </div>
            <div class="col-md-2"></div>
     </div>
           <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-5"><span style="color:red;">*</span>Vendor Address</label>
            <div class="col-md-7">
                <input type="text" type="text" id="address" name="address" class="form-control address" tabindex="2" value="" required>

            </div>
            
       </div>   
    </div>
    <div class="col-md-6">
    <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-5"><span style="color:red;">*</span>Vendor Email</label>
            <div class="col-md-7">
                <input type="text" type="text" id="email_id" name="email_id" class="form-control email_id" tabindex="2" value="" required>
                  </div>
            </div>
            <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-5"><span style="color:red;">*</span>Vendor Mobile</label>
            <div class="col-md-7">
                <input type="text" type="text" id="mobileno" name="mobileno" class="form-control mobileno" tabindex="2" value="" required>
                <span class="btn btn-danger email_vali" id="" style="display:none;"> Email format is example123@gmail.com</span>
                  </div>
            </div>
</div>
	 <div class="col-md-6">
<!--	  <div class="form-group row">
			<label for="active" class="form-control-label col-md-5">Created By</label>
			<div class="col-md-7" style="pointer-events:none;">
				<select name='created_by' rows='5' tabindex="4" class='select2 created_by' id="created_by" readonly >
		
				</select>
			</div>
		</div>-->
		 </div>
    </div>


    <div class="row text-center">
          
        <button type="submit"  class="btn success save" tabindex="5">Save</button> 
		
        <?php  include('toolbar.php'); ?>
   
    </div>


</form>

<div class="row">
            <div class="col-md-12">
            <hr class="xlg">
            </div>
            </div>


<div class="row">
<div class="col-md-12">
   <table id="vendorgrid"></table>
</div>
</div>


<div class="row">
            <div class="col-md-12">
            <hr class="xlg">
            </div>
            </div>


</div>

 </div>

<script>
/*Karthigaa Purpose for Duplicate Function for Payment term Name*/
    var dup_chk = true;
    function duplicate_validate()
    {
        var vendor_name = $(".vendor_name").val();
        var edit_id = $("#vendor_id").val();
        $.ajax({
            cache: false,
            url: 'amcname',
            type: 'GET',
            dataType: 'json',
            async : false,
            data: {vendor_name : vendor_name,edit_id : edit_id},
            success: function(response)
            {
                if(response == 1)
                {
                    $('.dup_name').html('Vendor Name:'+vendor_name+' Already Exists');
                    $('.dup_name').show();

                    $(".vendor_name").val('');
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

   $(document).on('keyup','.email_id',function()
    {
     $('.email_vali').hide();
   });

    /**************** email validation start ***********/
    function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
    $(document).on('click','.saveform',function()
    {
    
        if (!ValidateEmail($("#email_id").val())) {
            $('.email_vali').attr('id',1);
        }
        else {
            $('.email_vali').attr('id',0);
        }
    
    });
    /**************** email validation end ***********/







    /*Karthigaa Purpose For Upper Case*/
  $('.vendor_name').on('keyup',function(){
  this.value= this.value.toUpperCase();
  $('.dup_name').hide();
  });
    /*End*/

/*Karthigaa Purpose for Submit Function*/
    var form=$("#save1");
    form.parsley();
    form.submit(function(){
        $('input[name=_token]').val("{{csrf_token()}}");
        var data;
        change_date();
        form.parsley().validate();
    if (form.parsley().isValid())
    {
        data = form.serialize();
        var url="{{ URL::to('amc/save') }}";
        duplicate_validate();
         if(dup_chk==true){
        $.post(url, data, function(data1)
        {
         var msg    = data1.message;
         notyMsg('success',"<i class='' style='font-size:16px'></i>"+msg+"");
            $("#vendorgrid")[0].triggerToolbar();
            $("#vendorgrid").trigger('reloadGrid');
            $(".reset").trigger('click');
        });
       }
        return false;
        }
    return false;
    });



$("#vendorgrid").jqGrid({
      url: "getamcGridData",
      datatype: "json",
      mtype: "GET",
      colNames:['Vendor Id','Vendor Name', 'Address','Mobile No','Mail'],
      colModel: [
    { name: "vendor_id", label: "id" ,hidden:true},
    { name: "vendor_name", label: "Vendor Name" ,editable:true, editrules:{date:true}},
    { name: "address", label: "Vendor Address",editable:true, editrules:{date:true}},
    { name: "email_id", label: "Vendor Email",editable:true, editrules:{date:true}},
    { name: "mobileno", label: "Vendor Mobile No",editable:true, editrules:{date:true}},
//    { name: "username", label: "Created By", editable:true, editrules:{date:true}},
 ],
                iconSet: "fontAwesome",
                rowNum:10,
		viewrecords: true,
		footerrow: true,
		rownumbers: true ,
		userDataOnFooter: true, // use the userData parameter of the JSON response to display data on footer
		rowList: [10,20, 50, 100,250,500,1000],
                sortable:true,
		pager: "#vendorgrid",
                sortorder:"desc",
                gridview: true,
           });
      /*End*/     
           
  jQuery("#vendorgrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
  $("#vendorgrid").jqGrid("setLabel", "rn", "S.No");
   showcolumn("vendorgrid");
   
  /*Karthigaa Purpose For PDF Download*/
  $(document).on('click',".exportpdf",function() {
   	$("#vendorgrid").jqGrid('exportToPdf', {
  title: null,
  orientation: 'portrait',
  pageSize: 'A4',
  description: null,
  onBeforeExport: null,
  download: 'download',
  includeLabels : true,
  includeGroupHeader : true,
  includeFooter: true,
  fileName : "Payment Terms.pdf",
  mimetype : "application/pdf"  
});		
});
/*Karthigaa Purpose For Excel Download*/	
	$(document).on('click',".exportexcel",function() {
            $("#vendorgrid").jqGrid("exportToExcel",{
					includeLabels : true,
    					includeGroupHeader : true,
    					includeFooter: true,
    					fileName : "Payment Terms.xlsx"
				})		 
	});
/*Karthigaa Purpose for Edit Function*/
 $("#editdata").click(function(){
        var form=$("#save1");
        form.parsley().destroy();
	var index = $("#vendorgrid").jqGrid('getGridParam','selrow');
        var id = $("#vendorgrid").jqGrid ('getCell', index, 'vendor_id');
        var name = $("#vendorgrid").jqGrid ('getCell', index, 'vendor_name');
        var address = $("#vendorgrid").jqGrid ('getCell', index, 'address');
        var mobileno = $("#vendorgrid").jqGrid ('getCell', index, 'mobileno');
        var email_id = $("#vendorgrid").jqGrid ('getCell', index, 'email_id');

	
        if(index){
         		 $('#edit_id').val(id);
                        $('#vendor_id').val(id);
                        $('#vendor_name').val(name);
                        $('#address').val(address);
                        $('#mobileno').val(mobileno);
                        $('#email_id').val(email_id);  
                        $("#vendorgrid").trigger('reloadGrid');
                }
            else{
                    notyMsgs("info","Please Select a Row");
                }
            });
        /*End*/

/*purpose:clear search the jqgrid*/
  $(".clearsearch").click(function()
  {
    var grid = $("#vendorgrid");
    grid.jqGrid('setGridParam',{search:false});
    var postData = grid.jqGrid('getGridParam','postData');
    $.extend(postData,{filters:""});
    grid.trigger("reloadGrid",[{page:1}]);
    $('input[id*="gs_"]').val("");
    
  });
  /*end*/
   /*purpose:clear the Input Fields*/
  
      $(document).on('click','.reset',function()
    {
    var form=$("#save1");
   form.parsley().destroy();
        $(':input')
        .not(':button, :submit, :reset')
        .val('')
        .prop('checked', false);

        
    });
   /*Karthigaa Purpose For Delete Function*/ 
$(".delete").click(function(){
  var gr = jQuery("#vendorgrid").jqGrid('getGridParam','selrow');
  var id = jQuery("#vendorgrid").jqGrid ('getCell', gr,'vendor_id');
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
        var url ="{{ url('amcdelete') }}/" +id;
        $.get(url,function(data)
        {
          var data = $.trim(data);
          if(data =='0')
          {
            notyMsgs('success','Deleted Successfully');
             $('.clearsearch').trigger('click');
              $(".reset").trigger('click');
              $("#vendorgrid")[0].triggerToolbar();
           
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
   });

</script>

@endsection

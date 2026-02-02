@extends('layouts.header')
@section('content')

<h2 class="heads">PRODUCT</h2>

<div class="card">

    <div class="card-body card-block">

      <form  action="" id="save">
        <input type="hidden" name="edit_id" value="" id="edit_id" />
                {{ csrf_field()}}

<div class="row">
  <div class="col-md-6">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Organization Name</label>
          <div class="col-md-7">
             
              <input type="text" id="organization_name" name="organization_name" class="form-control organization_name" value="" required style="width:100%;" tabindex="1">
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
    <table id="grid1"></table>
  </div>
</div>
</div>
</div>

<script>
        



	$(document).ready(function(){



 
	
		
	$("#grid1").jqGrid(
            {
                url: "organizationgrid",
                datatype: "json",
                mtype: "GET",
                colModel: [
                    { name: "organization_id", label: "organization_id", width: 250, hidden: true },
                    { name: "organization_name", label: "Organization Name", width: 250,editable: true},
                    { name: "description", label: "Description", width: 250,editable:true},
                    
                ],

                iconSet: "fontAwesome",
                rowNum: 10,
                rowList: [10,20,100,1000,2000],
                sortname: "organization_id",
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
	
	
	
        /* end */

            $(document).on('click', '.saveform', function() {
                var url = "{{ url('organization/save') }}";
                var form = $('#save');
                form.parsley().validate();
                var form = $('#save');
                form.parsley().validate();
                if (form.parsley().isValid()) {
                    change_date();
                    var formdata = $('#save').serialize();
                    $.post(url, formdata, function(data) {
                        var data = $.trim(data);
                        if(data == 1){
                            notyMsg("success","Saved Successfullly");
                            $("#grid1")[0].triggerToolbar();
                            $(".reset").trigger('click');
                        }
                        else{
                            notyMsg("success","Updated Successfullly");
                            $("#grid1")[0].triggerToolbar();
                            $(".reset").trigger('click');
                        }
                       
                    });
                }
            });
            
            $("#editdata").click(function()
            {
                var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
                var organization_id = jQuery("#grid1").jqGrid ('getCell', gr, 'organization_id');
                var organization_name = jQuery("#grid1").jqGrid ('getCell', gr, 'organization_name');
                var description = jQuery("#grid1").jqGrid ('getCell', gr, 'description');
               if( organization_id)
                {
                     $('#edit_id').val(organization_id);
                  //  $('#department_id').val(department_id);
                    $('#description').val(description);
                    $('#organization_name').val(organization_name);
                   

                }
                else
                {
                    notyMsg('INFO','Please Select a Row');
                }
            });

              
            $(document).on('click','.del',function(e){
                e.preventDefault();
                var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
                var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'organization_id');
             
                if(cellValue )
                {
                    $.get('organizationdelete?del_id='+cellValue, function(data,status)
                    {
                        if(data == 0)
                        {
                            notyMsg('Warning','Deleted Successfully');
                            $("#grid1")[0].triggerToolbar();
                        }
                        else if(data == 2)
                        {
                            notyMsg('SUCCESS','Deleted Successfully');
                            $("#grid1")[0].triggerToolbar();
                        }
                    });
                }
                else
                {
                    notyMsg('Info','Please Select a Row');
                }


            });


		
            $('.reset').click(function(){

               $('#organization_id').val('');
               $('#organization_name').val('');
               $('#description').val('');
                
            });




	});
	</script>
@endsection

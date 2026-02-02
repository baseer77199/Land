@extends('layouts.header')
@section('content')

<h2 class="heads">Taks manager   
    <span class="ui_close_btn">
        <a href="../<?php echo $pageMethod; ?>" class="collapse-close pull-right btn-danger" ></a>
    </span>
</h2>


<div class="card">

<div class="card-body card-block">
<form method="post" action="{{URL::to('taskmanagersave')}}" id="taskmanager" class="taskmanager"  enctype="multipart/form-data">
	 {{ csrf_field() }}

<div class="row">
<div class="col-md-12">


    <!--************************ Body content start here **********************-->
      
    <div class="col-md-4">
	
	 <div class="form-group row">
            <label for="active" class="form-control-label col-md-4">Created By</label>
            <div class="col-md-6" style="pointer-events:none;">
                <select name='created_by' rows='5' class='select2 created_by' id="created_by" >
                    {!! $row->created_by !!}
                </select>
            </div>
        </div>
	
	
          
      

       

        <div class="form-group row">
            <label for="assigned_to" class="form-control-label col-md-4"><span style="color: red;" > * </span>Assigned To</label>
            <div class="col-md-6">
                <select class="form-control assigned_to select2" id="assigned_to" name="assigned_to" required >
                    {!! $row->assigned_to !!}
                </select>
            </div>
        </div>

        <div class="form-group row">
            <label for="start_date" class="form-control-label col-md-4">Start Date</label>
            <div class="col-md-6">
                <input type="text" name='start_date' rows='5' class='form-control start_date'  id="start_date" value="{{$row->start_date}}">                
            </div>
        </div>

    </div>

    <div class="col-md-4">
        <div class="form-group row">
            <label for="end_date" class="form-control-label col-md-4">End Date</label>
            <div class="col-md-6">
                <input type="text" name='end_date' rows='5' class='form-control end_date'  id="end_date" value="{{$row->end_date}}">
            </div>
        </div>

        <div class="form-group row">
            <label for="department_lead" class="form-control-label col-md-4"><span style="color: red;" > * </span>Department Lead</label>
            <div class="col-md-6">
                <select class="form-control department_lead select2" id="department_lead" name="department_lead" required >
                    {!! $row->department_lead !!}
                </select>
            </div>
        </div>
        

        <div class="form-group row">
            <label for="grade" class="form-control-label col-md-4"><span style="color: red;" > * </span>Task</label>
            <div class="col-md-6">
                <input type="text" name='task' rows='5' class='form-control task '  id="task" value="{{$row->task}}" required >
            </div>
        </div>

    </div>

    <div class="col-md-4">
      
     

        <div class="form-group row">
            <label for="description" class="form-control-label col-md-4">Description  </label>
            <div class="col-md-6">            
                <textarea name='description' rows='5' class='form-control description '  id="description"  >
                    {!! $row->description !!}
                </textarea>
            </div>
        </div>        

      
		
		  <div class="form-group row">
            <label for="department" class="form-control-label col-md-4 "><span style="color: red;" > * </span>Assign Department</label>
            <div class="col-md-6">
                <input class="form-control taskmanager_id" id="taskmanager_id" name="taskmanager_id" size="16" type="hidden" value="{{ $row->taskmanager_id }}" readonly>
                <select class="form-control department select2" id="department" name="department" required >
                    {!! $row->department !!}
                </select>
            </div>
        </div>
		
		<?php if($pageMethod == "update") { ?>
  		  <div class="form-group row">
            <label for="department" class="form-control-label col-md-4 "><span style="color: red;" > * </span>Update status</label>
            <div class="col-md-6">
               
                <select class="form-control  select2"  name="status" required >
                   
                   <option> --- Please Select ---</option>
                   <option value="Completed">Completed</option>
                   <option value="Pending">Pending</option>
                </select>
            </div>
        </div>
		<?php } else { ?>
        
		 <div class="form-group row" style="display:none;">
            <label for="status" class="form-control-label col-md-4">Taskmanager Status</label>
            <div class="col-md-6">
                <select name="status" id="status" class="form-control status" readonly>
                    <option value="">--Please Select--</option>
                    <option <?php if($row->status =="INITIATED") { echo "selected"; } else { echo ""; } ?> value="INITIATED">INITIATED</option>
                    <option <?php if($row->status =="APPROVED") { echo "selected"; } else { echo ""; } ?> value="APPROVED">APPROVED</option>
                    <option <?php if($row->status =="REJECTED") { echo "selected"; } else { echo ""; } ?> value="REJECTED">REJECTED</option>
                </select>
            </div>
        </div>
		
		
		<?php } ?>	
    </div>

</div>
</div>
    

    	<div class="row">
    		<div class="col-lg-12 col-md-12">
    			<div class="form-group text-center">
    				<?php if($pageMethod == "taskmanager"){ ?>
        				<button type="button" class="btn save saveform" value ="SAVE" >Save</button>
        				<button type="button" class="btn save saveform"   value ="SAVENEW" >Save and New</button>
    			    <?php }else if($pageMethod == "update") { ?>
					 <button type="button" class="btn save saveform" value ="APPROVED" >Update</button>
					<?php } else { ?>
                        <button type="button" class="btn save saveform" value ="APPROVED" >Approve</button>
                        <button type="button" class="btn save saveform"   value ="REJECTED" >Reject</button>
                        
                    <?php } ?>
                    <a class='btn cancel' onclick="location.href = '{{url::to($pageMethod)}}'">Cancel</a>
    			</div>
    		</div>
    	</div>

</form>

</div>
</div>

<link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.css')}}">

<script>



$(document).ready(function(){

   
	$(document).on('click','.saveform',function()
    {

    	var btnval		= $(this).val();
        if(btnval == 'SAVE' || btnval == 'SAVENEW')
            $("#status").val('INITIATED');
        if(btnval == "APPROVED")
            $("#status").val('APPROVED');
        if(btnval == "REJECTED")
            $("#status").val('REJECTED');

    	var url			="{{ url('taskmanagersave') }}";

        var red_url		="{{URL::to($pageMethod)}}";

        var create_url	="{{ url('taskmanagercreate') }}/0";
        

        validationrule('taskmanager');
        
        var form = $('#taskmanager');

       	form.parsley().validate();
       	var form = $('#taskmanager');
       	form.parsley().validate();
        if (form.parsley().isValid())
        {    
            change_date();     
            var formdata    = $('#taskmanager').serialize();
            $.post(url,formdata,function(data)
            {
            	var status = data.status;
                var msg    = data.message;
                var id     = data.id;

                if(btnval == 'SAVENEW' )
                {
                    notyMsg(status,msg);
    		        setTimeout(function(){
            			window.location.href=create_url;
                    }, 1500);
                }
                else
                {
                    notyMsg(status,msg);
    	            setTimeout(function(){
        	           window.location.href=red_url;
                    }, 1000);
                }
            });
        } 
        
        return false;

    });


    var data ="{{\Session::get('j_date_format')}}";
    
 var dateToday = new Date();
    $('.start_date').datepicker({
      dateFormat: data,
      minDate: dateToday,
      maxDate: null,
       onSelect: function(selected) {
        
        $('#end_date').datepicker("option", "minDate",  $(".start_date").datepicker('getDate') )
       }
    });

    $('.end_date').datepicker({
      dateFormat: data,
      minDate: dateToday,
      maxDate: null,
    }); 

});



</script>
@include('layouts.php_js_validation')
@endsection
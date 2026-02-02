@extends('layouts.header')
@section('content')
	
<style type="text/css">

 /*purpose to remove double border & overlap*/
 .select2-selection__rendered {
     font-size: 11px !important;
 }
 
 .select2-container--default .select2-selection--multiple {
     border: none !important;
 }
 
 .select2-container .select2-selection--multiple {
     box-sizing: border-box !important;
     cursor: pointer !important;
     display: block !important;
     min-height: 27px !important;
     user-select: none !important;
     -webkit-user-select: none !important;
 }
 

.select2-container{
	height: auto !important;
}
.select2-selection--multiple{
	height: 40px;
	overflow-y: auto;
}/*end*/
 </style>

 <div class="ajaxLoading"></div>
 <?php if($pageMethod=="initiatepmcreate") { ?>
         <h2 class="heads">Initiate PM <span class="ui_close_btn"><a href="{{ URL::to('initiatepm') }}" class="collapse-close pull-right btn-danger" ></a></span></h2>
 <?php } else {?>
       <h2 class="heads">Initiate PM Reschedule <span class="ui_close_btn"><a href="{{ URL::to('initiatepmreschedule') }}" class="collapse-close pull-right btn-danger" ></a></span></h2>
   
 <?php } ?>
		<form method="post" action="" id="initiatepm" data-parsley-validate>
		<input type="hidden" value="" name="savestatus" id="savestatus" />

		{{ csrf_field() }}
		
		<div class="card">
		
		<div class="card-body card-block headerdiv1">

		<div class="row">
				<div class="col-md-12">
				<div class="row">
		<div class="col-md-6">
			
		<div class="form-group row">

				<label for="inputIsValid" class="form-control-label col-md-4">PM No</label>
				<div class="col-md-6">
				<input type="hidden" name="initiate_pm_id" id="initiate_pm_id" class="form-control initiate_pm_id" value="{{$initiate_pm_id}}" readonly>
			<input type="text" id="pm_no" name="pm_no" class="form-control pm_no" value="{{$pm_no}}"  readonly>
					   <span class="btn btn-danger dup_name" style="display:none;"></span>
			</div>
			</div>
			

                    <div class="form-group row">
                            <label for="active" class="form-control-label col-md-4">Machine Name</label>
                            <div class="col-md-6" style="pointer-events:none;" >
                            <select name='machine_id'  class='select2 machine_id' id="machine_id"  >
                          {!! $machine_id !!}
                            </select>
                        </div>
                    </div>
       
                    <div class="form-group row">
                <label for="actual_pm_date" class="form-control-label col-md-4">Actual PM Date</label>
                <div class="col-md-6 actual_pm_date_div" style="pointer-events:none;">
                <input type='text' name="actual_pm_date" id="actual_pm_date" rows='5' tabindex="3" class='form-control actual_pm_date datepicker' data-link-format="yyyy-mm-dd" value="{{$actual_pm_date}}">
                </div>
                <div class="col-md-2">
                </div>
            </div>
                    <div class="form-group row">
				<label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>User Department Clearance</label>
				<div class="col-md-6">
			<select name='user_clearance_by[]'  class='select2 user_clearance_by' id="user_clearance_by" required="true" multiple >
                          {!! $user_clearance_by !!}
                            </select>
					 
			</div>
			</div>
		</div>
	
		<div class="col-md-6">
		<div class="form-group row">
                            <label for="active" class="form-control-label col-md-4">Department Name</label>
                            <div class="col-md-6" style="pointer-events:none;" >
                            <select name='department_id'  class='select2 department_id' id="department_id"  >
                          {!! $department_id !!}
                            </select>
                        </div>
                    </div>
		
	<div class="form-group row">
        <label for="inputIsValid" class="form-control-label col-md-4">Machine Number</label>
        <div class="col-md-6" style="pointer-events:none;">
            <select name="machine_number" class="form-control machine_number select2" style="width: 100%;" tabindex="4">
                {!!  $machine_number !!}
            </select>
        </div>
    </div>
                     <div class="form-group row">
                <label for="delivery_date" class="form-control-label col-md-4">Initiate PM Date</label>
                <div class="col-md-6 actual_pm_date_div">
                <input type='text' name="initiate_date" id="initiate_date" rows='5' tabindex="3" class='form-control initiate_date datepicker1' data-link-format="yyyy-mm-dd" value="{{$initiate_date}}">
                </div>
                <div class="col-md-2">
                </div>
            </div>
       
		</div>
			</div>
				</div>
			</div>
	<!------------------------------------------------------------------------------------------>
		<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="form-group text-center">
				
				<button type="button" class="btn save saveform" value="SAVE">Save</button>
				<!--<button type="button" class="btn save saveform"   value="SAVENEW">SUBMIT AND NEW</button>-->
				
                                   <?php if($pageMethod=="initiatepmcreate") { ?>
           <a href="{{ URL::to('initiatepm') }}" class='btn cancel'>Cancel</a>
             <?php } else {?>
       <a href="{{ URL::to('initiatepmreschedule') }}" class='btn cancel'>Cancel</a>
 <?php } ?>
			</div>
		</div>
		</div>
		</div>
 	</div>
		
		</form>
<script>
 $(document).ready(function()
 {
     var datetoday="{{$actual_pm_date}}";
     var parsedDate = $.datepicker.parseDate("yy-mm-dd", datetoday);
       var data ="{{\Session::get('j_date_format')}}";
  $( ".datepicker1" ).datepicker({
      changeMonth: true,
      dateFormat: data,
      changeYear: true,	  minDate: parsedDate,
      maxDate: null,
      onClose: function () {
        $(this).parsley().validate();
        }

    });
	
/*deepika purpose:to save function*/
		$('#savestatus').val('');
		$(document).on('click','.saveform',function()
		{      
                      
				var btnval		= $(this).val();
				if(btnval == 'APPLYCHANGES')
					var savestatus = 'APPLY CHANGES';
				else if(btnval == 'SAVE' || btnval == 'SAVENEW')
					var savestatus = 'SAVE';

				$('#savestatus').val(savestatus);
				var url		= "{{ URL::to('initiatepmsave') }}";
                                     <?php if($pageMethod=="initiatepmcreate") { ?>
           var red_url		="{{ URL::to('initiatepm') }}";
             <?php } else {?>
                 var red_url		="{{ URL::to('initiatepmreschedule') }}";
 <?php } ?>
				
				var create_url	="{{ URL::to('initiatepmcreate') }}";
			    //capacityrequiredvalid();
				validationrule('initiatepm');
				var formdata	= $('#initiatepm').serialize();
				var form = $('#initiatepm');
				if(btnval != 'APPLYCHANGES')
				{
					form.parsley().validate();
					var form = $('#initiatepm');
					form.parsley().validate();
					if (form.parsley().isValid())
					{	
					
				 var formData = $('#initiatepm').serialize();
            $.ajax({
          url:     "{{ url('initiatepmsave') }}",
          type:     'post',
          data:     formData,
          dataType: 'json',
          success: function (response) {
            //  console.log(response);
         	var status      = response.status;
       							var msg     = '<span style="color:#090065">'+response.message+'</span>  ';
						
							if(btnval !='SAVE' && btnval !='DRAFT')
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
								}, 1500);
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
       
				// 		$.post(url,formdata,function(data)
				// 		{
				// 			var status      = data.status;
				// 			var msg     = '<span style="color:#090065">'+data.message+'</span>  ';
						
				// 			if(btnval !='SAVE' && btnval !='DRAFT')
				// 			{

				// 				notyMsg(status,msg);
				// 				setTimeout(function(){
				// 				window.location.href=create_url;
				// 				}, 1500);
				// 			}
				// 			else
				// 			{
				// 				notyMsg(status,msg);
				// 				setTimeout(function(){
				// 				window.location.href=red_url;
				// 				}, 1500);
				// 			}
				// 		});
						
					return false;
					}
				}
		});
    /*end*/



		});
</script>
		@include('layouts.php_js_validation')
		@endsection
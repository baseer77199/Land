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
         <h2 class="heads">PM Clearance <span class="ui_close_btn"><a href="{{ URL::to('pmclearance') }}" class="collapse-close pull-right btn-danger" ></a></span></h2>
		
		<form method="post" action="" id="pmclearance" data-parsley-validate>
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
                                <input type="hidden" name="status" class="status">
                                <input type="hidden" name="postpone_status" class="postpone_status">
				
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
       
                    <div class="form-group row" style="pointer-events:none;">
                <label for="delivery_date" class="form-control-label col-md-4">Initiated Date</label>
                <div class="col-md-6 actual_pm_date_div" >
                <input type='text' name="actual_pm_date" id="actual_pm_date" rows='5' tabindex="3" class='form-control actual_pm_date datepicker' data-link-format="yyyy-mm-dd" value="{{$initiate_date}}">
                </div>
                <div class="col-md-2">
                </div>
            </div>
                    <div class="form-group row "> 
                        <label for="Change Initiated Date" class=" control-label col-md-4"><span style="color:red;">*</span> 
					Change Initiated Date</label>
					<div class="col-md-6">
                                            <select name="change_date" class="select2 change_date file" required>
                                                <option value="0">Please Select</option>
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                                </select>
                                           </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div>
                     <div class="form-group row clearance_date">
                <label for="actual_pm_date" class="form-control-label col-md-4"><span style="color:red;">*</span> Postpone To</label>
                <div class="col-md-6">
                <input type='text' name="postponed_date" id="postponed_date" rows='5' tabindex="3" class='form-control postponed_date datepicker' data-link-format="yyyy-mm-dd" value="">
                </div>
                <div class="col-md-2">
                </div>
            </div>
                    <div class="form-group row shift_timings">
                <label for="shift_timing" class="form-control-label col-md-4"><span style="color:red;">*</span> Shift Timing</label>
                <div class="col-md-6">
                <input type='text' name="shift_timing" id="shift_timing" rows='5' tabindex="3" class='form-control shift_timing timepicker' data-link-format="yyyy-mm-dd" value="">
                </div>
                <div class="col-md-2">
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
				<label for="inputIsValid" class="form-control-label col-md-4">User Clearance By</label>
                    <div class="col-md-6" style="pointer-events:none;">
			<select name='user_clearance_by[]'  class='select2 user_clearance_by' id="user_clearance_by" multiple>
                          {!! $user_clearance_by !!}
                            </select>
					 
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
				
				<!--<button type="button" class="btn save saveform" value="SAVE">SUBMIT</button>-->
                                <button type="submit" class="btn save save_btn saveform" value="SAVE"><i class="fa  fa-save "></i>  Accept </button>
					<button type="submit" class="btn save postpone_btn saveform" value="SAVE"><i class="fa  fa-save "></i>  Postpone </button>
				<!--<button type="button" class="btn save saveform"   value="SAVENEW">SUBMIT AND NEW</button>-->
				  <a href="{{ URL::to('pmclearance') }}" class='btn cancel'>Cancel</a>
			</div>
		</div>
		</div>
		</div>
 	</div>
		
		</form>
<script>
 $(document).ready(function()
 {
     
             $(".clearance_date,.shift_timings").hide();
     $(document).on("change",".change_date",function(){ 
    if(($(".change_date").select2("val"))=="1") {
        $(".save_btn").prop("disabled",true);
        $(".postpone_btn").prop("disabled",false);
        $(".clearance_date").show();
        $(".shift_timings").hide();
        $(".postponed_date").val("");
        $(".postponed_date").attr('required', 'required');
        $(".shift_timing").removeAttr('required', false);
    }
    else{
        
       $(".clearance_date").hide(); 
       $(".shift_timings").show();
       $(".save_btn").prop("disabled",false);
       $(".postpone_btn").prop("disabled",true);
       $(".shift_timing").val("");
       $(".shift_timing").attr('required', 'required');
       $(".postponed_date").removeAttr('required', false);
    }
});	
$(".postpone_btn,.save_btn").prop("disabled",true);
 $(".postpone_btn").click(function()
        {
         
			$(".status").val("0");
			$(".postpone_status").val("1");
        });
        
        $(".save_btn").click(function()
        {
           
            $(".status").val("1");
			$(".postpone_status").val("0");
        });
/* purpose:to save function*/
		$('#savestatus').val('');
		$(document).on('click','.saveform',function()
		{      
                      
				var btnval		= $(this).val();
				if(btnval == 'APPLYCHANGES')
					var savestatus = 'APPLY CHANGES';
				else if(btnval == 'SAVE' || btnval == 'SAVENEW')
					var savestatus = 'SAVE';

				$('#savestatus').val(savestatus);
				var url		= "{{ URL::to('pmclearancesave') }}";
				var red_url		="{{ URL::to('pmclearance') }}";
				var create_url	="{{ URL::to('pmclearancecreate') }}";
				validationrule('pmclearance');
				var formdata	= $('#pmclearance').serialize();
				var form = $('#pmclearance');
				if(btnval != 'APPLYCHANGES')
				{
					form.parsley().validate();
					var form = $('#pmclearance');
					form.parsley().validate();
					if (form.parsley().isValid())
					{	
						
				 var formData = $('#pmclearance').serialize();
            $.ajax({
          url:  url,
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
// 						$.post(url,formdata,function(data)
// 						{
// 							var status      = data.status;
// 							var msg     = '<span style="color:#090065">'+data.message+'</span>  ';
// 							var id          = data.id;
// //							var edit_url	= "{{ URL::to('agencyedit') }}/"+id;
// 							if(btnval !='SAVE' && btnval !='DRAFT')
// 							{

// 								notyMsg(status,msg);
// 								setTimeout(function(){
// 								window.location.href=create_url;
// 								}, 1500);
// 							}
// 							else
// 							{
// 								notyMsg(status,msg);
// 								setTimeout(function(){
// 								window.location.href=red_url;
// 								}, 1500);
// 							}
// 						});
					return false;
					}
				}
		});
    /*end*/


		});
</script>
		@include('layouts.php_js_validation')
		@endsection
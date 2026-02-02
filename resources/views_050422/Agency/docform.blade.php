@extends('layouts.header')
@section('content')
	
<style type="text/css">
/*purpose to align field width based on resolution*/
 @media only screen and (min-width: 1500px) {
     .bulk_line_no {
         width: 150px !important;
     }
     .bulk_product_type_id {
         width: 550px !important;
     }
     .bulk_machine_capacity {
         width: 550px !important;
     }
 }
 
  @media only screen and (min-width: 2000px) {
     .bulk_line_no {
         width: 50px !important;
     }
     .bulk_product_type_id {
         width: 650px !important;
     }
     .bulk_machine_capacity {
         width: 550px !important;
     }
 }
 .bulk_line_no {
     width: 50px;
 }
 
 .bulk_product_type_id {
     width: 330px;
 }
 
 .bulk_machine_capacity {
     width: 120px;
 }
 
 /*end*/
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
  <?php if($pagemethod!="documentcreate") { ?>
         <h2 class="heads">RENEWAL CALIBRATION<span class="ui_close_btn"><a href="{{ URL::to('documents') }}" class="collapse-close pull-right btn-danger" ></a></span></h2>
  <?php }else {?>
      <h2 class="heads">CALIBRATION<span class="ui_close_btn"><a href="{{ URL::to('documents') }}" class="collapse-close pull-right btn-danger" ></a></span></h2>
  <?php  } ?>
		<form method="post" action="" id="agency" data-parsley-validate >
		<input type="hidden" value="" name="edit_id" id="edit_id" />

		{{ csrf_field() }}
		
		<div class="card">
		
		<div class="card-body card-block headerdiv1">

		<div class="row">
				<div class="col-md-12">
				<div class="row">
		<div class="col-md-4">
			                      <div class="form-group row">
            <label for="active" class="form-control-label col-md-4"><span style="color:red">*</span>Department</label>
            <div class="col-md-6" >
                <select name="department_id" id="department_id" class="department_id select2" required="true">
                {!!$department_id!!}
               
                </select>
            </div>
        </div>
		
			
           <div class="form-group row">
			<label for="inputIsValid" class="form-control-label col-md-4">Valid From</label>
			<div class="col-md-6">
				<input type="text" name="valid_from" id="valid_from" class="form-control valid_from datepicker"  value="{{ $row->valid_from }}"/>
			</div>
			<div class="col-md-2">
		  </div>
		</div>
		
			
			<div class="form-group row">
                        <label for="inputIsValid" class="form-control-label col-md-4"> <span style="color:red">*</span> <?php if($pagemethod!="documentcreate") { ?>Actual Renewal Date <?php } else { ?>Renewal Date<?php } ?></label>
			<div class="col-md-6">
				<input type="text" name="renewal_date" id="renewal_date" class="form-control renewal_date datepicker"  value="{{ $row->renewal_date }}" required="true"/>
			</div>
			<div class="col-md-2">
		  </div>
		</div>
                          <?php if($pagemethod!="documentcreate") { ?>
				<div class="form-group row">
			<label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Next Renewal Date</label>
			<div class="col-md-6">
                            <input type="text" name="new_renewal_date" id="new_renewal_date" class="form-control new_renewal_date datepicker"  value="" required="">
			</div>
			<div class="col-md-2">
		  </div>
		</div>
                          <?php } ?>
		</div>
	
		<div class="col-md-4">
		
                    <div class="form-group row">
				<label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Machine</label>
				<div class="col-md-6">
			<select id="machine_id" name="machine_id"  class="select2  machine_id" required="true">
                          {!! $machine_id !!}
                        </select>
				</div>	 
			</div>
       	<div class="form-group row">
			<label for="inputIsValid" class="form-control-label col-md-4">Valid To</label>
			<div class="col-md-6">
				<input type="text" name="valid_to" id="valid_to" class="form-control valid_to datepicker"  value="{{ $row->valid_to }}"/>
			</div>
			<div class="col-md-2">
		  </div>
		</div>
		
	
              <div class="form-group row">
			<label for="inputIsValid" class="form-control-label col-md-4">Remainder Days</label>
			<div class="col-md-6">
				<input type="text" name="remainder_days" id="remainder_days" class="form-control remainder_days" row="5" value="{{ $row->remainder_days }}" />
			</div>
			<div class="col-md-2">
		  </div>
		</div>
                    
		</div>
                                    
		 <div class="col-md-4">
		<div class="form-group row">
				<label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Frequency</label>
				<div class="col-md-6">
			<select id="frequency" name="frequency"  class="select2  mobile_no" required="true">
                        {!! $frequency !!}
                        </select>
					 
			</div>
			</div>
	
                     <div class="form-group row">
			<label for="inputIsValid" class="form-control-label col-md-4">Description</label>
			<div class="col-md-6">
				<input type="text" name="description" id="description" class="form-control description" row="5" value="{{ $row->description }}" />
			</div>
			<div class="col-md-2">
		  </div>
		</div>
	                  
                      <div class="form-group row">
			<label for="inputIsValid" class="form-control-label col-md-4">File</label>
			<div class="col-md-6">
                            <input type="file" name="file[]" id="file"   class="form-control file" multiple>
			</div>
                        
			<div class="col-md-2"> 
                         
		  </div>
		</div>
                     
                 
                      <?php if($row->document_id!="" && $row->file!="") { ?>
                       <div class="form-group row">
			<label for="inputIsValid" class="form-control-label col-md-4">File Download</label>
			<div class="col-md-6">
                              @php
                                    $row = json_decode( $row->file);
                                    @endphp
                                    @if(!empty($row))
                                        @foreach($row as $key => $v)
                                        <p><a download href="{{URL::to('')}}/document/{{$v}}">{{$v}}&nbsp;</a>
                                        <a target="_blank" href="{{URL::to('')}}/document/{{$v}}" onclick="ajaxViewDetail('#attendanceregular',this.href); return false;"><i class="fa  fa-eye" id"view"></i></a></p>
                                        @endforeach
                                  
                                   @endif
			</div>
                        
			<div class="col-md-2"> 
                         
                     
		  </div>
		</div>
                      <?php } ?>
                     		
		</div>
                                    
			</div>
				</div>
			</div>

                

		<!------------------------------------------------------------------------------------------>
		<div class="row">
		<div class="col-lg-12 col-md-12">
			<div class="form-group text-center">
				        <?php if($pagemethod=="documentcreate") { ?>
				<button type="button" class="btn save saveform" value="SAVE">SAVE</button>
				<button type="button" class="btn save saveform"   value="SAVENEW">SAVE AND NEW</button>
                <a href="{{ URL::to('documents') }}" class='btn cancel'>Cancel</a>
                                        <?php } else { ?>
                <button type="button" class="btn save saveform" value="RENEW">Renew</button>
                <a href="{{ URL::to('renewal') }}" class='btn cancel'>Cancel</a>
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
       $(document).on('change','.department_id',function(){
           
            var department_id=$('.department_id option:selected').val();
            var session_loca="{{\Session::get('location')}}";
            var condition ="department_id="+department_id+" and locationid="+session_loca;
            $(".machine_id").html('');
          $(".machine_id").jCombo("{{ URL::to('jcomboform?table=machine_hdr_t:machine_id:machine_name') }}&order_by=machine_id asc"+'&parent='+condition,
                {selected_value: "" });
                
            });
       
		$('#edit_id').val('');
		$(document).on('click','.saveform',function()
		{      
                      
				var btnval		= $(this).val();
				if(btnval == 'APPLYCHANGES')
					var edit_id = 'APPLY CHANGES';
				else if(btnval == 'SAVE' || btnval == 'SAVENEW')
                                    var edit_id = 'SAVE';
                                    else if(btnval == 'RENEW')
					var edit_id = 'RENEW';
				$('#edit_id').val(edit_id);
				var url		= "{{ URL::to('documentsave') }}";
                                    <?php if($pagemethod=="documentcreate") { ?>
				var red_url		="{{ URL::to('documents') }}";
                                    <?php } else{ ?>
                                        	var red_url		="{{ URL::to('renewal') }}";
                                    <?php } ?>
				var create_url	="{{ URL::to('documentcreate') }}";
 				validationrule('agency');
			
				var form = $('#agency');
				if(btnval != 'APPLYCHANGES')
				{
					form.parsley().validate();
					var form = $('#agency');
					form.parsley().validate();
					if (form.parsley().isValid())
					{	
						change_date();
       	var formdata	= $('#agency').serialize();
         var form_data = new FormData(document.getElementById('agency'));   
		$('.ajaxLoading').show();
                 $.ajax({
                  url: url,
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
                                var percent = 0;
                                var position = event.loaded || event.position;
                                var total = event.total;
                                if (event.lengthComputable) {
                                        percent = Math.ceil(position / total * 100);
                                }
                                        //update progressbar

                                }, true);
                        }
          return xhr;

                },
                success: function (response) {
          	var status  = response.status;
				var msg     = response.message;
				var id      = response.id;
				var auto_no = response.auto_no;
         if(btnval !='SAVE' && btnval !='DRAFT' && btnval!="RENEW")
							{
                  notyMsg(status,msg);
                  $('.ajaxLoading').hide();
                  window.location.href=create_url;
          }
          else
          {
                 
                  $('.ajaxLoading').hide();
                  window.location.href=red_url;
                     notyMsg(status,msg);
          }
           },
         error: function(response) {
             console.log(response);
             $('.ajaxLoading').hide();
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
//                 }).done(function(data)
// 		{
// 			var status  = data.status;
// 				var msg     = data.message;
// 				var id      = data.id;
// 				var auto_no = data.auto_no;
//          if(btnval !='SAVE' && btnval !='DRAFT' && btnval!="RENEW")
// 							{
//                   notyMsg(status,msg);
//                   $('.ajaxLoading').hide();
//                   window.location.href=create_url;
//           }
//           else
//           {
                 
//                   $('.ajaxLoading').hide();
//                   window.location.href=red_url;
//                      notyMsg(status,msg);
//           }
// 		});  
					 return false;
					}
				}
				

		});
   
        

		});
</script>
		@include('layouts.php_js_validation')
		@endsection
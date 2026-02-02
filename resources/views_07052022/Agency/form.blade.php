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
         <h2 class="heads">Agency <span class="ui_close_btn"><a href="{{ URL::to('agency') }}" class="collapse-close pull-right btn-danger" ></a></span></h2>
		
		<form method="post" action="" id="agency" data-parsley-validate >
		<input type="hidden" value="" name="edit_id" id="edit_id" />

		{{ csrf_field() }}
		
		<div class="card">
		
		<div class="card-body card-block headerdiv1">

		<div class="row">
				<div class="col-md-12">
				<div class="row">
		<div class="col-md-6">
			
		<div class="form-group row">

				<label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Agency Name</label>
				<div class="col-md-6">
				<input type="hidden" name="agency_id" id="agency_id" class="form-control agency_id" value="{{ $row->agency_id }}" type="hidden" readonly>
			<input type="text" id="agency_name" name="agency_name" class="form-control agency_name" value="{{ $row->agency_name }}" required="true">
					   <span class="btn btn-danger dup_name" style="display:none;"></span>
			</div>
			</div>
			<div class="form-group row">
				<label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Mobile No</label>
				<div class="col-md-6">
			<input type="text" id="mobile_no" name="mobile_no" maxlength="10" class="form-control mobile_no" value="{{ $row->mobile_no }}" required="true">
					 
			</div>
			</div>
			<div class="form-group row">
            <label for="active" class="form-control-label col-md-4">Country</label>
            <div class="col-md-6" >
            	<select name="country" id="country" class="country select2" >
                {!!$country_id!!}
               
                </select>
            </div>
        </div>
			
       <div class="form-group row">
        <label for="inputIsValid" class="form-control-label col-md-4">Active</label>
        <div class="col-md-6">
            <select name="active" class="form-control active select2" style="width: 100%;" tabindex="4">
                 <option <?php if ($row->active == "Yes"){ echo "selected" ; }?> value="Yes" >Yes</option>
                            <option <?php if ($row->active == "No"){ echo "selected" ; }?> value="No" >No</option>
            </select>
        </div>
    </div>
		</div>
	
		<div class="col-md-6">
				<div class="form-group row">
			<label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Email</label>
			<div class="col-md-6">
				<input type="email" name="email" id="email" class="form-control email" row="5" value="{{ $row->email }}" required="true" />
			</div>
			<div class="col-md-2">
		  </div>
		</div>
		<div class="form-group row">
			<label for="inputIsValid" class="form-control-label col-md-4">Address</label>
			<div class="col-md-6">
				<input type="text" name="address" id="address" class="form-control address"  value="{{ $row->address }}"/>
			</div>
			<div class="col-md-2">
		  </div>
		</div>
		<div class="form-group row">
            <label for="active" class="form-control-label col-md-4">State</label>
            <div class="col-md-6" >
            	<select name="state" id="state" class="state select2" >
            	           <option >please select</option>

               
               
                </select>
            </div>
        </div>
	<div class="form-group row">
        <label for="inputIsValid" class="form-control-label col-md-4">City</label>
        <div class="col-md-6">
            <select name="city" class="form-control city select2"  style="width: 100%;" tabindex="4">
                       	           <option >please select</option>

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
				
				<button type="button" class="btn save saveform" value="SAVE">SAVE</button>
				<!--<button type="button" class="btn save saveform"   value="SAVENEW">SAVE AND NEW</button>-->
                <a href="{{ URL::to('agency') }}" class='btn cancel'>Cancel</a>
			</div>
		</div>
		</div>
		</div>
 	</div>
		
		</form>
<script>
/*deepika purpose:to check duplicate entry for machine name*/
	  var dup_chk = true;
    function duplicate_validate()
    {
    
        var agency_name = $(".agency_name").val();
    //  alert(agency_name);  
      var edit_id = $("#agency_id").val();
//alert(edit_id);
        $.ajax({
            cache: false,
            url: "{{URL::to('agencynamechk')}}",
            type: 'GET',
            dataType: 'json',
            async : false,
            data: {agency_name : agency_name,edit_id : edit_id},
            success: function(response)
            {
          if(response == 1)
                {
                    $('.dup_name').html('Agency Name:'+agency_name+' Already Exists');
                    $('.dup_name').show();
                    $(".agency_name").val('');
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
    }/*end*/

/*end*/
 $(document).ready(function()
 {
     $('.country').change(function(){
	var depid=$(this).select2('val');
	if(depid!=''){
       var condition="country_id="+depid;
            $(".state").jCombo("{{ URL::to('jcomboformlogin?table=m_states_t:state_id:state_name') }}&parent="+condition, {
                selected_value: "{{$state_id}}"
            });
        }
        });
         $('.state').change(function(){
	var depid=$(this).select2('val');
        if(depid!=''){
       var condition="state_id="+depid;
            $(".city").jCombo("{{ URL::to('jcomboformlogin?table=m_cities_t:city_id:city_name') }}&parent="+condition, {
                selected_value: "{{$city_id}}"
            });
        }
        });
        $('.country').trigger('change');
	// /*deepika purpose:to check machine name already used(noneditable) or notused (editable)*/			

// 	/*deepika purpose:to uppercase validation*/
		$(".agency_name").keyup(function() {
		$(this).val($(this).val().toUpperCase());
		});/*end*/
		/*deepika purpose:qty validation*/
			$(document).on('keypress','.mobile_no', function(ev){
				var regex = new RegExp("^[0-9.]+$");
						var str = String.fromCharCode(!ev.charCode ? ev.which : ev.charCode);
						if (regex.test(str)) {
							return true;
						}
						ev.preventDefault();
						return false;
			});
// // 		/*end*/
// // 		/*copy paste validation*/
		
//      $('.bulk_machine_capacity').bind("cut copy paste", function(e) {
//         e.preventDefault();
//             });
// // 		/*copy paste validation*/
// 	/*deepika purpose:to save function*/
		$('#edit_id').val('');
// 		$(document).on('click','.saveform',function()
// 		{      
                      
// 				var btnval		= $(this).val();
// 				if(btnval == 'APPLYCHANGES')
// 					var edit_id = 'APPLY CHANGES';
// 				else if(btnval == 'SAVE' || btnval == 'SAVENEW')
// 					var edit_id = 'SAVE';

// 				$('#edit_id').val(edit_id);
// 				var url		= "{{ URL::to('agencysave') }}";
// 				var red_url		="{{ URL::to('agency') }}";
// 				var create_url	="{{ URL::to('agencycreate') }}";
// 			    //capacityrequiredvalid();
// 				validationrule('agency');
// 				var formdata	= $('#agency').serialize();
// 				var form = $('#agency');
// 				if(btnval != 'APPLYCHANGES')
// 				{
// 					form.parsley().validate();
// 					var form = $('#agency');
// 					form.parsley().validate();
// 					if (form.parsley().isValid())
// 					{	
// 						duplicate_validate();
        
//          if(dup_chk==true)
//     {
// 		$('.ajaxLoading').show();
// 						$.post(url,formdata,function(data)
// 						{
// 							var status      = data.status;
// 							var msg     = '<span style="color:#090065">'+data.message+'</span>  ';
// 							var id          = data.id;
// 							var edit_url	= "{{ URL::to('agencyedit') }}/"+id;
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
// 					} return false;
// 					}
// 				}
// 				else
// 				{
// 					duplicate_validate();
// 					  if(dup_chk==true)
//     {
// 				$.post(url,formdata,function(data)
// 				{
// 						$('.ajaxLoading').show();
// 						var status = data.status;
// 						var msg    = data.message;
// 						var id     = data.id;
// 						var edit_url	="{{ URL::to('agencyedit') }}/"+id;
// 								notyMsg(status,msg);
// 								setTimeout(function(){
// 								window.location.href=edit_url;
// 								}, 1500);

// 					});
// 				} return false;
// 				}

// 		});
//     /*end*/
$(document).on('click','.saveform',function()
		{      
                      
				var btnval		= $(this).val();
				if(btnval == 'APPLYCHANGES')
					var edit_id = 'APPLY CHANGES';
				else if(btnval == 'SAVE' || btnval == 'SAVENEW')
					var edit_id = 'SAVE';

				$('#edit_id').val(edit_id);
				var url		= "{{ URL::to('agencysave') }}";
				var red_url		="{{ URL::to('agency') }}";
				var create_url	="{{ URL::to('agencycreate') }}";
			    //capacityrequiredvalid();
				validationrule('agency');
				var formdata	= $('#agency').serialize();
				var form = $('#agency');

            $.ajax({
          url:   url,
          type: 'post',
          data: formdata,
          dataType: 'json',
          success: function (data) {
        var status      = data.status;
		var msg     = '<span style="color:#090065">'+data.message+'</span>  ';
		var id          = data.id;
		var edit_url	= "{{ URL::to('agencyedit') }}/"+id;
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
               var errors = response.responseJSON.errors;
               var errorsHtml = '';
            $.each( errors, function( key, value ) {
               errorsHtml += '<p>'+ value[0] + '</p>';
            });
               notyMsg("error",errorsHtml);
           }
           
       });
		    
		});

		});/*end*/
</script>
		@include('layouts.php_js_validation')
		@endsection
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
         <h2 class="heads">Machine Files <span class="ui_close_btn"><a href="{{ URL::to('filemachine') }}" class="collapse-close pull-right btn-danger" ></a></span></h2>
		
		<form method="post" action="" id="filemachine" data-parsley-validate>
		<input type="hidden" value="" name="savestatus" id="savestatus" />

		{{ csrf_field() }}
		
		<div class="card">
		
		<div class="card-body card-block headerdiv1">

		<div class="row">
				<div class="col-md-12">
				<div class="row">
		<div class="col-md-6">
			
		<div class="form-group row">
<input type="hidden" name="machine_file_id" id="machine_file_id" class="form-control machine_file_id" type="hidden" value="{{$row->machine_file_id}}" readonly>
				<label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Department Name</label>
				<div class="col-md-6">
			                <select name='department_id'  class='select2 department_id ' id="department_id "  >
              {!! $department_id !!}
                </select>
			</div>
			</div>
    </div>
       
    <div class="col-md-6">
			<div class="form-group row" >
				<label for="inputIsValid" class="form-control-label col-md-4" ><span style="color:red">*</span>Machine Number</label>
				<div class="col-md-6">
            <select name='machine_id'  class='select2 machine_id ' id="machine_id" >{!! $machine_id !!}
                </select>
					 
			</div>
			</div>
    </div>
    <div class="col-md-6">
      <div class="form-group row" style="pointer-events: none">
        <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Machine Name</label>
        <div class="col-md-6">
            <select  class='select2 machine_name ' id="machine_name" >{!! $machine_name !!}
                </select>
            
      </div>
      </div>
    </div>
    <div class="col-md-6">
       <div class="form-group row">
        <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>File Name</label>
        <div class="col-md-6">
      <input type="text" id="file_name" name="file_name" class="form-control file_name" value="{{$row->file_name}}" required="true">
           
      </div>
      </div>   
		</div>
     <div class="col-md-6">
       <div class="form-group row">
        <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Choose File</label>
        <div class="col-md-6">
      <input type="file" id="upload_file" name="upload_file" class="form-control upload_file" value="{{$row->upload_file}}" required="true">
           <span id="fp"></span>
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
				<button type="button" class="btn save saveform"   value="SAVENEW">SAVE AND NEW</button>
				  <a href="{{ URL::to('filemachine') }}" class='btn cancel'>Cancel</a>
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
  
        var machine_name = $(".machine_name").val();
      var edit_id = $("#machine_id").val();
//alert(edit_id);
        $.ajax({
            cache: false,
            url: "{{URL::to('machinefilesnamechk')}}",
            type: 'GET',
            dataType: 'json',
            async : false,
            data: {machine_name : machine_name,edit_id : edit_id},
            success: function(response)
            {
          if(response == 1)
                {
                    $('.dup_name').html('Machine Name:'+machine_name+' Already Exists');
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

$('.department_id').change(function(){
    var depid=$(this).select2('val');
               var location ='<?php echo \Session::get('location'); ?>';
            if(location != 0){
       var condition='location_id='+location+' and department_id='+depid;
            } else {
                var condition='department_id='+depid;   
            }
            $(".machine_id").jCombo("{{ URL::to('jcomboformcomp?table=machine_hdr_t:machine_id:asset_code|machine_name') }}&parent="+condition, {
                selected_value: "{{$machine_id}}"
            });
        });


$('.machine_id').change(function(){
    var depid=$(this).select2('val');
       var condition=" machine_id="+depid;
            $(".machine_name").jCombo("{{ URL::to('jcomboformcomp?table=machine_hdr_t:machine_id:machine_no') }}&parent="+condition, {
               // {selected_value:suppdata['supplier_site_id'].toString()});
                selected_value: depid
            });
        });
//$('.department_id').trigger('change');

 	/*deepika purpose:to uppercase validation*/
		$(".machine_name").keyup(function() {
		$(this).val($(this).val().toUpperCase());
		});/*end*/
		/*deepika purpose:qty validation*/
			$(document).on('keypress','.machine_no', function(ev){
				var regex = new RegExp("^[0-9.]+$");
						var str = String.fromCharCode(!ev.charCode ? ev.which : ev.charCode);
						if (regex.test(str)) {
							return true;
						}
						ev.preventDefault();
						return false;
			});
	$(document).on('change','.files',function(){
      
        var fi = document.getElementById('files'); // GET THE FILE INPUT AS VARIABLE.

        var totalFileSize = 0;

        // VALIDATE OR CHECK IF ANY FILE IS SELECTED.
        if (fi.files.length > 0)
        {
            // RUN A LOOP TO CHECK EACH SELECTED FILE.
            for (var i = 0; i <= fi.files.length - 1; i++)
            {
                //ACCESS THE SIZE PROPERTY OF THE ITEM OBJECT IN FILES COLLECTION. IN THIS WAY ALSO GET OTHER PROPERTIES LIKE FILENAME AND FILETYPE
                var fsize = fi.files.item(i).size;
                totalFileSize = totalFileSize + fsize;
                document.getElementById('fp').innerHTML =
                document.getElementById('fp').innerHTML
                +
                '<tr><td><span class="note" ><br /> File:<span class="files">' + fi.files.item(i).name+'</span>&nbsp;<img src="{{URL::to('')}}/uploads/cancel.png" class="delete_user"></span></td></tr>';
            }
        }
        //document.getElementById('divTotalSize').innerHTML = "Total File(s) Size is <b>" + Math.round(totalFileSize / 1024) + "</b> KB";
    });
		 $(document).on('click','.save',function()
            { 
              $('#panel_add').trigger('click');
 // var btnval      = $(this).val();
                
                var btnval      = $(this).val();
                if(btnval == 'APPLYCHANGES')
                    var savestatus = 'APPLY CHANGES';
                else if(btnval == 'SAVE' || btnval == 'SAVENEW')
                    var savestatus = 'SAVE';
         var url     ="{{ url('machinefilessave') }}";
         var create_url  ="{{ URL::to('machinefilecreate') }}";
         var red_url   ="{{ url('filemachine') }}";
        validationrule('Issuestatus');
        var form = $('#filemachine');
          form.parsley().validate();
             form.parsley().validate();
            if (form.parsley().isValid())
            { 
                  $('.ajaxLoading').show();
                     change_date();
                     var form_data = new FormData(document.getElementById('filemachine'));
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
                }
                }).done(function(data,status)
                {
                     notyMsg("success","Machinefiles Saved Successfully");
                        setTimeout(function(){
                         window.location.href=red_url;
                        }, 1500);
                }).fail(function(response)
                { 
                    console.log(response);
               var errors = response.responseJSON.errors;

               var errorsHtml = '';

               $.each( errors, function( key, value ) {
                   errorsHtml += '<p>'+ value[0] + '</p>';
               });
              // errorsHtml += '</ul></div';
    notyMsg("error",errorsHtml);
    $('.ajaxLoading').hide();
   //  $("#grid1")[0].triggerToolbar();
  // $(".clear").trigger('click');
             //  $('.messages').html(errorsHtml);
                        setTimeout(function(){
                        ///    window.location.href=red_url;
                        }, 1000);
                });
            }
            });
		});/*end*/

</script>
		@include('layouts.php_js_validation')
		@endsection
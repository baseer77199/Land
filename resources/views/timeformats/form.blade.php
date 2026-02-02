@extends('layouts.header')
@section('content')
<?php error_reporting(0);?>

<span class="ui_close_btn"><a class="collapse-close pull-right btn-danger" onclick='location.href="{{ url($return_url) }}"'></a></span>
<span class="ui_close_btn"></span>

<h2 class="heads">Time Formats </h2>
  

	   <form method="post" action="{{ url('timeformatssave') }}" id="form-ui" data-parsley-validate enctype="multipart/form-data" >
		   {{ csrf_field() }}
		   
			   <div class="card">
				  

	    <div class="card-body card-block" >
			<div class="row">
            <div class="col-md-12">

				 <div class="form-group col-md-4">
					<label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red;" >&#42;</span> Php Format</label>
					<div class="col-md-6">
		<input class="form-control time_formats_id" id="time_formats_id" name="time_formats_id" size="16" type="hidden" value="{{$timefmdata['time_formats_id']}}" readonly>
						<input type="text" id="php_format" name="php_format" required class="form-control php_format" value="{{$timefmdata['php_format']}}">
					</div>
					<div class="col-md-2">
					</div>
				</div>

				 <div class="form-group col-md-4">
					<label for="inputIsValid" class="form-control-label col-md-4"> <span style="color:red;" >&#42;</span> Javascript Format</label>
					<div class="col-md-6">
				<input type="text" id="js_format" name="js_format" class="form-control js_format" required value="{{$timefmdata['js_format']}}">
					</div>
					<div class="col-md-2">
					</div>
				</div>

				 <div class="form-group col-md-4">
					<label for="inputIsValid" class="form-control-label col-md-4"> <span style="color:red;" >&#42;</span> Display Format</label>
					<div class="col-md-6">
				<input type="text" id="display_format" name="display_format" class="form-control display_format" required value="{{$timefmdata['display_format']}}">
					</div>
					<div class="col-md-2">
					</div>
				</div>
</div>


			 </div>

		

	    	<div class="row">
		      <div class="col-lg-12 col-md-12">
			    <div class="form-group text-center">
				   <button type="button" class="btn save saveform">Submit</button>
				  <a class='btn cancel' onclick="location.href ='{{url('timeformats')}}'">Cancel</a>
			    </div>
		     </div>
	     </div>



</div>
		</div>
		   
	   </form>

<script>
  var dup_chk = '';
        function duplicate_validate()
        {
            var php_format = $(".php_format").val();
            var js_format = $(".js_format").val();
            var display_format = $(".display_format").val();
            var edit_id =  $(".time_formats_id").val();
            $.ajax({
                cache: false,
                url: "{{URL :: to('timeformatcheck') }}", //this is your uri
                type: 'GET',
                dataType: 'json',
                async : false,
                data: {php_format : php_format,js_format : js_format,display_format : display_format,edit_id : edit_id},
                success: function(response)
                {
                    console.log(response);
                    if(response == 1)
                    {
                        notyMsg('info','Already this Combination Exists for this Group');
                  
                        $(".php_format").val('');
                         $(".js_format").val('');
                         $(".display_format").val('');
                        dup_chk = false;

                    }
                    else if(response == 0)
                    {
                        var html ="";
                           
                        dup_chk = true;

                    }

                },
                error: function(xhr, resp, text)
                {
                    console.log(xhr, resp, text);
                }
            });
        }


$(document).ready(function()
{

	$(document).on('click','.saveform',function()
    {
    	var url         ="{{ url('timeformatsave') }}";
    	var red_url     ="{{ url('timeformats') }}";
  		duplicate_validate();
    	validationrule('form-ui');
    	var formdata    = $('#form-ui').serialize();
        var form = $('#form-ui');
        form.parsley().validate();
        if (form.parsley().isValid() ){
        	 if(dup_chk== true)
        {
        	$.post(url,formdata,function(data)
            {
            	var status = data.status;
                var msg    = data.message;
                notyMsg(status,msg);
                setTimeout(function(){
                    window.location.href=red_url;
                }, 1500);
            });
        }
         return false;
    }
        /**/
    });

});	

</script>
@include('layouts.php_js_validation')	
@endsection

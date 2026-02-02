@extends('layouts.header')
@section('content')
<?php error_reporting(0);?>


<span class="ui_close_btn"><a class="collapse-close pull-right btn-danger" onclick='location.href="{{ url($return_url) }}"'></a></span>
<span class="ui_close_btn"></span>
  <h2 class="heads">Date Formats </h2>

	   <!-- <form method="post" action="{{ url('dateformatssettingssave') }}" id="save"> -->
	    <form action="" id="save"  data-parsley-validate>
		   {{ csrf_field() }}
		   
			   <div class="card">
				  
	    <div class="card-body card-block" >
	    	<div class="row">
			
				 <div class="form-group col-md-offset-1 col-md-5 ">
					<label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red;" >&#42;</span>  Php Format</label>
					<div class="col-md-6">
					<input class="form-control date_formats_id" id="date_formats_id" name="date_formats_id" size="16" type="hidden" value="{{$dateformats->date_formats_id}}" readonly>
						<input type="text" id="php_format" name="php_format" required class="form-control php_format" value="{{ $dateformats->php_format }}">
					</div>
					
				</div>

				 <div class="form-group col-md-6 ">
					<label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red;" >&#42;</span> Javascript Format</label>
					<div class="col-md-6">
				<input type="text" id="javascript_format" name="javascript_format" required class="form-control javascript_format" value="{{$dateformats->javascript_format}}">
					</div>
					
				</div>



			 

		

	    	
		      <div class="col-lg-12 col-md-12">
			    <div class="form-group text-center">
				   <button type="button"  class="btn save saveform" value='save'>Save</button>
				  <a class='btn cancel' onclick="location.href ='{{url('dateformatssettings')}}'">Cancel</a>
			    </div>
		     </div>
	     </div>
</div>


		</div>
		   
	   </form>
	<script type="text/javascript">


	  var dup_chk = true;
        function duplicate_validate()
        {
            var php_format = $(".php_format").val();
            var javascript_format = $(".javascript_format").val();
            var edit_id =  $(".date_formats_id").val();
            $.ajax({
                cache: false,
                url: "{{URL :: to('dateformatcheck') }}", //this is your uri
                type: 'GET',
                dataType: 'json',
                async : false,
                data: {php_format : php_format,javascript_format : javascript_format,edit_id : edit_id},
                success: function(response)
                {
                    console.log(response);
                    if(response == 1)
                    {
                        notyMsg('info','Already this Combination Exists for this Group');
                  
                        $(".php_format").val('');
                         $(".javascript_format").val('');
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
/*end*/


		$(document).ready(function(){

	$(".saveform").click(function()
            {
    duplicate_validate();
$('input[name="_token"]').val("{{csrf_token()}}"); 
 var form = $('#save');
      var  data = form.serialize();
	
        form.parsley().validate();
  
        var url="{{ URL::to('dateformatssettingssave')}}";

        if(dup_chk== true)
        {
        $.post(url,data,function(data1)
        {
                  var status = data1.status;
                        var msg    = data1.message;

               notyMsg('success',"<i class='' style='font-size:16px'></i>"+msg+" !!!");
               var url = "{{ url('dateformatssettings') }}";
               setTimeout(function() {
                                window.location.href = url;
                            }, 1500);
            
        });
    }
        return false;

});



		});
	</script>

@endsection
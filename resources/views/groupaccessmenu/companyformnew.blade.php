@extends('layouts.header')
@section('content')

<span class="ui_close_btn"></span>

<!---------------------------------->







<?php //include('tools_menu.php'); ?><h2 class='heads'>Company Access <span class="ui_close_btn"><a class="collapse-close pull-right btn-danger" onclick="location.href = '{{url('companyaccess')}}'"></a></span></h2>



<form   id="companyaccess" data-parsley-validate>
{{ csrf_field() }}

<div class="card">

<div class="card-body card-block">




		 <!------------------------------------- Body content start here ---------------------------->
		 
	
	 
	 <div class="row">
			 <div class="col-md-offset-3 col-md-6">





	<div class="form-group row">
	<label for="inputIsValid" class="form-control-label col-md-4">Company Name</label>
	<div class="col-md-6">
	 <select name='company_name' rows='5' class='select2 form-control company_name' data-show-subtext="true" data-live-search="true"  required>
	 {!! $company_name  !!}
	 </select>
	</div>
	<div class="col-md-2 showinline">
											 <input type="hidden" name="a_company_menu_access_id" value="{{$a_company_menu_access_id}}">
	</div>
	</div>


	</div>

    
</div>
                 	  <div class="card-body card-block">
     <div class="col-md-12">
     
<?php echo $headhtml; ?>
{!! $sub_headhtml !!}
{!! $sub_menuhtml !!}
{!! $buttonhtml !!}


     
  




     </div>
</div> 
	<div class="row">
		<div class="col-md-offset-4 col-md-6">
             <button name="button" type="button" class="btn save saveform" value="SAVE">Submit</button>
             <button type="button"  class="btn cancel reset" onclick="location.href = '{{url('companyaccess')}}'">Cancel</button>
  </div>
	</div>

<div class="row">
<div class="col-md-12">
<hr class="xlg">
</div>
</div>


<div class="row">
<div class="col-md-12">
<hr class="xlg">
</div>
</div>

</div>


<div id="preloader">
       <!--<img src="https://jrlma.ca/wp-content/plugins/gallery-by-supsystic/src/GridGallery/Galleries/assets/img/loading.gif">-->
    </div>
	</div>
</form>



	<script>
$(document).ready(function(){
  

$('.sub_menu_hide,.child_menu_hide,.button_menu_hides').hide();

        $(document).on('click','.headmenus',function(e){
            var id=$(this).attr('data-value');
            $('.sub_menu_hide').hide();
            $('#sub_menu'+id).show();
            return false;
        });
          $(document).on('click','.subheadmenus',function(e){
            var id=$(this).attr('data-value');
            $('.child_menu_hide').hide();
            $('#sub_head_menu'+id).show();
            return false;
        });
         $(document).on('click','.submenus',function(e){
            var id=$(this).attr('data-value');
            $('.button_menu_hides').hide();
            $('#button_names'+id).show();
            return false;
        });
        $(document).on('click','.check_head',function(e){
             var checkvalue= $(this).val();
            if($(this).is(":checked")){ 
              $('.sub_headmenu'+checkvalue).each(function(){
                   $(this).prop("checked","checked");
              });
            }
            else{
                $('.sub_headmenu'+checkvalue).each(function(){
                  $(this).removeProp('checked');
              });
            }
    });
    
      $(document).on('click','.sub_headmenu0,.sub_headmenus,.sub_child_menus',function(e){
             var checkvalue= $(this).attr('myval');
            if($(this).is(":checked")){ 
              $('.sub_headmenu'+checkvalue).each(function(){
                   $(this).prop("checked","checked");
                     var checkvalue1= $(this).attr('myval');
                     $('.sub_headmenu'+checkvalue1).each(function(){
                       $(this).prop("checked","checked");
                        var checkvalue2= $(this).attr('myval');
                     $('.sub_headmenu'+checkvalue2).each(function(){
                       $(this).prop("checked","checked");
                     });
                     });
              });
            }
            else{
                $('.sub_headmenu'+checkvalue).each(function(){
                  $(this).removeProp('checked');
                          var checkvalue1= $(this).attr('myval');
                   $('.sub_headmenu'+checkvalue1).each(function(){
                        $(this).removeProp('checked');
                           var checkvalue2= $(this).attr('myval');
                     $('.sub_headmenu'+checkvalue2).each(function(){
                        $(this).removeProp('checked');
                     });
                     });
              });
            }
    });
        $(document).on('click','.save',function(e){


       var saveurl="{{URL::to('companyaccesssave')}}";
validationrule('companyaccess');
               var form=$("#companyaccess");
    form.parsley();
  $('input[name=_token]').val("{{csrf_token()}}");
  var data = form.serialize();

       if( form.parsley().validate())

            {
                $.post(saveurl, data, function(data)
                {
                    var red_url     ="{{ url('companyaccess') }}";
                    if(data == 1){
                       notyMsg("success","Saved Successfully");
                        //location.reload();
                         window.location.href=red_url;
                    }else{
                   notyMsg("success","Updated Successfully");
                     window.location.href=red_url;
        }

                });
                //}

            }

        });
 		

	});
	</script>
<script>
$(window).on('load',function(){
       //preloader
       var preLoder = $("#preloader");
       preLoder.fadeOut(500);
       var backtoTop = $('.back-to-top')
       backtoTop.fadeOut(100);
   });
</script>

@include('layouts.php_js_validation')
@endsection

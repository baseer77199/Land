@extends('layouts.header')
@section('content')

<h3 class="heads">User Access <span class="ui_close_btn"><a class="collapse-close pull-right btn-danger cross" onclick="location.href = '{{url('useraccess')}}'"></a></span></h3>



<form   id="useraccess" data-parsley-validate>
{{ csrf_field() }}


<div class="card">


<div class="card-body card-block">



  <!---Toggle content start here------------------>
  <div class="row">
   <div class="col-md-12">


     <!------------------------------------- Body content start here ---------------------------->
    
 
  
     <div class="row">
       <div class="col-md-offset-4 col-md-4">





               <div class="form-group row">
                   <div class="col-md-1 showinline">

 </div>
 <label for="inputIsValid" class="form-control-label col-md-3">User Name</label>
 <div class="col-md-6" style="pointer-events:none;">
   <select name='user_id' rows='5' class='select2 user_name' data-show-subtext="true" data-live-search="true"  required>
   {!! $user_name  !!}
   </select>
 </div>
                     <div class="col-md-2 showinline">
                     <input type="hidden" name="a_user_access_id" value="{{$a_user_access_id}}">
 </div>

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
	  <div class="col-md-12">
		  <div class="row text-center">

<button name="button" type="button" class="btn save saveform" value="SAVE">Submit</button>
<a class='btn cancel' onclick='location.href="{{ url('useraccess') }}"'>Cancel</a>

</div>
	  </div>
 </div>





</div>

 <div class="card-body card-block">
     <div class="col-md-12">
     
      <div class="col-md-3 head_menu">

 </div>

    <div class="col-md-3 sub_menu">
   
 </div>
     
     <div class="col-md-3 child_menu">
      

 </div>
     
     <div class="col-md-3 button_menu">
      

 </div>



     </div>
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


       var saveurl="{{URL::to('saves')}}";
validationrule('save');
               var form=$("#useraccess");
    
  $('input[name=_token]').val("{{csrf_token()}}");
  var data = form.serialize();

      
                $.post(saveurl, data, function(data)
                {
                    if(data == 1){
                       notyMsg("success","Saved Successfully")
                       $('.cross').trigger('click');
                        //location.reload();
                    }else{
                        $('.cross').trigger('click');
                   notyMsg("success","Updated Successfully")
              }   

                });
                //}

            

        });









/*karthigaa purpose for hide product in labour condition*/

/*End*/


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

@extends('layouts.header')
@section('content')

<style type="text/css">
/*.select2.loc_id {
  border: none !important;
}
.loc_id .select2-container{
  border: none !important;
}
#sel2 .loc_id .select2-container{
   border: none !important;
  
}*/
.select2-container--default .select2-selection--multiple{
  border: none;
}
.select2-container--default.select2-container--focus .select2-selection--multiple{
  border: none;
}
.select2-container{
    box-sizing: border-box;
    display: inline-block;
    margin: 0;
    background-color: #fff;
    border: 1px solid #375a80;
    border-radius: 5px;
    box-shadow: none;
    color: #000;
    text-align: center;
    max-width: 100%;
    transition: all 300ms linear 0s;
    position: relative;
    vertical-align: middle;
    height: auto;
}
.form-control{
  padding: 3px 12px;
}
.bulk_checklist_id{
  width: 190px;
}
.stickytable-wrap th{
  padding: 2px 9px;
}

</style>

<span class="ui_close_btn"></span>

<h2 class="heads">Machine Checklist
  <span class="ui_close_btn">
  <a href="{{ URL::to('machinechecklistimport') }}" class="collapse-close pull-right btn-danger" ></a>
</span>
</h2>
<form autocomplete="off" action=" " id="machinechelistform" class="machinechelistform" data-parsley-validate  autocomplete="off" >
    {{ csrf_field() }}
    <input type="hidden" value="" name="savestatus" id="savestatus" />
   

<div class="card">

<div class="card-body card-block">


  <div class="row">

    <div class="col-md-4">
            <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Department</label>
            <div class="col-md-8">        
                 <input type="hidden"  name="checklist_hrd_id" id="checklist_hrd_id" value="<?php echo $id ?>" />
                  <select name='department_id' rows='5' class='form-control select2 department_id'  required>{!! $department_id !!}
                </select>
            </div>
             <div class="col-md-2 showinline refbtnhide">
  </div>
        </div>
         
        
    
    </div>
    <div class="col-md-4">
       <div class="form-group row">
         <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Machine Name</label>
            <div class="col-md-8">
              <select name='machine_id' rows='5' class='form-control select2 machine_id'  required>{!! $machine_id !!}
                </select>
            </div>           
        </div>
    </div>
    <div class="col-md-4">
     <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Frequency Name</label>
              <div class="col-md-8 sel2">
       <select name='frequency_id' rows='5' class='form-control select2 frequency_id'  required>{!! $frequency_id !!}
                </select>
           </div>
            
        </div>
    </div>
    <div class="col-md-4">
     <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Checklist Name</label>
              <div class="col-md-8 sel2">
      <select name="checklist_id" id="bulk_checklist_id" class="checklist_id select2 parsley-validated" required>{!! $checklist_id !!}</select>
                    
           </div>
            
        </div>
    </div>
       <div class="col-md-4">
       <div class="form-group row">
         <label for="inputIsValid" class="form-control-label col-md-4">Machine Name</label>
            <div class="col-md-8">
              <input type="text" name='batch_comments' rows='5' class='form-control  batch_comments'  value="{{$batch_comments}}">
             
            </div>           
        </div>
    </div>
   </div>



</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group text-center">
            <input type="hidden" name="submit_type" class="submit_type" id="submit_type">
            
          
            <button name="submit" type="button" class="btn save saveform" value="SAVE">Save</button>
            <a class='btn cancel' onclick='location.href="{{ url("machinechecklistimport") }}"'>Cancel</a>
       </div>
    </div>
</div>
</div>

</form>
  
<script>
 

$(document).ready(function()
{
    $('#savestatus').val('');
    $(document).on('click','.saveform',function()
    {
      var btnval    = $(this).val();
      $('#savestatus').val(savestatus);
      var url   = "{{ url('machinechecklistuploadnewsave') }}";
      var red_url   ="{{ url('machinechecklistimport') }}";
      validationrule('machinechelistform');
      var form = $('#machinechelistform');
      form.parsley().validate();
      var form = $('#machinechelistform');
      form.parsley().validate();
      var ss = new FormData(document.getElementById("machinechelistform"));
      if (form.parsley().isValid())
      {
          change_date();
          $.ajax({
              cache: false,
              enctype: 'multipart/form-data',
              url: url,
              type: 'POST',
              // dataType: 'json',
              // async : false,
              data: ss,
              processData: false,
              contentType: false,
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
                      }, true);
                  }
                  return xhr;
              },
              success: function(response)
              {
                  // alert(response);
                  var msg    = response.message;;
                  notyMsg('success',"<i class='' style='font-size:16px'></i>"+msg+"");
                  var status      = response.status;
                  var id          = response.id;
                  notyMsg(status,msg);
                  setTimeout(function(){
                      window.location.href=red_url;
                  }, 1500);
              },
              error: function(response)
              {
        	        $('.ajaxLoading').hide();
                  var errors = response.responseJSON.errors;
                  var errorsHtml = '';
                  $.each( errors, function( key, value ) {
                    errorsHtml += '<p>'+ value[0] + '</p>';
                  });
                  notyMsg("error",errorsHtml);
              }
          });
      }
      return false;
  });




$(window).on('load',function(){
       var preLoder = $("#preloader");
       preLoder.fadeOut(500);
       var backtoTop = $('.back-to-top')
       backtoTop.fadeOut(100);
   });
});
</script>

<!-- @include('layouts.php_js_validation') -->
@endsection

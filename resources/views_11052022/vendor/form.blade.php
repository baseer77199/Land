@extends('layouts.header')
@section('content')
<span class="ui_close_btn"></span>
<div class="row">


    <h2 class="heads">Create Vendor<span class="ui_close_btn"></span></h2>


<div class="card">


<div class="card-body card-block">
    <form method="post" action="" id="vendor_form" class="vendor_form" data-parsley-validate enctype="multipart/form-data">
    <input type="hidden" value="" name="savestatus" id="savestatus" />
        {{ csrf_field() }}
    <div class="row">
    <div class="col-md-12">


      <!--*******************- Body content start here *********************-->
    <div class="">
    
    <div>
        <div class="row">
            <div class="col-md-4">

                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4"><span class="req">*</span>Vendor Name</label>
                    <div class="col-md-6">
                        <input class="form-control vendor_id" id="vendor_id" name="vendor_id" size="16" type="hidden" value="{{$row->vendor_id}}" >
                        <input type="text" id="vendor_name" name="vendor_name"  class="form-control vendor_name" value="{{$row->vendor_name}}"  required>
                        <span class="btn btn-danger dup_name" style="display:none;"></span>
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4"><span class="req">*</span> Vendor Mail Id</label>
                    <div class="col-md-6">
                        <input type="text" id="email_id" name="email_id"  class="form-control email_id" required value="{{$row->email_id}}" required >
                        <span class="btn btn-danger email_vali" id="" style="display:none;"> Mail format is example123@gmail.com</span>
                    </div>
                    <div class="col-md-2"></div>
                </div>

            </div>
            
            <div class="col-md-4">

                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4"><span class="req">*</span>Contact No</label>
                    <div class="col-md-6">
                        <input type="text" id="contact_no" name="contact_no"  class="form-control contact_no" value="{{$row->contact_no}}" maxlength="15" required>
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4"><span class="req">*</span>Address</label>
                    <div class="col-md-6">
                        <input type="text" id="address" name="address"  class="form-control address" value="{{$row->address}}" maxlength="15" required>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                
            </div>

            <div class="col-md-4">
                
                <div class="form-group row">
                    <label for="active" class="form-control-label col-md-4">Active</label>
                    <div class="col-md-6 ">
                        <select name='active' id="active" rows='5' class=' select2 form-control' >
                            <option <?php if ($row->active == "Yes"){ echo "selected" ; }?> value="Yes" >Yes</option>
                            <option <?php if ($row->active == "No"){ echo "selected" ; }?> value="No" >No</option>
                        </select>
                    </div>
                    <div class="col-md-2"></div>
                </div>
  
            </div>

        </div>
    </div>
    </div>
      <!--*************************-->

    </div>
    </div>




<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group text-center">
            <input type="hidden" name="submit_type" class="submit_type" id="submit_type">
            <button type="button" class="btn save saveform" value="SAVE">Save</button>
              <a href="{{ URL::to('vendor') }}" class='btn cancel'>Cancel</a>
            <!--<button type="button"  class="btn btn-cancel cancel "  onclick="{{ URL::to('vendor') }}" >Cancel</button>-->
            
       </div>
    </div>
</div>
</form>
</div>
</div>   

</div>

    <div class="row">
        <div class="col-md-12">
            <table id="grid1"></table>
        </div>
    </div>
<style>

</style>
<script>

        var dup_chk = true;
        function duplicate_validate()
        {
            var vendor_name = $(".vendor_name").val();
            var vendor_id = $("#vendor_id").val();

            $.ajax({
                cache: false,
                url: "{{URL::to('vendorcheckname')}}", //this is your uri
                type: 'GET',
                dataType: 'json',
                async : false,
                data: {vendor_name : vendor_name,vendor_id : vendor_id},
                success: function(response)
                {
                    console.log(response);
                    if(response == 1)
                    {
                        $('.dup_name').html('Vendor Name:'+vendor_name+' Already Exists ');
                        $('.dup_name').show();
                        $(".vendor_name").val('');
                        dup_chk = false;


                    }
                    else if(response == 0)
                    {
                        var html ="";
                            $('.dup_name').hide();
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


    $('.reset').click(function(){
        $(':input','#vendor_form')
        .not(':button, :submit, :reset')
        .val('')
        .prop('checked', false);
    });

	 $(document).on('keyup','.email_id',function()
    {
		 $('.email_vali').hide();
	 });

    /**************** email validation start ***********/
    function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
    $(document).on('click','.saveform',function()
    {
		
        if (!ValidateEmail($("#email_id").val())) {
            $('.email_vali').attr('id',1);
        }
        else {
            $('.email_vali').attr('id',0);
        }
		
    });
    /**************** email validation end ***********/


    /**************** moblie number validation start ***********/
    $(document).on('keypress', '.contact_no', function(ev){
        var regex = new RegExp("^[0-9.]+$");
                var str = String.fromCharCode(!ev.charCode ? ev.which : ev.charCode);
                if (regex.test(str)) {
                    return true;
                }
                ev.preventDefault();
                return false;
    });

    // $(document).on('keyup', '.contact_no', function(ev){
    //     var count = $('.contact_no').val().replace(/\s+/g, '').length;
    //     var phno = $('.contact_no').val();
    //     if(count == 1){                   
    //         if(phno == 6 || phno == 7 || phno == 8 || phno == 9  ){

    //         }
    //         else{                        
    //             $('.contact_no').val('');
    //         }                   
    //     }
    //     else if(count >=2 ){                        
    //         var x =  $('.contact_no').val().split('');
    //         if(x[0] == 6 || x[0] == 7 || x[0] == 8 || x[0] == 9 )
    //         {
    //         }
    //         else{
    //             $('.contact_no').val('');
    //         }
    //     }
    //     else{
                
    //         $('.contact_no').val('');
    //     }
    // });
    /**************** moblie number validation end ***********/
$(document).on('click','.saveform',function()
     {

         var btnval      = $(this).val();
         var url         ="{{ url('vendorsave') }}";
        var red_url     ="{{ url('vendor') }}";
        validationrule('vendor_form');
        var formdata    = $('#vendor_form').serialize();
        var form = $('#vendor_form');
         //      /**************** email validation start ***********/
        var mail = $('.email_vali').attr('id');
        if(mail == 1){
            $('.email_vali').show();
        }else{
            $('.email_vali').hide();
        }
        /**************** email validation end ***********/
        duplicate_validate();
        var form = $('#vendor_form');
        form.parsley().validate();
         if (form.parsley().isValid() && mail != 1 && dup_chk == true )
        {
       $.ajax({
          url:   url,
          type:     'post',
          data:     formdata,
          dataType: 'json',
          success: function (data) {
              var status = data.status;
                var msg    = data.message;
                notyMsg(status,msg);
                setTimeout(function(){
                    window.location.href=red_url;
                }, 1500);
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
        }
     });

    // $(document).on('click','.saveform',function()
    // {

    //     var btnval      = $(this).val();

    //     var url         ="{{ url('vendorsave') }}";

    //     var red_url     ="{{ url('vendor') }}";
    //     validationrule('vendor_form');
    //     var formdata    = $('#vendor_form').serialize();
    //     var form = $('#vendor_form');

    //      /**************** email validation start ***********/
    //     var mail = $('.email_vali').attr('id');
    //     if(mail == 1){
    //         $('.email_vali').show();
    //     }else{
    //         $('.email_vali').hide();
    //     }
    //     /**************** email validation end ***********/
    //     duplicate_validate();
    //     var form = $('#vendor_form');
    //     form.parsley().validate();
    //     if (form.parsley().isValid() && mail != 1 && dup_chk == true )
    //     {

    //         $.post(url,formdata,function(data)
    //         {

    //             var status = data.status;
    //             var msg    = data.message;
    //             notyMsg(status,msg);
    //             setTimeout(function(){
    //                 window.location.href=red_url;
    //             }, 1500);

    //         });
    //     }

    // });


});

</script>

@include('layouts.php_js_validation')
@endsection

@extends('layouts.header')
@section('content')
<span class="ui_close_btn"></span>
<div class="row">


<style type="text/css">

@media  only screen and (min-width: 1500px) {

    .bulk_line_no {width: 50px !important;}
    .bulk_location_id {width: 500px !important;}
    .bulk_locationid {width: 500px !important;}
    .bulk_description {width: 500px !important;}

}

@media  only screen and (min-width: 2000px) {
    .bulk_line_no {width: 50px !important;}
    .bulk_location_id {width: 600px !important;}
    .bulk_locationid {width: 600px !important;}
    .bulk_description {width: 600px !important;}
}

<?php if($pageMethod == "companyedit"){ ?>

@media  only screen and (min-width: 1500px) {

    .bulk_line_no {width: 50px !important;}
    .bulk_location_id {width: 500px !important;}
    .bulk_locationid {width: 500px !important;}
    .bulk_description {width: 500px !important;}

}


.bulk_line_no {width: 50px;}
.bulk_location_id {width: 450px;}
.bulk_description {width: 450px }



 <?php } ?>
.bulk_line_no {width: 50px !important;}
.bulk_location_id {width: 450px !important;}
.bulk_locationid {width: 450px !important;}
.bulk_description {width: 450px !important;}

</style>

    <h2 class="heads">Company <span class="ui_close_btn"><a class="collapse-close pull-right btn-danger" onclick='location.href="{{ url($pageModule) }}"'></a></span></h2>


<div class="card">


<div class="card-body card-block">
    <form method="post" action="" id="company_form" class="company_form" data-parsley-validate enctype="multipart/form-data">
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
                    <label for="inputIsValid" class="form-control-label col-md-4"><span class="req">*</span>Company Name</label>
                    <div class="col-md-6">
                        <input class="form-control company_id" id="company_id" name="company_id" size="16" type="hidden" value="{{$row->company_id}}" >
                        <input type="text" id="company_name" name="company_name"  class="form-control company_name" value="{{$row->company_name}}"  required>
                        <span class="btn btn-danger dup_name" style="display:none;"></span>
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4"><span class="req">*</span>Company Code</label>
                    <div class="col-md-6">
                        <input type="text" id="company_code" name="company_code"  class="form-control company_code" value="{{$row->company_code}}"  required>
                    </div>
                    <div class="col-md-2"></div>
                </div>
                
                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4"><span class="req">*</span>Website Address</label>
                    <div class="col-md-6">
                        <input type="text" id="website_address" name="website_address"  class="form-control website_address" value="{{$row->website_address}}"  required>
                    </div>
                </div>
                
                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4"><span class="req">*</span> Email Id</label>
                    <div class="col-md-6">
                        <input type="text" id="email_id" name="email_id"  class="form-control email_id" required value="{{$row->email_id}}" >
                        <span class="btn btn-danger email_vali" id="" style="display:none;"> Email format is example123@gmail.com</span>
                    </div>
                    <div class="col-md-2"></div>
                </div>

            </div>
            
            <div class="col-md-4">

                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">Contact No</label>
                    <div class="col-md-6">
                        <input type="text" id="contact_no" name="contact_no"  class="form-control contact_no" value="{{$row->contact_no}}" maxlength="10" >
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4"><span class="req">*</span>GST No</label>
                    <div class="col-md-6">
                        <input type="text" id="gst_no" name="gst_no"  class="form-control gst_no" value="{{$row->gst_no}}" maxlength="15" required>
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">Service Tax Reg No</label>
                    <div class="col-md-6">
                        <input type="text" id="tax_reg_no" name="tax_reg_no"  class="form-control tax_reg_no" value="{{$row->tax_reg_no}}" maxlength="15" >
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">Excise Reg No</label>
                    <div class="col-md-6">
                        <input type="text" id="excise_registration_no" name="excise_registration_no"  class="form-control excise_registration_no" value="{{$row->excise_registration_no}}" maxlength="15" >
                    </div>
                    <div class="col-md-2"></div>
                </div>
                
            </div>

            <div class="col-md-4">
                
                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">CIN No</label>
                    <div class="col-md-6">
                        <input type="text" id="cin_no" name="cin_no"  class="form-control cin_no" value="{{$row->cin_no}}" maxlength="30" >
                    </div>
                    <div class="col-md-2"></div>
                </div>

                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">Pan No</label>
                    <div class="col-md-6">
                        <input type="text" id="pan_no" name="pan_no"  class="form-control pan_no" value="{{$row->pan_no}}" maxlength="15" >
                    </div>
                    <div class="col-md-2"></div>
                </div>
				
				
				
                

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




<!--*********************-Linedata ***************-->
<div class="row">
    <div class="col-md-12">
        <a href="javascript:void(0);" class="add_row additem" rel=".rcopy1"><i class="fa fa-plus"></i> ADD</a>
    <div id="preview-area" class="chandru">
    <table class="overflow-y preview company_table">
        <thead>
            <tr >
                <th>Line No</th>
                <th>Location Name</th>
                <th class="pdtdiv" >Description</th>
                <th ></th>
            </tr>
        </thead>
        <tbody class="company_lines_body">
        <?php if(count($linedata)>=1) { ?>
            @foreach($linedata as $key=>$value)
            <tr class="clone rcopy1">
                <td>
                    <input type="hidden" name="bulk_company_line_id[]" class="form-control input-sm bulk_company_line_id" value="{{ $value->company_line_id }}">
                </td>
                <td style="display:none;">
                    <input type="hidden" name="bulk_companyid[]" class="form-control input-sm bulk_companyid" value="{{ $value->companyid }}">
                </td>
                <td>
                    <input type="text" name="bulk_line_no[]" class="form-control input-sm bulk_line_no" value="{{ $key + 1 }}" readonly="readonly">
                </td>
                <td>
                    <select name="bulk_locationid[]" id="bulk_locationid" class="form-control bulk_locationid select2 " data-show-subtext="true" data-live-search="true" required="required">
                        {!! $value->location_id !!} 
                    </select>
                </td>
                <td>
                   
                   <input type="text" name="bulk_description[]" class="form-control input-sm bulk_description" value="{{$value->description}}">
                </td>
                <td>
                    <a class="remove remove0"><i class="fa btn-xs fa-2x fa-minus-circle rem" aria-hidden="true"></i></a>
                    <input type="hidden" name="counter[]">
                </td>
            </tr>
            @endforeach
        <?php } if(count($linedata) < 1 ) { ?>
            <tr class="clone rcopy1">
                <td>
                    <input type="hidden" name="bulk_company_line_id[]" class="form-control input-sm bulk_company_line_id" value="">
                </td>
                <td>
                    <input type="text" name="bulk_line_no[]" class="form-control input-sm bulk_line_no" value="1" readonly="readonly">
                </td>

                <td>
                    <select name="bulk_locationid[]" id="bulk_location_id" class="form-control bulk_location_id select2" data-show-subtext="true" data-live-search="true" required="required">
                        {!! $location_id !!}
                    </select>
                </td>
                <td>
                   <input type="text" name="bulk_description[]" class="form-control input-sm bulk_description" value="">
                </td>
                <td>
                    <a class="remove remove0"><i class="fa btn-xs fa-2x fa-minus-circle rem" aria-hidden="true"></i></a>
                    <input type="hidden" name="counter[]">
                </td>
            </tr>

        <?php } ?>
        </tbody>
    </table>
    <input type="hidden" name="enable-masterdetail" value="true">
    </div>
    </div>
</div>

<!--****************-Linedata End******************-->

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group text-center">
            <input type="hidden" name="submit_type" class="submit_type" id="submit_type">
            <button type="button" class="btn save saveform" value="SAVE">Save</button>
            <button type="button"  class="btn btn-cancel cancel "  onclick='location.href="{{ url($pageModule) }}"' >Cancel</button>
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
            var company_name = $(".company_name").val();
            var company_id = $("#company_id").val();

            $.ajax({
                cache: false,
                url: "{{URL::to('companycheckname')}}", //this is your uri
                type: 'GET',
                dataType: 'json',
                async : false,
                data: {company_name : company_name,company_id : company_id},
                success: function(response)
                {
                    console.log(response);
                    if(response == 1)
                    {
                        $('.dup_name').html('Company Name:'+company_name+' Already Exists ');
                        $('.dup_name').show();
                        $(".company_name").val('');
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
        $(':input','#company_form')
        .not(':button, :submit, :reset')
        .val('')
        .prop('checked', false);
    });

    $(".add_row").on('click',function(){
        var form = $('#company_form');
        form.parsley().destroy();
    });  

    var data ="{{\Session::get('j_date_format')}}";
    $(".add_row").relCopy(data);
    changeclassfields();

    $('.add_row').click(function(){
        changeclassfields();
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

    $(document).on('keyup', '.contact_no', function(ev){
        var count = $('.contact_no').val().replace(/\s+/g, '').length;
        var phno = $('.contact_no').val();
        if(count == 1){                   
            if(phno == 6 || phno == 7 || phno == 8 || phno == 9 ){
            }
            else{                        
                $('.contact_no').val('');
            }                   
        }
        else if(count >=2 ){                        
            var x =  $('.contact_no').val().split('');
            if(x[0] == 6 || x[0] == 7 || x[0] == 8 || x[0] == 9 )
            {
            }
            else{
                $('.contact_no').val('');
            }
        }
        else{
                
            $('.contact_no').val('');
        }
    });
    /**************** moblie number validation end ***********/


    $(document).on('click','.saveform',function()
    {

        var btnval      = $(this).val();

        var url         ="{{ url('companysave') }}";

        var red_url     ="{{ url('company') }}";
        validationrule('company_form');
        var formdata    = $('#company_form').serialize();
        var form = $('#company_form');

         /**************** email validation start ***********/
        var mail = $('.email_vali').attr('id');
        if(mail == 1){
            $('.email_vali').show();
        }else{
            $('.email_vali').hide();
        }
        /**************** email validation end ***********/
        duplicate_validate();
        var form = $('#company_form');
        form.parsley().validate();
        if (form.parsley().isValid() && mail != 1 && dup_chk == true )
        {
            var form_data = new FormData(document.getElementById('company_form'));  
                     $.ajax({
                  url: url,
                  type: "POST",
                  data: form_data,
                  enctype: 'multipart/form-data',
                  processData: false,  /*tell jQuery not to process the data*/
                  contentType: false,   /*tell jQuery not to set contentType*/
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
                
                success: function (data,status) {
              console.log(data);
              
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
                $(".alert-success").hide();
                  $(".alert-danger").fadeIn(800);
    notyMsg("error",errorsHtml);
            
          }
      }); 

            /*$.post(url,formdata,function(data)
            {

                var status = data.status;
                var msg    = data.message;
                notyMsg(status,msg);
                setTimeout(function(){
                    window.location.href=red_url;
                }, 1500);

            });*/
        }

    });

    $('.bulk_locationid').on('change',function(){
        var index =$(this).closest('tr').index();
        var bulk_locationid=$('.bulk_locationid'+index).val();

        for($i=index-1;$i>=0;$i--)
        {
            console.log("bvbv"+$i);
            var product_id=$('.bulk_locationid'+$i).val();
            console.log(product_id);
            if(product_id==bulk_locationid)
            {
                $(this).val('').change();
                $i=-1;
                notyMsg('info',"Same location can't choose");
            }
        }
    });
  

    $(document).on('click','.remove',function()
    {
    	var index = $(this).closest('tr').index();
    	var rowCount = $('.company_table tbody tr').length;
    	if(rowCount > 1)
    	{
    		$($(this).closest("tr")).remove();
    		removeclassfields();
    	}
    	else
    	{
    		notyMsg("info","You Can't Delete Atleast One row should be there");
    	}
    });

});

function changeclassfields(){
    changeClassName('bulk_company_line_id');
    changeClassName('bulk_line_no');
    changeClassName('bulk_locationid');
    changeClassName('bulk_description');
}

function removeclassfields(){
    removeClass('bulk_company_line_id');
    removeClass('bulk_line_no');
    removeClass('bulk_locationid');
    removeClass('bulk_description');
}

/************ Maruthu purpose to remove row action ********************/
function removeClass(className)
{
	var rowCount = $('.so_inq_table tbody tr').length;
	for(var i=0;i<=rowCount;i++)
	{
	   $('.so_inq_table tbody tr').find('.'+className).removeClass(className+i);
	}
	$('.' + className).each(function (index)
	{
		if (className == "bulk_line_no")
		{
		  $(this).val(index + 1).attr("readonly", 1);
		}
		$(this).addClass(className + index);
	});
}

function changeClassName(className)
{
    $('.' + className).each(function (index)
    {
        if (className == "bulk_line_no")
        {
            $(this).val(index + 1).attr("readonly", 1);
        }

        $(this).removeClass(className + '0');
        $(this).addClass(className + index);
    });
}


</script>

@include('layouts.php_js_validation')
@endsection

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

.stickytable-wrap th{
  padding: 2px 9px;
}
.bulk_department_id,.bulk_designation_id,.bulk_type{
  width: 180px !important;
}

</style>

<span class="ui_close_btn"></span>

<h2 class="heads">Mail Setting
  <span class="ui_close_btn">
  <a href="{{ URL::to('mailsetting') }}" class="collapse-close pull-right btn-danger" ></a>
</span>
</h2>
<form autocomplete="off" action=" " id="mailsettingform" class="mailsettingform" data-parsley-validate  autocomplete="off" >
    {{ csrf_field() }}
    <input type="hidden" value="" name="savestatus" id="savestatus" />
   

<div class="card">

<div class="card-body card-block">


  <div class="row">

    <div class="col-md-3">
      <div class="form-group row">
        <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Module</label>
        <div class="col-md-8">        
          <input type="hidden"  name="mailsetting_hrd_id" id="mailsetting_hrd_id" value="<?php echo $row->mailsetting_hrd_id; ?>" />
          <select name='module' rows='5' class='form-control select2 module'  required>
            <option <?php if($row->module=='ticket_generate'){echo 'selected';}?> value="ticket_generate">Ticket Generate</option>
            <option <?php if($row->module=='allocate_technician'){echo 'selected';}?> value="allocate_technician">Allocate Technician</option>
            <option <?php if($row->module=='closure_request'){echo 'selected';}?> value="closure_request">Closure Request</option>
            <option <?php if($row->module=='approve_request'){echo 'selected';}?> value="approve_request">Approve Request</option>
            <option <?php if($row->module=='reject_request'){echo 'selected';}?> value="reject_request">Reject Request</option>
            <option <?php if($row->module=='close_ticket'){echo 'selected';}?> value="close_ticket">Ticket Close</option>
          </select>
        </div>
        <div class="col-md-2 showinline refbtnhide"></div>
      </div>
    </div>
    <div class="col-md-3">
       <div class="form-group row">
         <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Description</label>
            <div class="col-md-8">
              <input type="text" name='description' rows='5' class='form-control description' value="{{$row->description}}" required>
            </div>           
        </div>
    </div>
    <div class="col-md-3">
     <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Origin Dept. Mail</label>
              <div class="col-md-8 sel2">
                <select name='created_by_mail' rows='5' class='form-control select2 created_by_mail'  required>
                  <option <?php if($row->created_by_mail=='Yes'){echo 'selected';}?> value="Yes">Yes</option>
                  <option <?php if($row->created_by_mail=='No'){echo 'selected';}?> value="No">No</option>
                </select>
           </div>
            
        </div>
    </div>
    <div class="col-md-3">
      <div class="form-group row">
        <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Active</label>
        <div class="col-md-8 sel2">
          <select name='active' rows='5' class='form-control select2 active'  required>
            <option <?php if($row->active=='Yes'){echo 'selected';}?> value="Yes">Yes</option>
            <option <?php if($row->active=='No'){echo 'selected';}?> value="No">No</option>
          </select>
        </div>
      </div>
    </div>
  </div>


<div class="row">
<div class="col-md-12">
<hr class="xlg">
</div>
</div>

<!------------------------- clone row start -------------------------------->
<div class="row">
<div class="col-md-12">

<!------------------------- clone row End-------------------------------->

<!-------------------------Linedata -------------------------------->

   <a href="javascript:void(0);" class="add_row additem newitem" rel=".rcopy">
            <i class="fa fa-plus"></i> New Item</a>
  <div id="preview-area" class="chandru">
      <table class="overflow-y preview checklist_table">
        <thead class="thead">
           
            <th>&nbsp;</th>
            <th>
                Department
            </th>
            <th>
                Designation
            </th>
            <th>
                Type
            </th>
            <th ></th>

        </thead>
 <tbody class="gst_code_lines_body">
           
            <?php if(count($linedata)>=1) { ?>
                @foreach($linedata as $key=>$value)

                <tr class="rcopy clone">
                    <td>
                        <input type="hidden" name="mailsetting_lines_id[]" class="form-control input-sm  mailsetting_lines_id" value="{{ $value->mailsetting_lines_id }}">
                    </td><td></td>
                    <td class="pdtdiv " >
                        <select name="bulk_department_id[]" id="bulk_department_id" class="bulk_department_id  select2 parsley-validated" required >{!! $value->department_id !!}</select>
                    </td>
                    <td class="pdtdiv " >
                        <select name="bulk_designation_id[]" id="bulk_designation_id" class="bulk_designation_id  select2 parsley-validated" required >{!! $value->designation_id !!}</select>
                    </td>
                    <td class="pdtdiv " >
                        <select name="bulk_type[]" id="bulk_type" class="bulk_type  select2 parsley-validated" required >
                          <option <?php if($value->type=='TO'){echo 'selected';}?> value="TO">TO</option>
                          <option <?php if($value->type=='CC'){echo 'selected';}?> value="CC">CC</option>
                        </select>
                    </td>
                     
                    <td><a class="remove remove0"><i class="fa btn-xs fa-2x fa-minus-circle rem" aria-hidden="true"></i></a>
                        <input type="hidden" name="counter[]">
                    </td>
                </tr>
                @endforeach
 <?php } if(count($linedata) < 1 ) { ?>
                    <tr class="rcopy clone">
                        <td>
                            <input type="hidden" name="mailsetting_lines_id[]" class="form-control  input-sm mailsetting_lines_id" value="">
                        </td>
                        <td></td>
                        <td class="pdtdiv " >
                            <select name="bulk_department_id[]" id="bulk_department_id" class="bulk_department_id select2 parsley-validated" required>{!! $department_id !!}</select>
                        </td> 
                        <td class="pdtdiv " >
                            <select name="bulk_designation_id[]" id="bulk_designation_id" class="bulk_designation_id select2 parsley-validated" required>{!! $designation_id !!}</select>
                        </td> 
                        <td class="pdtdiv " >
                            <select name="bulk_type[]" id="bulk_type" class="bulk_type  select2 parsley-validated" required >
                              <option value="">-- Please Select -- </option>
                              <option value="TO">TO</option>
                              <option value="CC">CC</option>
                            </select>
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
<!-------------------------Linedata End-------------------------------->


<div class="row">
<div class="col-md-12">
<hr class="xlg">
</div>
</div>

</div>

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group text-center">
            <input type="hidden" name="submit_type" class="submit_type" id="submit_type">
            
          
            <button name="submit" type="button" class="btn save saveform" value="SAVE">Save</button>
            <button name="submit" type="button" class="btn save saveform" value="SAVENEW">Save and New</button>
            <a class='btn cancel' onclick='location.href="{{ url("mailsetting") }}"'>Cancel</a>
       </div>
    </div>
</div>
</div>

</form>
  
<script>
 function taxcheck(checklist,index)
  {
    var taxcount = 0;
    $('.clone').each(function (ind, v)
    {
      var val = $(".bulk_designation_id" + ind).val();
      if($.trim(val)!="" && val!=null){
      if(index != ind){
      if(val == checklist){
        taxcount++;
      }
      }
      }
    });
    return taxcount;
  }
  

$(document).ready(function()
{
$



    var page ='<?php echo $pageMethod; ?>';
    if(page == "createissue"){
        $('.pagemethod').attr('readonly',false);
        $('.pagemethod').css('pointer-events','auto');
        $('.activecol').show();
    }else{
        $('.pagemethod').attr('readonly',true);
        $('.pagemethod').css('pointer-events','none');
        $('.activecol').hide();

    }

  
    $('.add_row').click(function()
    {
        var form = $('#mailsettingform');
        form.parsley().destroy();
  
  });
  $(".add_row").relCopy(data);
   changeclassfields();
   
   $('.add_row').click(function(){
            $('.onclickrel').trigger('click');
            var rowCount = $('.checklist_table tbody tr').length;
      var index = rowCount - 1;
             changeclassfields();
            
    });



 

  $('.read').css('pointer-events','none');
 $('.company').css('pointer-events','none');
  

$('#savestatus').val('');
    $(document).on('click','.saveform',function()
    {
            var btnval    = $(this).val();
            $('#savestatus').val(savestatus);

            var url   = "{{ url('mailsettingsave') }}";
            var create_url  ="{{ url('mailsettingcreate') }}";
            var red_url   ="{{ url('mailsetting') }}";
            validationrule('mailsettingform');
            var form = $('#mailsettingform');
                form.parsley().validate();
                  
                var form = $('#mailsettingform');
                form.parsley().validate();
               
                if (form.parsley().isValid())
                {
                    $(".ajaxLoading").show();
                    change_date();
                     var formdata = $('#mailsettingform').serialize();
                 
                       $.ajax({
                  url: "{{ url('mailsettingsave') }}",
                  type: "POST",
                  data: formdata,
                  async:true,
                 success: function (data) {
                        var status      = data.status;
                        var msg     = '<span style="color:#090065"></span>  '+data.message;
                        var id          = data.id;
                        if(btnval !='SAVE'&& btnval !='DRAFT')
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
                	$('.ajaxLoading').hide();
                       var errors = response.responseJSON.errors;
        
                       var errorsHtml = '';
        
                       $.each( errors, function( key, value ) {
                           errorsHtml += '<p>'+ value[0] + '</p>';
                       });
                     
            notyMsg("error",errorsHtml);
            
           }
       });
       
                    // $.post(url,formdata,function(data)
                    // {
                    //     var status      = data.status;
                    //     var msg     = '<span style="color:#090065"></span>  '+data.message;
                    //     var id          = data.id;
                    //     if(btnval !='SAVE'&& btnval !='DRAFT')
                    //     {
                    //         notyMsg(status,msg);
                    //         setTimeout(function(){
                    //         window.location.href=create_url;
                    //         }, 1500);
                    //     }
                    //     else
                    //     {
                    //         notyMsg(status,msg);
                    //         setTimeout(function(){
                    //         window.location.href=red_url;
                    //         }, 1500);
                    //     }
                    // });
                
                }


    });



$(document).on('click','.remove',function()
{
  var index = $(this).closest('tr').index();
  var rowCount = $('.checklist_table tbody tr').length;
  if(rowCount > 1)
  {
    $($(this).closest("tr")).remove();
    removeclassfields();
  }
  else
  {
    notyMsg('info',"You Can't Delete Atleast One row should be there");
  }
});

   // });

function changeclassfields(){
changeClassName('mailsetting_lines_id');
changeClassName('bulk_designation_id');
changeClassName('bulk_department_id');
changeClassName('bulk_type');
}
function removeclassfields(){
removeClass('mailsetting_lines_id');
removeClass('bulk_designation_id');
removeClass('bulk_department_id');
removeClass('bulk_type');
}


/************  purpose to remove row action ********************/
function removeClass(className)
{
  var rowCount = $('.checklist_table tbody tr').length;
  for(var i=0;i<=rowCount;i++)
  {
  $('.checklist_table tbody tr').find('.'+className).removeClass(className+i);
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



$(window).on('load',function(){
       var preLoder = $("#preloader");
       preLoder.fadeOut(500);
       var backtoTop = $('.back-to-top')
       backtoTop.fadeOut(100);
   });
});
</script>

@include('layouts.php_js_validation')
@endsection

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
.bulk_department_id,.bulk_designation_id,.bulk_type,.bulk_duration,.bulk_level{
  width: 180px !important;
}

</style>

<span class="ui_close_btn"></span>

<h2 class="heads">Mail Setting
  <span class="ui_close_btn">
  <a href="{{ URL::to('pmchecksheet') }}" class="collapse-close pull-right btn-danger" ></a>
</span>
</h2>
<form autocomplete="off" action=" " id="escalationform" class="escalationform" data-parsley-validate  autocomplete="off" >
    {{ csrf_field() }}
    <input type="hidden" value="" name="savestatus" id="savestatus" />
   

<div class="card">

<div class="card-body card-block">


  <div class="row">

    <div class="col-md-3">
      <div class="form-group row">
        <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Condition</label>
        <div class="col-md-8">        
          <input type="hidden"  name="escalation_hrd_id" id="escalation_hrd_id" value="<?php echo $row->escalation_hrd_id; ?>" />
          <select name='condition' rows='5' class='form-control select2 condition'  required>
            <option <?php if($row->condition=='1'){echo 'selected';}?> value="1">Ticket Not Yet Allocated</option>
            <option <?php if($row->condition=='2 '){echo 'selected';}?> value="2">Ticket Closure Request Not Yet Raised</option>
            <option <?php if($row->condition=='3'){echo 'selected';}?> value="3">Ticket Closure Request Not Yet Acknowledged</option>
            <option <?php if($row->condition=='4'){echo 'selected';}?> value="4">Ticket Not Yet Closed</option>
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
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Severity</label>
              <div class="col-md-8 sel2">
              <select name="severity" id="severity" class="severity  select2 parsley-validated" required >{!! $severity !!}</select>
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
            <th>Duration</th>
            <th>Department</th>
            <th>Designation</th>
            <th>Type</th>
            <th ></th>

        </thead>
 <tbody class="gst_code_lines_body">
           
            <?php if(count($linedata)>=1) { ?>
                @foreach($linedata as $key=>$value)

                <tr class="rcopy clone">
                    <td>
                        <input type="hidden" name="escalation_lines_id[]" class="form-control input-sm  escalation_lines_id" value="{{ $value->escalation_lines_id }}">
                    </td><td></td>
                    <td class="pdtdiv " >
                        <select name="bulk_level[]" id="bulk_level" class="bulk_level  select2 parsley-validated" required >
                          <option <?php if($value->type==''){echo 'selected';}?> value="">-- Please Select -- </option>
                          <option <?php if($value->type=='Level 1'){echo 'selected';}?> value="Level 1">Level 1</option>
                          <option <?php if($value->type=='Level 2'){echo 'selected';}?> value="Level 2">Level 2</option>
                          <option <?php if($value->type=='Level 3'){echo 'selected';}?> value="Level 3">Level 3</option>
                          <option <?php if($value->type=='Level 4'){echo 'selected';}?> value="Level 4">Level 4</option>
                          <option <?php if($value->type=='Level 5'){echo 'selected';}?> value="Level 5">Level 5</option>
                          <option <?php if($value->type=='Level 6'){echo 'selected';}?> value="Level 6">Level 6</option>
                          <option <?php if($value->type=='Level 7'){echo 'selected';}?> value="Level 7">Level 7</option>
                          <option <?php if($value->type=='Level 8'){echo 'selected';}?> value="Level 8">Level 8</option>
                          <option <?php if($value->type=='Level 9'){echo 'selected';}?> value="Level 9">Level 9</option>
                          <option <?php if($value->type=='Level 10'){echo 'selected';}?> value="Level 10">Level 10</option>
                        </select>
                    </td>
                    <td class="pdtdiv " >
                        <select name="bulk_duration[]" id="bulk_duration" class="bulk_duration  select2 parsley-validated" required >{!! $value->duration !!}</select>
                    </td>
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
                            <input type="hidden" name="escalation_lines_id[]" class="form-control  input-sm escalation_lines_id" value="">
                        </td>
                    <td class="pdtdiv " >
                        <select name="bulk_level[]" id="bulk_level" class="bulk_level  select2 parsley-validated" required >
                          <option value="">-- Please Select -- </option>
                          <option value="Level 1">Level 1</option>
                          <option value="Level 2">Level 2</option>
                          <option value="Level 3">Level 3</option>
                          <option value="Level 4">Level 4</option>
                          <option value="Level 5">Level 5</option>
                          <option value="Level 6">Level 6</option>
                          <option value="Level 7">Level 7</option>
                          <option value="Level 8">Level 8</option>
                          <option value="Level 9">Level 9</option>
                          <option value="Level 10">Level 10</option>
                        </select>
                    </td>
                        <td></td>
                        <td class="pdtdiv " >
                        <select name="bulk_duration[]" id="bulk_duration" class="bulk_duration  select2 parsley-validated" required >{!! $duration !!}</select>
                        </td> 
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
            <a class='btn cancel' onclick='location.href="{{ url("pmchecksheet") }}"'>Cancel</a>
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
        var form = $('#escalationform');
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

            var url   = "{{ url('escalationsave') }}";
            var create_url  ="{{ url('escalationcreate') }}";
            var red_url   ="{{ url('escalation') }}";
            validationrule('escalationform');
            var form = $('#escalationform');
                form.parsley().validate();
                  
                var form = $('#escalationform');
                form.parsley().validate();
               
                if (form.parsley().isValid())
                {
                    $(".ajaxLoading").show();
                    change_date();
                     var formdata = $('#escalationform').serialize();
                 
                       $.ajax({
                  url: "{{ url('escalationsave') }}",
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
                            // window.location.href=create_url;
                            }, 1500);
                        }
                        else
                        {
                            notyMsg(status,msg);
                            setTimeout(function(){
                            // window.location.href=red_url;
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
changeClassName('escalation_lines_id');
changeClassName('bulk_designation_id');
changeClassName('bulk_level');
changeClassName('bulk_department_id');
changeClassName('bulk_duration');
changeClassName('bulk_type');
}
function removeclassfields(){
removeClass('escalation_lines_id');
removeClass('bulk_designation_id');
removeClass('bulk_level');
removeClass('bulk_department_id');
removeClass('bulk_duration');
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

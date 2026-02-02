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
  <a href="{{ URL::to('pmchecksheet') }}" class="collapse-close pull-right btn-danger" ></a>
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
                 <input type="hidden"  name="checklist_hrd_id" id="checklist_hrd_id" value="<?php echo $row->checklist_hrd_id; ?>" />
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
            <th style="text-align: center; vertical-align: middle;">
                Checklist Name
            </th>
            <th ></th>

        </thead>
 <tbody class="gst_code_lines_body">
           
            <?php if(count($linedata)>=1) { ?>
                @foreach($linedata as $key=>$value)

                <tr class="rcopy clone">
                    <td>
                        <input type="hidden" name="bulk_checklist_lines_id[]" class="form-control input-sm  bulk_checklist_lines_id" value="{{ $value->checklist_lines_id }}">
                    </td><td></td>
                    <td class="pdtdiv " style="text-align: center; vertical-align: middle;">
                        <select name="bulk_checklist_id[]" id="bulk_checklist_id" class="bulk_checklist_id  select2 parsley-validated" required >{!! $value->checklist_id !!}</select>
                    </td>
                     
                    <td><a class="remove remove0"><i class="fa btn-xs fa-2x fa-minus-circle rem" aria-hidden="true"></i></a>
                        <input type="hidden" name="counter[]">
                    </td>
                </tr>
                @endforeach
 <?php } if(count($linedata) < 1 ) { ?>
                    <tr class="rcopy clone">
                        <td>
                            <input type="hidden" name="bulk_checklist_lines_id[]" class="form-control  input-sm bulk_checklist_lines_id" value="">
                        </td>
                        <td></td>
                        <td class="pdtdiv " style="text-align: center; vertical-align: middle;">
                            <select name="bulk_checklist_id[]" id="bulk_checklist_id" class="bulk_checklist_id select2 parsley-validated" required>{!! $checklist_id !!}</select>
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
      var val = $(".bulk_checklist_id" + ind).val();
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
        var form = $('#machinechelistform');
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

$('.department_id').change(function(){
	var depid=$(this).select2('val');
       var condition=" department_id="+depid;
            $(".machine_id").jCombo("{{ URL::to('jcomboformcomp?table=machine_hdr_t:machine_id:asset_code|machine_name') }}&parent="+condition, {
                selected_value: ""
            });
        });

 

  $('.read').css('pointer-events','none');
 $('.company').css('pointer-events','none');
  

$('#savestatus').val('');
    $(document).on('click','.saveform',function()
    {
            var btnval    = $(this).val();
            $('#savestatus').val(savestatus);

            var url   = "{{ url('machinechklistsave') }}";
            var create_url  ="{{ url('machinechklistcreate') }}";
            var red_url   ="{{ url('pmchecksheet') }}";
            validationrule('machinechelistform');
            var form = $('#machinechelistform');
                form.parsley().validate();
                  
                var form = $('#machinechelistform');
                form.parsley().validate();
               
                if (form.parsley().isValid())
                {
                    $(".ajaxLoading").show();
                    change_date();
                     var formdata = $('#machinechelistform').serialize();
                 
                       $.ajax({
                  url: "{{ url('machinechklistsave') }}",
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
changeClassName('bulk_checklist_lines_id');
changeClassName('bulk_checklist_id');
}
function removeclassfields(){
removeClass('bulk_checklist_lines_id');
removeClass('bulk_checklist_id');
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

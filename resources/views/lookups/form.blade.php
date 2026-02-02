@extends('layouts.header')
@section('content')


<span class="ui_close_btn"></span>


<style type="text/css">
    
     @media  only screen and (min-width: 1500px) {

.bulk_line_no {width:80px !important;}
.bulk_lookup_code {width:300px !important;}
.bulk_lookup_meaning {width:300px !important;}
.bulk_sequence {width:200px !important;}
.bulk_active {width:200px !important;}

}

.bulk_line_no {width:80px;}
.bulk_lookup_code {width:300px;}
.bulk_lookup_meaning {width:300px;}
.bulk_sequence {width:220px;}
.bulk_active {width:200px;}

textarea {
    font-size: 10px;
}

</style>

 <h2 class="heads">Common Lookups <span class="ui_close_btn"><a href="{{ url('lookup') }}" class="collapse-close pull-right btn-danger" ></a></span></h2>

<form method="post" action="" id="lookups" data-parsley-validate>
{{ csrf_field() }}
<div class="card">


<div class="card-body card-block headerdiv1">




		<!------------------------------------- Body content start here ---------------------------->
		<div class="row">
			<div class="col-md-12">
			     <input class="form-control lookuphdr_id" id="lookuphdr_id"  name="lookuphdr_id" size="16" type="hidden" value="{{ $row->lookuphdr_id }}" readonly>	

		
				
					
<div class="col-md-4">
    <div class="form-group row">
        <label for="inputIsValid" class="form-control-label col-md-4"> <span style="color:red">*</span>Field Name</label>
        <div class="col-md-6">

            <input type="text" id="lookup_type" name="lookup_type" required class="form-control lookup_type" value="{{ $row->lookup_type }}" required>
        </div>
        <div class="col-md-2">
        </div>
    </div>

    

</div>			
			<div class="col-md-4">
                <div class="form-group row hide">
        <label for="inputIsValid" class="form-control-label col-md-4">Description</label>
        <div class="col-md-6">
            <textarea name="description" id="description" row="5" value="{{ $row->description }}" class="form-control remarks"></textarea>
        </div>
        <div class="col-md-2">
        </div>
    </div>
	           </div>
			
		
				
			</div>
		</div>
	<!------------------------------------------------------------------------------------------>

 <!--*****************  End  *********** -->

<!------------------------- clone row start -------------------------------->
<div class="row">
	<div class="col-md-12">
		<a href="javascript:void(0);" class="add_row additem" rel=".rcopy"><i class="fa fa-plus"></i> New Item</a>

<!------------------------- clone row End-------------------------------->

 <div id="preview-area" class="chandru">
    <table class="overflow-y preview lookups_table">



        <thead>
            <tr>
                
                <th>Line No</th>
                <th class="pdtdiv">Field Option</th>
                <th class="pdtdes_div">Field Option Meaning</th>

                <!--<th>Sequence</th>-->
                <th>Active</th>
                <th>&nbsp;</th>

            </tr>
        </thead>
        <tbody class="so_inq_lines_body1">

            <?php if(count($linedata)>=1) { ?>
    @foreach($linedata as $key=>$value)
                <tr class="rcopy clone">
                

                    <td>
                        <input type="hidden" name="bulk_lookuplines_id[]"  class="form-control input-sm bulk_lookuplines_id" value="{{ $value->lookuplines_id }}">
                    </td>
                    <td>
                        <input type="text" name="bulk_line_no[]" required class="form-control input-sm bulk_line_no" value="{{ $key + 1 }}" readonly="readonly">
                    </td>

                    <td>
                        <input type="text" name="bulk_lookup_code[]" required class="form-control input-sm bulk_lookup_code" value="{{$value->lookup_code}}">
                    </td>
                    <td>
                        <input type="text" name="bulk_lookup_meaning[]" required class="form-control input-sm bulk_lookup_meaning" value="{{ $value->lookup_meaning }}">
                    </td>
<!--                    <td>
                        <input type="text" name="bulk_sequence[]" required class="form-control input-sm bulk_sequence" value="{{$value->sequence}}">
                    </td>-->
                    <td>
                        <select name="bulk_active[]" id="bulk_active" required class="select2 bulk_active" data-show-subtext="true" data-live-search="true">
                            <option value=''>--Please Select--</option>
                            <?php if($value->active=="Yes") { ?>
                                <option value='Yes' selected>Yes</option>
                                <?php }  else { ?>
                                    <option value='No' selected>No</option>
                                    <?php } ?>
                        </select>
                    </td>
                    <td>
                        <a class="remove remove0"><i class="fa btn-xs fa-2x fa-minus-circle rem" aria-hidden="true"></i></a>
                        <input type="hidden" name="counter[]">
                    </td>
                </tr>

                @endforeach

                <?php } if(count($linedata) < 1 ) { ?>
                    <tr class="rcopy clone">
                        <td>
                            <input type="hidden" required name="bulk_lookuplines_id[]" class="form-control input-sm bulk_lookuplines_id" value="" required>
                        </td>
                        <td>
                            <input type="text" required name="bulk_line_no[]" class="form-control input-sm bulk_line_no" value="" readonly="readonly">
                        </td>
                        <td>
                            <input type="text" required name="bulk_lookup_code[]" class="form-control input-sm bulk_lookup_code" required="">
                        </td>
                        <td>
                            <input type="text" required name="bulk_lookup_meaning[]" class="form-control input-sm bulk_lookup_meaning" required>
                        </td>
<!--                        <td>
                            <input type="text" required name="bulk_sequence[]" class="form-control input-sm bulk_sequence">
                        </td>-->
                        <td>
                            <select name="bulk_active[]" required id="bulk_active" class="select2 bulk_active" data-show-subtext="true" data-live-search="true">
                                <option value=''>--Please Select--</option>
                                <option value='Yes'>Yes</option>
                                <option value='No'>No</option>

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
</div>
	</div>
</div>


<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="form-group text-center">
			

            <!--<button type="button" class="btn save saveform"   value="SAVENEW">Save and New</button>-->
			<button type="button" class="btn save saveform" value="SAVE">Save</button>
			  <a href="{{ url('lookup') }}" class='btn cancel'>Cancel</a>
		</div>
	</div>
</div>
</div>




</div>
	


</form>


	<script>
$(document).ready(function(){



var data ="{{\Session::get('j_date_format')}}";
$(".add_row").on('click',function(){
  var form = $('#lookups');
  form.parsley().destroy();
});

$(".add_row").relCopy(data);
   changeclassfields();


$('.add_row').click(function(){
                var rowCount = $('.lookups_table tbody tr').length;
                var index = rowCount - 1;
             changeclassfields();
             $('.bulk_active'+index).val('Yes').change();
            });
            
$(document).on('click','.lookup_menu',function()
{
	var id=$(this).val();

$(".lookup_submenu").jCombo("{{ URL::to('jcomboformlogin?table=tb_menus:menus_id:menus_name') }}&parent=parent_id="+id+ '&order_by=menus_id asc',
		{selected_value:""});
});



	
    $('#savestatus').val('');
    $(document).on('click','.saveform',function()
    {
            var btnval		= $(this).val(); 
            
           if(btnval == 'SAVE' || btnval == 'SAVENEW')
                var savestatus = 'SAVE';
            
            $('#savestatus').val(savestatus);
            
            var url		= "{{ url('lookupsave') }}";
            var red_url		="{{ url('lookup') }}";
            var create_url	="{{ url('lookupcreate') }}";
           validationrule('lookups');
            var formdata	= $('#lookups').serialize();
            var form = $('#lookups');
           
		form.parsley().validate();

		if (form.parsley().isValid())
		{
            
            $.post(url,formdata,function(data)
            {
                    
                    var status = data.status;
                    var msg    = data.message;
                    var id     = data.id;
                    var edit_url	="{{ url('lookup') }}";
                            notyMsg(status,msg);
                            setTimeout(function(){
                            window.location.href=edit_url;
                            }, 1500);

                });
		}
            
    });



$(document).on('click','.jcr_customer_id',function()
{
$(".customer_id").jCombo("{{ URL::to('jcomboformlogin?table=m_customers_t:customer_id:customer_name') }}&order_by=customer_name asc",
{selected_value:""});
});

$(document).on('click','.jcr_project_id',function()
{
$(".project_id").jCombo("{{ URL::to('jcomboformlogin?table=m_projects_t:project_id:project_name') }}&order_by=project_name asc",
{selected_value:""});
});
var index = $('.clone').closest('tr').index();
changeclassfields();



$(document).on('click','.remove',function()
{
	var index = $(this).closest('tr').index();
	var rowCount = $('.lookups_table tbody tr').length;
	if(rowCount > 1)
	{
		$($(this).closest("tr")).remove();
		removeclassfields();
	}
	else
	{
		notyMsgs('info',"You Can't Delete Atleast One row should be there");
	}
});



function changeclassfields(){
changeClassName('bulk_lookuplines_id');
changeClassName('bulk_line_no');
changeClassName('bulk_lookup_code');
changeClassName('bulk_lookup_meaning');
changeClassName('bulk_active');
}
function removeclassfields()
{
changeClassName('bulk_lookuplines_id');
changeClassName('bulk_line_no');
changeClassName('bulk_lookup_code');
changeClassName('bulk_lookup_meaning');
changeClassName('bulk_active');	
}
/************ Maruthu purpose to remove row action ********************/
function removeClass(className)
{
	var rowCount = $('.lookups_table tbody tr').length;
	for(var i=0;i<=rowCount;i++)
	{
	$('.lookups_table tbody tr').find('.'+className).removeClass(className+i);
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
 function changeClassName(className) {
            $('.' + className).each(function(index) {
                if (className == "bulk_line_no")
                {
                $(this).val(index + 1).attr("readonly", 1);
                }
                $(this).removeClass(className + '0');
                $(this).addClass(className + index);
            });
        }		


});
	</script>
<style>
#table_scroll tbody {
display:block;
max-height:300px;
overflow:auto;
}
#table_scroll table thead tr {
display:table;
}
</style>
@include('layouts.php_js_validation')
@endsection

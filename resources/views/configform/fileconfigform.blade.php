@extends('layouts.header')
@section('content')
<style>
@media only screen and (min-width: 1500px) {
    .bulk_line_no {width: 50px !important;}
    .bulk_field {width: 280px !important;}
    .bulk_title {width: 130px !important;
         text-transform: capitalize;   
    }
    .bulk_type {width: 110px !important;}
    .bulk_show {width: 100px !important;}
    .bulk_db_table {width: 60px !important;}
    .bulk_required_option {width: 100px !important;}
    
       }
    @media only screen and (min-width: 2000px) {
    .bulk_line_no {width: 50px !important;}
    .bulk_field {width: 310px !important;
        
    }
    .bulk_title {width: 230px !important;
         text-transform: capitalize;   
    }
    .bulk_type {width: 210px !important;}
    .bulk_show {width: 120px !important;}
    .bulk_db_table {width: 120px !important;}
    .bulk_required_option {width: 100px !important;}
   
      }
    .bulk_line_no{width: 100px;}
    .bulk_field{width: 280px;}
    .bulk_title {width: 280px ;
      
    text-transform: capitalize;   
  
        
    }
    .bulk_type{width: 180px;}
    .bulk_show{width: 180px;}
    .bulk_db_table{width: 100px;}
    .bulk_required_option {width: 275px;}
   
   
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  border: 1px solid #ccc;
  border-top: none;
}
</style>

<h2 class="heads">Configuration 
    <span class="ui_close_btn">
        <a href="../<?php echo $pageMethod; ?>" class="collapse-close pull-right btn-danger" ></a>
    </span>
</h2>


<div class="card">

<div class="card-body card-block">
<form method="post" action="" id="configurationform" class="configurationform"  enctype="multipart/form-data">
	 {{ csrf_field() }}

<div class="row">
<div class="col-md-12">

<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'London')" type='button'>Info</button>
  <button class="tablinks" onclick="openCity(event, 'Paris')" type='button'>Module</button>
</div>

<div id="London" class="tabcontent">
 
 <div class="col-md-12">
 
 <div class="form-group row">
            <label for="target_date_to_completion" class="form-control-label col-md-4">Module Name / Title</label>
            <div class="col-md-6 rdonlydiv updatediv" >
                <input type="hidden" name='config_hdr_id'  class='form-control config_hdr_id'  id="config_hdr_id" value="">                
                <input type="text" name='module_name'  class='form-control module_name'  id="module_name">                
            </div>
        </div>
        
        

 <div class="form-group row">
            <label for="assigned_to" class="form-control-label col-md-4"><span style="color: red;" > * </span>Module Table</label>
            <div class="col-md-8" >
                <select class="form-control module_table select2" id="module_table" name="module_table"  >
                    {!! $table !!}
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="assigned_to" class="form-control-label col-md-4"><span style="color: red;" > * </span>Module Table Primary Key</label>
            <div class="col-md-6">
                <input type="text" class="form-control module_table_pk " id="module_table_pk" name="module_table_pk"  value="" required readonly>
                
            </div>
        </div>

 
 </div>
</div>

<div id="Paris" class="tabcontent">
    <a href="javascript:void(0);" class="add_row2 additem newitem" rel=".rcopy">
            <i class="fa fa-plus"></i> New Item</a>

 <div class="table-responsive">
		<table class="table table-striped table-bordered" id="table">
		<thead class="no-border">
          <tr>
            <th>No</th>
            <th>Field</th>
            <th >Title / Caption </th>
          	<th >Type </th>
            <th>Show</th>
             <th>Field   Options</th>
          </tr>
		  </thead>
		  <tbody>
		        <tr class="rcopy clone1">
                                <td>
                                     <input type="text" name="bulk_line_no[]" class="form-control input-sm bulk_line_no"   value="">
                                
                                </td>
                                <td>
                                   <input type="text" name="bulk_field[]" class="form-control input-sm bulk_field"   value="">
                                </td>
                                <td>
                <input type="text" name="bulk_title[]" class="form-control  input-sm bulk_title"   value="">
            </td>
             <td>
                <select name="bulk_type[]" class="form-control  select2 bulk_type" id="bulk_type">
                    <option value="">-- Please Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </td>
             <td>
                
            <select name="bulk_show[]" class="form-control  select2 bulk_show" id="bulk_show">
                    <option value="">-- Please Select --</option>
                    <option value="Yes">Yes</option>
                    <option value="No">No</option>
                </select>
            </td>
               <td>
               <a class="fieldoptions" data-type="module"><i class="fa btn-xs fa-2x fa-plus" aria-hidden="true"></i></a> 
                <input type="hidden" name="bulk_field_type[]" class="form-control bulk_field_type " value="" >
                <input type="hidden" name="bulk_select_option_tbl[]" class="form-control bulk_select_option_tbl " value="" >
                <input type="hidden" name="bulk_select_option_pri_id[]" class="form-control bulk_select_option_pri_id " value="" >
                <input type="hidden" name="bulk_display1[]" class="form-control bulk_display1 " value="" >
                <input type="hidden" name="bulk_display2[]" class="form-control bulk_display2 " value="" >
            </td>
                  <input type="hidden" name="counter[]">
                
                            </tr>
		  </tbody></table>
</div>
</div>



</div>
</div>

  <div class="row">	<div class="col-lg-12 col-md-12">
      <button name="submit" type="button" class="btn save saveform" value="SAVE">Submit</button>
           
  </div></div>  



</form>

</div>
</div>
<div class="modal fade" id="fieldModal">
  <div class="modal-dialog" style="width:50%;">
    <div class="modal-content">
		<!--Moda Header-->
      <div class="modal-header">
		  <h4 class="modal-title"> Field Option Details </h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
	  </div>
		<!-- Modal Body -->
	  <div class="modal-body">
	      <div class="col-md-12">
 
 <div class="form-group row">
            <label for="form_type" class="form-control-label col-md-4">Form Type</label>
            <div class="col-md-6" >
	      <select  rows='5'  class='select2 form_type' data-show-subtext="true" data-live-search="true" style="width: 100%">
                               <option value="">--Please select--</option>          
                               <option value="Hidden">Hidden</option>          
                               <option value="Text">Text</option>          
                               <option value="Textarea">Textarea</option>          
                               <option value="Date">Date</option>          
                               <option value="Select">Select</option>          
                               <option value="File">File</option>          
                                        </select>
                                        </div>
                                        </div>
  <div class="form-group row tablediv">
            <label for="select_table" class="form-control-label col-md-4">Select Table</label>
            <div class="col-md-6" >
	      <select  rows='5'  class='select2 select_table' data-show-subtext="true" data-live-search="true" style="width: 100%">
                                       {!! $table !!}
                                        </select>
                                        </div>
                                        </div>  
    <div class="form-group row tablediv">
            <label for="primarykey" class="form-control-label col-md-4">Primary Key</label>
            <div class="col-md-6" >
	      <select  rows='5'  class='select2 primarykey' data-show-subtext="true" data-live-search="true" style="width: 100%">
                                       
                                        </select>
                                        </div>
                                        </div> 
   <div class="form-group row tablediv">
            <label for="primarykey" class="form-control-label col-md-4">Display1</label>
            <div class="col-md-6" >
	      <select  rows='5'  class='select2 display1' data-show-subtext="true" data-live-search="true" style="width: 100%">
                                       
                                        </select>
                                        </div>
                                        </div>
   <div class="form-group row tablediv">
            <label for="primarykey" class="form-control-label col-md-4"> Display2</label>
            <div class="col-md-6" >
	      <select  rows='5'  class='select2 display2' data-show-subtext="true" data-live-search="true" style="width: 100%">
                                       
                                        </select>
                                        </div>
                                        </div>                                                                   
                                        </div>
	  </div>
		 <!-- Modal footer -->
      <div class="modal-footer">
          <input type="hidden" class="findex" value="">
          <input type="hidden" class="dtype" value="">
          <button  type="button" class="savefield">Save</button>
      </div>

    </div>
  </div>
</div>

<link rel="stylesheet" href="{{asset('css/bootstrap-datetimepicker.css')}}">

<script>
$(document).ready(function(){
   $('.module_table').change(function(){
     var table= $(".module_table").select2('val'); 
   $.get("{{URL::to('gettablefield')}}/"+table,function(data){
      // console.log(data[0].Field);
       $('.module_table_pk').val(data[0].Field);
     $.each(data,function(index,val){
         
        if(index>0)
        $(".add_row2").trigger('click');
        
    var ind=$(".clone1").last('tr').index();
    
    console.log(ind);
    
    var v=val.Field;
    
    var vv=v.toUpperCase().replace(/_/g, ' ');
    
    $(".bulk_field"+ind).val(v);
    $(".bulk_title"+ind).val(vv);
     $(".bulk_db_table"+ind).val(v);
   
    
         
        console.log(val); 
     });
     
   });  
   }); 
  
   $('.select_table').change(function(){
       var table= $(".select_table").select2('val'); 
   $.get("{{URL::to('gettablefield')}}/"+table,function(data){
       
       var html="<option value=''>--Please Select--</option>";
       
       $.each(data,function(index,val){
       
       html =html + "<option value='"+val.Field+"'>"+val.Field+"</option>";
           
       });
       
       
       $(".primarykey").html(html);
        $(".display1").html(html);
         $(".display2").html(html);
       
   
   }); 
   });
    $('.fieldoptions').click(function()
	{
	 $('#fieldModal').modal('show');
	 $('#fieldModal').width("100%");
	 $('.form_type').select2('val',['']);
    $('.select_table').select2('val',['']);
     $('.primarykey').select2('val',['']);
 $('.display1').select2('val',['']);
    $('.display2').select2('val',['']);
    	$('.tablediv').hide();
	 var index=$(this).closest('tr').index();
	$('.findex').val(index);
	var dtype=$(this).data('type');
	$('.dtype').val(dtype);
	});
	$('.tablediv').hide();
	$('.form_type').change(function(){
	    var ftype=$(this).val();
	    if(ftype=="Select"){
	    $('.tablediv').show();
	    }
	});

 $('.savefield').click(function(){
     var type=$('.form_type').select2('val');
     var dbtable=$('.select_table').select2('val');
     var primarykey=$('.primarykey').select2('val');
     var display1=$('.display1').select2('val');
     var display2=$('.display2').select2('val');
     var index=$('.findex').val();
     var dtype=$('.dtype').val();
     if(dtype=="module")
{
    $('.bulk_field_type'+index).val(type);
     $('.bulk_select_option_tbl'+index).val(dbtable);
     $('.bulk_select_option_pri_id'+index).val(primarykey);
     $('.bulk_display1'+index).val(display1);
     $('.bulk_display2'+index).val(display2);
}

     $('#fieldModal').modal('hide');
 });
 
 $(document).on('click','.saveform',function() {
     
	var url			="{{ URL::to('configurationdatasave') }}";
        var red_url		="{{ URL::to('configform') }}";
     
	validationrule('configurationform');
	var form = $('#configurationform');

		form.parsley().validate();
		var form = $('#configurationform');
              
		form.parsley().validate();

		if (form.parsley().isValid())
		{
		 $('.ajaxLoading').show();
		 //alert(round_off);
               
                 var formdata	= $('#configurationform').serialize();
		 var form_data = new FormData(document.getElementById('configurationform'));   
          $.ajax({
                  url: url,
                  type: "POST",
                  data: form_data,
                  enctype: 'multipart/form-data',
                  processData: false,  // tell jQuery not to process the data
                  contentType: false,   // tell jQuery not to set contentType
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
                                        //update progressbar

                                }, true);
                        }
          return xhr;

                }
                }).done(function(data)
		{
			var status  = data.status;
				var msg     = data.message;
			
                   notyMsg(status,msg);
                   $('.ajaxLoading').hide();
                   window.location.href=red_url;
                   
           
		});  
		}
	

});
        $(".add_row2").relCopy();
        changeClassfields(); 
    $('.add_row2').click(function() {
        changeClassfields(); 
    });
      });
    function changeClassfields()
{
        changeClassName('fieldoptions');
        changeClassName('bulk_field_type');
        changeClassName('bulk_select_option_tbl');
        changeClassName('bulk_select_option_pri_id');
        changeClassName('bulk_display1');
        changeClassName('bulk_display2');
        changeClassName('bulk_line_no');
        changeClassName('bulk_title');
        changeClassName('bulk_show');
        changeClassName('bulk_type');
        changeClassName('bulk_field');
        changeClassName('bulk_db_table');
        changeClassName('bulk_required_option');
     }
     

    function changeClassName(className1) {
            $('.' + className1).each(function(index) {
                if (className1 == "bulk_line_no") {
                    $(this).val(index + 1).attr("readonly", 1);
                }
   $(this).removeClass (function (index, className) {
    return (className.match (new RegExp("\\b"+className1+"\\S+", "g") ) || []).join(' ');
});
               
                $(this).addClass(className1 + index);
                $('.'+className1+index).css('pointer-events','');
            });
        }
         
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

</script>
@include('layouts.php_js_validation')
@endsection
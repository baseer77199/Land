@extends('layouts.header')
@section('content')

<style type="text/css">

</style>

<div id="accordion">
<div class="panel-heading" role="tab" id="headingOne">
  
                                <h4 class="panel-title">
                                    <a role="button">
                                       
                                        Machine Checklist
                                    </a>
                                </h4>

                             
                            </div>

</div>
<form id="create-user" action="{{URL::to('machinechklistcreate')}}" method="POST" style="display: none;">
                                   {{ csrf_field() }}
                                <input type='hidden' name='id' value='0' id='id' class='id'>   
                                    
                                  </form>
                                  
                                  
    <form id="view-user" action="{{URL::to('machinechecklistview')}}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                                <input type='hidden' name='id' value='0' id='id' class='id'>   
                                    
                                  </form>     


  <div class="panel panel-visible" id="spy1">


<div class="panel-title">
  <div class="row">
  <div class="col-md-12">
	  <?php include('toolbar.php'); ?>
</div>
</div>
</div>


<div class="row">
<div class="col-md-12">
<hr class="xlg">
</div>
</div>

<div class="row">
<div class="col-md-12">

  <table id="grid1"></table>
</div>
</div>

<div class="row">
<div class="col-md-12">
<hr class="xlg">
</div>
</div>


  </div>
  





<script type="text/javascript">
$( document ).ready(function() {


$("#grid1").jqGrid({
url:"{{URL::to('getchecklistdata')}}",
mtype:'GET',
datatype:'json',

colModel: [
{ name: "id", label: "S.NO",hidden:true },
{ name: "checklist_hrd_id", label: "id",hidden:true },
{ name: "department_name", label: "Department Name" },
{ name: "machine_name", label: "Machine Name"},
{ name: "frequency_name", label: "Frequency Name",editable:true, editrules:{date:true}},

],
iconSet: "fontAwesome",
   rowNum: 10,
    rowList: [10,20,50,100,250,500,1000],
    sortorder: "desc",
    viewrecords: true,
    gridview: true,
    rownumbers:true,
      pager: "#grid1",
      autowidth: true,
viewrecords: true,
searching: {
defaultSearch: "cn"
}
});
        jQuery("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false, defaultSearch:'cn'});
$("#grid1").jqGrid("setLabel", "rn", "S.No");
	
// $(".edit").click(function(){
//     var index = $("#grid1").jqGrid('getGridParam','selrow');
// 	var edit_id = $("#grid1").jqGrid ('getCell', index, 'checklist_hrd_id');
//       if( index){
// 		window.location.replace('machinechecklistedit/'+edit_id);
// 	}
// 	else
// 	{
// 		 notyMsgs("info","Please Select a Row");
// 	}

// });
$('.edit').on('click',function(){
	       var index = $("#grid1").jqGrid('getGridParam','selrow');
 	var edit_id = $("#grid1").jqGrid ('getCell', index, 'checklist_hrd_id');
   var id=$('.id').val(edit_id);
   if(index){ 
document.getElementById('create-user').submit(); 
      }else{
          notyMsgs("info","Please Select one row");	 
      }
     })
     
     $('.create').on('click',function(){
    
document.getElementById('create-user').submit(); 
       
     })
     
// $(document).on('click','.create',function()
// {
// var inquirytype = $(this).val();
// var url="{{ url('machinechklistcreate') }}";

// window.location.replace(url);
// });
showcolumn('grid1');

 $('#viewdata').on('click',function(){
     var index = $("#grid1").jqGrid('getGridParam','selrow');
 	var id = $("#grid1").jqGrid ('getCell', index, 'checklist_hrd_id');
     var id=$('.id').val(id);
        if(index){     
document.getElementById('view-user').submit();   
      }else{
         notyMsgs("info","Please Select one row");	 
      }
     })
//       $("#viewdata").click(function(){
// 	var index = $("#grid1").jqGrid('getGridParam','selrow');
// 	var id = $("#grid1").jqGrid ('getCell', index, 'checklist_hrd_id');
// 	if(index)
// 	{
// 		window.location.replace('machinechecklistview/'+id );
// 	}
// 	else
// 	{
// 			 notyMsgs("info","Please Select a Row");
// 	}
// });
       $(".delete").click(function(){
		var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
		var pohdrid = jQuery("#grid1").jqGrid ('getCell', gr, 'id');
		if( pohdrid != false ){
		window.location.replace('userdelete/' +pohdrid);
		}
		else{
		 notyMsg("info","Please Select a Row");
		}
	});
/***** Delete Row ********/

	$("#clearsearch").click(function() {
		var grid = $("#grid1");
		grid.jqGrid('setGridParam',{search:false});

		var postData = grid.jqGrid('getGridParam','postData');
		$.extend(postData,{filters:""});
		grid.trigger("reloadGrid",[{page:1}]);
		 $('input[id*="gs_"]').val("");
         $('select[id*="gs_"]').select2('val',['']);
	});
/*End*/

	$("#exportpdf").on("click", function(){
		
			$("#grid1").jqGrid('exportToPdf', {
  title: null,
  orientation: 'portrait',
  pageSize: 'A4',
  description: null,
  onBeforeExport: null,
  download: 'download',
  includeLabels : true,
  includeGroupHeader : true,
  includeFooter: true,
  fileName : "Machine Checklist.pdf",
  mimetype : "application/pdf"  
});
	});	
		
		$("#exportexcel").on("click", function(){
				$("#grid1").jqGrid("exportToExcel",{
					includeLabels : true,
					includeGroupHeader : true,
					includeFooter: true,
					fileName : "Machine Checklist.xlsx",
					maxlength : 40000 
				})
		
		
			})

});
    </script>
@endsection

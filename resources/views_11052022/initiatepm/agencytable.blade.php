@extends('layouts.header')
@section('content')

<style type="text/css">
.Menu li>a:nth-child(1)::before{
	display: none;
}

.panel,.card{
	margin-bottom: 280px;
}

</style>
<h2 class="heads">PM AGENCY ALLOCATION</h2>
<form id="create-user" action="{{URL::to('pmagencyallocationcreate')}}" method="POST" style="display: none;">
                                    {{ csrf_field()}}
                                <input type='hidden' name='id' value='' id='id' class='id'>   
                                    
                                  </form>
                                                        
<div class="panel panel-visible" id="spy1">

	<div class="row">
	<div class="col-md-12">
      <?php include('toolbar.php'); ?>
</div>
</div>
<div class="row">
<div class="col-md-12" >
<table id="agencyallocationgrid"></table>
</div>
</div>
</div>

<script type="text/javascript">
$( document ).ready(function() {
/*karthigaa purpose: function to load data using jqgrid*/
$("#agencyallocationgrid").jqGrid({
url: "{{URL::to('pmagencyallocationData')}}",
datatype: "json",
mtype: "GET",
	 colModel: [
	{ name: "initiate_pm_id", label: "id",hidden:true },
	{ name: "pm_no", label: "PM No"},
	{ name: "machine_name", label: "Machine Name"},
        { name: "department_name", label: "Department Name"},	
        { name: "actual_pm_date", label: "Actual PM Date"}		
		],
               rowNum:10,
		viewrecords: true,
            	footerrow: true,
                sortorder: "desc",
		userDataOnFooter: true, // use the userData parameter of the JSON response to display data on footer
		width: 780,
		height: 300,
                rownumbers: true ,
		rowList: [10, 20, 50, 100,250,500,1000],
		pager: "#agencyallocationgrid"
      });
jQuery("#agencyallocationgrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
/*end*/
	/*karthigaa purpose: function to set label for sno*/
	$("#agencyallocationgrid").jqGrid("setLabel", "rn", "S.No");/*end*/
        showcolumn('agencyallocationgrid');
          $("#gs_actual_pm_date").attr("placeholder","Eg:2018-10-31");  

	/*karthigaa purpose:export excel & pdf*/
 $(document).on('click',".exportpdf",function() {
   	$("#agencyallocationgrid").jqGrid('exportToPdf', {
  title: null,
  orientation: 'portrait',
  pageSize: 'A4',
  description: null,
  onBeforeExport: null,
  download: 'download',
  includeLabels : true,
  includeGroupHeader : true,
  includeFooter: true,
  fileName : "PM Agency Allocation.pdf",
  mimetype : "application/pdf"  
});
});
 $(document).on('click',".exportexcel",function() {	
	$("#initiatepmgrid").jqGrid("exportToExcel",{
					includeLabels : true,
    					includeGroupHeader : true,
    					includeFooter: true,
    					fileName : "PM Agency Allocation.xlsx"
    					
				});		
				});		
	/*end*/

  
/*purpose:clear search the jqgrid*/
  $(".clearsearch").click(function()
  {
    var grid = $("#agencyallocationgrid");
    grid.jqGrid('setGridParam',{search:false});
    var postData = grid.jqGrid('getGridParam','postData');
    $.extend(postData,{filters:""});
    grid.trigger("reloadGrid",[{page:1}]);
    $('input[id*="gs_"]').val("");
    
  });
  /*end*/
  $('.allocateagency').on('click',function(){
var gr=$('#agencyallocationgrid').jqGrid('getGridParam','selrow');
 var id = $("#agencyallocationgrid").jqGrid ('getCell', gr, 'initiate_pm_id');
   if(gr){ 
       var id=$('.id').val(id);
document.getElementById('create-user').submit(); 
  
      }else{
          notyMsgs("info","Please Select one row");	 
      }
     })
/*karthigaa purpose: function :Initiate PM*/
// $(document).on('click','.allocateagency',function()
// {
//   var gr=$('#agencyallocationgrid').jqGrid('getGridParam','selrow');
//     var id = $("#agencyallocationgrid").jqGrid ('getCell', gr, 'initiate_pm_id');

//   if(gr)
//   {
// var url="{{ URL::to('pmagencyallocationcreate') }}"+"/"+id;
// window.location.replace(url);
//   }else{
//       notyMsg("info","Please Select Row");
//   }
// });
/*end*/

});
  </script>
@endsection

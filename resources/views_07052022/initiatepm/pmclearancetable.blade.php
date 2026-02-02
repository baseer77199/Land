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
<?php if($pageMethod=="pmclearance"){ ?>
<h2 class="heads">PM Clearance</h2>
<?php } else{ ?>
<h2 class="heads">Initiate PM Reschedule</h2>
<?php }?>
 <form id="create-user" action="{{URL::to('pmreschedule')}}" method="POST" style="display: none;">
                                   		{{ csrf_field() }}
                                <input type='hidden' name='id' value='' id='id' class='id'>   
                                    
                                  </form>
 <form id="create-clearance" action="{{URL::to('pmclearancecreate')}}" method="POST" style="display: none;">
                             		{{ csrf_field() }}
                                <input type='hidden' name='id' value='' id='id' class='id'>   
                                    
                                  </form>
                                  
                                  
    <form id="view-user" action="{{URL::to('pmviewdata')}}" method="POST" style="display: none;">
                                 		{{ csrf_field() }}
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
<table id="clearancepmgrid"></table>
</div>
</div>
</div>

<script type="text/javascript">
$( document ).ready(function() {
/*karthigaa purpose: function to load data using jqgrid*/
$("#clearancepmgrid").jqGrid({
url: "{{URL::to('pmclearanceData')}}",
datatype: "json",
mtype: "GET",
	 colModel: [
	{ name: "initiate_pm_id", label: "id",hidden:true },
	{ name: "pm_no", label: "PM No"},
	{ name: "machine_name", label: "Machine Name"},
        { name: "department_name", label: "Department Name"},	
          { name: "actual_pm_date", label: "Plan PM Date",formatter: 'date', formatoptions: { srcformat: 'Y-m-d', newformat: 'Y-m-d'}},
        { name: "initiate_date", label: "Initiate Date",formatter: 'date', formatoptions: { srcformat: 'Y-m-d', newformat: 'Y-m-d'}},	
        { name: "user_clearance_by", label: "Clearance Allocated To"},
      //  { name: "initiate_status", label: "Status"}   
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
		pager: "#clearancepmgrid"
      });
jQuery("#clearancepmgrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
/*end*/
	/*karthigaa purpose: function to set label for sno*/
	$("#clearancepmgrid").jqGrid("setLabel", "rn", "S.No");/*end*/
        showcolumn('clearancepmgrid');
	/*karthigaa purpose:export excel & pdf*/
 $(document).on('click',".exportpdf",function() {
   	$("#clearancepmgrid").jqGrid('exportToPdf', {
  title: null,
  orientation: 'portrait',
  pageSize: 'A4',
  description: null,
  onBeforeExport: null,
  download: 'download',
  includeLabels : true,
  includeGroupHeader : true,
  includeFooter: true,
  fileName : "PM Clearance.pdf",
  mimetype : "application/pdf"  
});
});

 jQuery("#clearancepmgrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
$("#gs_initiate_date").attr("placeholder","Eg:2018-10-31");  

 $(document).on('click',".exportexcel",function() {	
	$("#clearancepmgrid").jqGrid("exportToExcel",{
					includeLabels : true,
    					includeGroupHeader : true,
    					includeFooter: true,
    					fileName : "PM Clearance.xlsx"
    					
				});		
				});		
	/*end*/

  /*purpose:clear search the jqgrid*/
  $(".clearsearch").click(function()
  {
    var grid = $("#clearancepmgrid");
    grid.jqGrid('setGridParam',{search:false});
    var postData = grid.jqGrid('getGridParam','postData');
    $.extend(postData,{filters:""});
    grid.trigger("reloadGrid",[{page:1}]);
    $('input[id*="gs_"]').val("");
    
  });
  /*end*/
/*karthigaa purpose: function :Initiate PM*/
$('.clearance').on('click',function(){
     var gr=$('#clearancepmgrid').jqGrid('getGridParam','selrow');
     var id = $("#clearancepmgrid").jqGrid ('getCell', gr, 'initiate_pm_id');
  
   if(gr){ 
        var id=$('.id').val(id);
document.getElementById('create-clearance').submit(); 
      }else{
          notyMsgs("info","Please Select one row");	 
      }
     })
// $(document).on('click','.clearance',function()
// {
//   var gr=$('#clearancepmgrid').jqGrid('getGridParam','selrow');
//     var id = $("#clearancepmgrid").jqGrid ('getCell', gr, 'initiate_pm_id');

//   if(gr)
//   {
// var url="{{ URL::to('pmclearancecreate') }}"+"/"+id;
// window.location.replace(url);
//   }else{
//       notyMsg("info","Please Select Row");
//   }
// });
/*end*/
// $(document).on('click','.reschedule',function()
// {
//   var gr=$('#clearancepmgrid').jqGrid('getGridParam','selrow');
//     var id = $("#clearancepmgrid").jqGrid ('getCell', gr, 'initiate_pm_id');

//   if(gr)
//   {
// var url="{{ URL::to('pmreschedule') }}"+"/"+id;
// window.location.replace(url);
//   }else{
//       notyMsg("info","Please Select Row");
//   }
// });
$('.reschedule').on('click',function(){
    var gr=$('#clearancepmgrid').jqGrid('getGridParam','selrow');
    var id = $("#clearancepmgrid").jqGrid ('getCell', gr, 'initiate_pm_id');
   var id=$('.id').val(id);
   if(gr){ 
document.getElementById('create-user').submit(); 
      }else{
          notyMsgs("info","Please Select one row");	 
      }
     })
$('#viewdata').on('click',function(){
   var gr=$('#clearancepmgrid').jqGrid('getGridParam','selrow');
    var id = $("#clearancepmgrid").jqGrid ('getCell', gr, 'initiate_pm_id');
     
        if(gr){     
            var id=$('.id').val(id);
document.getElementById('view-user').submit();   
      }else{
         notyMsgs("info","Please Select one row");	 
      }
     })

// $(document).on('click','#viewdata',function()
// {
//   var gr=$('#clearancepmgrid').jqGrid('getGridParam','selrow');
//     var id = $("#clearancepmgrid").jqGrid ('getCell', gr, 'initiate_pm_id');

//   if(gr)
//   {
// var url="{{ URL::to('pmviewdata') }}"+"/"+id;
// window.location.replace(url);
//   }else{
//       notyMsg("info","Please Select Row");
//   }
// });
});
  </script>
@endsection

@extends('layouts.header')
@section('content')

@if (session('status'))
        <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session('status') }}
        </div>
    @endif


<h2 class="heads">Task Manager</h2>

<div class="panel panel-visible" id="spy1">

<div class="panel-title ">
  <div class="row" style="text-align:left;">
  <div class="col-md-12">


  <?php include 'toolbar.php'; ?>
  </div>
</div>
</div>
<div class="row">

<div class="col-md-12" style="padding:15px;">

<table id="grid1"></table>

</div>
</div>
</div>





<script type="text/javascript">
$( document ).ready(function() {
var status = '<?php echo $pageMethod; ?>';
if(status == "taskmanagerapproval"){
  status = 'approval';
}else if(status == "taskmanagerupdate"){
  status = 'update';
} else {
	status = '';
}

var date_format="{{\Session::get('p_date_format')}}";
      $("#grid1").jqGrid({
      url: "gettaskmanData?status="+status,
      datatype: "json",
      mtype: "GET",
    colModel: [
    { name: "taskmanager_id", label: "id" ,hidden:true},
//{ name: "department_name", label: "Department" ,editable:true, editrules:{date:true}},
{ name: "first_name", label: "Assigned To" ,editable:true, editrules:{date:true}},
{ name: "status", label: "Status" ,editable:true, editrules:{date:true}},
{ name: "sub_department_name", label: "Department Name" ,editable:true, editrules:{date:true}},
{ name: "start_date", label: "Start Date" ,editrules:{date:true},formatter: 'date', formatoptions: { srcformat: 'Y-m-d', newformat: date_format}},
{ name: "end_date", label: "End Date",editrules:{date:true},formatter: 'date', formatoptions: { srcformat: 'Y-m-d', newformat: date_format}},
  { name: "task", label: "Task", editable:true, editrules:{date:true}},
    { name: "username", label: "Created By",editable:true, editrules:{date:true}},
 ],
          rowNum:10,
    viewrecords: true,
    footerrow: true,
    sortorder: "desc",
             
    userDataOnFooter: true,
    width: 780,
    height: 300,
    rownumbers: true ,
    pager:"#grid1",
    rowList: [10,50,100,250,500,1000]
      
 });

$("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false,edit:true,add:true,del:true,search:true,cloneToTop:true,refresh:false});


 $(document).on('click',".exportexcel",function() {

  $("#grid1").jqGrid("exportToExcel",{
          includeLabels : true,
              includeGroupHeader : true,
              includeFooter: true,
              fileName : "Task Manager.xlsx"
              
        })     
    });

 $(document).on('click',".exportpdf",function() {
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
  fileName : "Task Manager.pdf",
  mimetype : "application/pdf"  
});
      

  
});

showcolumn('grid1');



$(".create").click(function(){

var url="{{ URL::to('taskmanagercreate/0')}}";
window.location.replace(url);

});
	


$("#edit").click(function()
{
	var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
	var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'taskmanager_id');
  var status = jQuery("#grid1").jqGrid ('getCell', gr, 'status');
  
	if(cellValue)
	{
    if(status == "INITIATED"){
        var url = "{{ url('taskmanageredit') }}/";  
        window.location.replace(url +cellValue);
    }else{
        notyMsg('info','only INITIATED data can edit')
    }
		  
	}
	else
	{
	notyMsg("info","Please a Select Row");
	}
});




$("#view").click(function()
{
  var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
  var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'taskmanager_id');
  var type = "<?php echo $urlname ?>";
  if(cellValue)
  {
    var url = "{{ url('taskmanagerview') }}/";
      window.location.replace(url +cellValue);
  }
  else
  {
      notyMsg("info","Please a Select Row");
  }
});


$(".approve").click(function()
{
	var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
	var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'taskmanager_id');
  var type = "<?php echo $urlname ?>";
	if(cellValue)
	{
    var url = "{{ url('taskmanagercreate') }}/";
      window.location.replace(url +cellValue+"?status=approve");
	}
	else
	{
	    notyMsg("info","Please a Select Row");
	}
});

$("#update").click(function()
{
	var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
	var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'taskmanager_id');
  var type = "<?php echo $urlname ?>";
	if(cellValue)
	{
    var url = "{{ url('taskmanagercreate') }}/";
      window.location.replace(url +cellValue+"?status=update");
	}
	else
	{
	    notyMsg("info","Please a Select Row");
	}
});


$(".jqgrow td input").each(function () {
    jQuery(this).click(function () {
        $("#grid").jqGrid('setSelection', $(this).parents('tr').attr('id'));
    });
});


$("#delete").click(function(){

  var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
  var cellValue = jQuery("#grid1").jqGrid ('getCell', gr,'taskmanager_id');
  if( cellValue )
  {
    swal({
      title: "Are you sure?",
      text: "You want to delete!",
      type: "warning",
      showCancelButton: !0,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    }, function(e) {
    if(e == true)
      {
        var url ="{{ URL::to('taskmanagerdelete') }}/" +cellValue;
        $.get(url,function(data)
        {
          var data = $.trim(data);
          var red_url ="{{ URL::to('taskmanager') }}";

          if(data =='0')
          {
            notyMsg('success','Deleted Successfully');
            setTimeout(function(){
            $("#grid1")[0].triggerToolbar();
            }, 1500);
          }
          if(data=='2')
          {
            notyMsg('error',"You Cant't delete , Doctor Used in SomeWhere");
            setTimeout(function(){
              $("#grid1")[0].triggerToolbar();
            }, 1500);
          }
        });
      }
      else
      {
        $('.apply').css('display','none');
        swal("Cancelled");
      }
    });
  $('.apply').css('display','none');
  }
  else
  {
  notyMsg("info","Please a Select Row");
  }
});




/*********** CLEAR search **************************/

 $(".clearsearch").click(function()
  { 

      var grid = $("#grid1");
      grid.jqGrid('setGridParam',{search:false});

      var postData = grid.jqGrid('getGridParam','postData');
      $.extend(postData,{filters:""});
      grid.trigger("reloadGrid",[{page:1}]);
      $('input[id*="gs_"]').val("");
     
  });
  /*End*/




});
  </script>
@endsection

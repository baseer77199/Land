@extends('layouts.header')
@section('content')


 <h2 class="heads">Company</h2>
  <div class="panel panel-visible" id="spy1">

    
<div class="panel-title ">
  <div class="row">
    <div class="col-md-12">
<?php include('toolbar.php'); ?>
<!--<a> <button type="button" class="btn add create" >Create</button></a>
<a href="companyform/0"> <button type="button" class="btn add saveform">Create</button></a>
<a> <button type="button" class="btn add Edit"  id="editdata">Edit</button></a>
<a id="view"><button type="button" class="btn add View" >View</button></a>
<a> <button type="button" class="btn add Delete  del" >Delete</button></a>

<a id="clearsearch"><button type="button" class="btn search clearsearch">Clear Search</button></a>-->
</div>
  </div>
</div>
<div class="row">

<div class="col-md-12">


  <table id="grid1"></table>

</div>
</div>
</div>



<script type="text/javascript">
$( document ).ready(function() {
    var organization_name="{{ $organization_name }}";
      $("#grid1").jqGrid({
      url: "getCompanyData",
      datatype: "json",
      mtype: "GET",

      colModel: [
    { name: "company_id", label: "id" ,hidden:true},
{ name: "company_code", label: "Company Code" ,editable:true, editrules:{date:true}},
{ name: "company_name", label: "Company Name" ,editable:true, editrules:{date:true}},
{ name: "website_address", label: "Company Website" ,editable:true, editrules:{date:true}},
{ name: "gst_no", label: "GST No",editable:true, editrules:{date:true}},
 ],
 iconSet: "fontAwesome",
          rowNum: 10,
              rowList: [10,20,50,100,250,500,1000],
              sortorder: "asc",
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

$("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false,edit:true,add:true,del:true,search:true,cloneToTop:true,refresh:false});
$("#grid1").jqGrid("setLabel", "rn", "S.No");
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
  fileName : "Company.pdf",
  mimetype : "application/pdf"  
});
   });
   $(document).on('click',".exportexcel",function() {
$("#grid1").jqGrid("exportToExcel",{
          includeLabels : true,
              includeGroupHeader : true,
              includeFooter: true,
              fileName : "Company.xlsx"
              
        })  
});

showcolumn('grid1');

 $(".create").click(function()
{
  var url="{{ URL::to('companyform/0')}}";
    window.location.replace(url);
});


 $("#edit").click(function()
{
 
  var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
  var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'company_id');
  if( cellValue )
  {

    window.location.replace('companyform/' +cellValue);
  }
  else
  {
    //alert("hj");
   notyMsg('info',"Please Select a Row");
  }
});


 
  
  

$(document).on('click','.del',function(e){
        e.preventDefault();
        var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
        var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'company_id');
        if(cellValue)
        {
            swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: !0,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No',
            }, function(e) {
                 if(e == true)
                 {
                    $.get('companydelete/'+cellValue, function(data,status)
                    {
                        var data = $.trim(data);
                        if(data =='1')
                        {
                            notyMsg('success','Deleted Successfully');
                            setTimeout(function(){
                            $("#grid1")[0].triggerToolbar();
                            }, 1500);
                        }
                        if(data =='2')
                        {
                            notyMsg('error',"You Cant't delete  Used in SomeWhere");
                            setTimeout(function(){
                            $("#grid1")[0].triggerToolbar();
                            }, 1500);
                        }
                    });
                }
                else{
                  $('.apply').css('display','none');
                  swal("Cancelled");
                }
            })
             $('.apply').css('display','none');
        }
        else
        {
            notyMsg('info',"Please Select a Row");
        }
   });
$('#view').click(function()
{
  var gr=$('#grid1').jqGrid('getGridParam','selrow');
  var cellValue = $("#grid1").jqGrid ('getCell', gr, 'company_id');
  if(cellValue)
  {

     window.location.replace('companyview/' +cellValue);
  }
  else
  {
    notyMsg('info',"Please Select a Row");
  }
});

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


$(window).on('load',function(){
       //preloader
       var preLoder = $("#preloader");
       preLoder.fadeOut(500);
       var backtoTop = $('.back-to-top')
       backtoTop.fadeOut(100);
   });

});
    </script>
@endsection

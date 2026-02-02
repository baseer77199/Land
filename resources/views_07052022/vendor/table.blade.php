@extends('layouts.header')
@section('content')


 <h2 class="heads">Vendor</h2>
  <div class="panel panel-visible" id="spy1">

 <form id="create-user" action="{{URL::to('createvendor')}}" method="POST" style="display: none;">
                                  {{ csrf_field() }}
                                <input type='hidden' name='id' value='0' id='id' class='id'>   
                                    
                                  </form>
                                  
                                  
    <form id="view-user" action="{{URL::to('vendorview')}}" method="POST" style="display: none;">
                                   {{ csrf_field() }}
                                <input type='hidden' name='id' value='' id='id' class='id'>   
                                    
                                  </form>    
    
<div class="panel-title ">
  <div class="row">
    <div class="col-md-12">
	<a href="{{url('vendorupload')}}"><button type="button"  class="btn upload  upload-image" tabindex="5">Upload</button></a>
<?php include('toolbar.php'); ?>

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
      $("#grid1").jqGrid({
      url: "getvendorData",
      datatype: "json",
      mtype: "GET",

      colModel: [
    { name: "vendor_id", label: "id" ,hidden:true},
{ name: "vendor_name", label: "Vendor Name" ,editable:true, editrules:{date:true}},
{ name: "address", label: "Vendor Address" ,editable:true, editrules:{date:true}},
{ name: "contact_no", label: "Contact No" ,editable:true, editrules:{date:true}},
{ name: "email_id", label: "Mail Id" ,editable:true, editrules:{date:true}},

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
  fileName : "Vendor.pdf",
  mimetype : "application/pdf"  
});
   });
   $(document).on('click',".exportexcel",function() {
$("#grid1").jqGrid("exportToExcel",{
          includeLabels : true,
              includeGroupHeader : true,
              includeFooter: true,
              fileName : "Vendor.xlsx"
              
        })  
});

showcolumn('grid1');

//  $(".create").click(function()
// {
//   var url="{{ URL::to('createvendor/0')}}";
//     window.location.replace(url);
// });
$('.create').on('click',function(){
     var id=$('.id').val(0);
document.getElementById('create-user').submit(); 
       
     })

$('.edit').on('click',function(){
var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
  var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'vendor_id');
   var id=$('.id').val(cellValue);
   if(cellValue){ 
document.getElementById('create-user').submit(); 
  
      }else{
          notyMsgs("info","Please Select one row");	 
      }
     })
//  $(".edit").click(function()
// {
 
//   var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
//   var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'vendor_id');
//   if( cellValue )
//   {

//     window.location.replace('editvendor/' +cellValue);
//   }
//   else
//   {
//     //alert("hj");
//   notyMsg('info',"Please Select a Row");
//   }
// });


 
  
  

$(document).on('click','.del',function(e){
        e.preventDefault();
        var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
        var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'vendor_id');
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
               var red_url     ="{{ url('vendor') }}";
                 if(e == true)
                 {
                    $.get('vendordelete/'+cellValue, function(data,status)
                    {
                        var data = $.trim(data);
                        if(data =='0')
                        {
                            notyMsg('success','Deleted Successfully',red_url);
                       
                            setTimeout(function(){
                                 var red_url     ="{{ url('vendor') }}";
                            window.location.href=red_url;

                            }, 100);
                        }
                        if(data =='2')
                        {
                            notyMsg('error',"You Cant't delete  Used in SomeWhere");
                             $('.clearsearch').trigger('click');
                            setTimeout(function(){
                            $("#grid1")[0].triggerToolbar();
                            }, 1500);
                        }
                    });
                }
                else{
                  $('.apply').css('display','none');
                   $('.clearsearch').trigger('click');
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
$('#viewdata').on('click',function(){
  var gr=$('#grid1').jqGrid('getGridParam','selrow');
  var cellValue = $("#grid1").jqGrid ('getCell', gr, 'vendor_id');
        if(gr){     
            var id=$('.id').val(cellValue);
document.getElementById('view-user').submit();   
      }else{
         notyMsgs("info","Please Select one row");	 
      }
     })
// $('#viewdata').click(function()
// {
//   var gr=$('#grid1').jqGrid('getGridParam','selrow');
//   var cellValue = $("#grid1").jqGrid ('getCell', gr, 'vendor_id');
//   if(cellValue)
//   {
//      window.location.replace('vendorview/' +cellValue);
//   }
//   else
//   {
//     notyMsg('info',"Please Select a Row");
//   }
// });

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

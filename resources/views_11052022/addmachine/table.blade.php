@extends('layouts.header')
@section('content')



<div id="accordion">
<div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button">
                                       Machine 
                                    </a>
        </h4>
  </div>
</div>
<form id="create-user" action="{{URL::to('createmachine')}}" method="POST" style="display: none;">
                                    {{ csrf_field()}}
                                <input type='hidden' name='id' value='0' id='id' class='id'>   
                                    
                                  </form>
    <form id="view-user" action="{{URL::to('createmachineview')}}" method="POST" style="display: none;">
                                    {{ csrf_field()}}
                                <input type='hidden' name='id' value='0' id='id' class='id'>   
                                    
                                  </form>   

<div class="panel panel-visible" id="spy1">
<div class="row">
<div class="col-md-12">
<!--<a href="gstcodecreate"> <button type="button" class="btn add saveform">Create</button></a>-->
<?php include('toolbar.php'); ?>
</div>
</div>

<div class="row">
<div class="col-md-12">
<hr class="xlg">
</div>
</div>

<div class="row">
<div class="col-md-12">
<table id="grid"></table>
</div>
</div>

<div class="row">
<div class="col-md-12">
<hr class="xlg">
</div>
</div>

</div>




<script type="text/javascript">
$( document ).ready(function(){

$("#grid").jqGrid({

url: "getmachineData",
datatype: "json",
mtype: "GET",
   colModel: [
  { name: "machine_id", label: "id",hidden:true ,width: 250 },
  { name: "machine_no", label: "Machine Number"  ,width: 250},
  { name: "machine_name", label: "Machine Name" ,width: 250},
  { name: "department_name", label: "Department" ,width: 250},
  { name: "capacity", label: "Capacity" ,width: 250},
  { name: "location", label: "Location" ,width: 250},
  { name: "relocated_date", label: "Relocated Date" ,width: 250},
  { name: "purchased_date", label: "Purchased Date" ,width: 250},
  { name: "machine_make", label: "Machine Make" ,width: 250},
  { name: "cost", label: "Cost" ,width: 250},
  { name: "vendorname", label: "Vendor" ,width: 250},
  { name: "amcvendor", label: "Amc Vendor" ,width: 250},
  { name: "renewal_date", label: "Renewal Date" ,width: 250},
  { name: "from_date", label: "From Date" ,width: 250},
  { name: "to_date", label: "To Date" ,width: 250},
  { name: "remarks", label: "Remarks" ,width: 250},
    { name: "username", label: "Created By" ,width: 250},
    ],
        rowNum:10,
     viewrecords: true,
    footerrow: true,
    sortorder: "desc",
    userDataOnFooter: true, // use the userData parameter of the JSON response to display data on footer
      rownumbers: true ,
      autowidth:true,
    rowList: [10,20,50,100,250,500,1000],
    pager: "#grid",
    searching: {
                defaultSearch: "cn",
                },
      });
     
jQuery("#grid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
  $("#grid").jqGrid("setLabel", "rn", "S.No");  
  showcolumn("grid");
        
 $(document).on('click',".exportpdf",function() {
    $("#grid").jqGrid('exportToPdf', {
            title: null,
            orientation: 'portrait',
            pageSize: 'A4',
            description: null,
            onBeforeExport: null,
            download: 'download',
            includeLabels : true,
            includeGroupHeader : true,
            includeFooter: true,
            fileName : "Machine.pdf",
            mimetype : "application/pdf"  
});
    });


 $(document).on('click',".exportexcel",function() {
   $("#grid").jqGrid("exportToExcel",{
          includeLabels : true,
              includeGroupHeader : true,
              includeFooter: true,
              fileName : "Machine.xlsx"
              
            })     
  });
  
  
  $('.create').on('click',function(){
    
document.getElementById('create-user').submit(); 
       
     })
     
// $(".create").click(function(){ 
//   var url="{{  URL::to('createmachine')}}";
//   window.location.replace(url);
//   });
  
  	$('.edit').on('click',function(){
var gr = jQuery("#grid").jqGrid('getGridParam','selrow');
  var cellValue = jQuery("#grid").jqGrid ('getCell', gr, 'machine_id');
   var id=$('.id').val(cellValue);
   if(gr){ 
document.getElementById('create-user').submit(); 
  
      }else{
          notyMsgs("info","Please Select one row");	 
      }
     })
     
// $(".edit").click(function(){
//   var gr = jQuery("#grid").jqGrid('getGridParam','selrow');
//   var cellValue = jQuery("#grid").jqGrid ('getCell', gr, 'machine_id');
//   if( gr )
//   {
//     var url = "{{ url('createmachine') }}";
//                 var editUrl = url + '/' + cellValue;
//     window.location.replace(editUrl);
//   }
//   else
//   {
//   notyMsg("info","Please Select Row");
//   }
// });

$('#viewdata').on('click',function(){
  var gr = jQuery("#grid").jqGrid('getGridParam','selrow');
  var cellValue = jQuery("#grid").jqGrid ('getCell', gr, 'machine_id');
     var id=$('.id').val(cellValue);
        if(gr){     
document.getElementById('view-user').submit();   
      }else{
         notyMsgs("info","Please Select one row");	 
      }
     })
// $("#viewdata").click(function(){
//   var gr = jQuery("#grid").jqGrid('getGridParam','selrow');
//   var cellValue = jQuery("#grid").jqGrid ('getCell', gr, 'machine_id');
//   if( gr )
  
//   {
//     var url = "{{ url('createmachineview') }}";
//                 var editUrl = url + '/' + cellValue;
//     window.location.replace(editUrl);
//   }
//   else
//   {
//   notyMsg("info","Please Select Row");
//   }
// });

$("#delete").click(function()
{
  var gr = jQuery("#grid").jqGrid('getGridParam','selrow');
  var id = jQuery("#grid").jqGrid ('getCell', gr, 'machine_id');
 // alert(id);
  if( gr ){
    swal({
                title: "Are you sure?",
                text: "You want to delete!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: !1,
                //timer: 2e3,
                closeOnCancel: !1
            }, function(e) {

      if(e == true)
      {
        var url ="{{ url('createmachinedelete') }}/" +id;
        $.get(url,function(data)
        {
          var data = $.trim(data);
          var red_url ="{{ url('addmachine') }}";
          var data = $.trim(data);
          if(data =='0')
          {
            notyMsg('success','Deleted Successfully!!!',red_url);
                                                  $('.clearsearch').trigger('click');
            setTimeout(function(){
            window.location.href=red_url;
            }, 1500);
          }
          if(data =='2')
          {
            notyMsg('error',"You Can't delete , Machine name some ware used!!!",red_url);
                                                 $('.clearsearch').trigger('click');
                                                setTimeout(function(){
                                                  $("#grid")[0].triggerToolbar();
                                                }, 1500);
          }

        });
      }
      else
      {
                            $('.apply').css('display','none');
                             $('.clearsearch').trigger('click');
                            swal("Cancelled");
      }
            })
    $('.apply').css('display','none');
  }
  else
  {
  notyMsg("info","Please Select Row");
  }
});

$('#view').click(function(){
  var gr=$('#grid').jqGrid('getGridParam','selrow');
  var cellValue = $("#grid").jqGrid ('getCell', gr, 'machine_id');
  if(gr){
     var url="gstcodeview";
     var viewurl = url+'/'+cellValue+'/view';
     window.location.replace('gstcodeview/' +cellValue);
  }
  else
  {
  notyMsg("info","Please Select Row");
  }
});

/*Karthigaa purpose:clear search the jqgrid*/
  $(".clearsearch").click(function(){
            var grid = $("#grid");
            grid.jqGrid('setGridParam',{search:false});

            var postData = grid.jqGrid('getGridParam','postData');
            $.extend(postData,{filters:""});
            grid.trigger("reloadGrid",[{page:1}]);
              $('input[id*="gs_"]').val("");
              $('select[id*="gs_"]').select2('val',['']);
    });
/*end*/
  $(window).scroll(function() {
if ($(this).scrollTop() >150){
    $('.header-sticky').addClass("sticky");
  }
  else{
    $('.header-sticky').removeClass("sticky");
  }
});

});
  </script>
@endsection

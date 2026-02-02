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

<form id="create-user" action="{{URL::to('agencycreate')}}" method="POST" style="display: none;">
                                    {{ csrf_field()}}
                                <input type='hidden' name='id' value='0' id='id' class='id'>   
                                    
                                  </form>
                                  
                                  
    <form id="view-user" action="{{URL::to('agencyview')}}" method="POST" style="display: none;">
                                    {{ csrf_field()}}
                                <input type='hidden' name='id' value='0' id='id' class='id'>   
                                    
                                  </form>                              
     
<h2 class="heads">Agency</h2>

<div class="panel panel-visible" id="spy1">

	<div class="row">
	<div class="col-md-12">
	<a href="{{url('agencyupload')}}"><button type="button"  class="btn upload  upload-image" tabindex="5">Upload</button></a>
      <?php include('toolbar.php'); ?>
</div>
</div>
<div class="row">
<div class="col-md-12" >
<table id="grid1"></table>
</div>
</div>
</div>

<script type="text/javascript">
$( document ).ready(function() {
/*deepika purpose: function to load data using jqgrid*/
$("#grid1").jqGrid({
url: "{{URL::to('agencyData')}}",
datatype: "json",
mtype: "GET",
	 colModel: [

	{ name: "agency_id", label: "id",hidden:true },
	{ name: "agency_name", label: "Agency Name"},
	{ name: "address", label: "Address"},
    { name: "email", label: "Email"},	
    { name: "mobile_no", label: "Mobile"}		

		],iconSet: "fontAwesome",
    rowNum: 10,
    rowList: [10,20,100,1000,2000],
    sortname: "agency_id",
    sortorder: "desc",
    viewrecords: true,
    gridview: true,
    rownumbers:true,
    pager: "#grid1",
    multiselect:false,
    multipageselection:true,
    searching: {
        defaultSearch: "cn",
    },
      });
jQuery("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
/*end*/
	/*deepika purpose: function to set label for sno*/
	$("#grid1").jqGrid("setLabel", "rn", "S.No");/*end*/
	/*deepika purpose: function to show hidden columns ref showcolumn in header blade*/	
showcolumn('grid1');
	/*deepika purpose:export excel & pdf*/
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
  fileName : "Agency.pdf",
  mimetype : "application/pdf"  
});
});
 $(document).on('click',".exportexcel",function() {	
	$("#grid1").jqGrid("exportToExcel",{
					includeLabels : true,
    					includeGroupHeader : true,
    					includeFooter: true,
    					fileName : "Agency.xlsx"
    					
				});		
				});		
	/*end*/
	/*deepika purpose: function :redirect to  create new record*/
// $(document).on('click','.create',function()
// {
// var url="{{ URL::to('agencycreate') }}";
// var red_url="{{ URL::to('agency') }}";
// window.location.replace(url);
// });

$('.create').on('click',function(){
    
document.getElementById('create-user').submit(); 
     
     })
   $('.edit').on('click',function(){
       var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
   var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'agency_id');
   var id=$('.id').val(cellValue);
   if(gr){ 
document.getElementById('create-user').submit(); 
  
      }else{
          notyMsgs("info","Please Select one row");	 
      }
     })  
/*end*/
	/*deepika purpose: function :redirect to  update the created record*/
// 	$(".edit").click(function(){
//   var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
//   var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'agency_id');
// //  alert(cellValue);
//   if( gr )
//   {
//     var url = "{{ url('agencycreate') }}";
//                 var editUrl = url + '/' + cellValue;
//               //  alert(editUrl);
//     window.location.replace(editUrl);
//   }
//   else
//   {
//   notyMsg("info","Please Select Row");
//   }
// });
$(document).on('click','.del',function(e){
        e.preventDefault();
        var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
        var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'agency_id');
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
               var red_url     ="{{ url('agency') }}";
                 if(e == true)
                 {
                    $.get('agencydelete/'+cellValue, function(data,status)
                    {
                        var data = $.trim(data);
                      //  alert(data);
                        if(data =='0')
                        {
                            notyMsg('success','Deleted Successfully',red_url);
                       
                            setTimeout(function(){
                                 var red_url     ="{{ url('agency') }}";
                            window.location.href=red_url;

                            }, 100);
                        }
                        if(data =='1')
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

//Ajith purpose : function  clearsearch in grid  
 $(".clearsearch").click(function(){
            var grid = $("#grid1");
            grid.jqGrid('setGridParam',{search:false});

            var postData = grid.jqGrid('getGridParam','postData');
            $.extend(postData,{filters:""});

            grid.trigger("reloadGrid",[{page:1}]);
              $('input[id*="gs_"]').val("");
              $('select[id*="gs_"]').select2('val',['']);
    });
 /*end*/
	/*Ajith purpose: function :redirect to show the created records*/
$('#viewdata').click(function()
{
  var gr=$('#grid1').jqGrid('getGridParam','selrow');
  var cellValue = $("#grid1").jqGrid ('getCell', gr, 'agency_id');
  if(gr)
  {
     var url="{{URL::to('agencyview')}}/"+cellValue;
     window.location.replace(url);
  }
  else
  {
     notyMsg("info","Please Select Row");
  }
});
 /*end*/

$('#viewdata').on('click',function(){
    var gr=$('#grid1').jqGrid('getGridParam','selrow');
  var cellValue = $("#grid1").jqGrid ('getCell', gr, 'agency_id');
     var id=$('.id').val(cellValue);
        if(gr){     
document.getElementById('view-user').submit();   
      }else{
         notyMsgs("info","Please Select one row");	 
      }
     })

});
  </script>
@endsection

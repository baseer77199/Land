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
<h2 class="heads">Machine Files</h2>

<div class="panel panel-visible" id="spy1">
<form id="create-user" action="{{URL::to('machinefilescreate')}}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                <input type='hidden' name='id' value='0' id='id' class='id'>   
                                    
                                  </form>
                                  
                                  
    <!--<form id="view-user" action="{{URL::to('userviews')}}" method="POST" style="display: none;">-->
    <!--                               {{ csrf_field() }}-->
    <!--                            <input type='hidden' name='id' value='' id='id' class='id'>   -->
                                    
    <!--                              </form>                              -->
	<div class="row">
	<div class="col-md-12">
	 <?php include('toolbar.php'); ?>

     <a class="btn download_attach" id="download_attach" download style="display:none">Download</a>
                <a><button type="button" class="btn download" id="download" value="">Download</button></a>
                <input type="hidden" name="file_path" id="file_path" class="file_path" >
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
url: "{{URL::to('machinefilesData')}}",
datatype: "json",
mtype: "GET",
	 colModel: [

  { name: "machine_file_id", label: "machine_file_id",hidden:true },
	{ name: "machine_id", label: "id",hidden:true },
	{ name: "department_name", label: "Department Name"},
	{ name: "machine_name", label: "Machine Name"},
	{ name: "machine_no", label: "Machine No"},
    {name:'upload_file',label: "Uploaded File"}
    
 		],
       rowNum:10,
		viewrecords: true,
		footerrow: true,
	    sortorder: "desc",
		userDataOnFooter: true, // use the userData parameter of the JSON response to display data on footer
		width: 780,
		height: 300,
	    rownumbers: true ,
		rowList: [10, 20, 50, 100,250,500,1000,2000],
		pager: "#grid1",
                searching:{defaultSearch:"cn" ,},
        
       
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
  fileName : "Machinefiles.pdf",
  mimetype : "application/pdf"  
});
});
 $(document).on('click',".exportexcel",function() {	
	$("#grid1").jqGrid("exportToExcel",{
					includeLabels : true,
    					includeGroupHeader : true,
    					includeFooter: true,
    					fileName : "Machinefiles.xlsx"
    					
				});		
				});		
	/*end*/
	/*deepika purpose: function :redirect to  create new record*/
// $(document).on('click','.create',function()
// {
// var url="{{ URL::to('machinefilescreate') }}";
// var red_url="{{ URL::to('machinefiles') }}";
// window.location.replace(url);
// });
/*end*/
$('.create').on('click',function(){
    
document.getElementById('create-user').submit(); 
       
     })
    $('.edit').on('click',function(){
	 var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
   var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'machine_file_id');
   if(gr){ 
          var id=$('.id').val(cellValue);
document.getElementById('create-user').submit(); 
  
      }else{
          notyMsgs("info","Please Select one row");	 
      }
     })
     
// 	/*deepika purpose: function :redirect to  update the created record*/
// $(".edit").click(function(){
//   var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
//   var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'machine_file_id');
//   if( gr )
//   {
//     var url = "{{ url('machinefilescreate') }}";
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
        var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'machine_id');
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
               var red_url     ="{{ url('machinefiles') }}";
                 if(e == true)
                 {
                      $.get('machinefilesdelete/'+cellValue, function(data,status)
                    {
                        var data = $.trim(data);
                        if(data =='0')
                        {
                            notyMsg('success','Deleted Successfully',red_url);
                       
                            setTimeout(function(){
                                 var red_url     ="{{ url('filemachine') }}";
                            window.location.href=red_url;

                            }, 100);
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


$('#download').click(function(){
    
    var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
    var attachfile_name = jQuery("#grid1").jqGrid ('getCell', gr, 'upload_file');
      var file_path = "{{url('/upload/machinefile')}}/"+attachfile_name;
      if(file_path==''){
          notyMsg("info","No File to Download");
      }else{
          $('#download_attach').attr("href", file_path);
          $('#download_attach')[0].click();
      }
  });

});
  </script>
@endsection

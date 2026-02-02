@extends('layouts.header')
@section('content')




<div id="accordion">
<div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button">
                                       Machine List
                                    </a>
        </h4>
  </div>
</div>
 <form id="create-user" action="{{URL::to('createmachine')}}" method="POST" style="display: none;">
                                    {{ csrf_field()}}
                                <input type='hidden' name='id' value='' id='id' class='id'>   
                                    
                                  </form>
                                  
                                  
    <form id="view-user" action="{{URL::to('createmachineview')}}" method="POST" style="display: none;">
                                    {{ csrf_field()}}
                                <input type='hidden' name='id' value='' id='id' class='id'>   
                                    
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

<!-- <script type="text/javascript" src="http://trirand.com/blog/jqgrid/js/jquery.jqGrid.js"></script> -->

<!--<script src="http://www.guriddo.net/demo/js/trirand/i18n/grid.locale-en.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.14.1/plugins/min/ui.multiselect.js"></script>-->
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jqgrid/4.6.0/js/i18n/grid.locale-en.js"></script>-->
<!--<script src="http://www.guriddo.net/demo/js/trirand/src/jquery.jqGrid.js"></script>-->

<script type="text/javascript">
$( document ).ready(function() {



  $("#grid").jqGrid({
url: "getmachineData",
datatype: "json",
mtype: "GET",
   colModel: [
  { name: "machine_id", label: "id",hidden:true },
 { name: "files", label: "Product Image",formatter:formatImage},
   { name: "department_name", label: "Department Name"},

  { name: "machine_name", label: "Machine Name"},
    { name: "asset_code", label: "Asset Code" },
    { name: "machine_no", label: "Machine Number" },

  { name: "capacity", label: "Machine Capacity"},
  //{ name: "purchased_date", label: "Purchased Date"},
     ],
        rowNum:10,
     viewrecords: true,
    footerrow: true,
    userDataOnFooter: true, // use the userData parameter of the JSON response to display data on footer
      rownumbers: true ,
      autowidth:true,
    rowList: [10,20,50,100,250,500,1000],
    pager: "#grid"
      });


jQuery("#grid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
  $("#grid").jqGrid("setLabel", "rn", "S.No");
  $("#gs_purchased_date").attr("placeholder","Eg:2018-10-31");  

        
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

function formatImage(cellValue, options, rowObject) {

	       cellValue=cellValue.replace("[",'');
	       cellValue=cellValue.replace("]",'');
	       cellValue=cellValue.replace('"','');
	       cellValue=cellValue.replace('"','');
         
   var url = "{{URL::to('/upload/machineupload')}}/"+cellValue;
            var imageHtml = "<img width='110' height='70' src="+url + " originalValue='" + cellValue + "' />";
          console.log(url);
            return imageHtml;

        }


	$("#exportexcel").on("click", function(){
   $("#grid").jqGrid("exportToExcel",{
          includeLabels : true,
              includeGroupHeader : true,
              includeFooter: true,
              fileName : "Machine.xlsx"
            })     
  });
  

 function readURL(input) {

      if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#myImg').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
      }
    }

$("#files").change(function() {
        readURL(this);
      });
  
$(".create").click(function(){ 
  var url="{{  URL::to('createmachine')}}";
  window.location.replace(url);
  });




  
$(".edit").click(function(){
  var gr = jQuery("#grid").jqGrid('getGridParam','selrow');
  var cellValue = jQuery("#grid").jqGrid ('getCell', gr, 'machine_id');
  if( gr )
  {
    var url = "{{ url('createmachine') }}";
                var editUrl = url + '/' + cellValue;
    window.location.replace(editUrl);
  }
  else
  {
  notyMsg("info","Please Select Row");
  }
});
$('.edit').on('click',function(){
	       var gr = jQuery("#grid").jqGrid('getGridParam','selrow');
  var cellValue = jQuery("#grid").jqGrid ('getCell', gr, 'machine_id');
   if(gr){ 
       var id=$('.id').val(cellValue);
document.getElementById('create-user').submit(); 
  
      }else{
          notyMsgs("info","Please Select one row");	 
      }
     })
$('.create').on('click',function(){
    
document.getElementById('create-user').submit(); 
       
     })
showcolumn('grid');

$("#delete").click(function()
{
  var gr = jQuery("#grid").jqGrid('getGridParam','selrow');
  var id = jQuery("#grid").jqGrid ('getCell', gr, 'machine_id');
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
        var url ="{{ url('gstcodedelete') }}/" +id;
        $.get(url,function(data)
        {
          var data = $.trim(data);
          var red_url ="{{ url('gstcode') }}";
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
            notyMsg('error',"You Can't delete , GST Code Used in SomeWhere!!!",red_url);
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
$('#viewdata').on('click',function(){
  var gr=$('#grid').jqGrid('getGridParam','selrow');
  var cellValue = $("#grid").jqGrid ('getCell', gr, 'machine_id');
        if(gr){     
            var id=$('.id').val(cellValue);
document.getElementById('view-user').submit();   
      }else{
         notyMsgs("info","Please Select one row");	 
      }
     })

// $('#viewdata').click(function(){
//   var gr=$('#grid').jqGrid('getGridParam','selrow');
//   var cellValue = $("#grid").jqGrid ('getCell', gr, 'machine_id');
//   if(gr){
//      var url="createmachineview";
//      var viewurl = url+'/'+cellValue;
//      window.location.replace(viewurl);
//   }
//   else
//   {
//   notyMsg("info","Please Select Row");
//   }
// });


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

@extends('layouts.header')
@section('content')
<style type="text/css">
/*styles for jqgrid pagination*/
    .ui-jqgrid .ui-pg-table td {
    font-weight: normal;
    vertical-align: middle;
    padding: 6px;
}
</style>
<div id="accordion">
<div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button">
                                        
                                        User Access
                                    </a>
                                </h4>
                            </div>

</div>
<!-- <h2 class="heads">User Access</h2> -->
<form id="create-user" action="{{URL::to('useraccessedit')}}" method="POST" style="display: none;">
                                   {{ csrf_field() }}
                                <input type='hidden' name='id' value='' id='id' class='id'>   
                                    
                                  </form>
        <div class="card">

            <div class="card-body card-block">
               
                   <div class="row">
                      <div class="col-md-12">

                        <div class="panel-title">

                        <!--    <a id="create">
                                <button type="button" class="btn add saveform">Create</button>
                            </a> -->
                            <a>
                                <button type="button" class="btn edit Edit">Edit</button>
                            </a>

                            <a id="clearsearch">
                                <button type="button" class="btn clearsearch">Clear Search</button>
                            </a>
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

        </div>



<script type="text/javascript">
$( document ).ready(function() {

var data="{{$data}}";
            var result = jQuery.parseJSON(data.replace(/&quot;/g, '"' ));
            $("#grid1").jqGrid({
                        
                colModel: [
                   { name: "id", label: "SNO",hidden:true, width: 100 },
                    { name: "username", label: "User Name", width: 250,editable:true, editrules:{date:true}},
                    { name: "email", label: "Email", width: 250,editable:true, editrules:{date:true}},
                   
                ],
				datatype:'local',
                data:result,
                iconSet: "fontAwesome",
                rownumbers: true,
                sortname: "user_name ",
                sortorder: "asc",
                threeStateSort: true,
                sortIconsBeforeText: true,
                headertitles: true,
                
                pager: '#grid1',
                rowNum: 10,
                viewrecords: true,
                searching: {
                    defaultSearch: "cn"
                }
            });
        jQuery("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
        $("#grid1").jqGrid("setLabel", "rn", "S.No");

/* Edit Function*/
$("#create").click(function(){
    
var url="{{ url('createuseraccess') }}";

window.location.replace(url);

});


$('.edit').on('click',function(){
    
    var index = $("#grid1").jqGrid('getGridParam','selrow');
  var pohdrid = $("#grid1").jqGrid ('getCell', index, 'id');
       if( index){
           
   var id=$('.id').val(pohdrid);
    
document.getElementById('create-user').submit(); 
  
      }else{
          notyMsgs("info","Please Select one row");	 
      }
     })



// $(".edit").click(function(){

//       var index = $("#grid1").jqGrid('getGridParam','selrow');
//   var pohdrid = $("#grid1").jqGrid ('getCell', index, 'id');
//       if( index){
//         window.location.replace('useraccessedit/' +pohdrid);
//     }
//     else
//     {
//          notyMsg("info","Please Select a Row");
//     }
     
// });

    /*View Function*/
   
  

/*****  CLEAR search ********/
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
});
    </script>
@endsection

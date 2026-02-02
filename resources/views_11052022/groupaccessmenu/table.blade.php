@extends('layouts.header')
@section('content')
   
     
<div id="accordion">
<div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button">
                                      
                                        Group Menu Access
                                    </a>
                                </h4>
                            </div>

</div>

     <form id="create-user" action="{{URL::to('groupaccessedit')}}" method="POST" style="display: none;">
                                    {{ csrf_field()}}
                                <input type='hidden' name='id' value='' id='id' class='id'>   
                                    
                                  </form>
                                  

        <!-- <h2 class="heads">Group Menu Access</h2> -->
        <div class="card">

           

            <div class="card-body card-block">
                
                   <div class="row">
                    <div class="col-md-12">
                        
                            <!--<a> <button type="button" class="btn add create" >Create</button></a>-->
                          <!--  <a id="create">
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
                   { name: "menus", label: "Menus",hidden:true, width: 100 },
                    { name: "group_name", label: "Group Name", width: 250,editable:true, editrules:{date:true}},
                ],
				datatype:'local',
                data:result,
                iconSet: "fontAwesome",
                rownumbers: true,
				loadonce:true,
                sortname: "group_name",
                sortorder: "asc",
                threeStateSort: true,
                sortIconsBeforeText: true,
                headertitles: true,
                pager: "#grid1",
                rowNum: 10,
                viewrecords: true,
                searching: {
                    defaultSearch: "cn"
                }
            });
        jQuery("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
        

/* Edit Function*/
$("#create").click(function(){
	
var url="{{ url('creategroupaccess') }}";

window.location.replace(url);

});





$(".edit").click(function(){

      var index = $("#grid1").jqGrid('getGridParam','selrow');
  var pohdrid = $("#grid1").jqGrid ('getCell', index, 'menus');
  var id=$('.id').val(pohdrid);
   if(index){ 
document.getElementById('create-user').submit(); 
  
      }else{
          notyMsgs("info","Please Select one row");	 
      }
});

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

@extends('layouts.header')
@section('content')
<style type="text/css">

</style>

<span class="ui_close_btn"></span>

<h2 class="heads">COMPANY DOCUMENT</h2>

<div class="card">


                <div class="card-body card-block">
                  <form  action=""  id="save" >
                    <input type="hidden" name="edit_id" value="" id="edit_id" />
                    {{ csrf_field()}}
                  <div class="row">  
                <div class=" col-md-6">

                    <div class="form-group row">
                        <label for="inputIsValid" class="form-control-label col-md-5"><span style="color:red;" >*</span>Document Name</label>
                            <div class="col-md-7">
                                <input type="text" id="document" name="document" class="form-control document" value="" required>
                                <span class="btn btn-danger dup_name" style="display:none;"></span>
                            </div>
                    </div>
                </div>
                     <div class="col-md-6">
                        <div class="form-group" >
                            <label for="inputIsValid" class="form-control-label col-md-5">Active</label>
                            <div class="col-md-7">
                                <select name='active' id="active" rows='5' class='select2 form-control'  >
                                    <option value="Yes" >Yes</option>
                                    <option value="No" >No</option>
                                </select>
                            </div>
                        </div>
                        </div>
                
                        <div class="col-md-12 text-center">
                            <?php include('toolbar.php'); ?>
                        </div>
              </div>
							
            </form>
                    
                    <div class="row">
                        <div class="col-md-12">
                        <table id="grid1"></table>
                        </div>
                        </div>
        </div>





</div>


	<script>
	$(document).ready(function(){


//** company document grid load function  start***/
           
            $("#grid1").jqGrid({
				
			url: "companydocumentgrid",
			datatype: "json",
			mtype: "GET",
                colModel: [
                    { name: "id", label: "id", width: 100,hidden:true},
                    { name: "document", label: "Document", width: 250,editable:true, editrules:{date:true}},
                    { name: "active", label: "Active", width: 250,editable:true, editrules:{date:true}}

                ],
                
                iconSet: "fontAwesome",
                rownumbers: true,
                sortname: "id",
                sortorder: "desc",
                rowList: [10, 50, 100,250,500,1000],
                threeStateSort: true,
                sortIconsBeforeText: true,
                headertitles: true,
                pager: "#grid1",
                rowNum: 10,
                viewrecords: true,
                searching: {
                    defaultSearch: "cn",
                    


                }
            });
        jQuery("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
$("#grid1").jqGrid("setLabel", "rn", "S.No");
      showcolumn('grid1');


//** company document grid load function  end***/
/**** edit function start **/
            $("#editdata").click(function()
            {
                var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
                var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'id');
                var document = jQuery("#grid1").jqGrid ('getCell', gr, 'document');
                var active = jQuery("#grid1").jqGrid ('getCell', gr, 'active');

                if(gr)
                {
                        $('#document').val(document);
                        $('#active').select2('val',[active]);
                        $('#edit_id').val(cellValue);

                }
                else
                {
                	notyMsgs('Info',"Please Select a Row");
                }
            });
/**** edit function end **/
          /** clear function start **/
            $('.reset').click(function(){
                var form=$("#save");
   form.parsley().destroy();
                $('#document').val('');
                $('#edit_id').val('');
                $('.dup_name').hide();
				   $('#active').select2('val',['Yes']);
                                      $("#grid1")[0].triggerToolbar();
            });
               /** clear function end **/
                     /** export to excel  function start **/
             $(document).on('click',".exportexcel",function() {
                        $("#grid1").jqGrid("exportToExcel",{
                                includeLabels : true,
                                includeGroupHeader : true,
                                includeFooter: true,
                                fileName : "Company Document.xlsx"
                        })	
	
                });
                   /** export to excel  function end **/
                          /** export to pdf  function start **/
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
                                      fileName : "Company Document.pdf",
                                      mimetype : "application/pdf"   
                            });
                    });
       /** export to pdf  function end **/
             /** clear search in grid  function start **/
	$(".clearsearch").click(function()
	{	

	    var grid = $("#grid1");
	    grid.jqGrid('setGridParam',{search:false});

	    var postData = grid.jqGrid('getGridParam','postData');
	    $.extend(postData,{filters:""});
	    grid.trigger("reloadGrid",[{page:1}]);
	    $('input[id*="gs_"]').val("");
	   
	});
           /** clear search in grid  function end **/
                    /** duplicate of document name  function start **/
            var dup_chk = true;
            function duplicate_validate()
            {
                var cmp_document = $(".document").val();
                var edit_id = $("#edit_id").val();

                $.ajax({
                    cache: false,
                    url: 'companydocument/checkname', //this is your uri
                    type: 'GET',
                    dataType: 'json',
                    async : false,
                    data: {cmp_document : cmp_document,edit_id : edit_id},
                    success: function(response)
                    {
                        if(response == 1)
                        {
                            $('.dup_name').html('Document Name:'+cmp_document+' Already Exists');
                            $('.dup_name').show();
                            $(".document").val('');
                            dup_chk = false;

                        }
                        else if(response == 0)
                        {
                            var html ="";
                                $('.dup_name').hide();
                            dup_chk = true;

                        }

                    },
                    error: function(xhr, resp, text)
                    {
                        console.log(xhr, resp, text);
                    }
                });
            }
  /** duplicate of document name  function end **/

  /** company document form save  function start **/
            $(document).on('click','.save',function(){

                
                var data;
				var form = $('#save');
				form.parsley().validate();
				var form = $('#save');
				form.parsley().validate();
                data = $("#save").serialize();
                duplicate_validate();
                if(form.parsley().isValid() && dup_chk)
                {
                $.post('companydocument/save', data, function(data)
                {
                    if(data == 1){
                        notyMsgs('success',"Company Document Saved Successfully");
                        $("#grid1")[0].triggerToolbar();
						$('.reset').trigger('click');
                    }
                    else if(data == 2)
                    {
                        notyMsgs('success',"Company Document Updated Successfully");
                        $("#grid1")[0].triggerToolbar();
						$('.reset').trigger('click');
                    }
                });
                }

            });


  /** company document form save  function end **/
  /** company document form delete  function start **/
            $(document).on('click','.delete',function(e){
                e.preventDefault();
                var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
                var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'id');
                if(gr)
                {
          swal({
            title: "Are you sure?",
            text: "You want to delete!",
            type: "warning",
            showCancelButton: !0,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnCancel:!1
          }, function(e) {
          if(e == true)
            {
                    $.get('companydocument/delete?del_id='+cellValue, function(data,status)
                    {

                        if(data == 1)
                        {
                            notyMsgs('Warning','Deletion Error Already Used In Somewhere');
                            $("#grid1")[0].triggerToolbar();
                        }
                        else if(data == 2)
                        {
                             notyMsgs('Success','Deleted Successfully');
                            $("#grid1")[0].triggerToolbar();
                        }
                    });
                }
                else
      {
		       $("#grid1")[0].triggerToolbar();
        $('.apply').css('display','none');
        swal("Cancelled");
      }
    });
  $('.apply').css('display','none');
  }
                else
                {
                 	notyMsgs('Info',"Please Select a Row");
                }


            });

	});
  /** company document form delete  function end **/
    /************  company document keyup hide duplicate div start ***********/

$(document).on('keyup','.document',function(){
             $('.dup_name').hide();
});
  /************  company document keyup hide duplicate div end ***********/
$(".edit").click(function(){
var form=$("#save");
   form.parsley().destroy();

 });
 


	</script>
@include('layouts.php_js_validation')
@endsection

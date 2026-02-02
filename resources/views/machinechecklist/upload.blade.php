@extends('layouts.header')
@section('content')
<style>
    input[type="file"] {
    display: none;
}
.custom-file-upload 
{
    border: 1px solid #ccc;
    display: inline-block;
    padding: 6px 12px;
    cursor: pointer;
}
.btnic 
{
    text-align: center;
    background-color: DodgerBlue;
    border: none;
    color: white;
    padding: 12px 30px;
    cursor: pointer;
    font-size: 12px;
}
.general_label
	{
		font-size: 20px;
		padding: 10px 0;
		font-weight: 500;
	}
</style>


<span class="ui_close_btn"></span>


<h2 class="heads">PM Machine Checklist Upload</h2>

            <div class="card">
                    

                            <div class="card-body card-block">
                              
                                
                               <div class=" col-md-6">
								   <label class="general_label">File Upload</label>
                               


                          <div class="ajaxLoading"></div>
 
                            <form id="file_up" method='POST'>
                                {{ csrf_field()}}
                              
				<div class="form-group col-md-12">			
                                                <label for="inputIsValid" class="form-control-label col-md-2">Choose File:</label>
                                                <div class="col-md-5"> 
                                                <label for="file-upload" class="custom-file-upload file_choose">
                                                     <i class="fa fa-cloud-upload "></i>&nbsp;File Upload
                                                </label>

                                                <input type="file" id="file_upload" name="file_upload" class="form-control file_upload" value="" required><span class="b_name"></span>
                                                </div>
                                            </div>
                                              
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button type="button" id="upload" class="btn upload  upload-image">&nbsp;Upload</button> &nbsp;&nbsp;&nbsp;
                                                  
                                                  
                                                </div>  
                                        </div>

                                
                            </form>
                              <form id="file_up_download" method="POST" action="{{URL::to('download_templetechecklist')}}">
                                     {{ csrf_field()}}
                                     <div class="row">
                                                <div class="col-md-12">
                                                    <input  type='submit' class="lst btn download" value="Download Template">
                                                  
                                                </div>  
                                        </div>
                                        
                                  </form>
                            
                          </div>

                        <div class="row">
                            <div class="col-md-12 " style="padding: 15px;" >
                                <div class="img_location" >
       <img src="{{asset('/images/Clear.png')}}" class="clear" height="30px;" width="30px" align="right">
         </div>

                                <table id="grid1"></table>
                            </div>
                        </div>
                    </div>
            </div>
   
	<script>
	$(document).ready(function(){
            // file choose
		$(document).on('change','.file_upload',function(){              
                var file = $(this).val();
                var file_name = $('.file_upload')[0].files[0].name;
                $('.b_name').html(file_name);
//              
            });
      /** atenndance import grid load **/
        $("#grid1").jqGrid(
            {
                url: "checklistgrid",
                datatype: "json",
                mtype: "GET",
                colModel: [
                    { name: "checklist_id", label: "checklist_id", width: 250, hidden: true },
                    { name: "checklist_name", label: "Checklist Name", width: 250,editable: true},
                                     
                    { name: "terms", label: "Terms and Condition", width: 250,editable:true},
                    { name: "file", label: "File", width: 250,hidden:true},
                    
                ],

                iconSet: "fontAwesome",
                rowNum: 10,
                rowList: [10,20,100,1000,2000],
                sortname: "checklist_id",
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
/** file choose **/
            $(document).on('click','.file_choose',function(e)
            {
                $("#file_upload").trigger( "click" );
            });
        
   

  $(".clear").click(function()
    {   
        var grid = $("#grid1");
        grid.jqGrid('setGridParam',{search:false});

        var postData = grid.jqGrid('getGridParam','postData');
        $.extend(postData,{filters:""});
       location.reload();
        $('input[id*="gs_"]').val("");
       
    });

    
		/*** upload function **/

            $(document).on('click','#upload',function()
            {
         
                var file_upload = $('#file_upload').val();

                if(file_upload != '')
                {
                    
                           $('.ajaxLoading').show();
                    var form_data = new FormData(document.getElementById('file_up'));
                    $.ajax({
                          url: "{{URL::to('checklistuploadsave')}}",
                          type: "POST",
                          data: form_data,
                          enctype: 'multipart/form-data',
                          processData: false,  // tell jQuery not to process the data
                          contentType: false,   // tell jQuery not to set contentType
                          async:true,
                          xhr: function(){
                              var xhr = $.ajaxSettings.xhr();
                            if (xhr.upload) 
                            {
                                xhr.upload.addEventListener('progress', function(event){
                                }, true);
                            }
                            return xhr;
                    }
                    }).done(function(data,status)
                        {
                            $('.ajaxLoading').hide();
                            if(data == 1)
                            {
                                
                                notyMsgs('success','Details Uploaded  Successfully');
                                setTimeout(function(){
                                location.reload();
                                }, 2000);
                            }
                            else if(data == 2)
                            {
                                notyMsgs('info','Not a Valid File Extension');
                                setTimeout(function(){
                                location.reload();
                                }, 2000);
                            }
                            else
                            {
                                $(".alert-success").hide();
                                $(".alert-danger").fadeIn(800);

                            }
                        }).fail(function(data,status)
                        {

                                $(".alert-success").hide();
                                $(".alert-danger").fadeIn(800);

                        });

                }
                else
                {
                     notyMsgs('warning','<i class="fa fa-warning"></i> Choose a File');
                }
            });        

	});
	</script>

@endsection

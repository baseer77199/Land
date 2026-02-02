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
.panel, .card {
    margin-bottom: 240px;
}
</style>

    <div class="ajaxLoading"></div>
<span class="ui_close_btn"></span>


<h2 class="heads">Checklist Upload</h2>

            <div class="card">
                    

                            <div class="card-body card-block">
                              <div class="row">
                                
                               <div class=" col-md-6">
                                

                            <form id="file_up">
                        
                                <input type="hidden" name="edit_id" value="" id="edit_id" />
                                {{ csrf_field()}}

                                
                                     
                                        <div class="form-group row">
                                          
                                            <label for="inputIsValid" class="form-control-label col-md-2">File:</label>
                                            <div class="col-md-5"> 
                                            <label for="file-upload" class="custom-file-upload file_choose">
                                                 File Upload
                                            </label>

                                            <input type="file" id="file_upload" name="file_upload" class="form-control file_upload" value="" required>
                                            <span class="b_name"></span>
                                            </div>
                                              </div>
                                              
                                            <!-- <div class="row"> -->
                                              <div class="col-md-offset-2 col-md-10" style="margin-left: 15.666667%;">
                                          <button type="button" id="upload" class="btn upload  upload-image">Upload</button>
                                          <!--<a href="{{url('/download/machinechecklist.csv')}}"  class="lst btn download" download>Download Template</a>-->
                                       
                                          </div>  
                                       <!--  </div> -->
                            </form>
                             <form id="file_up_download"  method="POST" action="{{URL::to('download_templetemachine')}}">
                                 {{ csrf_field()}}
                                   <input  type='submit' class="lst btn download" value="Download Template">
                                                  
                            </form>
                          </div>

                            <div class=" col-md-6">
                                
                                    <form id="validate_form" action="" >
                                        {{ csrf_field()}}
                                    <div class="form-group col-md-12">

                                        <label for="inputIsValid" class="form-control-label col-md-4">Batch Number:</label>
                                        <div class="col-md-6">
                                            <select id="batch_number" name="batch_number" class="select2 form-control batch_number" required="">
                                                {!!$batch_no!!}
                                            </select>
                                        </div>
                                            </div>
                                            
                                              <div class="col-md-offset-3 col-md-9" style="margin-left:32.4%;">
                                                <button type="button"  class="btn  verify validate validate_btn" >Validate</button>
                                                <button type="button"  class="btn  vie load loadd load_btn" >Load</button>
                                              </div>
                                            
                                    
                                    </form>
                                


                            </div>

                            
                                    

                                            
                                              <div class="row">
                                                  <div class=" col-md-12">
                                            <!-- <a id="editdata"  class="btn sec"> Edit</a> -->
                                            <button type='button'  class='btn delete'>Delete</button>
                                          </div>
                                        </div>
                                      
                                    
                                
                        <div class="row">
                        <div class="col-md-12">
                        <table id="grid1"></table>
                        </div>
                        </div>
                      
                    </div>
                    </div>
            </div>
  
	<script>
	<?php //dd('hh');?>
	$(document).ready(function(){

            // file choose
		$(document).on('change','.file_upload',function(){              
                var file = $(this).val();
                var file_name = $('.file_upload')[0].files[0].name;
                $('.b_name').html(file_name);
//              
            });
        /**** jqgrid employee upload start*****/
        $("#grid1").jqGrid({
	url: "getmachineuploaddata",
	datatype: "json",
	mtype: "GET",
        colModel: [
            { name: "machine_id", label: "id", width:100,hidden:true },
            { name: "department_id", label: "Department", width: 200,editable:true, editrules:{date:true}},
            { name: "machine_id", label: "Machine", width:200, editable:true, editrules:{date:true}},
            { name: "frequency_id", label: "Frequency", width:200, editable:true, editrules:{date:true}},
            { name: "batch_no", label: "Batch No", width:250, editable:true, editrules:{date:true}},
            { name: "checklist_id", label: "Checklist", width:80, editable:true, editrules:{date:true}},
            { name: "batch_status", label: "Batch Status", width:200,editable:true, editrules:{date:true}},
            { name: "batch_comments", label: "Batch Comments", width:350,editable:true, editrules:{date:true}},
            ],
           iconSet: "fontAwesome",
           rownumbers: true,
           sortname: "machine_id",
           sortorder: "desc",
           threeStateSort: true,
           sortIconsBeforeText: true,
           headertitles: true,
           pager: "#grid1",
           autowidth:true,
           rowNum: 10,
           viewrecords: true,
searching: {
    defaultSearch: "cn"
}
});
jQuery("#grid1").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
$("#grid1").jqGrid("setLabel", "rn", "S.No");
/**** jqgrid employee upload end*****/
/**** file choose start*****/

            $(document).on('click','.file_choose',function(e)
            {
                $("#file_upload").trigger( "click" );
            });
            /**** file choose end*****/
                    /****edit function  start*****/
            $("#editdata").click(function()
            {
                var gr=$('#grid1').jqGrid('getGridParam','selrow');
                var cellValue = $("#grid1").jqGrid ('getCell', gr, 'machine_id');  //alert(cellValue);
 var batch_status = jQuery("#grid1").jqGrid ('getCell', gr, 'batch_status');
                if(cellValue)
                {
                    if(batch_status=="LOADED"){
                          notyMsg("info","Loaded data can't be Edit");
                    }else{
                  
                   window.location.replace('machineuploadedit/' +cellValue);
               }
                }
                else
                {
                   notyMsg("info","Please Select Row");
                    setTimeout(function(){
                    window.location.replace(newUrl);
                  }, 2000);
                }
            });
                    /****edit function  end*****/
                     

		
		/*** verify batch number start **/
		$('.verify').click(function()
                {

		var batchname=$('.batch_number option:selected').val();
		var parm='';
		var verify='verify';
		if(batchname!=''){
                    $('.ajaxLoading').show(); 
                  
			var parm="?batchname="+batchname+'&type=verify';
                        var newUrl = refineUrl();//fetch new url
		var url="{{URL::to('getmachinevalidate')}}";

		$.get(url, {'batchname': encodeURIComponent(batchname), 'type': verify}, function (response) {
			var data=response.status;
			var message=response.message;
			if(data == 'success')
			{

			notyMsg("success",message);
				 setTimeout(function(){
			window.location.replace(newUrl);
			    }, 2000);

			}

			if(data=='info')
			{
				notyMsg("info",message);
				setTimeout(function(){
			window.location.replace(newUrl);
			    }, 2000);

			}
			if(data=='error') {
			notyMsg("error",message);
			 setTimeout(function(){
			window.location.replace(newUrl);
			    }, 2000);
			}
		});
		}
		else
		{
			notyMsg("info","Please select batchnumber");
		}

		
	});
		
		
		//Download Template
		  $(".download").click(function(){
      //  url="{{url('download_templete')}}";
    //    file="{{url('/download/checklist.csv')}}";
           //  $('.ajaxLoading').show();
                    var form_data = new FormData(document.getElementById('file_up'));
                    $.ajax({
                          url: "{{URL::to('download_templetemachine')}}",
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
     });
     
		
		    /*** verify batch number end **/
        /*** load data in employee start **/
		$('.load').click(function(){

		var batchname=$('#batch_number option:selected').val();
		var parm='';
		var load='load';
		if(batchname!=''){
			// alert(batchname);
			var parm="?batchname="+batchname+'&type=load';
                        var url="{{URL::to('getmachinevalidate')}}";

		$.get(url, {'batchname': encodeURIComponent(batchname), 'type': load}, function (response) {
			var data=response.status;
			var message=response.message;
			if(data == 'success')
			{

			notyMsg("success",message);
				 setTimeout(function(){
			window.location.replace(newUrl);
			    }, 2000);

			}

			if(data=='info')
			{
				notyMsg("info",message);
				setTimeout(function(){
			window.location.replace(newUrl);
			    }, 2000);

			}
			if(data=='error') {
			notyMsg("error",message);
			 setTimeout(function(){
			window.location.replace(newUrl);
			    }, 2000);
			}
		});
		}
		else
		{
			notyMsg("info","Please select batchnumber");
		}
				var newUrl = refineUrl();//fetch new url
		

	});
		        /*** load data in employee end **/
function refineUrl()
{
	//get full url
	var url = window.location.href;
	//get url after/
	//var value = url.substring(url.lastIndexOf('/') + 1);
	//get the part after before ?
	var value  = url.split("?")[0];
	// alert(value);
	return value;
}
 /*** load data in employee start **/
            $(document).on('click','.load_btn',function()
            {
                var batch_number = $('.batch_number').select2('val');

                if(batch_number != '')
                {
                        var form_data = new FormData(document.getElementById('validate_form'));
                        $.ajax({
                          url: "{{ url('getmachineload')}}",
                          type: "POST",
                          data: form_data,
                          enctype: 'multipart/form-data',
                          processData: false,  // tell jQuery not to process the data
                          contentType: false,   // tell jQuery not to set contentType
                          async:true,
                          xhr: function(){
                              var xhr = $.ajaxSettings.xhr();
                            if (xhr.upload) {
                                xhr.upload.addEventListener('progress', function(event) {
                                }, true);
                                }
                                return xhr;
                        }
                        }).done(function(data,status)
                        {
                            if(data[1] == 1)
                            {
                                notyMsgs('success','Checklist Details Saved Successfully');
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
                     notyMsgs('info','<i class="fa fa-warning"></i> Select Batch Number');
                }
            });
/*** upload function **/

            $(document).on('click','#upload',function()
            {
     
                var file_upload = $('#file_upload').val();
;
                if(file_upload != '')
                {
                    
                           $('.ajaxLoading').show();
                    var form_data = new FormData(document.getElementById('file_up'));
                    $.ajax({
                          url: "{{URL::to('machineuploadsave')}}",
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
                                
                                notyMsgs('success','Machine Checklist Uploaded  Successfully');
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
                
/** upload end*****/
/** delete funcation start ***/
            $(document).on('click','.delete',function(e){
                e.preventDefault();
                var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
                var cellValue = jQuery("#grid1").jqGrid ('getCell', gr, 'machine_id');
                var batch_status = jQuery("#grid1").jqGrid ('getCell', gr, 'batch_status');
                if(cellValue)
                {
                    if(batch_status=="LOADED"){
                          notyMsg("info","Loaded data can't be Delete");
                    }
                    else{
                    $.get('machineuploaddelete/'+cellValue, function(data,status)
                    {
                        if(data == 0)
                        {
                                notyMsg("success","Deleted successfully");
                            setTimeout(function(){
                                location.reload();
                         
                         },300);
                            
                        }
                        
                    });
                }
            }
                else
                {
                 notyMsg("info","Please Select Row");
                }


            });
/***** delete function end *****/
	});
	</script>

@endsection

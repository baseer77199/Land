@extends('layouts.header')
@section('content')

<style type="text/css">
/*styles for line table to differnt media devices*/

@media  only screen and (min-width: 1500px) {
.bulk_frequency_id {width: 300px !important;}
.bulk_frequency_date {width: 300px !important;}

 }

.bulk_frequency_id {width: 300px;}
.bulk_frequency_date {width: 300px;}

.stickytable-wrap td, .stickytable-wrap th {
    text-align: center;
    padding: 2px 12px;
    box-sizing: border-box;
}
.readonly{
    pointer-events: none;
}
</style>
<div class="ajaxLoading"></div>
<span class="ui_close_btn"></span><h3 class="heads"><a role="button">Attendence Upload</a> <span class="ui_close_btn"><a href="{{ URL::to('addmachine') }}" class="collapse-close pull-right btn-danger" onclick="attendanceupload"></a></span></h3>




<div class="card">

    <?php error_reporting(0); ?>
        <div class="card-body card-block">
        
              <form  action="" id="save">

<input type="hidden" name="edit_id" value="" id="edit_id" />
                {{ csrf_field()}}


     
         <div class="col-md-12"> 
    <div class="row">
  

    <div class="col-md-4">
		   <div class="form-group row">
        <label for="Machine Number" class="form-control-label col-md-4">Employee No</label>
        <div class="col-md-6">
        <input class="form-control employee_id" id="employee_id" name="employee_id" size="16" type="hidden" value="" >

            <input type='text' name="employee_no" id="employee_no" rows='5' class='form-control employee_no'  value=" " tabindex="2" >
        </div>
        <div class="col-md-2">
        </div>
    </div>  
</div>

<div class="col-md-4">
           <div class="form-group row">
        <label for="date" class="form-control-label col-md-4">Date</label>
        <div class="col-md-6">
            <input class='form-control datepicker date' name="date" id="date" rows='5' class='form-control date'  value=" " tabindex="2" >
        </div>
        <div class="col-md-2">
        </div>
    </div>  
</div>


  


<div class="col-md-4">
           <div class="form-group row">
        <label for="checkin" class="form-control-label col-md-4">checkin</label>
        <div class="col-md-6">
            <input type='text' name="checkin" id="checkin" rows='5' class='form-control checkin'  value=" " tabindex="2" >
        </div>
        <div class="col-md-2">
        </div>
    </div>  
</div>
</div>

<div class="row">

<div class="col-md-4">
           <div class="form-group row">
        <label for="checkout" class="form-control-label col-md-4">checkout</label>
        <div class="col-md-6">
            <input type='text' name="checkout" id="checkout" rows='5' class='form-control checkout'  value=" " tabindex="2" >
        </div>
        <div class="col-md-2">
        </div>
    </div>  
</div>

<div class="col-md-4">
           <div class="form-group row">

            <label for="inputIsValid" class="form-control-label col-md-4">File Upload  @php if($row->employee_id!= "") {   $image = $row->choosefile == "" ? "profile_none.jpg" : $row['choosefile'] @endphp
                            <img id="myImg" src="" alt="your choosefile" height="20px" width="10px"><br>      
       @php  } @endphp</label>
            <div class="col-md-8">
                
          
                            <input type="file" name='choosefile' rows='5' class='form-control choosefile' id="choosefile" >
            </div>
            
        </div>
    </div>  


</div>
        <div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group text-center">
            <button type="button" class="btn save saveform" value="SAVE">SAVE</button>
               <!--  <button type="button" class="btn save saveform" value="SAVENEW">SAVE AND NEW</button>                
                <a href="{{ URL::to('addmachine') }}" class='btn cancel'>Cancel</a> -->
                
</div>
        </div>
    </div>
        </div>   

        </form>


 
       <div class="row">
  <div class="col-md-12" style="padding:15px;">
    <table id="attendenceuploadgrid"></table>
  </div>
</div>
        </div>
        </div>


<style type="text/css">

</style>

<script>

$("#attendenceuploadgrid").jqGrid(
            {
                url: "getattenddenceuploadgriddata",
                datatype: "json",
                mtype: "GET",
                colModel: [
                    { name: "employee_id", label: "employee_id", width: 250, hidden: true },
                    { name: "employee_no", label: "Employee No", width: 250,editable: true},
                  
                    { name: "date", label: "Date", width: 250,editable:true},
                    { name: "checkin", label: "Checkin", width: 250,editable:true},
                    { name: "checkout", label: "Checkout", width: 250,editable:true},
                    
                ],

                iconSet: "fontAwesome",
                rowNum: 10,
                rowList: [10,20,100,250,500,1000,2000],
                sortname: "employee_id",
                sortorder: "desc",
                viewrecords: true,
                gridview: true,
                rownumbers:true,
                pager: "#attendenceuploadgrid",
                multiselect:false,
                multipageselection:true,
                searching: {
                defaultSearch: "cn",
                },
            });

jQuery("#attendenceuploadgrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});
  $("#attendenceuploadgrid").jqGrid("setLabel", "rn", "S.No");
   //showcolumn("attendenceuploadgrid");

    $(document).ready(function () {


/**********Up/down/left/right arrow navigation start*******/
    
    
	

         $('#savestatus').val('');

    // $(document).on('click','.saveform',function()
    // {
    //         var btnval      = $(this).val();
    //        alert(btnval);
    //         if(btnval == 'SAVE')
    //             var savestatus = 'SAVE';

    //         $('#savestatus').val(savestatus);

    //         var url     = "{{ URL::to('attendenceuploadsave') }}";
    //         validationrule('attendenceupload');
    //         var formdata    = $('#attendenceupload').serialize();
    //        if(btnval != "APPLYCHANGES")
    //         {

    //            var form = $('#attendenceupload');
    //             form.parsley().validate();

    //             if (form.parsley().isValid())
    //             {
    //                        var a= $("#choosefile").val();

				// 	change_date();
    //                 $('.ajaxLoading').show();

    //               var form_data = new FormData(document.getElementById('attendenceupload'));
    //             $.ajax({
    //               url: "{{URL::to('attendenceuploadsave')}}",
    //               type: "POST",
 //                  data: form_data,
 //                  enctype: 'multipart/form-data',
 //                  processData: false,  // tell jQuery not to process the data
 //                  contentType: false,   // tell jQuery not to set contentType
 //                  async:true,
 //                  xhr: function(){
 //                      var xhr = $.ajaxSettings.xhr();
 //                    if (xhr.upload) {
 //                        xhr.upload.addEventListener('progress', function(event) {
 //                                var percent = 0;
 //                                var position = event.loaded || event.position;
 //                                var total = event.total;
 //                                if (event.lengthComputable) {
 //                                        percent = Math.ceil(position / total * 100);
 //                                }
 //                                        //update progressbar

 //                                }, true);
 //                        }
 //          return xhr;

 //                }
 //                }).done(function(data,status)
	// 	{
		
 // if(data == 1)
  //                   // {
  //                       notyMsgs('info','Uploaded Saved Successfully');

  //                           window.location.href="{{URL::to('attendanceupload')}}";

  //                   } 
  //       else
		// {
		// 	notyMsg(status,msg);
		// 	setTimeout(function(){
		// 			$('.ajaxLoading').hide();
		// 	window.location.href=red_url;
		// 	}, 1500);
		// }
		// });
  //               }
  //     }
  //   });
//   $(document).on('click', '.saveform', function() {
//                 var url = "{{ url('attendenceuploadsave') }}";
//                 var form = $('#save');
//               form.parsley().validate();
//                 if (form.parsley().isValid()) {
//                     change_date();
//                     $.post(url, function(data) {
//                         var data = $.trim(data);
//                         if(data == 1){
//                             notyMsg("success","Saved Successfullly");
//                             $("#attendenceuploadgrid")[0].triggerToolbar();
//                         $( '#save' ).each(function(){
//     this.reset();
// });

//                         }
//                         else{
//                             notyMsg("success","Updated Successfullly");
//                             $("#attendenceuploadgrid")[0].triggerToolbar();
//                           $("#edit_id").val('');
//                             $( '#save' ).each(function(){
//     this.reset();
// });
//                         }
                       
//                     });
//                 }
//             });
            
      

$(document).on('click','.saveform',function() {

           var form=$("#save");
             form.parsley();
             $('input[name=_token]').val("{{csrf_token()}}");
            form.parsley().validate();
              var data = form.serialize();
              duplicate_validate();
       
var url="{{ URL::to('attendenceuploadsave') }}";

if (form.parsley().isValid())
        {

       var formData = $('#save').serialize();
            $.ajax({
          url:     "{{ url('attendenceuploadsave') }}",
          type:     'post',
          data:     formData,
          dataType: 'json',
          success: function (response) {
           if(response == 1){
               notyMsg("success","Saved Successfullly");
                            $("#attendenceuploadgrid")[0].triggerToolbar();
                        $( '#save' ).each(function(){
    this.reset();
});
                        }
                        else{
                         notyMsg("success","Updated Successfullly");
                            $("#attendenceuploadgrid")[0].triggerToolbar();
                           $("#edit_id").val('');
                            $( '#save' ).each(function(){
    this.reset();
});
                        }
           },
         error: function(response) {
             console.log(response);
               var errors = response.responseJSON.errors;
               var errorsHtml = '';
               $.each( errors, function( key, value ) {
                   errorsHtml += '<p>'+ value[0] + '</p>';
               });
    notyMsg("error",errorsHtml);
           }
       });
  
        }   
});
        

/*deepika purpose:remove function*/
     


                changeClassfields();

        /********************* end ****************************/
     
 var data ="{{\Session::get('j_date_format')}}";

  $( ".datepicker1" ).datepicker({
      changeMonth: true,
      dateFormat: data,
      changeYear: true,	  
      maxDate: null,
      onClose: function () {
        $(this).parsley().validate();
        }

    })       
    });


function changeClassfields()
{
        changeClassName('bulk_machine_lines_id');
        changeClassName('bulk_frequency_id');
        changeClassName('bulk_frequency_date');
     }

    function changeClassName(className) {
            $('.' + className).each(function(index) {
                if (className == "bulk_line_no") {
                    $(this).val(index + 1).attr("readonly", 1);
                }

                $(this).removeClass(className + '0');
                $(this).addClass(className + index);
                $('.'+className+index).css('pointer-events','');
            });
        }
   function removeClass1(className)
    {
        var rowCount = $('.contact_table tbody tr').length;
        for (var i = 0; i <= rowCount; i++)
        {
            $('.contact_table tbody tr').find('.' + className).removeClass(className + i);
        }
        $('.' + className).each(function (index)
        {
            $(this).addClass(className + index);
        });

    }
    function changeClassName1(className)
    {
        $('.' + className).each(function (index) {
            $(this).removeClass(className + '0');
            $(this).addClass(className + index);
        });
    }
    function changeclassfields1()
{
    changeClassName1('contact_name');
}
    function removeClass(className)
    {
        var rowCount = $('.suppliersite_table tbody tr').length;
        for (var i = 0; i <= rowCount; i++)
        {
            $('.suppliersite_table tbody tr').find('.' + className).removeClass(className + i);
        }
        $('.' + className).each(function (index)
        {
            $(this).addClass(className + index);
        });

    }
</script>

<style>
    .btn-xs {
        display: inline-block;
        min-width: 10px;
        margin: 2px 5px;
        /*padding: 10px 15px 12px;*/
        padding:5px;
        /*font: 700 12px/1 'Open Sans', sans-serif;*/
        border-radius: 3px;
        /*box-shadow: inset 0 -1px 0 1px rgba(0, 0, 0, 0.1), inset 0 -10px 20px rgba(0, 0, 0, 0.1);*/
        cursor: pointer;
    }
u {
    text-decoration: underline;
   width: 265px;
   margin-top: -66px;
   margin-left: 0px;
   font-weight:700;
}

</style>
@include('layouts.php_js_validation')
@endsection

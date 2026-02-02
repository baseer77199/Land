@extends('layouts.header')
@section('content')
<style>
body {font-family: Arial;}
.previous{display:none;}
</style>

<h2 class="heads">Upload 
    <span class="ui_close_btn">
        <a href="{{url($pageMethod)}}" class="collapse-close pull-right btn-danger" ></a>
    </span>
</h2>

<div class="ajaxLoading"></div>
<div class="card">

<div class="card-body card-block">
<form method="post" action="" id="uploadform" class="uploadform"  enctype="multipart/form-data">
	 {{ csrf_field() }}

<div class="row upload_data">
<div class="col-md-12">
<div class="col-md-5">


<div class="form-group row">
            <label for="assigned_to" class="form-control-label col-md-4"><span style="color: red;" > * </span>Module</label>
            <div class="col-md-4" style="pointer-events:none;">
                <select class="form-control module_name select2" id="module_name" name="module_name"  >
                  {!! $module_name !!}  
                </select>
            </div>
            <div class="col-md-2 showinline dwnld">
				<span class="showspan"> <i class="fa fa-download download1"></i></span><a class="download_csv_n2"></a>
				</div>
           
        </div>
 
     

           
  
  <h4><b>Upload a File:</b></h4></br>
				<input type="file" name="upload_file" class="upload" id="file_upload" required>	
                                
                                <br>
                             <div class="import_option">
                                    <b>Import Option:</b></br>
                                    </br> 
                                    <input type="radio" name="read_option"  value="skip" checked> Skip </br></br>
                                    <input type="radio" name="read_option"  value="overwrite" > Overwrite </br></br>
                                    <input type="radio" name="read_option"  value="clone" class="clone" > Clone 
                                </div>
                            <br> 
     <div class="duplication_div">
                           
                          <b>Find duplicates with:</b></br></br>
                          <div class="col-md-4" >
                            <select multiple id="find_duplicate" name="find_duplicate[]" class="select2 find_duplicate">
                            </select>  
			</div>
			</div>
</div>
<div class="col-md-7">
                        <h4>Supported File Format:</h4>
<ul>
  <li>You can import using <b>.csv</b> file format</li>
</ul> 
<h4>Maximum Limits:</h4>
<ul>
  <li>Maximum <b>1000 rows</b> can be imported.Others will be skipped</li>
</ul>
<h4>Important Notes:</h4>
<ul>
  <li>File size cannot exceed <b>5 MB</b></li>
  <li>All duplicate records will be ignored when importing.</li>
  <li>Checkbox value should be<b> 1</b> or <b>0</b>.</li>
  <li>Dates must be in the format <b>YYYY-MM-DD</b>. Records that use other date formats will be ignored.</li>
  <li>Date Time must be in the format <b>YYYY-MM-DD H:i:s</b>. Records that use other date formats will be ignored.</li>
  <li>By default, the character encoding is UTF-8 (Unicode). Make sure you provide the correct character encoding if your import file has special characters.</li>
  <li>We recommend doing a test import with a sample file before importing your actual data.
</li>
</ul> 
<h4>Find Duplicate:</h4>

<ul>
  <li> <b>Skip</b> -Skips the rows which already exists. Other rows will be inserted.</li>
  <li><b>Overwrite</b> - Overwrite the existing records, if anything exists.</li>
  <li><b>Clone</b> - Create duplicate records, even though already exists.</li>
</ul>                         
                        
  
</div>

</div>


<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <!--<button type="button" name="next" id="next" class="btn btn-primary btn-sm saveform"><i class="fa  fa-save "></i>  Map Fields </button>                              -->
        </div>
        <div class="col-md-6 text-center">
            
            <button type="button"   class="btn btn-info previous tab_change" value="previous"> < Prev</button>
            <button type="button" name="next" id="next" class="btn btn-info next tab_change saveform" value="next"> Next ></button>
        </div>
    </div>
</div>
</div>
<div class='row mapping_data'></div>
<input type='hidden' name='stage' class='stage'>

</form>

</div>

</div>
	<!--Deepika purpose Upload Details model-->
<div class="modal fade" id="uploaddetailsModal" >
  <div class="modal-dialog" style="width:40%">
    <div class="modal-content">
		<!--Moda Header-->
      <div class="modal-header">
		  <h4 class="modal-title"> Upload Details </h4>
		  <button type="button" class="close" data-dismiss="modal">&times;</button>
		 </div>
		<!-- Modal Body -->
	  <div class="modal-body uploaddetail text-center">
	      <table class="center">
	          <tbody>
	              <tr><th>Total Records</th><td>:</td><td width="50%"><span class="totrec"></span></td></tr>
	              <tr><th>Skip</th><td>:</td><td width="50%"><span class="skip"></span></td></tr>
	              <tr><th>Overwrite</th><td>:</td><td width="50%"><span class="overwr"></span></td></tr>
	              <tr><th>Clone</th><td>:</td><td width="50%"><span class="cln"></span></td></tr>
	              <tr><th>New</th><td>:</td><td width="50%"><span class="newdata"></span></td></tr>
	          </tbody>
	      </table>
	  </div>
		<div style="text-align:center;"> 	<span class="showspan"> <i class="fa fa-download download1"></i><a download href="{{asset('uploads/upload_log.csv')}}"> Download Report</a></span> </div>

      <div class="modal-footer">
      </div>
      </div>


    </div>
  </div>
  <style>
      table.center {
  margin-left: auto; 
  margin-right: auto;
}
  </style>
<!--end-->
<script>
$(document).ready(function(){
     $(".import_option").hide();
         $(".duplication_div").hide();
$("#next").hide();
     $("#file_upload").on("click",function(){
         
         var isclone=$('input:radio[name=read_option]:checked').val();
         $(".import_option").show();
         $(".duplication_div").show();
         $("#next").show();

    }); 
      $("#next").on("click",function(){ 
          $(".stage").val(1);
      });
      
       $(document).on('click','.upload',function(){
          $(".stage").val(2);
      });
      
    
    $('input[type="file"]').change(function(e) {
                var filename = e.target.files[0].name;
                var size=e.target.files[0].size;
               var extension = filename.substr( (filename.lastIndexOf('.') +1) );
               console.log(size);
  if(extension!="csv"){
      notyMsg("info","Please select CSV file");
      $("#file_upload").val('');
  }else{
  if(size > 5e+6){
     notyMsg("info","Please select CSV file with 5MB");
      $("#file_upload").val('');
  }
  }
            });
    $('.module_name').change(function(){
        var moduleid=$('.module_name').select2('val');
        var condition=" config_hdr_id="+moduleid+" and `show`='Yes'";
        $('.find_duplicate').jCombo("{{ URL::to('jcomboformcomp?table=c_config_lines_t:field:title')}}&parent="+condition,
			{selected_value:""});
    });
	var moduleid=$('.module_name').select2('val');
    var condition=" config_hdr_id="+moduleid+" and `show`='Yes'";
	 $('.find_duplicate').jCombo("{{ URL::to('jcomboformcomp?table=c_config_lines_t:field:title')}}&parent="+condition,
			{selected_value:""});
    
       $(document).on('click','.saveform',function(){
           

  var urls      ="{{ URL::to('uploadconfigsave')}}";

  validationrule('uploadform');
      
    var form = $('#uploadform');
    form.parsley().validate();
    
                   
            var form_data = new FormData(document.getElementById('uploadform')); 
            $('.ajaxLoading').show();
            $.ajax({
                  url: "{{ URL::to('uploadconfigsave') }}",
                  type: "POST",
                  data: form_data,
                  enctype: 'multipart/form-data',
                  processData: false,  /*tell jQuery not to process the data*/
                  contentType: false,   /*tell jQuery not to set contentType*/
                  async:true,
                  xhr: function(){
                      var xhr = $.ajaxSettings.xhr();
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', function(event) {
                                var percent = 0;
                                var position = event.loaded || event.position;
                                var total = event.total;
                                if (event.lengthComputable) {
                                        percent = Math.ceil(position / total * 100);
                                }
                                }, true);
                        }
          return xhr;

                }
                }).done(function(data,status)
                {
                   // console.log(data);
                    $('.ajaxLoading').hide();
                if(data.status=='mapping')
                {
                  $(".upload_data").hide();
                  $(".mapping_data").html(data.table_fields);
                  $('.previous').show();
                  $.each(data.filesop,function(index,val){
                      $(".field"+index).val(val.position)
                  })
                }else if(data.status=="Success"){
                    $(".upload_data").hide();
                    $(".mapping_data").hide();
                    $("#uploaddetailsModal").modal('show');
                    $('#uploaddetailsModal').on('shown.bs.modal', function () {
       	            $('.totrec').append(data.totalrecords);
                    $('.skip').append(data.skip);
                    $('.newdata').append(data.new);
                    $('.cln').append(data.clone);
                    $('.overwr').append(data.overwrite);
       	});
                }
                   console.log(data);
                }).fail(function(data,status)
                {
                  $(".alert-success").hide();
                  $(".alert-danger").fadeIn(800);

                });
    
      
      

       });
       
       $('.tab_change').click(function(){
          var val = $(this).val();
          if(val=='previous'){
              $(".upload_data").show();
              $(".mapping_data").hide();
          }
          
       });
       
    	$('.download1').click(function()
{
    var modulename=$('.module_name option:selected').text();
    var moduleid=$('.module_name').select2('val');
    if(moduleid!="" ){
var form_data = new FormData();                  
$.ajax({
url: "{{URL::to('downloadtemplate')}}/"+moduleid,             
contentType: false,
processData: false,                  
type: 'get',
success: function(data){
console.log(data['status']);
if(data['status']==1)
{
$('.ajaxLoading').hide();
var file_name= modulename+' TEMPLATE.csv';
$('.download_csv_n2').attr('download',file_name);
$('.download_csv_n2').attr('href','uploads/'+file_name);

$('.download_csv_n2')[0].click();
}


}

});
$('.ajaxLoading').hide();
return true;
}else{
    notyMsg("info","Please Select Module Name");
}

return false;

}); 

      });
</script>
@include('layouts.php_js_validation')
@endsection
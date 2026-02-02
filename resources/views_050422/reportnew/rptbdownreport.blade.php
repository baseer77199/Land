  @extends('layouts.header')
@section('content')
<style type="text/css">

.ui-datepicker-calendar {
   display: none;
}
.divhide .card{
    padding: 5px;
    border: 1px solid #ccc;
}
.divhide .table{
    width: 100%;
}
.card-header{
    border-bottom:1px solid #ccc;
}
</style>

<link rel="stylesheet" type="text/css" href="{{asset('datetimepicker/bootstrap-datetimepicker.css')}}">
<script type="text/javascript" src="{{asset('datetimepicker/moment-with-locales.js')}}"></script>
<script type="text/javascript" src="{{asset('datetimepicker/bootstrap-datetimepicker.js')}}"></script>


<h2 class="heads">PM Monthly Schedule report</h2>
<div class="card">


<div class="card-body card-block">
  <form method="post" action="" id="job_card_reprot" class="org_form" data-parsley-validate enctype="multipart/form-data">
 
{{ csrf_field() }}
    <div class="col-md-offset-2 col-md-4">
        <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4">Month</label>
            <div class="col-md-6">
                            <div class="input-group form_date " 	 data-date=""   data-link-format="yyyy-mm-dd">
                                            <input class="form-control start_date  " id="start_date" name="start_date"  required type="text" value="" style="border-radius: 5px;">
                                             
                            </div>
            </div>
        </div>
    </div>
            <div class="col-lg-12 col-md-12">
                <div class="form-group text-center">
                    <button type="button" class="btn save search" value="SAVE">Search</button>
               </div>
            </div>
    </form>

<div class="divhide">
    
    
    </div>
<div class="row">
    <div class="col-md-12" >
   <table id="pmmonthlyrpt"></table>
  </div>
  </div>

</div>
</div>
	<script type="text/javascript">
$( document ).ready(function() {
		
	    $(document).on('click','.search',function()
		{
		
			 var start_date = ($('.start_date').val() != '') ? $('.start_date').val() : '';
			// var end_date   =  ($('.end_date').val() != '') ? $('.end_date').val()  : ''; 
       var department_id   =  ($('.department_id').val() != '') ? $('.department_id').val()  : ''; 
 		    
		   if(start_date!=''&&department_id!=''){
			var url="{{URL::to('rptbdatareport')}}/?start_date="+start_date+"&department_id="+department_id;
          $.get(url,function(data){
			$('#pmmonthlyrpt').append(data);  
		  });
         
        }else{
             notyMsg("info","Please Choose Feilds");
         }
        
   });
 
	});

  var data = "<?php echo \Session('j_date_format'); ?>";
  // $('.start_date').datetimepicker({
  //   autoClose:true,
  //    viewMode: 'years'
  // });
  $('.end_date').datepicker({
    changeMonth: true,
      dateFormat: data,
      changeYear: true,   
      
  });

	
function highchart(data)
{
    
}
     $(function () {
            $('.start_date').datetimepicker({
                viewMode: 'years',
                format: 'YYYY-MM'
            });
        })  
	</script>
@include('layouts.php_js_validation')
@endsection





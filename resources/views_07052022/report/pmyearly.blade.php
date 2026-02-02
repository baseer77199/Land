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
<style type="text/css" media="print">
   @media print{
.Image{
        opacity: 1;
        border-top:1px solid #fff !important;
    }
@page {
  size: A3;
 margin: 25mm 25mm 25mm 25mm;
}

/*.header1{*/
/*    visibility: visible !important;*/
/*}*/
    #job_card_reprot,.footershow,.heads{
            display: none !important;
        }
                #reportshow{
            display:block;
             visibility: visible !important;
        }
        #reportshow:after {
    visibility: visible;
    top: 10mm;
    left: 300mm;
    content: "FORMAT NO:04.2211.71.03-2 REV:00/16";
}
    }   
    #table-scroll{
        overflow-x: hidden !important;
    }
    .table .table {
   page-break-after:always !important;
}

#reportTable>tbody{
    page-break-inside:always !important;
    display:table-footer-group !important;
  }
 
#table-scroll{
    float: none !important; 
    position: static !important; 
    display: inline; 
    box-sizing: content-box !important;
}
#table-scroll>#reportTable>thead{
    page-break-before: always !important;
}
 thead { display: table-header-group !important; }
tfoot { display: table-row-group !important}
tr { page-break-inside: avoid !important }

.table-bordered>thead>tr:nth-child(1)>td,.table-bordered>thead>tr:nth-child(2)>td,
.table-bordered>thead>tr:nth-child(3)>td,.table-bordered>thead>tr:nth-child(4)>td,.table-bordered>thead>tr:nth-child(5)>td{
    border:0px solid #fff !important;
}

.table>thead>tr:nth-child(1)>td,
.table>thead>tr:nth-child(2)>td,
.table>thead>tr:nth-child(3)>td,
.table>thead>tr:nth-child(4)>td,
.table>thead>tr:nth-child(5)>td{
    border-left: 1px solid #fff !important;
     border-right:1px solid #fff !important;
      border-top:1px solid #fff !important;
}
th,td{
     padding: 1.8px !important;
    font-size: 9.8px !important; 
    font-weight: bolder !important;
    page-break-inside: avoid !important;
}

</style>
<link rel="stylesheet" type="text/css" href="{{asset('datetimepicker/bootstrap-datetimepicker.css')}}">
<script type="text/javascript" src="{{asset('datetimepicker/moment-with-locales.js')}}"></script>
<script type="text/javascript" src="{{asset('datetimepicker/bootstrap-datetimepicker.js')}}"></script>
<h2 class="heads">PM Six Months Schedule report</h2>
<div class="card">


<div class="card-body card-block">
  <form method="post" action="" id="job_card_reprot" class="org_form" data-parsley-validate enctype="multipart/form-data" >
 
{{ csrf_field() }}
    <div class="col-md-offset-2 col-md-4">
        <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4">Year</label>
            <div class="col-md-6">
                            <div class="input-group form_date " 	 data-date=""   data-link-format="yyyy-mm-dd">
                                            <input class="form-control start_date  " id="start_date" name="start_date"  required type="text" value="" style="border-radius: 5px;">
                                             
                            </div>
            </div>
        </div>
    </div>

    <div class="col-md-offset-2 col-md-4">
        <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4">Department Name</label>
            <div class="col-md-6">
                  <select id="department_id" name='department_id' rows='5'  class='form-control department_id select2' tabindex="1" data-show-subtext="true" data-live-search="true" required>
                    {!! $department_id !!}
            </select>
            </div>
        </div>
    </div>
  

            <div class="col-lg-12 col-md-12">
                <div class="form-group text-center">
                    <button type="button" class="btn save search" value="SAVE">Search</button>
               </div>
            </div>
            <input class="float-right" style="margin-left: 900px;" type="button" onclick="window.print()" value="Print this page"/>
    </form>

<div class="divhide">
    
    
    </div>
<div class="row">
    <div class="col-md-12" >
   <table id="pmyearlygrid"></table>
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
			var url="{{URL::to('getpmyearlydata')}}/?start_date="+start_date+"&department_id="+department_id;
           $.get(url,function(data){
			$('#pmyearlygrid').append(data);
		   });
           
     
        }else{
             notyMsg("info","Please Choose Feilds");
         }
        
   });
     $('.end_date').datepicker({
    changeMonth: true,
      dateFormat: data,
      changeYear: true,   
      
  });

});
function highchart(data)
{
    
}
    $(function () {
            $('.start_date').datetimepicker({
                viewMode: 'years',
                format: 'YYYY'
            });
        }) 


	</script>
@include('layouts.php_js_validation')
@endsection





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
    .alert {
    padding: 0px !important;
    border: none !important;
}
.alert-info {
    color: #31708f;
    background-color: #d9edf7;
    border-color: #bce8f1;
}
.alert-labelled-cell {
    padding: 10px;
    display: table-cell;
    vertical-align: middle;
}
    .alert-labeled-row {
    display: table-row;
    padding: 0px;
}
.alert-label {
    vertical-align: middle;
    background: #BCE8F1;
    width: auto;
    padding: 10px 15px;
    height: 100%;
    font-size: 1.1em;
}
#exceeds_leave > div > div > span > i {
    font-size: 80px;
}
h2{
    margin-top: -4px;
    padding: 0 4px;
}
hr {
    margin-top: 20px;
    margin-bottom: 20px;
    border: 0;
    border-top: 1px solid #eee;
}
.alert-info hr {
    border-top-color: #a6e1ec;
}
.table{
    width: 100%;
    font-family: 'Saira Semi Condensed', sans-serif;
    font-size: 13px;
}
</style>



<h2 class="heads">Report</h2>
<div class="panel panel-visible" id="spy1">


   
    <div class="panel-title ">
            <div class="row">

                <div class="col-md-4">
                      <div class="form-group row " > 
                    <label for="year" class=" control-label col-md-4 text-left"> 
                        Department
                    </label>
                    <div class="col-md-6">
                        <select name="department" class="select2 department" id="department">
                        </select>
                    </div> 
                    <div class="col-md-2">

                    </div>
                </div>
                </div>
                <div class="col-md-4">
                       <div class="form-group  row" > 
                    <label for="Description" class=" control-label col-md-4 text-left"> 
                      Year
                    </label>
                    <div class="col-md-6">
                        <input type="text" name="year" class="form-control year" id="year">
                   </div> 
                    <div class="col-md-2">

                    </div>
                </div>  
                </div> 
            </div>
    </div>
         <div class="row">
       <div class="col-lg-12 col-md-12">
          <div class="form-group text-center">
             <button name="submit" type="button" class="btn search report_search" >Search</button>
     
       
      
          </div>
       </div>
      </div>
   <div class="row">
                <div class="col-md-12">
                <table id="grid1"></table>
                </div>
                </div>
</div>
@extends('layouts.footer')
<link rel="stylesheet" type="text/css" href="{{asset('datetimepicker/bootstrap-datetimepicker.css')}}">
<script type="text/javascript" src="{{asset('datetimepicker/moment-with-locales.js')}}"></script>
<script type="text/javascript" src="{{asset('datetimepicker/bootstrap-datetimepicker.js')}}"></script>
<script src="{{ asset('js/pqgrid.min.js')}}"></script>
<script src="{{ asset('js/pqselect.min.js')}}"></script>
<script src="{{ asset('js/pq-localize-en.js')}}"></script>
<link rel="stylesheet" href="{{ asset('css/pqselect.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.ui.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.css')}}" />
<script src="{{ asset('js/filesaver.js')}}"></script>
<script type="text/javascript">
$(document).ready(function()
{
$(function () {
            $('.year').datetimepicker({
                viewMode: 'years',
                format: 'YYYY'
            });
        }) 
       $(".department").jCombo("{{ URL::to('jcomboform?table=ma_department_t:department_id:department_no|department_name') }}",
        {selected_value:""});
    $(document).on('click','.search',function()
    {
    
       var year = ($('.year').val() != '') ? $('.year').val() : '';
      // var end_date   =  ($('.end_date').val() != '') ? $('.end_date').val()  : ''; 
       var department_id   =  ($('.department').val() != '') ? $('.department').val()  : ''; 
        
       if(year!=''&&department_id!=''){
      var url="{{URL::to('reportdetails')}}/?year="+year+"&department_id="+department_id;
           $.get(url,function(data){
      $('#grid1').append(data);
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
   
       
// search
      

      



</script>

@endsection

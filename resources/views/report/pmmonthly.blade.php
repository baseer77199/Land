@extends('layouts.header')
@section('content')
<style type="text/css">
.ui-datepicker-calendar {
    display: none;
}

.divhide .card {
    padding: 5px;
    border: 1px solid #ccc;
}

.divhide .table {
    width: 100%;
}

.card-header {
    border-bottom: 1px solid #ccc;
}

#pmmonthlyrpt {
    width: 100% !important;
}
</style>
</style>
<style type="text/css" media="print">
@media print {
    .Image {
        opacity: 1;
        border-top: 1px solid #fff !important;
    }

    @page {
        size: A3;
        margin: 25mm 25mm 25mm 25mm;
    }



    /*.header1{*/
    /*    visibility: visible !important;*/
    /*}*/
    #job_card_reprot,
    .footershow,
    .heads {
        display: none !important;
    }

    #reportshow {
        display: block;
        visibility: visible !important;
    }

    #reportshow:after {
        visibility: visible;
        top: 10mm;
        left: 300mm;
        content: "FORMAT NO:04.2211.71.03-3 REV:00/16";
    }
}
</style>
<link rel="stylesheet" type="text/css" href="{{asset('datetimepicker/bootstrap-datetimepicker.css')}}">
<script type="text/javascript" src="{{asset('datetimepicker/moment-with-locales.js')}}"></script>
<script type="text/javascript" src="{{asset('datetimepicker/bootstrap-datetimepicker.js')}}"></script>


<h2 class="heads">PM Monthly Schedule report</h2>
<div class="card">


    <div class="card-body card-block">
        <form method="post" action="" id="job_card_reprot" class="org_form" data-parsley-validate
            enctype="multipart/form-data">

            {{ csrf_field() }}
            <div class="col-md-offset-2 col-md-4">
                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">Month</label>
                    <div class="col-md-6">
                        <div class="input-group form_date " data-date="" data-link-format="yyyy-mm-dd">
                            <input class="form-control start_date  " id="start_date" name="start_date" required
                                type="text" value="" style="border-radius: 5px;">

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">Department Name</label>
                    <div class="col-md-6">
                        <select id="department_id" name='department_id' rows='5'
                            class='form-control department_id select2' tabindex="1" data-show-subtext="true"
                            data-live-search="true" required>
                            {!! $department_id !!}
                        </select>
                    </div>
                </div>
            </div>


            <div class="col-lg-12 col-md-12">
                <div class="form-group text-center">
                    <button type="button" class="btn save search" value="SAVE">Search</button>
                    <button type="button" class="btn print" onclick="window.print()">Print</button>

                </div>
            </div>

        </form>

        <div class="divhide">


        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="pmmonthlyrpt"></table>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {

    $(document).on('click', '.search', function() {

        var start_date = ($('.start_date').val() != '') ? $('.start_date').val() : '';
        // var end_date   =  ($('.end_date').val() != '') ? $('.end_date').val()  : ''; 
        var department_id = ($('.department_id').val() != '') ? $('.department_id').val() : '';

        if (start_date != '' && department_id != '') {
            var url = "{{URL::to('getpmmonthlydata')}}/?start_date=" + start_date + "&department_id=" +
                department_id;
            $.get(url, function(data) {
                $('#pmmonthlyrpt').html(data);
            });

        } else {
            notyMsg("info", "Please Choose Feilds");
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


function highchart(data) {

}
$(function() {
    $('.start_date').datetimepicker({
        viewMode: 'years',
        format: 'YYYY-MM'
    });
})
</script>
@include('layouts.php_js_validation')
@endsection
@extends('layouts.header')
@section('content')
<style type="text/css">
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
</style>
<style>
@media print {
    .Image {
        opacity: 1;
        border-top: 1px solid #fff !important;
    }

    @page {
        size: A3;
        margin: 0 !important;
    }

    /*.header1{*/
    /*    visibility: visible !important;*/
    /*}*/
    #job_card_reprot,
    .footer,
    .heads {
        display: none !important;
    }
}
</style>

<link rel="stylesheet" type="text/css" href="{{asset('datetimepicker/bootstrap-datetimepicker.css')}}">
<script type="text/javascript" src="{{asset('datetimepicker/moment-with-locales.js')}}"></script>
<script type="text/javascript" src="{{asset('datetimepicker/bootstrap-datetimepicker.js')}}"></script>


<h2 class="heads">TOP 5 BREAKDOWN Category Wise</h2>
<div class="card">



    <div class="card-body card-block">
        <form method="post" action="" id="job_card_reprot" class="org_form" data-parsley-validate
            enctype="multipart/form-data">

            {{ csrf_field() }}
            <div class="col-md-6">
                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">From Date</label>
                    <div class="col-md-6">
                        <div class="input-group form_date " data-date="" data-link-format="yyyy-mm-dd">
                            <input class="form-control  start_date " id="start_date" name="start_date" required
                                type="text" value="" style="border-radius: 5px;">

                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-md-6">
                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">To Date</label>
                    <div class="col-md-6">
                        <div class="input-group form_date " data-date="" data-link-format="yyyy-mm-dd">
                            <input class="form-control  end_date " id="end_date" name="end_date" required type="text"
                                value="" style="border-radius: 5px;">

                        </div>
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
                <div class="monthlybreakdownreport">
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
    $(document).ready(function() {
        $(document).on('click', '.search', function() {
            var start_date = ($('.start_date').val() != '') ? $('.start_date').val() : '0';
            var end_date = ($('.end_date').val() != '') ? $('.end_date').val() : '0';
            if (start_date != 0 && end_date != 0) {
                if (start_date <= end_date) {
                    var url = "{{URL::to('topcategorywisereportsearch')}}/" + start_date + "/" +
                        end_date;
                    $.get(url, function(data) {
                        $('.monthlybreakdownreport').html(data);
                    });
                } else {
                    $('.monthlybreakdownreport').html('');
                    notyMsg("info", "End Date must be greater than orequal to Start Date");
                }
            } else {
                $('.monthlybreakdownreport').html('');
                notyMsg("info", "Please choose Date");
            }

        });
        var data = "<?php echo \Session('j_date_format'); ?>";

        $('.start_date,.end_date').datepicker({
            changeMonth: true,
            dateFormat: data,
            changeYear: true,

        });
    });
    </script>
    @include('layouts.php_js_validation')
    @endsection
@extends('layouts.header')
@section('content')

<style type="text/css">
/* ===== Variables & Base Styles ===== */
:root {
    --primary-color: #154c87;
    --secondary-color: #07234e;
    --success-color: #28a745;
    --warning-color: #ffc107;
    --danger-color: #dc3545;
    --light-bg: #f8f9fa;
    --border-color: #e3e6f0;
    --text-dark: #2c3e50;
    --text-muted: #6c757d;
}

body {
    background-color: var(--light-bg);
    color: var(--text-dark);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* ===== Breadcrumb ===== */
.breadcrumb-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, #1a5a99 100%);
    padding: 20px 0;
    margin-bottom: 30px;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(21, 76, 135, 0.15);
}

.breadcrumb-section h1 {
    color: #fff;
    font-size: 28px;
    font-weight: 700;
    margin: 0;
    display: flex;
    align-items: center;
}

.breadcrumb-section h1::before {
    content: "📊";
    margin-right: 12px;
    font-size: 32px;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 10px 0 0 0;
}

.breadcrumb .breadcrumb-item {
    color: rgba(255, 255, 255, 0.8);
    font-size: 13px;
}

.breadcrumb .breadcrumb-item.active {
    color: #fff;
    font-weight: 600;
}

.breadcrumb .breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: color 0.3s;
}

.breadcrumb .breadcrumb-item a:hover {
    color: #fff;
}

/* ===== Main Card ===== */
.report-card {
    background: #fff;
    border: none;
    border-radius: 10px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
    margin-bottom: 30px;
    overflow: hidden;
}

.card-header-custom {
    background: linear-gradient(135deg, var(--primary-color) 0%, #1a5a99 100%);
    color: #fff;
    padding: 24px;
    border-bottom: 3px solid var(--secondary-color);
}

.card-header-custom h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
}

.card-body {
    padding: 30px;
}

/* ===== Form Filters ===== */
.filter-section {
    background: #f8fafc;
    padding: 24px;
    border-radius: 8px;
    margin-bottom: 25px;
    border-left: 4px solid var(--primary-color);
}

.filter-section h5 {
    font-weight: 700;
    color: var(--text-dark);
    margin-bottom: 20px;
    font-size: 16px;
}

.form-group-custom {
    margin-bottom: 20px;
}

.form-group-custom label {
    font-weight: 600;
    color: var(--text-dark);
    margin-bottom: 8px;
    font-size: 14px;
    display: block;
}

.form-control {
    border: 1px solid var(--border-color);
    border-radius: 6px;
    padding: 10px 14px;
    font-size: 14px;
    transition: border-color 0.3s, box-shadow 0.3s;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(21, 76, 135, 0.1);
    outline: none;
}

.select2-container--default .select2-selection--single {
    border: 1px solid var(--border-color);
    border-radius: 6px;
    height: 38px;
    padding: 2px;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    padding: 8px 12px;
    line-height: 24px;
}

/* ===== Buttons ===== */
.btn-search {
    background: linear-gradient(135deg, var(--primary-color) 0%, #1a5a99 100%);
    color: #fff;
    border: none;
    padding: 10px 28px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(21, 76, 135, 0.3);
}

.btn-search:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(21, 76, 135, 0.4);
}

.btn-search:active {
    transform: translateY(0);
}

/* ===== Tab Buttons ===== */
.btn-tab-group {
    display: flex;
    gap: 10px;
    margin-top: 25px;
    flex-wrap: wrap;
}

.btn-tab {
    background: #fff;
    color: var(--text-muted);
    border: 2px solid var(--border-color);
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s;
}

.btn-tab:hover {
    border-color: var(--primary-color);
    color: var(--primary-color);
}

.btn-tab.active {
    background: var(--primary-color);
    color: #fff;
    border-color: var(--primary-color);
    box-shadow: 0 4px 12px rgba(21, 76, 135, 0.3);
}

.btn-print {
    background: linear-gradient(135deg, var(--success-color) 0%, #20c997 100%);
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.3s;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
}

.btn-print:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
}

/* ===== Tables ===== */
.table-responsive-custom {
    border-radius: 8px;
    overflow-x: auto;
    overflow-y: visible;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    margin-top: 20px;
}

.table {
    margin-bottom: 0;
    border-collapse: collapse;
    width: 100%;
    table-layout: auto;
    min-width: 1200px;
}

.table thead {
    background: linear-gradient(135deg, var(--secondary-color) 0%, #0a2e4a 100%);
}

.table thead th {
    color: #fff;
    font-weight: 700;
    padding: 14px 10px;
    font-size: 13px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
    vertical-align: middle;
    text-align: center;
    white-space: nowrap;
}

.table tbody td {
    padding: 14px 10px;
    font-size: 14px;
    font-weight: 500;
    border-bottom: 1px solid var(--border-color);
    vertical-align: middle;
    text-align: center;
}

.table tbody tr:hover {
    background-color: #f8fafc;
}

.table tbody tr:last-child td {
    border-bottom: 1px solid var(--border-color);
}

.table tbody td:first-child,
.table thead th:first-child {
    text-align: left;
    padding-left: 14px;
}

.th-width {
    width: auto;
    min-width: 100px;
    text-align: center;
    padding: 12px 8px !important;
}

.table thead th:nth-child(1),
.table tbody td:nth-child(1) {
    width: 140px;
    min-width: 140px;
    text-align: left;
    padding-left: 16px;
}

.table thead th:nth-child(2),
.table thead th:nth-child(3),
.table thead th:nth-child(4),
.table thead th:nth-child(5),
.table thead th:nth-child(6),
.table thead th:nth-child(7),
.table thead th:nth-child(8),
.table thead th:nth-child(9),
.table thead th:nth-child(10),
.table thead th:nth-child(11),
.table thead th:nth-child(12),
.table thead th:nth-child(13),
.table tbody td:nth-child(2),
.table tbody td:nth-child(3),
.table tbody td:nth-child(4),
.table tbody td:nth-child(5),
.table tbody td:nth-child(6),
.table tbody td:nth-child(7),
.table tbody td:nth-child(8),
.table tbody td:nth-child(9),
.table tbody td:nth-child(10),
.table tbody td:nth-child(11),
.table tbody td:nth-child(12),
.table tbody td:nth-child(13) {
    width: 110px;
    min-width: 110px;
    text-align: center;
}

.td-bg {
    background: var(--secondary-color);
    color: #fff;
    font-weight: 700;
    text-align: center;
    font-size: 12px;
    padding: 12px 8px !important;
}

/* ===== Data Sections ===== */
.data-section {
    animation: fadeIn 0.3s ease-in;
}

.data-section.hidden {
    display: none !important;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.chart-container {
    background: #f8fafc;
    padding: 25px;
    border-radius: 8px;
    margin-bottom: 25px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

/* ===== Utilities ===== */
.ui-datepicker-calendar {
    display: none;
}

.form_date {
    margin-bottom: 0;
}

/* ===== Print Styles ===== */
@media print {

    .breadcrumb-section,
    .filter-section,
    .btn-tab-group,
    .headerdata,
    .footer,
    .heads {
        display: none !important;
    }

    .report-card {
        box-shadow: none;
        border: 1px solid #ccc;
    }

    .card-header-custom {
        background: #f5f5f5;
        color: #000;
        border: 1px solid #ccc;
    }

    @page {
        size: A3;
        margin: 0;
    }

    .table thead {
        background: #f5f5f5 !important;
        color: #000 !important;
    }

    .table thead th {
        color: #000 !important;
        border: 1px solid #ccc !important;
    }

    .table tbody td {
        border: 1px solid #ccc !important;
    }

    thead {
        display: table-header-group !important;
    }

    tfoot {
        display: table-row-group !important;
    }

    tr {
        page-break-inside: avoid !important;
    }
}
</style>

<link rel="stylesheet" type="text/css" href="{{asset('datetimepicker/bootstrap-datetimepicker.css')}}">
<script type="text/javascript" src="{{asset('datetimepicker/moment-with-locales.js')}}"></script>
<script type="text/javascript" src="{{asset('datetimepicker/bootstrap-datetimepicker.js')}}"></script>


<!-- Main Report Card -->
<div class="report-card">
    <div class="card-header-custom">
        <h3>Overall Machine Report</h3>
    </div>

    <div class="card-body">
        <form method="post" action="" id="job_card_reprot" class="org_form" data-parsley-validate
            enctype="multipart/form-data">
            {{ csrf_field() }}

            <!-- Filter Section -->
            <div class="filter-section">
                <h5>🔍 Filter Parameters</h5>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group-custom">
                            <label for="start_date">Select Year</label>
                            <div class="form_date">
                                <input class="form-control start_date" id="start_date" name="start_date" required
                                    type="text" value="" placeholder="Select Year">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group-custom">
                            <label for="machine_id">Machine Name</label>
                            <select id="machine_id" name='machine_id' class='form-control machine_id select2'
                                tabindex="1" data-show-subtext="true" data-live-search="true" required>
                                {!! $machine_id !!}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group-custom">
                            <label>&nbsp;</label>
                            <button type="button" class="btn btn-search w-100">
                                <i class="fas fa-search"></i> Search Report
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="btn-tab-group">
                <button type="button" class="btn-tab search_data active" data-value="calculation">
                    <i class="fas fa-calculator"></i> Calculation
                </button>
                <button type="button" class="btn-tab search_data" data-value="mttr">
                    <i class="fas fa-chart-bar"></i> MTTR
                </button>
                <button type="button" class="btn-tab search_data" data-value="mtbf">
                    <i class="fas fa-chart-line"></i> MTBF
                </button>
                <button type="button" class="btn-print ms-auto" onclick="window.print()">
                    <i class="fas fa-print"></i> Print Report
                </button>
            </div>

            <!-- Calculation Tab -->
            <div class="data calculation data-section">
                <div class="table-responsive-custom">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th rowspan="2" class="th-width">Month</th>
                                <th rowspan="2" class="th-width">NO OF BD</th>
                                <th rowspan="2" class="th-width">BD HOURS</th>
                                <th rowspan="2" class="th-width">AVAILABILITY HOURS</th>
                                <th rowspan="2" class="th-width">REPAIR HOURS</th>
                                <th colspan="2" class="th-width">MTTR</th>
                                <th colspan="2" class="th-width">MTBF</th>
                                <th rowspan="2" class="th-width">Remarks</th>
                            </tr>
                            <tr>
                                <th class="th-width">Target</th>
                                <th class="th-width">ACTUAL</th>
                                <th class="th-width">Target</th>
                                <th class="th-width">ACTUAL</th>
                            </tr>
                        </thead>
                        <tbody class="cal_body">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MTTR Tab -->
            <div class="data mttr data-section hidden">
                <div class="chart-container">
                    <div id="chartContainer"></div>
                </div>

                <div class="table-responsive-custom">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="th-width">MONTH</th>
                                <th class="th-width">JAN</th>
                                <th class="th-width">FEB</th>
                                <th class="th-width">MAR</th>
                                <th class="th-width">APR</th>
                                <th class="th-width">MAY</th>
                                <th class="th-width">JUN</th>
                                <th class="th-width">JUL</th>
                                <th class="th-width">AUG</th>
                                <th class="th-width">SEP</th>
                                <th class="th-width">OCT</th>
                                <th class="th-width">NOV</th>
                                <th class="th-width">DEC</th>
                            </tr>
                        </thead>
                        <tbody class="mttr_cal">
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- MTBF Tab -->
            <div class="data mtbf data-section hidden">
                <div class="chart-container">
                    <div id="mtbfchart"></div>
                </div>

                <div class="table-responsive-custom">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="th-width">MONTH</th>
                                <th class="th-width">JAN</th>
                                <th class="th-width">FEB</th>
                                <th class="th-width">MAR</th>
                                <th class="th-width">APR</th>
                                <th class="th-width">MAY</th>
                                <th class="th-width">JUN</th>
                                <th class="th-width">JUL</th>
                                <th class="th-width">AUG</th>
                                <th class="th-width">SEP</th>
                                <th class="th-width">OCT</th>
                                <th class="th-width">NOV</th>
                                <th class="th-width">DEC</th>
                            </tr>
                        </thead>
                        <tbody class="mtbf_cal">
                        </tbody>
                    </table>
                </div>
            </div>

        </form>
    </div>
</div>

<script src="{{ asset('js/pqselect.min.js')}}"></script>
<script src="{{ asset('js/pqgrid.min.js')}}"></script>
<script src="{{ asset('js/pq-localize-en.js')}}"></script>
<link rel="stylesheet" href="{{ asset('css/pqselect.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.ui.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.css')}}" />
<script src="{{ asset('js/filesaver.js')}}"></script>

<script type="text/javascript">
$(document).ready(function() {
    $(".btn-search").click(function() {
        var start_date = ($('.start_date').val() != '') ? $('.start_date').val() : '';
        var machine_id = ($('.machine_id').val() != '') ? $('.machine_id').val() : '';

        if (start_date != '' && machine_id != '') {
            var url = "{{URL::to('getoverallmachinereport')}}/?start_date=" + start_date +
                "&machine_id=" + machine_id;
            $.get(url, function(data) {

                var months = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11",
                    "12"
                ];
                var mttr_chart = [];
                var mtbf_chart = [];

                var html = '';
                $.each(data.data, function(index, val) {
                    html += "<tr><td>" + val.issue_month + "</td><td>" + val.no_of_bd +
                        "</td><td>" + val.bd_time + "</td><td>" + val.total_hrs +
                        "</td><td>" + val.repair_time + "</td><td>00:00:00</td><td>" +
                        val.mttr + "</td><td>00:00:00</td><td>" + val.mtbf +
                        "</td><td></td></tr>";
                });

                var mttr1 = '<tr><td class="td-bg">NO OF BD</td>';
                var mttr2 = '<tr><td class="td-bg">REPAIR HOURS</td>';
                var mttr3 = '<tr><td class="td-bg">MTTR HOURS</td>';
                var mtbf1 = '<tr><td class="td-bg">NO OF BD</td>';
                var mtbf2 = '<tr><td class="td-bg">BREAKDOWN HOURS</td>';
                var mtbf3 = '<tr><td class="td-bg">AVAILABLE HOURS</td>';
                var mtbf4 = '<tr><td class="td-bg">MTBF HOURS</td>';

                $.each(months, function(index, val) {
                    var check = 0;

                    $.each(data.data, function(index1, val1) {
                        if (val1.month == val) {
                            mttr_chart.push(parseFloat(val1.mttr.slice(0, -3)
                                .replace(':', '.')));
                            mtbf_chart.push(parseFloat(val1.mtbf.slice(0, -3)
                                .replace(':', '.')));

                            check = 1;
                            mttr1 += '<td>' + val1.no_of_bd + '</td>';
                            mttr2 += '<td>' + val1.repair_time + '</td>';
                            mttr3 += '<td>' + val1.mttr + '</td>';
                            mtbf1 += '<td>' + val1.no_of_bd + '</td>';
                            mtbf2 += '<td>' + val1.bd_time + '</td>';
                            mtbf3 += '<td>' + val1.total_hrs + '</td>';
                            mtbf4 += '<td>' + val1.mtbf + '</td>';
                        }
                    });

                    if (check == 0) {
                        mttr1 += '<td></td>';
                        mttr2 += '<td></td>';
                        mttr3 += '<td></td>';
                        mtbf1 += '<td></td>';
                        mtbf2 += '<td></td>';
                        mtbf3 += '<td></td>';
                        mtbf4 += '<td></td>';

                        mttr_chart.push(0.00);
                        mtbf_chart.push(0.00);
                    }
                });

                highchart(mttr_chart, mtbf_chart);

                var mttr = mttr1 + "</tr>" + mttr2 + "</tr>" + mttr3 + "</tr>";
                var mtbf = mtbf1 + "</tr>" + mtbf2 + "</tr>" + mtbf3 + "</tr>" + mtbf4 +
                    "</tr>";

                $(".cal_body").html(html);
                $(".mttr_cal").html(mttr);
                $(".mtbf_cal").html(mtbf);
            });
        } else {
            notyMsg("info", "Please select all required fields");
        }
    });

    $(".search_data").click(function() {
        $(".search_data").removeClass('active');
        $(this).addClass("active");
        var div = $(this).data('value');
        $(".data-section").addClass('hidden');
        $("." + div).removeClass('hidden');
    });
});

var data = "<?php echo \Session('j_date_format'); ?>";

$('.end_date').datepicker({
    changeMonth: true,
    dateFormat: data,
    changeYear: true,
});

function highchart(data, data1) {
    Highcharts.chart('chartContainer', {
        title: {
            text: 'MEAN TIME TO REPAIR'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f} hrs'
                }
            }
        },
        series: [{
            type: 'column',
            name: 'MTTR in Hours',
            data: data
        }]
    });

    Highcharts.chart('mtbfchart', {
        title: {
            text: 'MEAN TIME BETWEEN FAILURES'
        },
        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.2f} hrs'
                }
            }
        },
        series: [{
            type: 'column',
            name: 'MTBF in Hours',
            data: data1
        }]
    });
}

$(function() {
    $('.start_date').datetimepicker({
        viewMode: 'years',
        format: 'YYYY'
    });
})
</script>

@include('layouts.php_js_validation')
@endsection
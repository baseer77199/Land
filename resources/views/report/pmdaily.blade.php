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

<h2 class="heads">PM Daily Schedule report</h2>
<div class="card">


    <div class="card-body card-block">
        <form method="post" action="" id="job_card_reprot" class="org_form" data-parsley-validate
            enctype="multipart/form-data">

            {{ csrf_field() }}
            <div class="col-md-offset-2 col-md-4">
                <div class="form-group row">
                    <label for="inputIsValid" class="form-control-label col-md-4">Date</label>
                    <div class="col-md-6">
                        <div class="input-group form_date " data-date="" data-link-format="yyyy-mm-dd">
                            <input class="form-control start_date  " id="start_date" name="start_date" required
                                type="text" value="" style="border-radius: 5px;">

                        </div>
                    </div>
                </div>
            </div>

            <div class=" col-md-4">
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
                </div>
            </div>
        </form>

        <div class="divhide">


        </div>
        <div class="row">
            <div class="col-md-12">
                <table id="pmyearlygrid"></table>
            </div>
        </div>

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

    $(document).on('click', '.search', function() {

        var start_date = ($('.start_date').val() != '') ? $('.start_date').val() : '';
        // var end_date   =  ($('.end_date').val() != '') ? $('.end_date').val()  : ''; 
        var department_id = ($('.department_id').val() != '') ? $('.department_id').val() : '';

        if (start_date != '' && department_id != '') {
            var url = "{{URL::to('getpmdailydata')}}/?start_date=" + start_date + "&department_id=" +
                department_id;
            //  alert(url);
            var url = url;
            obj.dataModel.url = url;
            $("#pmyearlygrid").pqGrid("option", "dataModel.url", url);
            $("#pmyearlygrid").pqGrid("refreshDataAndView");
        } else {
            notyMsg("info", "Please Choose Feilds");
        }

    });
    var url = "";
    var colModel = [{
            dataIndx: "department_id",
            align: "center",
            title: "Id",
            hidden: true
        },
        {
            dataIndx: "department_name",
            align: "Left",
            title: "Department Name",
            width: "15%",
            filter: {
                crules: [{
                    condition: "begin"
                }]
            }
        },
        {
            dataIndx: "machine_name",
            align: "Left",
            title: "Machine Name",
            width: "15%",
            filter: {
                crules: [{
                    condition: "begin"
                }]
            }
        },
        {
            dataIndx: "actual_pm_date",
            align: "Left",
            title: "Months",
            width: "15%",
            filter: {
                crules: [{
                    condition: "begin"
                }]
            }
        },
        {
            dataIndx: "frequency_id",
            align: "Left",
            title: "Plan",
            width: "20%",
            filter: {
                crules: [{
                    condition: "begin"
                }]
            }
        },
        //  { dataIndx: "debit_amounts", align: "Right",title: "Actual Done On" ,width:"15%", filter: { crules: [{condition: "begin" }] }},
        {
            dataIndx: "done_on_date",
            align: "Right",
            title: "AMC Done On",
            width: "15%",
            filter: {
                crules: [{
                    condition: "begin"
                }]
            }
        },
        {
            dataIndx: "statuss",
            align: "Right",
            title: "Status",
            width: "15%",
            filter: {
                crules: [{
                    condition: "begin"
                }]
            }
        },

    ];
    var dataModel = {
        location: "remote",
        dataType: "JSON",
        method: "GET",
        url: url,

    }
    var obj = {
        width: '100%',
        dataModel: dataModel,
        flex: {
            one: true
        },
        colModel: colModel,
        pageModel: {
            type: "remote",
            rPP: 10,
            strRpp: "{0}",
            strPage: "{0} of {1}"
        },
        wrap: false,

        editable: false,
        menuIcon: true,
        editable: false,
        numberCell: {
            show: false
        },
        selectionModel: {
            type: 'row'
        },
        menuUI: {
            singleFilter: true
        },
        filterModel: {
            on: true,
            header: true,
            type: 'remote',
            menuIcon: true
        },
        title: "PM Daily Report",
        resizable: true,

        freezeCols: 2,
        toolbar: {
            items: [{
                    type: 'button',
                    label: "Export to Excel",
                    icon: 'ui-icon-arrowthickstop-1-s',
                    listener: function() {
                        var blob = this.exportData({
                            format: 'xlsx',
                            render: true,
                            type: 'blob'
                        });
                        saveAs(blob, "PM Daily Report.xlsx");
                    }
                },
                {
                    type: 'button',
                    icon: 'ui-icon-print',
                    label: 'Print',
                    listener: function() {
                        var exportHtml = this.exportData({
                                title: 'PM Daily Report',
                                format: 'htm',
                                render: true
                            }),
                            newWin = window.open('', '', 'width=1200, height=700'),
                            doc = newWin.document.open();
                        doc.write(exportHtml);
                        doc.close();
                        newWin.print();
                    }
                }
            ]
        },
        rowSelect: function(evt, ui) {
            var str = JSON.stringify(ui, function(key, value) {
                if (key.indexOf("pq_") !== 0) {
                    return value;
                }
            }, 2)
            var val = $.parseJSON(str);
            var poinvid = val['addList'][0]['rowData'].po_invoice_id;
            $('.poinvoiceid').val(poinvid);
        }
    };
    $("#pmyearlygrid").pqGrid(obj);
    $("#pmyearlygrid").pqGrid({
        scrollModel: {
            autoFit: true
        }
    });
    $(document).on('click', ".exportexcel", function() {
        $("#pmyearlygrid").jqGrid("exportToExcel", {
            includeLabels: true,
            includeGroupHeader: true,
            includeFooter: true,
            fileName: "PM Daily Balance.xlsx"

        })
    });

});

var data = "<?php echo \Session('j_date_format'); ?>";

$('.start_date').datepicker({
    changeMonth: true,
    dateFormat: data,
    changeYear: true,

});

function highchart(data) {

}
</script>
@include('layouts.php_js_validation')
@endsection
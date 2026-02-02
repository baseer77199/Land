@extends('layouts.header')
@section('content')
<script src="{{ asset('js/pqselect.min.js')}}"></script>
<script src="{{ asset('js/pqgrid.min.js')}}"></script>
<script src="{{ asset('js/pq-localize-en.js')}}"></script>
<link rel="stylesheet" href="{{ asset('css/pqselect.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.ui.min.css')}}" />
<link rel="stylesheet" href="{{ asset('css/pqgrid.css')}}" />
<script src="{{ asset('js/filesaver.js')}}"></script>
<style type="text/css">
  .datepicker{

    z-index:1052 !important;}

.Menu {
    position: absolute;
    top: 77%;
    left: auto;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 160px;
    padding: 5px 0;
    margin: 2px 0 0;
    font-size: 14px;
    text-align: left;
    list-style: none;
    background-color: #fff;
    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, .15);
    border-radius: 4px;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
}





</style>
<h2 class="heads">BREAKDOWN REPORT</h2>
<div class="card">


<div class="card-body card-block">
  <form method="post" action="" id="job_card_reprot" class="org_form" data-parsley-validate enctype="multipart/form-data">
 
{{ csrf_field() }}
    <div class="col-md-offset-2 col-md-4">
        <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4">From Date</label>
            <div class="col-md-6">
                            <div class="input-group form_date "      data-date=""   data-link-format="yyyy-mm-dd">
                                            <input class="form-control start_date  " id="start_date" name="start_date"  required type="text" value="" style="border-radius: 5px;">
                                             
                            </div>
            </div>
        </div>
    </div>
      
    <div class="col-md-4">
        <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-4">To Date</label>
            <div class="col-md-6">
                    <div class="input-group form_date "      data-date=""   data-link-format="yyyy-mm-dd">
                                    <input class="form-control end_date  " id="end_date" name="end_date"  required type="text" value="" style="border-radius: 5px;">
                                     <!-- <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span> -->
                    </div>
            </div>
        </div>
    </div>

     </form>
     <div class="col-lg-12 col-md-12">
                <div class="form-group text-center">
                    <button type="button" class="btn save search" value="SAVE">Search</button>
               </div>
            </div>
   

<div class="row">
    <div class="col-md-12" >
   <table id="datewisegrid"></table>
  </div>
  </div>
    </div>

    </div>

<script type="text/javascript">

$( document ).ready(function() {
    $(document).on('click','.search',function()
        {
            var start_date = ($('.start_date').val() != '') ? $('.start_date').val() : '';
            var end_date   =  ($('.end_date').val() != '') ? $('.end_date').val()  : '';    
           if(start_date!=''&& end_date!=''){
            if(start_date<=end_date){
                var url="{{URL::to('getdatewiserpt')}}?start_date="+start_date+"&end_date="+end_date;

                var url = url;
                obj.dataModel.url=url;
                $( "#datewisegrid" ).pqGrid( "option" , "dataModel.url",url );
                $("#datewisegrid").pqGrid("refreshDataAndView");
            }else{
                notyMsg("info","End Date Must be greater or equal than Start Date");   
            }
            
        }else{
             notyMsg("info","Please Choose Feilds");
         }
        
   });
  var url="";
   var colModel=[
	{ dataIndx: "id", align: "center",title: "Id" ,hidden:true},
        { dataIndx: "ticket_number",width:"10%", title: "Ticket Number", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "department_name",align: "center",title: "Department Name" ,width:"10%", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "machine_name", align: "center",title: "Machine Name" , width:"15%",filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "location_name", align: "center",title: "Locaiton Name" , width:"15%",filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "breakdown_name",align: "center",width:"15%",title: "Type Name", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "issue_date", align: "center",width:"10%",title: "Issue Date", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "start_date",align: "center",width:"10%",title: "Start Date", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "end_date",align: "center",width:"10%",title: "End Date", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "actvltime",align: "center",width:"10%",title: "Actual Time", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "diftime",align: "center",width:"10%",title: "Repair Time", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "request_status",align: "center",width:"10%",title: "Status", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "created_by",align: "center",width:"10%",title: "Created By", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "closed_by",align: "center",width:"10%",title: "Closed By", filter: { crules: [{condition: "begin" }] }},
	];
  //define dataModel
        var dataModel = {
            location: "remote",            
            dataType: "JSON",
            method: "GET",
            url: url,
			 getData: function (dataJSON) {
                var data = dataJSON.data;
                return { curPage: dataJSON.curPage, totalRecords: dataJSON.totalRecords, data: data };
            }
        }
         var obj = {
            width:'100%',
            dataModel: dataModel,
            flex:{one: true},
            colModel: colModel,
            pageModel: { type: "remote", rPP: 10, strRpp: "{0}",strPage:"{0} of {1}" },
            wrap: false,
                  
            editable: false,  
            menuIcon: true,
			 editable: false,
            numberCell: { show: false },
            selectionModel: { type: 'row' },
             menuUI: {
                singleFilter: true
            },
            filterModel: { 
                on: true,             
                header: true, 
                type: 'remote', 
                menuIcon: true 
            },
            title: "DATEWISE BREAKDOWN REPORT",
            resizable: true,
           // hwrap:false,
            freezeCols: 2,
                toolbar: {
                items: [{
                    type: 'button',
                    label: "Export to Excel",
                    icon: 'ui-icon-arrowthickstop-1-s',
                    listener: function () {
                        var blob = this.exportData({
                                format: 'xlsx',                                
                                render: true,
                                type: 'blob'
                            });                        
                        saveAs(blob, "Breakdown Report.xlsx" );
                    }
                },
                {
                    type: 'button',
                    icon: 'ui-icon-print',
                    label: 'Print',
                    listener: function () {
                        var exportHtml = this.exportData({ title: 'Breakdown Report', format: 'htm', render: true }),
                            newWin = window.open('', '', 'width=1200, height=700'),
                            doc = newWin.document.open();
                        doc.write(exportHtml);
                        doc.close();
                        newWin.print();
                    }
                }]
            },
rowSelect: function (evt, ui) {
                var str = JSON.stringify(ui, function(key, value){                    
                    if( key.indexOf("pq_") !== 0){
                        return value;
                    }
                }, 2)
                var val=$.parseJSON(str);
				var poinvid=val['addList'][0]['rowData'].po_invoice_id;
				 $('.poinvoiceid').val(poinvid);
            }
        };
        $("#datewisegrid").pqGrid(obj);
$("#datewisegrid" ).pqGrid({ scrollModel:{autoFit: true }});
    $(document).on('click',".exportexcel",function() {
        $("#datewisegrid").jqGrid("exportToExcel",{
                                                includeLabels : true,
                                                includeGroupHeader : true,
                                                includeFooter: true,
                                                fileName : "BREAKDOWN REPORT.xlsx"

                                        })		 
    });

});


      var data = "<?php echo \Session('j_date_format'); ?>";
  $('.start_date').datepicker({
    changeMonth: true,
      dateFormat: data,
      changeYear: true,   
      
  });
  $('.end_date').datepicker({
    changeMonth: true,
      dateFormat: data,
      changeYear: true,   
      
  });
function highchart(data)
{
	
}


    </script>
@endsection

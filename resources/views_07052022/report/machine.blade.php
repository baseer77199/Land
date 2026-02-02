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


<h2 class="heads">PM Machine and Equipments Report</h2>
<div class="card">


<div class="card-body card-block">
  

<div class="divhide">
    
    
    </div>
<div class="row">
    <div class="col-md-12" >
   <table id="machinegrid"></table>
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
$( document ).ready(function() {
		     
			var url="";
                   
            // var url = url;
     //       obj.dataModel.url=url;
			var colModel=[
         { dataIndx: "machine_id", align: "center",title: "Id" ,hidden:true},
      //  { dataIndx: "machine_number",align: "Left",title: "S No" , width:"20%",filter: { crules: [{condition: "begin" }] }}, 
        { dataIndx: "asset_code",align: "Left",title: "Asset Code" , width:"20%",filter: { crules: [{condition: "begin" }] }},
         { dataIndx: "machine_name",align: "Left",title: "Name of Machine /Equipments" , width:"20%",filter: { crules: [{condition: "begin" }] }},
      /* { dataIndx: "location",align: "Left",title: "Location" , width:"20%",filter: { crules: [{condition: "begin" }] }},*/
      { dataIndx: "machine_no",align: "Left",title: "Model" , width:"20%",filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "purchased_date",align: "Left",title: "Date of Aqn" , width:"20%",filter: { crules: [{condition: "begin" }] }},
      { dataIndx: "", align: "Right",title: "Actual Done On" ,width:"15%", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "", align: "Right",title: "Aqn Value" ,width:"15%", filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "", align: "Right",title: "Book Value" ,width:"15%", filter: { crules: [{condition: "begin" }] }},
        
  ];
var dataModel = {
            location: "remote",            
            dataType: "JSON",
            method: "GET",
            url: '{{URL::to('pmmachinedata')}}',
      
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
            title: "PM Machine and Equipments Report",
            resizable: true,
            
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
                        saveAs(blob, "PM Machine and Equipments Report.xlsx" );
                    }
                },
                {
                    type: 'button',
                    icon: 'ui-icon-print',
                    label: 'Print',
                    listener: function () {
                        var exportHtml = this.exportData({ title: 'PM Machine and Equipments Report', format: 'htm', render: true }),
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
        $("#machinegrid").pqGrid(obj);
$("#machinegrid" ).pqGrid({ scrollModel:{autoFit: true }});
    $(document).on('click',".exportexcel",function() {
        $("#machinegrid").jqGrid("exportToExcel",{
                                                includeLabels : true,
                                                includeGroupHeader : true,
                                                includeFooter: true,
                                                fileName : "PM Machine and Equipments Report.xlsx"

                                        })     
    });
		
	});

  var data = "<?php echo \Session('j_date_format'); ?>";
 
 $('.start_date,.end_date').datepicker({
    changeMonth: true,
      dateFormat: data,
      changeYear: true,   
      
  });
	
function highchart(data)
{
    
}

	</script>
@include('layouts.php_js_validation')
@endsection





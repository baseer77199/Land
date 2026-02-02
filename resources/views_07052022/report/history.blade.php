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


<h2 class="heads">History Card Report</h2>
<!-- <div class="card"> -->


<!-- <div class="card-body card-block">
 --><!--   <form method="post" action="" id="job_card_reprot" class="org_form" data-parsley-validate enctype="multipart/form-data">
 
{{ csrf_field() }}
   
    <div class="col-md-offset-2 col-md-6">
        <div class="form-group row">
            <label for="inputIsValid" class="form-control-label col-md-6">Machine Name</label>
            <div class="col-md-6">
                  <select id="machine_id" name='machine_id' rows='5'  class='form-control machine_id select2' tabindex="1" data-show-subtext="true" data-live-search="true" required>
                    {!! $machine_id !!}
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
 -->
<div class="divhide">
    
    
    </div>
<div class="row">
    <div class="col-md-12" >
   <table id="historygrid"></table>
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
		
	 
		   // if(machine_id!=''){
			var url="{{URL::to('gethistoryreport')}}";
  
			var colModel=[
        { dataIndx: "id", align: "center",title: "Id" ,hidden:true},
       // { dataIndx: "sno",align: "Left",title: "S.No" , width:"20%",filter: { crules: [{condition: "begin" }] }}, 
        { dataIndx: "issue_date",align: "Left",title: "Date" , width:"20%",filter: { crules: [{condition: "begin" }] }}, 
        { dataIndx: "shift",align: "Left",title: "Shift" , width:"20%",filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "machine_name",align: "Left",title: "Machine Name" , width:"20%",filter: { crules: [{condition: "begin" }] }},  
        { dataIndx: "asset_code",align: "Left",title: "Asset Code" , width:"20%",filter: { crules: [{condition: "begin" }] }},  
        { dataIndx: "breakdown_name",align: "Left",title: "B/D Type" , width:"20%",filter: { crules: [{condition: "begin" }] }}, 
        { dataIndx: "causes",align: "Left",title: "Nature of B/D" , width:"20%",filter: { crules: [{condition: "begin" }] }}, 
        { dataIndx: "corrective_action",align: "Left",title: "Work Carried Out" , width:"20%",filter: { crules: [{condition: "begin" }] }}, 
        { dataIndx: "tym",align: "Left",title: "Time taken (Hrs)" , width:"20%",filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "",align: "Left",title: "Availability in P/m" , width:"20%",filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "",align: "Left",title: "Frequency the Month" , width:"20%",filter: { crules: [{condition: "begin" }] }},
        { dataIndx: "request_status",align: "Left",title: "Remarks" , width:"20%",filter: { crules: [{condition: "begin" }] }},
    
        
  ];
var dataModel = {
            location: "remote",            
            dataType: "JSON",
            method: "GET",
            url: url,
      
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
            numberCell: { show: true },
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
            title: "History Card Report",
            resizable: true,
            
            freezeCols: 2,
            toolbar: {
                 items: [{
                    type: 'button',
                    label: "Export to Excel",
                    icon: 'ui-icon-arrowthickstop-1-s',
                    listener: function () {
                        var data=this;
                        var url=$.trim($.cookie('historygrid_pq_export_url')).slice(1,-1)+"&download=1";
                        $.get(url,function(s){
                        
                        var blob = data.exportData({
                                format: 'xlsx',                                
                                render: true,
                                type: 'blob',
                                data:s
                            });                        
                        saveAs(blob, "History Card Report.xlsx" );
                        });
                    }
                },
                {
                    type: 'button',
                    icon: 'ui-icon-print',
                    label: 'Print',
                    listener: function () {
                        var exportHtml = this.exportData({ title: 'History Card Report', format: 'htm', render: true }),
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
        $("#historygrid").pqGrid(obj);
$("#historygrid" ).pqGrid({ scrollModel:{autoFit: true }});
    $(document).on('click',".exportexcel",function() {
        $("#historygrid").jqGrid("exportToExcel",{
                                                includeLabels : true,
                                                includeGroupHeader : true,
                                                includeFooter: true,
                                                fileName : "Product Wise PO.xlsx"

                                        })     
    });


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





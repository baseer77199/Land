@extends('layouts.header')
@section('content')
<?php //dd($pageMethod); ?>
<style type="text/css">
    
</style>
<div id="accordion">
<div class="panel-heading" role="tab" id="headingOne">
                                <h4 class="panel-title">
                                    <a role="button">
                                       
                                        Quality Check
                                    </a>
                                </h4>
                            </div>

</div>


  
  
  <div class="panel panel-visible" id="spy1">


<div class="panel-title ">
  <div class="row">
  <div class="col-md-12">
   <?php include('toolbar.php'); ?>
        <!--<button type="button" class="btn sec qualityindent" value="">Quality Indent</button>-->
    
</div>
</div>
<div class="row">
    <div class="col-md-12">
         <hr class="xlg">
    </div>
</div>
</div>
<?php if($pageMethod == 'qualitymr' || $pageMethod == 'mrapproval'){ ?>
    <div class="row">
        <div class="col-md-12" >
            <table id="mrgrid"></table>
      </div>
    </div>
<?php }else{ ?>
    <div class="row">
        <div class="col-md-12" >
            <table id="pogrid"></table>
        </div>
    </div>
<?php } ?>
<div class="row">
    <div class="col-md-12">
         <hr class="xlg">
    </div>
</div>

  </div>

  
<form method="post" action="" id="indentreducesaves"  data-parsley-validate>
    <!-- Trigger the modal with a button -->
  <div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3>Quality Indent</h3>
        </div>
        <div class="modal-body ">
   
          <table width=80%>
          <tr>
          <th>Product Name</th>
          <th>Uom Code</th>
          <th>Qty</th>
          <th>Used Qty</th>
          </tr>
          <tbody class="indentdata">
          </tbody>
          </table>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default view" data-dismiss="modal">View</button>
     
        </div>
      </div>
    </div>
  </div>
 </form>

  



<script type="text/javascript">
$( document ).ready(function() {

    
    /*Karthigaa Purpose For View Function*/
       $("#view").click(function(){
    var index = $("#pogrid").jqGrid('getGridParam','selrow');
    var qc_header_id = $("#pogrid").jqGrid ('getCell', index, 'qc_header_id');
    if( index )
    {
        window.location.replace('gethomedata');
    }
    else
    {
             notyMsg("info","Please Select Row");
    }
    });
    

/*End*/
});
    </script>
@endsection

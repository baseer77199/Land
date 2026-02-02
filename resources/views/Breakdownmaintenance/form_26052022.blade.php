  @extends('layouts.header')
@section('content')

<style type="text/css">
/*.select2.loc_id {
  border: none !important;
}*/
/*.loc_id .select2-container{
  border: none !important;
}*/
#sel2 .loc_id .select2-container{
   border: none !important;
  
}
.select2-container--default .select2-selection--multiple{
  border: none;
}
.select2-container--default.select2-container--focus .select2-selection--multiple{
  border: none;
}
.select2-container{
    box-sizing: border-box;
    display: inline-block;
    margin: 0;
    background-color: #fff;
    border: 1px solid #375a80;
    border-radius: 5px;
    box-shadow: none;
    color: #000;
    text-align: center;
    max-width: 100%;
    transition: all 300ms linear 0s;
    position: relative;
    vertical-align: middle;
    height: auto;
}
.form-control{
  padding: 3px 12px;
}

@media only screen and (min-width: 1500px) {
  .bulk_line_no{width: 50px !important;}
.bulk_spares_id{width: 120px !important;}
.bulk_inventory_stock{width: 120px !important;}
.bulk_qty{width: 120px !important;}

}




.bulk_line_no{width: 50px;}
.bulk_spares_id{width: 120px;}
.bulk_inventory_stock{width: 120px;}
.bulk_qty{width: 120px;}

</style>

<?php include('tools_menu.php');
?> 
<span class="ui_close_btn"></span>
<div class="ajaxLoading"></div>
<h2 class="heads">  <?php if($pageMethod=="allocateengineer") {?>
                                        Allocate Engineer
                                       <?php }else if($pageMethod=="allocatetechnician"){ ?>
                                        Allocate Technician
                                     <?php  }else if($pageMethod=="reallocatetechnician"){ ?>
                                        Reallocate Technician
                                     <?php  }else if($pageMethod=="requestraise"){?>
                                     Ticket Closure Request
                                     <?php } else if($pageMethod=="approverequest"){ ?>
                                      Ticket Closure Approval
                                      <?php } else if($pageMethod=="closerequest"){?>
                                        Close Request
                                      <?php }else if($pageMethod=="sopupload"){?>
                                        SOP
                                        <?php } else{ ?>
                                        Create Issue
                                    <?php } ?>
                                    
  <span class="ui_close_btn">
  <a class="collapse-close pull-right btn-danger close" onclick='location.href="{{ url($returnurl) }}"'></a>
</span>
</h2>
<form autocomplete="off" action=" " id="user_form" class="user_form" data-parsley-validate  autocomplete="off" >
    {{ csrf_field() }}
    <input type="hidden" value="" name="request_status" id="request_status" />
    <input type="hidden" value="{{$noti_type}}" name="noti_type" id="noti_type">
   

<div class="card">

<div class="card-body card-block">


  <div class="row">

    <div class="col-md-4">

            <div class="form-group row ticket pagemethod editissue">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Ticket Number</label>
            <div class="col-md-8">
         <input type="text" name="ticket_number" id="causes" class="form-control ticket_number"  value="{{ $row->ticket_number }}" readonly tabindex="4" >

            </div>
            
        </div>

            <div class="form-group row department_id pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Department</label>
            <div class="col-md-8">
               <?php //print_r($row->id);die;?>
                 <input type="hidden"  name="id" id="id" value="<?php echo $row->id; ?>" />
                  <select name='department_id' rows='5' class='form-control select2 department_id' id="department_id" required>{!! $row->department_id !!}
                </select>
            </div>
            
        </div>
             <div class="form-group row pagemethod machine_div">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Machine</label>
            <div class="col-md-7 ">
                  <select name='machine_id' class='form-control select2 machine_id' required id="machine_id">
                  
                </select>
            </div>
            <div class="col-md-1 showinline bdmachine_div">
                                <i class="fa fa-plus" aria-hidden="true" data-toggle="modal" data-target="#bdmachine" style="color: #142e78;
                font-size: 13px;
                padding: 5px;
                border: 1px solid;
                cursor: pointer;"></i>   
                            </div> 
        </div>


          <div class="form-group row pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Breakdown Type</label>
            <div class="col-md-8">
              <select name='break_type_id' rows='5' class='form-control select2 break_type_id'  required>{!! $row->break_type_id !!}
                </select>
            </div>
           
        </div>
          <?php if($pageMethod=="requestraise" or $pageMethod=="approverequest" ) {?>
     <div class="form-group row requestraise" >
    <label class="form-control-label col-md-4" for="request_remark"><span style="color:red;">*</span>Request Remarks</label>
  <div class="col-md-8">
  <div class="input-group col-md-12 ">
      <input class="form-control request_remark" id="request_remark" name="request_remark" size="16" type="text" value="{{ $row->request_remark }}" required>
    
  </div>
  </div>
    <div class="col-md-2"></div>
</div>
<?php } ?>
 <?php if($pageMethod=="approverequest" || $pageMethod=="closerequest") { ?>
      <!--   <div class="form-group row closerequest closere">
            <label for="inputIsValid" class="form-control-label col-md-4">Repair End Date</label>
            <div class="col-md-8">
    <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
      <input class="form-control end_date datetimepickers" id="end_date" name="end_date" size="16" type="text" value="{{ $row->end_date }}" tabindex="5" >
       <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span> 
      </div>
            </div>
            
        </div>
        -->
       
        <?php } ?>
      
      <div class="form-group row closerequest approre">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Critical Spares Used</label>
              <div class="col-md-8 sel2">
       <select name='critical_spare' rows='5' class='form-control select2 critical_spare'  >
           <option {{$row->critical_spare == "" ? "selected" : "" }} value="">--Please Select--</option>
           <option {{$row->critical_spare == "Yes" ? "selected" : "" }} value="Yes">Yes</option>
           <option {{$row->critical_spare == "No" ? "selected" : "" }} value="No">No</option>
           <option {{$row->critical_spare == "Other" ? "selected" : "" }} value="Other">Other</option>
         {!!$row->critical_spare !!}
       </select>
           </div>
            
        </div>

        <div class="form-group row sopupload">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Error Code</label>
            <div class="col-md-8">
         <!-- <input type="text" name="corrective_action" id="corrective_action" class="form-control corrective_action"  value="{{ $row->corrective_action }}" tabindex="4" > -->
         <textarea name="error_code" id="error_code" class="form-control error_code">{{ $row->error_code }}</textarea>
            </div>
            
        </div>

         <div class="form-group row others">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Other Spares</label>
            <div class="col-md-8">
               
                  <input type="text" name="others" id="others" class="form-control others"  value="{{ $row->others }}" tabindex="4" >
            </div>
            
        </div>
        
    </div>
    <div class="col-md-4">
  <?php  if($pageMethod=='createissue'){$style = "";}else{$style = "style=pointer-events:none";} ?>
<div class="form-group row" {{$style}}>
    <label class="form-control-label col-md-4" for="issue_date"><span style="color:red;">*</span>Issue Date</label>
  <div class="col-md-8">
  <div class="input-group date form_date col-md-12 datehide">
      <input class="form-control timepicker issue_date" id="issue_date" name="issue_date" size="16" type="text" value="{{ $row->issue_date }}" required>
    
  </div>
  </div>
    <div class="col-md-2"></div>
</div>
      
      
       <div class="form-group row pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Causes of Breakdown</label>
            <div class="col-md-8">

         <textarea name="causes" id="causes" cols="50" class="form-control causes"  tabindex="4" required> {!!$row->causes !!}</textarea>
            </div>
            
        </div>
     <div class="form-group row pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Breakdown Severity</label>
              <div class="col-md-8 sel2">
       <select name='breakdown_sevearity' rows='5' class='form-control select2 breakdown_sevearity' required >
        {!!$row->breakdown_sevearity !!}
       </select>
           </div>
            
        </div>
        <div class="form-group row engineer">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Priority Option</label>
              <div class="col-md-8 sel2">
       <select name='priority_option' rows='5' class='form-control select2 priority_option' required >
         <option {{$row->priority_option == "Low" ? "selected" : "" }} value="Low">Low</option>
           <option {{$row->priority_option == "Medium" ? "selected" : "" }} value="Medium">Medium</option>
           <option {{$row->priority_option == "High" ? "selected" : "" }} value="High">High</option>
           <option {{$row->priority_option == "Critical/Emergency" ? "selected" : "" }} value="Critical/Emergency">Critical/Emergency</option>
       
       </select>
           </div>
            
        </div>
         
 <?php if($pageMethod=="requestraise" || $pageMethod=="approverequest" || $pageMethod=="closerequest") { 
  if($pageMethod=='requestraise'){$style = "";}else{$style = "style=pointer-events:none";}
  ?>
 <div class="form-group row requestraise" {{$style}}>
    <label class="form-control-label col-md-4" for="start_date"><span style="color:red;">*</span>Repair Start Date</label>
  <div class="col-md-8">
  <div class="input-group date form_date col-md-12 datehide">
      <input class="form-control start_date datetimepicker1" id="start_date" name="start_date" size="16" type="text" value="{{ $row->start_date }}" required>
    
  </div>
  </div>
    <div class="col-md-2"></div>
</div>
         <?php } ?>

<?php if($pageMethod=="approverequest") { ?>
<div class="form-group row approverequest" >
    <label class="form-control-label col-md-4" for="approve_remarks"><span style="color:red;">*</span>Approval Remarks</label>
  <div class="col-md-8">
  <div class="input-group col-md-12 ">
      <input class="form-control approve_remarks" id="approve_remarks" name="approve_remarks" size="16" type="text" value="{{ $row->approve_remarks }}" required>
    
  </div>
  </div>
    <div class="col-md-2"></div>
</div>
   <?php } ?>
  
          <?php if($pageMethod=="approverequest" || $pageMethod=="closerequest") { ?>
         <div class="form-group row closerequest closere">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Is Breakdown ?</label>
            <div class="col-md-8 sel2">
       <select name='is_breakdown' rows='5' class='form-control select2 is_breakdown' required >
           <option {{$row->is_breakdown == "Yes" ? "selected" : "" }} value="Yes">Yes</option>
           <option {{$row->is_breakdown == "No" ? "selected" : "" }} value="No">No</option>
       </select>
           </div>
            
           </div>
           <?php } ?>


        <div class="form-group row closerequest approre">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Preventive Action</label>
            <div class="col-md-8">
              <textarea name="preventive_action" id="preventive_action" class="form-control preventive_action"  >{{ $row->preventive_action }}</textarea>
       <!--   <input type="text" name="preventive_action" id="preventive_action" class="form-control preventive_action"  value="{{ $row->preventive_action }}" tabindex="4" > -->

            </div>
            
        </div>
    
        <div class="col-md-6 sopupload">
         <div class="form-group row">
           <label for="active" class="form-control-label col-md-4 ">Attach File</label>
           <div class="col-md-8">
             <input type="file" id="choosefile" name="choosefile" class="choosefile" tabindex="6" >
             
          </div>
       </div>
    </div>
             </div>
    
   
                <div class="col-md-4">
                <div class="form-group row pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Maintenance Type</label>
            <div class="col-md-8 sel2">
            <select name='maintenance_type' rows='5' class='form-control select2 maintenance_type' required >
           <option {{$row->maintenance_type == "Machine" ? "selected" : "" }} value="Machine">Machine</option>
           <option {{$row->maintenance_type == "Facility" ? "selected" : "" }} value="Facility">Facility</option>
         {!!$row->maintenance_type !!}
       </select>
            </div>
            
        </div>





           <div class="form-group row pagemethod">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Shift</label>
            <div class="col-md-8 sel2">
       <select name='shift' rows='5' class='form-control select2 active' required >
           <option {{$row->shift == "1" ? "selected" : "" }} value="1">1st Shift</option>
           <option {{$row->shift == "2" ? "selected" : "" }} value="2">2nd Shift</option>
           <option {{$row->shift == "3" ? "selected" : "" }} value="3">3rd Shift</option>
           <option {{$row->shift == "4" ? "selected" : "" }} value="4">4th Shift</option>
         {!!$row->shift !!}
       </select>
           </div>
            
           </div>
                     <div class="form-group row engineer" style="display:none"> 
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Allocate Engineer</label>
            <div class="col-md-8">
              
              <select name='engineer' rows='5' class='form-control select2 engineer'  >
                {!!$row->engineer !!}
                </select>
            </div>
           
        </div>
         <div class="form-group row technician_div">
            <label for="inputIsValid" class="form-control-label col-md-4">Allocate Technician</label>
            <div class="col-md-8">
                 <select multiple id="technician" name='technician[]' rows='5' class='select2 technician' data-show-subtext="true" data-live-search="true" >
                   {!!$row->technician !!}
                 </select>
            </div>
           
        </div>
        
          <?php if($pageMethod=="requestraise" |$pageMethod=="approverequest" || $pageMethod=="closerequest") { 
             if($pageMethod=='requestraise'){$style = "";}else{$style = "style=pointer-events:none";}?>
            <div class="form-group row requestraise" {{$style}}>
    <label class="form-control-label col-md-4" for="end_date"><span style="color:red;">*</span>Repair End Date</label>
  <div class="col-md-8">
  <div class="input-group date form_date col-md-12 datehide">
      <input class="form-control end_date datetimepicker1" id="end_date" name="end_date" size="16" type="text" value="{{ $row->end_date }}" required>
    
  </div>
  </div>
    <div class="col-md-2"></div>
</div>
          <?php } ?>

        <?php if($pageMethod=="approverequest" || $pageMethod=="closerequest") { ?>
     <!--    <div class="form-group row closerequest closere">
            <label for="inputIsValid" class="form-control-label col-md-4">Repair Start Date</label>
            <div class="col-md-8">
    <div class="input-group date form_date col-md-12" data-date="" data-date-format="dd MM yyyy" data-link-field="dtp_input2" data-link-format="yyyy-mm-dd">
      <input class="form-control start_date datetimepickers" id="start_date" name="start_date" size="16" type="text" value="{{ $row->start_date }}" tabindex="5" >
       <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span> 
      </div>
      
            </div>
            
        </div>
        -->
       
          <?php } ?>
  <div class="form-group row closerequest approre">
            <label for="inputIsValid" class="form-control-label col-md-4"><span style="color:red">*</span>Corrective Action</label>
            <div class="col-md-8">
         <!-- <input type="text" name="corrective_action" id="corrective_action" class="form-control corrective_action"  value="{{ $row->corrective_action }}" tabindex="4" > -->
         <textarea name="corrective_action" id="corrective_action" class="form-control corrective_action">{{ $row->corrective_action }}</textarea>
            </div>
            
        </div>


         
       
                </div>

</div>

<!-- raja Code for lines level data-->
             <div class="row linesdiv">
           <div class="col-md-12">
             <a href="javascript:void(0);"  class="add_row additem"  rel=".rcopy"><i class="fa fa-plus"></i> New Item</a>
      
                 <div id="preview-area" class="chandru">
                              <table class="overflow-y preview product_tbl">
                 
                 <thead >
                <tr>                
                <th>Line No</th>
                <th>Spare Name</th>
                <th>Inventory Stock</th>
                <th>Quantity</th>
                <th>Spare Image</th>
                  <th>&nbsp;</th>
                </tr>
                </thead>  <?php //dd($productdata); ?>
                 <tbody class="product_tbl_lines_body">
                   <?php if($parent_id>=1)
                                      { ?>
                   @foreach($productdata as $key=>$value)
                     <tr>
                     
                     </tr>
                   @endforeach 
                                    <?php  }  
                       if($parent_id < 1 ) { 
                      ?>
                   
                 <tr class="rcopy clone">
                  
         <td>
          <input type="hidden" name="bulk_bm_lines_id[]" class="form-control input-sm bulk_bm_lines_id" value=""></td>
         <td>
          <input type="text" name="bulk_line_no[]" class="form-control input-sm bulk_line_no" value="1" readonly="readonly"></td>
         <td>
            <select name='bulk_spares_id[]' rows='5' class='form-control bulk_spares_id select2' data-show-subtext="true" data-live-search="true">
                        {!!$row->spares_id !!}
            </select>
         </td>
        <td>
          <input type="text" name="bulk_inventory_stock[]" class="form-control input-sm bulk_inventory_stock" data-value="0" value="{{ $value->inventory_stock }}" readonly="true" >
       
              </td>                
      <td>
      <input type="text" name="bulk_qty[]" class="form-control input-sm bulk_qty"  data-value="0" >
     </td>
     <td>

     <img class="bulk_upload_image" src="{{URL::to('')}}/upload/machineupload/noimg.png" height="65" width="65" > 

     </td>
                                                                                                                                    
       <td><a class="remove remove0"><i class="fa btn-xs fa-2x fa-minus-circle rem" aria-hidden="true"></i></a><input type="hidden" name="counter[]"></td>

            
             </tr> 
               <?php } ?>
             </tbody>    
           </table>
         </div>
       </div>
       </div>
       <div id="bdmachine" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Breakdowns</h4>
      </div>
      <div class="modal-body">
       
           <table class="table table-bordered">   
 
              <tr style="background:#05234e;color:#fff;font-family: fantasy;
    font-size: 14px;">
                <th>Ticket Number</th>
                <th>Issue Date</th>
                <th>Maintenance Type</th>
                <th>Corrective Action</th>
                <th>Preventive Action</th>
                
              </tr>
        
               <?php  $i=1;
        
               foreach($lastmaintenance as $k=>$v) { ?>  
                    <tr>
                  <td>{{$v->ticket_number}}
         
          </td>
          <td>{{$v->issue_date}}
         
          </td>
          <td>{{$v->maintenance_type}}
         
          </td>
           <td>{{$v->corrective_action}}
         
          </td>
           <td>{{$v->corrective_action}}
         
          </td>
                 <!--  <td class="checkadv balance_amount pobalance_amount{{$i}}" id="{{$v->balance_amount}}">{{$v->balance_amount}}</td>
                  <td class="checkadv balance_amount pobalance_amount{{$i}}" id="{{$v->advance_amount}}">{{$v->advance_amount}}</td>
                  <td><input type="text" name="popaymentamt[{{$v->po_hdr_id}}]" class="popaymentamt"  hidden="true"></td> -->
                 
              </tr>
          <?php $i++; } ?>
       
          </table>

      </div>
    
      <div class="modal-footer">
<!--         <button type="button" class="btn btn-default addadvancepayamt " data-dismiss="modal">Add</button>-->
        <button type="button" class="btn btn-default close1 " data-dismiss="modal">Close</button>
      </div>
    
    </div>

  </div>
</div>
<!--end-->

<div class="row">
    <div class="col-lg-12 col-md-12">
        <div class="form-group text-center">
          <?php if($pageMethod=="requestraise") {?>
            <button name="submit" type="button" class="btn save saveform" value="REQUESTED">Request</button>
          <?php }else if($pageMethod=="approverequest"){?>
            <button name="submit" type="button" class="btn save saveform" value="APPROVED">Approve</button>
            <button name="submit" type="button" class="btn save saveform" value="REJECTED">REJECT</button>
          <?php }else if($pageMethod=="closerequest"){?>
          	<button name="submit" type="button" class="btn save saveform" value="CLOSED">Close</button>
           <?php  }else if($pageMethod=="allocateengineer"){?>
          	<button name="submit" type="button" class="btn save saveform" value="INITIATED">ALLOCATE ENGINEER</button>
           <?php } else if($pageMethod=="allocatetechnician"){?>
          	<button name="submit" type="button" class="btn save saveform" value="INITIATED">ALLOCATE TECHNICIAN</button>
           <?php } else if($pageMethod=="reallocatetechnician"){?>
            <button name="submit" type="button" class="btn save saveform" value="REALLOCATED">ALLOCATE TECHNICIAN</button>
           <?php }else{ ?>
            <input type="hidden" name="submit_type" class="submit_type" id="submit_type">
            <button name="submit" type="button" class="btn save saveform" value="SAVE">Save</button>
            <button name="submit" type="button" class="btn save saveform" value="SAVENEW">Save and New</button>
          <?php } ?>
            <a class='btn cancel' onclick='location.href="{{ url($returnurl) }}"'>Cancel</a>
       </div>
    </div>
</div>
</div>
   
</div>

</form>

<script>
$(document).ready(function()
{
    $('.technician').change(function(){
      var technician = $(this).val()[0];
      if(technician!=''){
        $('.engineer').val(technician);
      }
    });
    
    var deparid=$('#department_id').select2('val');
          var location ='<?php echo \Session::get('location'); ?>';
          var is_tech = '<?php echo \Session::get('is_technician');?>';
          var dept_id = '<?php echo \Session::get('machine_department_id');?>';
          var condition2='';
          console.log(is_tech);
  if(location != 0){
   condition2+=' and location_id='+location;
  }
  if(is_tech!='Yes'){
    condition2+=' and department_id='+dept_id;
  }

  $("#machine_id").jCombo("{{ URL::to('jcomboform1?table=machine_hdr_t:machine_id:asset_code|machine_name') }}&parent="+condition2+'&order_by=machine_name asc',
                {selected_value:'{{$row->machine_id}}'});
  $('.bdmachine_div').css('pointer-events','auto');
    var page ='<?php echo $pageMethod; ?>';
// alert(page);
    if(page == "createissue"){
       
        $('.pagemethod,.technician_div,.engineer').attr('readonly',false);
        $('.pagemethod').css('pointer-events','auto');
        $('.department_id').css('pointer-events','none');
        $('.closerequest,.technician_div,.engineer,.bdmachine_div,.sopupload,.ticket,.active').hide();
   

    }else if(page == "editissue"){
       
       $('.pagemethod,.technician_div,.engineer').attr('readonly',false);
       $('.pagemethod').css('pointer-events','auto');
       $('.department_id').css('pointer-events','none');
       $('.closerequest,.technician_div,.engineer,.bdmachine_div,.sopupload,.active').hide();
  

   }else if(page=="allocateengineer"){
        $('.pagemethod').attr('readonly',true);
        $('.pagemethod').css('pointer-events','none');
        $('.bdmachine_div').css('pointer-events','auto');
        //$('#technician').prop('required',true);
        $('.engineer').prop('required',true);
        $('.closerequest,.sopupload,.active').hide();

    }
    else if(page=="allocatetechnician"){
       
        $('.pagemethod').attr('readonly',true);
        $('.pagemethod').css('pointer-events','none');
        $('.bdmachine_div').css('pointer-events','auto');
       // $('#technician').attr('required',true);
        $('.closerequest,.sopupload,.active').hide();

    }
    else if(page=="reallocatetechnician"){
       
        $('.pagemethod').attr('readonly',true);
        $('.pagemethod').css('pointer-events','none');
        $('.bdmachine_div').css('pointer-events','auto');
       // $('#technician').attr('required',true);
        $('.closerequest,.sopupload,.active').hide();

    }else if(page=="sopupload"){
  $('.pagemethod').attr('readonly',true);
      $('.bdmachine_div').css('pointer-events','auto');
      $('.pagemethod,.engineer,.technician_div').css('pointer-events','none');
      $('.closerequest').show();
      $('.active').hide();
      $('.critical_spare,.preventive_action,.corrective_action').attr('required',true);
    }else if(page=="closerequest"){
      $('.pagemethod').attr('readonly',true);
      $('.bdmachine_div').css('pointer-events','auto');
      $('.pagemethod,.engineer,.technician_div').css('pointer-events','none');
      $('.closerequest').show();
          $('.closere').css('pointer-events','none');
      $('.active').hide();
      $('.critical_spare,.preventive_action,.corrective_action').attr('required',true);

$('.sopupload').hide();
// <?php if(page=="closerequest"){?>
// $(document).on('change','.bulk_spares_id',function(){
//     var index=($(this).closest('tr').index());
//     var product_id=$(this).val();
//     var bom_hdr_id=$(".reference_id").val();
//     var pdtcount = pdtcheck(product_id,index);
//     if(pdtcount <= 0){
//     var url="{{URL::to('getbomqty')}}/"+bom_hdr_id+"/"+product_id;
//     $.get(url,function(data){
//         $(".bulk_qty"+index).val(data[0].component_qty_value);
//     });
//     }
//     else
//         {
//         var msg    = $(".bulk_product_id" + index + ' option:selected').text();
//         var message  = '<span style="color:#fdff65">'+msg+'</span>'+' Product Already Selected';
//         notyMsgs('info',message);
//         rowdataEmpty(index);
//         }
// });
// <?php } ?>


/*Lines Same Spare name duplicate validation and Image show function */
 $(document).on('change','.bulk_spares_id',function(){
    var index=($(this).closest('tr').index());
    var spares_id=$(this).val();
    var pdtcount = pdtcheck(spares_id,index);
    var url1="{{URL::to('')}}/upload/spares/"; 
    if(pdtcount <= 0){
    var url="{{URL::to('getspareqty')}}/"+spares_id;
    $.get(url,function(data){
      if((data[0].inventory_stock)>0){
        qty=data[0].inventory_stock
      }else{
        qty = 0;
      }
        $(".bulk_inventory_stock"+index).val(qty);

        url1= url1+data[0].upload_image;
        if(data[0].upload_image){
        $(".bulk_upload_image"+index).attr("src",url1);
      }
    });
    }
    else
        {
        var msg    = $(".bulk_spares_id" + index + ' option:selected').text();
        var message  = '<span style="color:#fdff65">'+msg+'</span>'+' Spare Already Selected';
        notyMsgs('info',message);
        rowdataEmpty(index);
          $(".bulk_spares_id" + index).select2('val',['']);
        }
});

 /*End*/

    }else{
      $('.pagemethod').attr('readonly',true);
        $('.pagemethod,.engineer,.technician_div').css('pointer-events','none');
        $('.approre').hide();
        $('.sopupload').hide();
    }
$('.others').hide();
$('.linesdiv').hide();
$('.critical_spare').change(function()
{
  var val = $(this).val();
  if(val=="Other")
  {
 $('.others').show();
 $('.linesdiv').hide();
 $('.others').prop('required',true);
  }else if(val=="Yes"){
    $('.others').hide();
    $('.linesdiv').show();
     $('.others').prop('required',false);

  }else{
     $('.others').hide();
 $('.linesdiv').hide();
 $('.others').prop('required',false);

  }
})
$(".add_row").relCopy(data);
     changeclassfields();
    
     $('.add_row').click(function(){
             changeclassfields();
         });
//$(".machine_div").hide();

/* Ajith Number Validation */
 $(document).on('keypress', '.bulk_qty', function(ev){
        var regex = new RegExp("^[0-9.]+$");
        var str = String.fromCharCode(!ev.charCode ? ev.which : ev.charCode);
                if (regex.test(str)) {
                    return true;
                }
                ev.preventDefault();
                return false;
            
    });
 /*End*/

/* Ajith Quantity not Greater than Inventory Stock function*/
$(document).on('change','.bulk_qty',function()
   {
     var index = $(this).closest('tr').index();
    var qty =$(".bulk_qty"+index).val();
 
     var stock =$.trim($(".bulk_inventory_stock"+index).val());
      if(qty > stock) {
                     notyMsg('info',"Quantity should not be Greater than Inventory Stock");
                   $(".bulk_qty"+index).val('');  
        }
         
          });  
/*End*/

 $(document).on('change','#department_id',function()
   {
       $(".machine_div").show();
        var id=$(this).select2('val');
            var condition2='and department_id="'+id+'"';
            $("#machine_id").jCombo("{{ URL::to('jcomboform1?table=machine_hdr_t:machine_id:asset_code|machine_name') }}&parent="+condition2+'&order_by=machine_id asc',
                {selected_value:'{{$row->machine_id}}'});
       
    });
  
 $(document).on('change','#machine_id',function()
   {
        var machine_id=$(this).select2('val');
       var issue_id = $('#id').val();
       if(issue_id==''){issue_id=0;}
       var url =  "{{ URL::to('issuemachinecheck') }}/"+issue_id+"/"+machine_id;
       $.get(url,function(data){
          if(data==1){
            $('#machine_id').select2('val',['']);
            notyMsg('info',"Machine already in Breakdown");
          }else if(data==2){
            $('#machine_id').select2('val',['']);
            notyMsg('info',"Machine Not Available");
          }
       });
    });
  


// $(document).on('change','.causes',function(){
   
//   var causes=$(this).val();
//     var allowed = 0; //allowed times
// var regex = /www.|https?:\/\/[\-A-Za-z0-9+&@#\/%?=~_|$!:,.;]*/g; //match urls
// 	var textArea = causes.match(regex); // search string
// 	if(textArea && textArea.length > allowed){
// 	      notyMsg('error',"Url Not Allow to Enter");
// 		$('.save').prop("disabled", true);
// 	}else{
// 		$('.save').prop("disabled", false);
// 	}
// });

  $(document).on('click','.remove',function()
   {
     var index = $(this).closest('tr').index();
     var rowCount = $('.product_tbl tbody tr').length;
    if(rowCount > 1)
    {
      $($(this).closest("tr")).remove();
      removeclassfields();
    }
    else
    {
      notyMsg('info',"You Can't Delete Atleast One row should be there");
    }
    }); 
    
  
    $(document).on('click','.addbtn',function(){
       var index = $(this).closest('tr').index();
        //alert(index);
      
    });

/**** To Empty the Rowdata when product Empty ********/
    function rowdataEmpty(index){
    $(".bulk_spares_id" + index).val('').change();
    $(".bulk_inventory_stock" + index).val('');
    $(".bulk_qty" + index).val('');
    $(".bulk_upload_image" + index).val('');
    }

function changeclassfields(){
changeClassName('bulk_bm_lines_id');
changeClassName('bulk_line_no');
changeClassName('bulk_spares_id');
changeClassName('bulk_inventory_stock');
changeClassName('bulk_qty');
changeClassName('bulk_upload_image');
}
function removeclassfields()
{
removeClass('bulk_bm_lines_id');
removeClass('bulk_line_no');
removeClass('bulk_spares_id');
removeClass('bulk_inventory_stock');
removeClass('bulk_qty');
removeClass('bulk_upload_image');
}

  function changeClassName(className){
$('.' + className).each(function (index)
{
if (className == "bulk_line_no")
{
$(this).val(index + 1).attr("readonly", 1);
}

$(this).removeClass(className + '0');
$(this).addClass(className + index);
});
} 
    
function removeClass(className)
{
  var rowCount = $('.product_tbl tbody tr').length;
  for(var i=0;i<=rowCount;i++)
  {
  $('.product_tbl tbody tr').find('.'+className).removeClass(className+i);
  }
  $('.' + className).each(function (index)
  {
    if (className == "bulk_line_no")
    {
    $(this).val(index + 1).attr("readonly", 1);
    }
    $(this).addClass(className + index);
  });
}

  $('.read').css('pointer-events','none');
 $('.company').css('pointer-events','none');
  

      $('#request_status').val('');
    $(document).on('click','.saveform',function() {

  var btnval    = $(this).val();
  $('#request_status').val(btnval);
  validationrule('user_form');
      
    var form = $('#user_form');
    form.parsley().validate();


        if (form.parsley().isValid())
        {            
            var form_data = new FormData(document.getElementById('user_form'));   
            $('.ajaxLoading').show();           
            $.ajax({
                  url: "{{ URL::to('issuesave') }}",
                  type: "POST",
                  data: form_data,
                  enctype: 'multipart/form-data',
                  processData: false,  /*tell jQuery not to process the data*/
                  contentType: false,   /*tell jQuery not to set contentType*/
                  async:true,
                  xhr: function(){
                      var xhr = $.ajaxSettings.xhr();
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', function(event) {
                                var percent = 0;
                                var position = event.loaded || event.position;
                                var total = event.total;
                                if (event.lengthComputable) {
                                        percent = Math.ceil(position / total * 100);
                                }
                                }, true);
                        }
          return xhr;

                },
                
                success: function (data,status) {
              console.log(data);
                  var msg    = data.message;
                  var no    = data.no;
                  notyMsg('success',no+" - "+"<i class='' style='font-size:16px'></i>"+msg+"");
                  setTimeout(function(){
                     $('.close').trigger('click');
                  },300);

                 
           },
         error: function(response) {
        
               var errors = response.responseJSON.errors;
console.log(errors);
               var errorsHtml = '';

               $.each( errors, function( key, value ) {
                   errorsHtml += '<p>'+ value[0] + '</p>';
               });
                $(".alert-success").hide();
                  $(".alert-danger").fadeIn(800);
    notyMsg("error",errorsHtml);
            
           }
       }); 
      // $('.ajaxLoading').hide();     
                // }).done(function(data,status)
                // {
                //   console.log(data);
                //   var msg    = data.message;
                //   var no    = data.no;
                //   notyMsg('success',no+" - "+"<i class='' style='font-size:16px'></i>"+msg+"");
                //   setTimeout(function(){
                //      $('.close').trigger('click');
                //   },300);

                // }).fail(function(data,status)
                // {
                //   $(".alert-success").hide();
                //   $(".alert-danger").fadeIn(800);

                // });
    }
      
      
});
var id="{{$row->id}}";
if(id!=''){
$('.department_id').trigger('change');
}
var date = new Date();
date.setDate(date.getDate() - 7);
var startDate = date;
       
$(".start_date,.end_date").on('change', function(){
var startDate = $(".start_date").data("datetimepicker").getDate() ;
var endDate = $(".end_date").data("datetimepicker").getDate() 
  if(startDate>endDate){
                notyMsgs('info',"End Time Must be greater than Start Time");
                $(".end_date").val('');
  }
    // alert(formatted);
})     
  $('.start_date,.end_date').datetimepicker({
    format: "dd-mm-yyyy hh:ii",
    startDate:  date,
  });

});
$(window).on('load',function(){
       var preLoder = $("#preloader");
       preLoder.fadeOut(500);
       var backtoTop = $('.back-to-top')
       backtoTop.fadeOut(100);
   });
</script>

@include('layouts.php_js_validation')
@endsection

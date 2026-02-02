@extends('layouts.header')
@section('content')

<h2 class="heads">Asset Transfer</h2>

<div class="card">
    <div class="card-body card-block">

      <form  action="" id="spare">

                {{ csrf_field()}}
<div class="row">
  <div class="col-md-6">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Location</label>
          <div class="col-md-7">
       
              <select name='locationid' rows='5' class='form-control select2 locationid'  required>{!! $locationid !!}
                </select>
		  </div>
		  <div>
              <span class="btn btn-danger dup_name" style="display:none;"></span>
          </div>
      </div>
      </div>
       <div class="col-md-6">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Location</label>
          <div class="col-md-7">
              <select name='locationid' id="locationid" rows='5' class='form-control select2 locationid'  required>
                </select>
      </div>
      <div>
              <span class="btn btn-danger dup_name" style="display:none;"></span>
          </div>
      </div>
      </div>

       </div>

      <div class="row text-center">
	 	  <button type="button"  class="btn save" tabindex="6">Save</button>
       
	   </div>
  
</form>
<div class="row">
  <div class="col-md-12" style="padding:15px;">

  </div>
</div>
</div>
  </div>


<script>


  $(document).ready(function(){

$('.locationid').change(function(){
	var depid=$(this).select2('val');
       var condition=" locationid="+depid;
            $(".spare_id").jCombo("{{ URL::to('jcomboformcomp?table=m_spares_t:locationid:spares_name') }}&parent="+condition, {
                selected_value: ""
            });
        });
            $(document).on('click', '.save', function() {
                var url = "{{ url('sparequantitysave') }}";
                var form = $('#spare');
                form.parsley().validate();
                if (form.parsley().isValid()) {
                    change_date();
                    var formdata = $('#spare').serialize();
                    $.post(url, formdata, function(data) {
                        var data = $.trim(data);
                        if(data == 1){
                            notyMsg("success","Spare Quantity Updated  Successfullly");
                           setTimeout(function(){
                     var red_url     ="{{ url('sparequantity') }}";
                     window.location.href=red_url;
                            }, 100);
                             }
                       
                       
                    });
                }
            });
            
            $("#editdata").click(function()
            {
                var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
                var spares_id = jQuery("#grid1").jqGrid ('getCell', gr, 'spares_id');
                var department_name = jQuery("#grid1").jqGrid ('getCell', gr, 'department_name');
                var spares_name = jQuery("#grid1").jqGrid ('getCell', gr, 'spares_name');
                var quantity = jQuery("#grid1").jqGrid ('getCell', gr, 'quantity');
               if( department_id)
                {
                     $('#edit_id').val(spares_id);
                   // $('#department_id').val(department_id);
                    $('#spares_name').val(spares_name);
                    $('#department_name').val(department_name);
                    $('#quantity').val(quantity);

                }
                else
                {
                    notyMsg('INFO','Please Select a Row');
                }
            });

 /* Purpose For Delete Function*/ 
$('.del').click(function(){
 // alert("dfhgfd");
  var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
  var id = jQuery("#grid1").jqGrid ('getCell', gr,'spares_id');
  if(gr ){
    swal({
                title: "Are you sure?",
                text: "You want to delete!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
            closeOnCancel:!1
            }, function(e) {
      if(e == true)
      {
        var url ="{{ url('sparedelete') }}/" +id;
        $.get(url,function(data)
        {
          var data = $.trim(data);
      
          if(data =='0')
          {
            notyMsgs('success','Deleted Successfully');
             setTimeout(function(){
                     var red_url     ="{{ url('sparequantity') }}";
                     window.location.href=red_url;
                            }, 100);
           
          }
          if(data =='1')
          {
            notyMsgs('info',"You Can't delete  Used in SomeWhere");
           $('.clearsearch').trigger('click');
                             setTimeout(function(){
                             $("#grid1")[0].triggerToolbar();
                             }, 1500);
          }

        });
            }
            else
            {
            $('.apply').css('display','none');
            $('.clearsearch').trigger('click');
            swal("Cancelled");
            }
            });
             $('.apply').css('display','none');
          }
      else{
            notyMsg("info","Please Select a Row");
        }
    });
    /*End*/

            $('.reset').click(function(){

               $('#spares_id').val('');
               $('#department_name').val('');
               $('.spares_name').val('');
               $('#quantity').val('');
                
            });




  });
  </script>
@endsection
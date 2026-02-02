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
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Asset Code</label>
          <div class="col-md-7">
       
              <select name='asset_code' rows='5' class='form-control select2 asset_code'  required>{!! $asset_code !!}
                </select>
      </div>
      <div>
              <span class="btn btn-danger dup_name" style="display:none;"></span>
          </div>
      </div>
      </div>
<!--        <div class="col-md-6">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Machine Code</label>
          <div class="col-md-7">
       
              <select name='machine_no' rows='5' class='form-control select2 machine_no'  required>{!! $machine_no !!}
                </select>
      </div>
      <div>
              <span class="btn btn-danger dup_name" style="display:none;"></span>
          </div>
      </div>
      </div> -->
        <div class="col-md-6">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Machine Name</label>
          <div class="col-md-7">
       
              <select name='machine_id' rows='5' class='form-control select2 machine_id'  required>{!! $machine_id !!}
                </select>
      </div>
      <div>
              <span class="btn btn-danger dup_name" style="display:none;"></span>
          </div>
      </div>
      </div>
 <!--       <div class="col-md-6">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Department Name</label>
          <div class="col-md-7">
       
              <select name='department_id' rows='5' class='form-control select2 department_id'  required>{!! $department_id !!}
                </select>
      </div>
      <div>
              <span class="btn btn-danger dup_name" style="display:none;"></span>
          </div>
      </div>
      </div> -->
        <div class="col-md-6">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>Current Location</label>
          <div class="col-md-7">
       
              <select name='locationidold' rows='5' class='form-control select2 locationidold'  required>{!!$locationidold!!}
                </select>
      </div>
      <div>
              <span class="btn btn-danger dup_name" style="display:none;"></span>
          </div>
      </div>
      </div>
       <div class="col-md-6">
      <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-5"><span style="color:red;">*</span>New Location</label>
          <div class="col-md-7">
              <select name='locationid' id="locationid" rows='5' class='form-control select2 locationid'  required>{!!$locationid!!}
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

$('.asset_code').change(function(){
  var asset_code=$(this).select2('val');
 // alert(asset_code);

           var location ='<?php echo \Session::get('location'); ?>';

  if(asset_code!==''){
       var condition='location_id='+location+' and machine_id='+asset_code;
            $(".machine_id").jCombo("{{ URL::to('jcomboformcomp?table=machine_hdr_t:machine_id:asset_code|machine_name') }}&parent="+condition, {
                selected_value: asset_code

            });
            }
        });
// $('.machine_no').change(function(){
//   var machine_no=$('.machine_no option:selected').val();
//   if(machine_no!==''){
//        var condition=" machine_id="+machine_no;
//             $(".machine_id").jCombo("{{ URL::to('jcomboformcomp?table=machine_hdr_t:machine_id:machine_name') }}&parent="+condition, {
//                 selected_value: ""
//             });
//           }
//         });
$(document).on('change','.machine_id',function(){
                            var machine_id=$('.machine_id option:selected').val();
                           // alert(machine_id);
                            if(machine_id != ''){
                                var url="{{URL::to('getmachinetbl')}}?machine_id="+machine_id;
                                  $.get(url,function(data){
                              var data =$.trim(data);
                             console.log(data);
                                   $('.locationidold').select2('val',[data]);
                                 // conslo.log(data);
                                 //      $('.location_name').select2(data);
                                   
                                });    
                              
                            }
                          
                });
// $('.machine_id').change(function(){
//   var machine_id=$('.machine_id option:selected').val();
//        var condition=" location_id="+machine_id;
//             $(".locationidold").jCombo("{{ URL::to('jcomboformcomp?table=m_location_t:location_id:location_name') }}&parent="+condition, {
//                 selected_value: ""
//             });
//         });

       // });
       $(document).on('click','.save',function() {

           var form=$("#spare");
             form.parsley();
             $('input[name=_token]').val("{{csrf_token()}}");
            form.parsley().validate();
              var data = form.serialize();
       //       duplicate_validate();
       
var url="{{ URL::to('assettransfersave') }}";

if (form.parsley().isValid())
        {

       var formData = $('#spare').serialize();
            $.ajax({
          url:     "{{ url('assettransfersave') }}",
          type:     'post',
          data:     formData,
          dataType: 'json',
          success: function (response) {
           if(response == 1){
              notyMsg("success","Asset Transfer Updated  Successfullly");
                           setTimeout(function(){
                     var red_url     ="{{ url('assettransfer') }}";
                     window.location.href=red_url;
                            }, 100);
                        }
           },
         error: function(response) {
             console.log(response);
               var errors = response.responseJSON.errors;

               var errorsHtml = '';

               $.each( errors, function( key, value ) {
                   errorsHtml += '<p>'+ value[0] + '</p>';
               });
              // errorsHtml += '</ul></div';
    notyMsg("error",errorsHtml);
   //  $("#grid1")[0].triggerToolbar();
  // $(".clear").trigger('click');
             //  $('.messages').html(errorsHtml);
           }
       });
  
        }   
});
            // $(document).on('click', '.save', function() {
            //     var url = "{{ url('assettransfersave') }}";
            //     var form = $('#spare');
            //     form.parsley().validate();
            //     if (form.parsley().isValid()) {
            //         change_date();
            //         var formdata = $('#spare').serialize();
            //         $.post(url, formdata, function(data) {
            //             var data = $.trim(data);
            //             if(data == 1){
            //                 notyMsg("success","Asset Transfer Updated  Successfullly");
            //               setTimeout(function(){
            //          var red_url     ="{{ url('assettransfer') }}";
            //          window.location.href=red_url;
            //                 }, 100);
            //                  }
                       
                       
            //         });
            //     }
            // });
            
            // $("#editdata").click(function()
            // {
            //     var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
            //     var spares_id = jQuery("#grid1").jqGrid ('getCell', gr, 'spares_id');
            //     var department_name = jQuery("#grid1").jqGrid ('getCell', gr, 'department_name');
            //     var spares_name = jQuery("#grid1").jqGrid ('getCell', gr, 'spares_name');
            //     var quantity = jQuery("#grid1").jqGrid ('getCell', gr, 'quantity');
            //    if( department_id)
            //     {
            //          $('#edit_id').val(spares_id);
            //        // $('#department_id').val(department_id);
            //         $('#spares_name').val(spares_name);
            //         $('#department_name').val(department_name);
            //         $('#quantity').val(quantity);

            //     }
            //     else
            //     {
            //         notyMsg('INFO','Please Select a Row');
            //     }
            // });

//  /* Purpose For Delete Function*/ 
// $('.del').click(function(){
//  // alert("dfhgfd");
//   var gr = jQuery("#grid1").jqGrid('getGridParam','selrow');
//   var id = jQuery("#grid1").jqGrid ('getCell', gr,'spares_id');
//   if(gr ){
//     swal({
//                 title: "Are you sure?",
//                 text: "You want to delete!",
//                 type: "warning",
//                 showCancelButton: !0,
//                 confirmButtonColor: "#DD6B55",
//                 confirmButtonText: "Yes",
//                 cancelButtonText: "No",
//             closeOnCancel:!1
//             }, function(e) {
//       if(e == true)
//       {
//         var url ="{{ url('sparedelete') }}/" +id;
//         $.get(url,function(data)
//         {
//           var data = $.trim(data);
      
//           if(data =='0')
//           {
//             notyMsgs('success','Deleted Successfully');
//              setTimeout(function(){
//                      var red_url     ="{{ url('sparequantity') }}";
//                      window.location.href=red_url;
//                             }, 100);
           
//           }
//           if(data =='1')
//           {
//             notyMsgs('info',"You Can't delete  Used in SomeWhere");
//            $('.clearsearch').trigger('click');
//                              setTimeout(function(){
//                              $("#grid1")[0].triggerToolbar();
//                              }, 1500);
//           }

//         });
//             }
//             else
//             {
//             $('.apply').css('display','none');
//             $('.clearsearch').trigger('click');
//             swal("Cancelled");
//             }
//             });
//              $('.apply').css('display','none');
//           }
//       else{
//             notyMsg("info","Please Select a Row");
//         }
//     });
    /*End*/

            // $('.reset').click(function(){

            //    $('#spares_id').val('');
            //    $('#department_name').val('');
            //    $('.spares_name').val('');
            //    $('#quantity').val('');
                
            // });




  });
  </script>
@endsection
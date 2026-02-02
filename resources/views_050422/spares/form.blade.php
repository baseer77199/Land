@extends('layouts.header')
@section('content')

<h2 class="heads">Create Spare</h2>
<div class="ajaxLoading"></div>
<div class="card">


    <div class="card-body card-block">

      <form  action="" id="save" data-parsley-validate>
        <input type="hidden" name="" value="" id="edit_id" />
                {{ csrf_field()}}
            <div class="row">
               <div class="col-md-6">
                 <div class=" form-group row">
                   <label for="fob_point_name" class="form-control-label col-md-4"><span style="color:red;">*</span>Department Name</label>
                    <div class="col-md-8">
                        <input type="hidden" class="form-control spares_id" id="spares_id" name="spares_id" value="" size="16" type="hidden" readonly>

                        <select name='department_id' rows='5' class='form-control select2 department_id'  required>
                        {!! $row->department_id !!}
                        </select>

                    </div>
                
           </div>
        </div>
       <div class="col-md-6">
        <div class=" form-group row">
          <label for="fob_point_name" class="form-control-label col-md-4"><span style="color:red;">*</span>Category</label>
          <div class="col-md-8">
            <select class='form-control select2 category' name="category" id="category" required>
               <option value="">-- Please Select Category --</option>
               <option value="consumable">Consumable</option>
               <option value="spare">Spare</option>
            </select>
           
         </div>
         
      </div>
   </div>
 </div>

       <div class="row">
          <div class="col-md-6">
            <div class=" form-group row">
              <label for="fob_point_name" class="form-control-label col-md-4"><span style="color:red;">*</span>Spare Name</label>
              <div class="col-md-8">

                  <input type="text" id="spares_name" name="spares_name" class="form-control spares_name" tabindex="1" value="" required style="width:100%;" tabindex="3" required>
              </div>
              <div>
                <span class="btn btn-danger dup_name" style="display:none;"></span>
            </div>
            <div style="display: none;">
                <select name='created_by' rows='5' class='form-control select2 created_by'  required>{!! $created_by !!}
                </select>
         </div>

     </div>
       </div>
       <div class="col-md-6">
           <div class="form-group row">
             <label for="active" class="form-control-label col-md-4 "><span style="color:red;">*</span>Quantity</label>
             <div class="col-md-8">
               <input type="text" id="spare_quantity" name="spare_quantity" class="form-control spare_quantity" tabindex="4"  required>


           </div>
       </div>
       
        


   </div>  
    
 <div class="row">

   <div class="col-md-6">
      <div class=" form-group row">
        <label for="fob_point_name" class="form-control-label col-md-4">Description</label>
        <div class="col-md-8">
            <textarea class="form-control" name="description" id="description" rows="5"></textarea>
         </div>
      </div>
       </div>

       <div class="col-md-6">
         <div class="form-group row">
           <label for="active" class="form-control-label col-md-4 ">Upload Image</label>
           <div class="col-md-8">
             <input type="file" id="upload_image" name="upload_image" class="upload_image" tabindex="6" accept="image/*" >             
          </div>
       </div>
       <div class="form-group row" id="img_block" style="display: none;">
           <div class="col-md-4"></div>
           <div class="col-md-8 pull-right">
             <img id="existing_img" src="" width="100" height="100">
             <label id="uploaded_image"></label>
          </div>
       </div>
    </div>


    </div>
 </div>
 </div>

      <div class="row text-center">
		<a href="{{url('sparesupload')}}"><button type="button"  class="btn upload  upload-image" tabindex="5">Upload</button></a>
        <button type="submit"  class="btn save" tabindex="6">Save</button>
     <?php include('toolbar.php'); ?>
      </div>
     </form>
     <div class="row">
  <div class="col-md-12" style="padding:15px;">
    <table id="sparegrid"></table>
  </div>
</div>


    </div>

</div>

</div>
</div>
<script>

$('#spare_quantity').keyup(function(e){

    if(!/^[0-9]*$/.test(this.value)){

        this.value = this.value.split(/[^0-9.]/).join('');
    }
    // notyMsg('vdf');

});

/* Purpose for Duplicate Function for Payment term Name*/
    var dup_chk = true;
    function duplicate_validate()
    {
        var spares_name = $(".spares_name").val();
        var edit_id = $("#spares_id").val();
        $('ajaxLoading').show();
        $.ajax({
            cache: false,
            url: 'sparechkname',
            type: 'GET',
            dataType: 'json',
            data: {spares_name : spares_name,edit_id : edit_id},
            async:false,
            success: function(response)
            {
                if(response == 1)
                {
                    $('.dup_name').html('Spare Name:'+spares_name+' Already Exists');
                    $('.dup_name').show();

                    $(".spares_name").val('');
                    dup_chk = false;
                }
                else if(response == 0)
                {
                    var html ="";
                    $('.dup_name').hide();
                    dup_chk  = true;
                }
            },
        });
    }
/*End*/

/*Karthigaa Purpose for Duplicate Function for Payment term Name*/
  
$(document).ready(function(){

 /* Purpose For Upper Case*/
 $('.spares_name').on('keyup',function(){
  this.value= this.value.toUpperCase();
  $('.dup_name').hide();
});
 /*End*/

 $("#save").submit(function(){
    var form=$("#save");
    form.parsley();
    $('input[name=_token]').val("{{csrf_token()}}");
    var data;
    change_date();
    form.parsley().validate();
    duplicate_validate();
    var ss = new FormData(document.getElementById("save"));
    if (form.parsley().isValid())
    {
        
      if(dup_chk==true){
       var a= $("#upload_image").val();
       $.ajax({
        cache: false,
        enctype: 'multipart/form-data',
        url: 'spare/save',
        type: 'POST',
            // dataType: 'json',
            // async : false,
            data: ss,
            processData: false,
            contentType: false,
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
            success: function(response)
            {
              // alert(response);
              var msg    = response.message;;
              notyMsg('success',"<i class='' style='font-size:16px'></i>"+msg+"");
              $("#sparegrid")[0].triggerToolbar();
              $(".clear").trigger('click');
            },
            error: function(response)
            {
        	    $('.ajaxLoading').hide();
                var errors = response.responseJSON.errors;
                var errorsHtml = '';
                $.each( errors, function( key, value ) {
                   errorsHtml += '<p>'+ value[0] + '</p>';
                });
                notyMsg("error",errorsHtml);
            }
      });
   }       
}
        // return false;
        
        return false;
    });


 $("#sparegrid").jqGrid(
 {
    url: "sparegrid",
    datatype: "json",
    mtype: "GET",
    colModel: [
    { name: "spares_id", label: "id", width: 250, hidden: true },
    { name: "department_name", label: "Department Name", width: 250,editable:true},
    { name: "department_id", label: "Department Name", width: 250,editable:true,hidden:true},
    { name: "upload_image", label: "Upload Image", width: 250,editable:true,hidden:true},
    { name: "spares_name", label: "Spare Name", width: 250,editable: true},
    { name: "spare_quantity", label: "Quantity", width: 250,editable: true},
    { name: "category", label: "Category", width: 250,editable: true},
    { name: "description", label: "Description", width: 250,editable:true},

    ],

    iconSet: "fontAwesome",
    rowNum: 10,
    rowList: [10,20,50,100,250,500,1000,2000],
    sortname: "spares_id",
    sortorder: "desc",
    viewrecords: true,
    gridview: true,
    rownumbers:true,
    pager: "#sparegrid",
    multiselect:false,
    multipageselection:true,
    searching: {
        defaultSearch: "cn",
    },
});
 jQuery("#sparegrid").jqGrid('filterToolbar',{stringResult: true,searchOnEnter : false});

 /*Karthigaa Purpose For PDF Download*/
 $(document).on('click',".exportpdf",function() {
    $("#sparegrid").jqGrid('exportToPdf', {
      title: null,
      orientation: 'portrait',
      pageSize: 'A4',
      description: null,
      onBeforeExport: null,
      download: 'download',
      includeLabels : true,
      includeGroupHeader : true,
      includeFooter: true,
      fileName : "Spares.pdf",
      mimetype : "application/pdf"  
  });   
}); 
 $(document).on('click',".exportexcel",function() {
    $("#sparegrid").jqGrid("exportToExcel",{
      includeLabels : true,
      includeGroupHeader : true,
      includeFooter: true,
      fileName : "Spares.xlsx"
  })     
});


 $(".clearsearch").click(function()
 {
    var grid = $("#sparegrid");
    grid.jqGrid('setGridParam',{search:false});
    var postData = grid.jqGrid('getGridParam','postData');
    $.extend(postData,{filters:""});
    grid.trigger("reloadGrid",[{page:1}]);
    $('input[id*="gs_"]').val("");
    
});




 $("#editdata").click(function()
 {
     var form=$("#save");
     var index = $("#sparegrid").jqGrid('getGridParam','selrow');
     var id = $("#sparegrid").jqGrid ('getCell', index, 'spares_id');
     var spares_name = $("#sparegrid").jqGrid ('getCell', index, 'spares_name');
     var department_id = jQuery("#sparegrid").jqGrid ('getCell', index, 'department_id');
     var description = $("#sparegrid").jqGrid ('getCell', index, 'description');
     var spare_quantity = $("#sparegrid").jqGrid ('getCell', index, 'spare_quantity');
     var upload_image = $("#sparegrid").jqGrid ('getCell', index, 'upload_image');
     var created_by = jQuery("#sparegrid").jqGrid ('getCell', index, 'created_by');
     var category = jQuery("#sparegrid").jqGrid ('getCell', index, 'category');

     var url ="{{ url('spareedit') }}/" +id;
     if(index){
        $.get(url,function(data){ 
           if($.trim(data) =='1'){
            notyMsgs('info',"You Can't Edit  Used in SomeWhere");
        } else {
            $('#edit_id').val(id);

            $('#spares_id').val(id);
            $('#spares_name').val(spares_name);
            $('.department_id').select2('val',[department_id]);
            $('.category').select2('val',[category]);
            $('#description').val(description);
            $('#spare_quantity').val(spare_quantity);

            if(upload_image!=''){
                
            $("#img_block").css("display", "block");
            $("#existing_img").show();
            $('#existing_img').attr('src','{{ asset("upload/spares") }}/'+upload_image);
            $("#existing_img").error(function() { $(this).hide(); });
             $('#uploaded_image').text(upload_image);
        }

           
            $('#created_by').val(created_by);
            $("#sparegrid").trigger('reloadGrid');
                }
            });
    }
    else{
        notyMsgs("info","Please Select a Row");
    }
});


 /* Purpose For Delete Function*/ 
 $('.delete').click(function(){
 // alert("dfhgfd");
 var gr = jQuery("#sparegrid").jqGrid('getGridParam','selrow');
 var id = jQuery("#sparegrid").jqGrid ('getCell', gr,'spares_id');
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
            $('.clearsearch').trigger('click');
            $(".reset").trigger('click');
            $("#sparegrid")[0].triggerToolbar();

        }
        if(data =='1')
        {
            notyMsgs('info',"You Can't delete  Used in SomeWhere");
            $('.clearsearch').trigger('click');
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



 /*purpose:clear the Input Fields*/
 $('.clear').click(function(){
  var form=$('#save');
  form.parsley().destroy();
  /*$(':input','#save').not(':button, :submit, :reset').val('').prop('checked', false); 
  $(".dup_name").hide();
  $("select").val("").select2();*/
    $('#spares_id').val('');
    $('#spares_name').val('');
 $(".department_id").val("").select2();
 $(".category").val("").select2();
   /* $('#department_id').val('');
    $('#category').val('');*/
    // $('#department_name').val('');
    $('#description').val('');
    $('#upload_image').val('');
    $('#spare_quantity').val('');

  
      //  $('#active').select2('val',['Yes']);
  });
 /***** Clear Function Start  ****/
 $('.reset').click(function(){

    $('#spares_id').val('');
    $('#spares_name').val('');
    $('#department_id').val('');
    $('#category').val('');
    // $('#department_name').val('');
    $('#description').val('');
    $('#upload_image').val('');
    // $('#created_by').val('');
    location.reload();
});
 /***** Clear Function End  ****/ 



});
  </script>
@endsection
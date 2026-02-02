<div class="sbox">
	<div class="sbox-title"> 
		
	</div>
	<div class="sbox-content"> 
            
         <div class="col-md-6">
                            <fieldset>
				<div class="form-group"> 
				<label for="IQ No" class=" control-label col-md-4 text-left">
                                    {!! SiteHelpers::activeLang('Department', (isset($fields['iq_no']['language'])? $fields['iq_no']['language'] : array())) !!}	
				<span style="color:red;">*</span></label>
				<div class="col-md-6">
                                    <select class="select2 department_id" name="department_id">    </select>
				</div> 
				<div class="col-md-2"></div>
				</div> 							  
                            </fieldset>
			</div>
			
			<div class="col-md-6">
                            <fieldset>
					
                            <div class="form-group"> 
				<label for="IQ No" class=" control-label col-md-4 text-left">
                                    {!! SiteHelpers::activeLang('Year', (isset($fields['iq_no']['language'])? $fields['iq_no']['language'] : array())) !!}	
				</label>
				<div class="col-md-6">
                                    <select name='year' id='year' class='select2 year'>
                                <option value="">--Please Select--</option>
                                             </select>
				</div> 
				<div class="col-md-2"></div>
				</div>	
                            </fieldset>
			</div>
			<div style="clear:both"></div>	
				<br><br>			
			<div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
                                    
					<button type="submit" class="btn btn-primary btn-sm search_view" name="search"><i class="fa  fa-search "></i> Search </button>
                                        
				</div>			
			</div>    
                                <div id="report"></div>
        </div>
            
</div>
<script>
    $(".department_id").jCombo("{{ URL::to('overallmachinereport/customselect?filter=m_department_tbl:department_id:department_name')}}&parent= and department_id!=8"   );
var min = 2010,
max = new Date().getFullYear(),
select = document.getElementById('year');

       for (var i = max; i>=min; i--){
var opt = document.createElement('option');
opt.value = i;
opt.innerHTML = i;
select.appendChild(opt);
					
	}
        $('.tips').tooltip();
        $(".select2").select2('destroy');
	$(".select2").select2({ width:"98%"});
        $('.search_view').click(function(){
            var department_id=$(".department_id").select2("val");
            var year=$(".year").select2("val");
           
            if((department_id == "" && year == "")){
                notyMessageError("Select an option, machine is mandatory");	
            } else if(department_id == "" && year != ""){
                notyMessageError("Machine name is mandatory");
            }
           // alert(machine_id+"  "+year);
        // reloadData( '#{{ $pageModule }}',"{{ $pageUrl }}/search/"+machine_id+'/'+year);
        else {
            if(year==""){
                year="0";
            }
         $.get('consolidationsheet/searchreport/'+department_id+'/'+year,function(data){
           
             $("#report").html(data);
         });
        }
    });
</script>
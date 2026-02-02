
@if($setting['form-method'] =='native')
<h5><u> HOME/BREAKDOWN MAINTENANCE/BREAKDOWN/CONSOLIDATION SHEET</u></h5> 
	<div class="sbox">
		<div class="sbox-title">  
			<h4> <i class="fa fa-table"></i> <?php echo $pageTitle ;?> <small>{{ $pageNote }}</small>
				<a href="javascript:void(0)" class="collapse-close pull-right btn btn-xs btn-danger" onclick="ajaxViewClose('#{{ $pageModule }}')"><i class="fa fa fa-times"></i></a>
			</h4>
	</div>

	<div class="sbox-content"> 
@endif	
			{!! Form::open(array('url'=>'consolidationsheet/save/'.SiteHelpers::encryptID($row['issue_id']), 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ','id'=> 'consolidationsheetFormAjax')) !!}
			<div class="col-md-12">
						<fieldset><legend> Consolidation Sheet</legend>
									
				  <div class="form-group  " > 
					<label for="Issue Id" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Issue Id', (isset($fields['issue_id']['language'])? $fields['issue_id']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('issue_id', $row['issue_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Issue Name" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Issue Name', (isset($fields['issue_name']['language'])? $fields['issue_name']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('issue_name', $row['issue_name'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Machine Id" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Machine Id', (isset($fields['machine_id']['language'])? $fields['machine_id']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('machine_id', $row['machine_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Department Id" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Department Id', (isset($fields['department_id']['language'])? $fields['department_id']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('department_id', $row['department_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Issue Date" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Issue Date', (isset($fields['issue_date']['language'])? $fields['issue_date']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('issue_date', $row['issue_date'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Issue Datetime" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Issue Datetime', (isset($fields['issue_datetime']['language'])? $fields['issue_datetime']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('issue_datetime', $row['issue_datetime'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
				 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Issue Doneat" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Issue Doneat', (isset($fields['issue_doneat']['language'])? $fields['issue_doneat']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('issue_doneat', $row['issue_doneat'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
				 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Description" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Description', (isset($fields['description']['language'])? $fields['description']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  <textarea name='description' rows='5' id='description' class='form-control '  
				           >{{ $row['description'] }}</textarea> 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Issue To" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Issue To', (isset($fields['issue_to']['language'])? $fields['issue_to']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  <textarea name='issue_to' rows='5' id='issue_to' class='form-control '  
				           >{{ $row['issue_to'] }}</textarea> 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Approve Status" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Approve Status', (isset($fields['approve_status']['language'])? $fields['approve_status']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('approve_status', $row['approve_status'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Jo Status" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Jo Status', (isset($fields['jo_status']['language'])? $fields['jo_status']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('jo_status', $row['jo_status'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="CreatedBy" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('CreatedBy', (isset($fields['createdBy']['language'])? $fields['createdBy']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('createdBy', $row['createdBy'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Issue By" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Issue By', (isset($fields['issue_by']['language'])? $fields['issue_by']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('issue_by', $row['issue_by'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Issue Done By" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Issue Done By', (isset($fields['issue_done_by']['language'])? $fields['issue_done_by']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('issue_done_by', $row['issue_done_by'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="UpdatedBy" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('UpdatedBy', (isset($fields['updatedBy']['language'])? $fields['updatedBy']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('updatedBy', $row['updatedBy'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Approved By" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Approved By', (isset($fields['approved_by']['language'])? $fields['approved_by']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('approved_by', $row['approved_by'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Allocated By" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Allocated By', (isset($fields['allocated_by']['language'])? $fields['allocated_by']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('allocated_by', $row['allocated_by'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Reviewed By" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Reviewed By', (isset($fields['reviewed_by']['language'])? $fields['reviewed_by']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('reviewed_by', $row['reviewed_by'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="CreatedOn" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('CreatedOn', (isset($fields['createdOn']['language'])? $fields['createdOn']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('createdOn', $row['createdOn'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
				 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="UpdatedOn" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('UpdatedOn', (isset($fields['updatedOn']['language'])? $fields['updatedOn']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  
				<div class="input-group m-b" style="width:150px !important;">
					{!! Form::text('updatedOn', $row['updatedOn'],array('class'=>'form-control datetime', 'style'=>'width:150px !important;')) !!}
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				</div>
				 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Status" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Status', (isset($fields['status']['language'])? $fields['status']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('status', $row['status'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Amc Status" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Amc Status', (isset($fields['amc_status']['language'])? $fields['amc_status']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('amc_status', $row['amc_status'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Loc Id" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Loc Id', (isset($fields['loc_id']['language'])? $fields['loc_id']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('loc_id', $row['loc_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Org Id" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Org Id', (isset($fields['org_id']['language'])? $fields['org_id']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('org_id', $row['org_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Cmpy Id" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Cmpy Id', (isset($fields['cmpy_id']['language'])? $fields['cmpy_id']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('cmpy_id', $row['cmpy_id'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Breakdowntype Name" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Breakdowntype Name', (isset($fields['breakdowntype_name']['language'])? $fields['breakdowntype_name']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('breakdowntype_name', $row['breakdowntype_name'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Head Approve" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Head Approve', (isset($fields['head_approve']['language'])? $fields['head_approve']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('head_approve', $row['head_approve'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Allocated Engineer" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Allocated Engineer', (isset($fields['allocated_engineer']['language'])? $fields['allocated_engineer']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('allocated_engineer', $row['allocated_engineer'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Expire Date" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Expire Date', (isset($fields['expire_date']['language'])? $fields['expire_date']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('expire_date', $row['expire_date'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Spares Used" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Spares Used', (isset($fields['spares_used']['language'])? $fields['spares_used']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  {!! Form::text('spares_used', $row['spares_used'],array('class'=>'form-control', 'placeholder'=>'',   )) !!} 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Required Spares" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Required Spares', (isset($fields['required_spares']['language'])? $fields['required_spares']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  <textarea name='required_spares' rows='5' id='required_spares' class='form-control '  
				           >{{ $row['required_spares'] }}</textarea> 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Spare Qty" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Spare Qty', (isset($fields['spare_qty']['language'])? $fields['spare_qty']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  <textarea name='spare_qty' rows='5' id='spare_qty' class='form-control '  
				           >{{ $row['spare_qty'] }}</textarea> 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Scheduled Date" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Scheduled Date', (isset($fields['scheduled_date']['language'])? $fields['scheduled_date']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  <textarea name='scheduled_date' rows='5' id='scheduled_date' class='form-control '  
				           >{{ $row['scheduled_date'] }}</textarea> 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> 					
				  <div class="form-group  " > 
					<label for="Eng Description" class=" control-label col-md-4 text-left"> 
					{!! SiteHelpers::activeLang('Eng Description', (isset($fields['eng_description']['language'])? $fields['eng_description']['language'] : array())) !!}	
					</label>
					<div class="col-md-6">
					  <textarea name='eng_description' rows='5' id='eng_description' class='form-control '  
				           >{{ $row['eng_description'] }}</textarea> 
					 </div> 
					 <div class="col-md-2">
					 	
					 </div>
				  </div> </fieldset>
			</div>
			
												
								
						
			<div style="clear:both"></div>	
							
			<div class="form-group">
				<label class="col-sm-4 text-right">&nbsp;</label>
				<div class="col-sm-8">	
					<button type="submit" class="btn btn-primary btn-sm "><i class="fa  fa-save "></i>  {{ Lang::get('core.sb_save') }} </button>
					<button type="button" onclick="ajaxViewClose('#{{ $pageModule }}')" class="btn btn-success btn-sm"><i class="fa  fa-arrow-circle-left "></i>  {{ Lang::get('core.sb_cancel') }} </button>
				</div>			
			</div> 		 
			{!! Form::close() !!}


@if($setting['form-method'] =='native')
	</div>	
</div>	
@endif	

	
</div>	
			 
<script type="text/javascript">
$(document).ready(function() { 
	 
	
	$('.editor').summernote();
	$('.previewImage').fancybox();	
	$('.tips').tooltip();	
	$(".select2").select2({ width:"98%"});	
	$('.date').datepicker({format:'yyyy-mm-dd',autoClose:true})
	$('.datetime').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'}); 
	$('input[type="checkbox"],input[type="radio"]').iCheck({
		checkboxClass: 'icheckbox_square-green',
		radioClass: 'iradio_square-green',
	});			
	$('.removeCurrentFiles').on('click',function(){
		var removeUrl = $(this).attr('href');
		$.get(removeUrl,function(response){});
		$(this).parent('div').empty();	
		return false;
	});			
	var form = $('#consolidationsheetFormAjax'); 
	form.parsley();
	form.submit(function(){
		
		if(form.parsley('isValid') == true){			
			var options = { 
				dataType:      'json', 
				beforeSubmit :  showRequest,
				success:       showResponse  
			}  
			$(this).ajaxSubmit(options); 
			return false;
						
		} else {
			return false;
		}		
	
	});

});

function showRequest()
{
	$('.ajaxLoading').show();		
}  
function showResponse(data)  {		
	
	if(data.status == 'success')
	{
		ajaxViewClose('#{{ $pageModule }}');
		ajaxFilter('#{{ $pageModule }}','{{ $pageUrl }}/data');
		notyMessage(data.message);	
		$('#sximo-modal').modal('hide');	
	} else {
		notyMessageError(data.message);	
		$('.ajaxLoading').hide();
		return false;
	}	
}			 

</script>		 
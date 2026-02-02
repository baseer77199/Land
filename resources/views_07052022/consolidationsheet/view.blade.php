@if($setting['view-method'] =='native')
<h5><u> HOME/BREAKDOWN MAINTENANCE/BREAKDOWN/CONSOLIDATION SHEET</u></h5> 
<div class="sbox">
	<div class="sbox-title">  
		<h4> <i class="fa fa-table"></i> <?php echo $pageTitle ;?> <small>{{ $pageNote }}</small>
			<a href="javascript:void(0)" class="collapse-close pull-right btn btn-xs btn-danger" onclick="ajaxViewClose('#{{ $pageModule }}')">
			<i class="fa fa fa-times"></i></a>
		</h4>
	 </div>

	<div class="sbox-content"> 
@endif	 

		<table class="table table-striped table-bordered" >
			<tbody>	
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Issue Id', (isset($fields['issue_id']['language'])? $fields['issue_id']['language'] : array())) }}	
						</td>
						<td>{{ $row->issue_id }} </td>
						
					</tr>
				 
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Issue Name', (isset($fields['issue_name']['language'])? $fields['issue_name']['language'] : array())) }}	
						</td>
						<td>{{ $row->issue_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Machine Id', (isset($fields['machine_id']['language'])? $fields['machine_id']['language'] : array())) }}	
						</td>
						<td>{{ $row->machine_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Department Id', (isset($fields['department_id']['language'])? $fields['department_id']['language'] : array())) }}	
						</td>
						<td>{{ $row->department_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Issue Date', (isset($fields['issue_date']['language'])? $fields['issue_date']['language'] : array())) }}	
						</td>
						<td>{{ $row->issue_date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Issue Datetime', (isset($fields['issue_datetime']['language'])? $fields['issue_datetime']['language'] : array())) }}	
						</td>
						<td>{{ $row->issue_datetime }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Issue Doneat', (isset($fields['issue_doneat']['language'])? $fields['issue_doneat']['language'] : array())) }}	
						</td>
						<td>{{ $row->issue_doneat }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Description', (isset($fields['description']['language'])? $fields['description']['language'] : array())) }}	
						</td>
						<td>{{ $row->description }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Issue To', (isset($fields['issue_to']['language'])? $fields['issue_to']['language'] : array())) }}	
						</td>
						<td>{{ $row->issue_to }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Approve Status', (isset($fields['approve_status']['language'])? $fields['approve_status']['language'] : array())) }}	
						</td>
						<td>{{ $row->approve_status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Jo Status', (isset($fields['jo_status']['language'])? $fields['jo_status']['language'] : array())) }}	
						</td>
						<td>{{ $row->jo_status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('CreatedBy', (isset($fields['createdBy']['language'])? $fields['createdBy']['language'] : array())) }}	
						</td>
						<td>{{ $row->createdBy }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Issue By', (isset($fields['issue_by']['language'])? $fields['issue_by']['language'] : array())) }}	
						</td>
						<td>{{ $row->issue_by }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Issue Done By', (isset($fields['issue_done_by']['language'])? $fields['issue_done_by']['language'] : array())) }}	
						</td>
						<td>{{ $row->issue_done_by }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('UpdatedBy', (isset($fields['updatedBy']['language'])? $fields['updatedBy']['language'] : array())) }}	
						</td>
						<td>{{ $row->updatedBy }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Approved By', (isset($fields['approved_by']['language'])? $fields['approved_by']['language'] : array())) }}	
						</td>
						<td>{{ $row->approved_by }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Allocated By', (isset($fields['allocated_by']['language'])? $fields['allocated_by']['language'] : array())) }}	
						</td>
						<td>{{ $row->allocated_by }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Reviewed By', (isset($fields['reviewed_by']['language'])? $fields['reviewed_by']['language'] : array())) }}	
						</td>
						<td>{{ $row->reviewed_by }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('CreatedOn', (isset($fields['createdOn']['language'])? $fields['createdOn']['language'] : array())) }}	
						</td>
						<td>{{ $row->createdOn }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('UpdatedOn', (isset($fields['updatedOn']['language'])? $fields['updatedOn']['language'] : array())) }}	
						</td>
						<td>{{ $row->updatedOn }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Status', (isset($fields['status']['language'])? $fields['status']['language'] : array())) }}	
						</td>
						<td>{{ $row->status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Amc Status', (isset($fields['amc_status']['language'])? $fields['amc_status']['language'] : array())) }}	
						</td>
						<td>{{ $row->amc_status }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Loc Id', (isset($fields['loc_id']['language'])? $fields['loc_id']['language'] : array())) }}	
						</td>
						<td>{{ $row->loc_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Org Id', (isset($fields['org_id']['language'])? $fields['org_id']['language'] : array())) }}	
						</td>
						<td>{{ $row->org_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Cmpy Id', (isset($fields['cmpy_id']['language'])? $fields['cmpy_id']['language'] : array())) }}	
						</td>
						<td>{{ $row->cmpy_id }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Breakdowntype Name', (isset($fields['breakdowntype_name']['language'])? $fields['breakdowntype_name']['language'] : array())) }}	
						</td>
						<td>{{ $row->breakdowntype_name }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Head Approve', (isset($fields['head_approve']['language'])? $fields['head_approve']['language'] : array())) }}	
						</td>
						<td>{{ $row->head_approve }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Allocated Engineer', (isset($fields['allocated_engineer']['language'])? $fields['allocated_engineer']['language'] : array())) }}	
						</td>
						<td>{{ $row->allocated_engineer }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Expire Date', (isset($fields['expire_date']['language'])? $fields['expire_date']['language'] : array())) }}	
						</td>
						<td>{{ $row->expire_date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Spares Used', (isset($fields['spares_used']['language'])? $fields['spares_used']['language'] : array())) }}	
						</td>
						<td>{{ $row->spares_used }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Required Spares', (isset($fields['required_spares']['language'])? $fields['required_spares']['language'] : array())) }}	
						</td>
						<td>{{ $row->required_spares }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Spare Qty', (isset($fields['spare_qty']['language'])? $fields['spare_qty']['language'] : array())) }}	
						</td>
						<td>{{ $row->spare_qty }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Scheduled Date', (isset($fields['scheduled_date']['language'])? $fields['scheduled_date']['language'] : array())) }}	
						</td>
						<td>{{ $row->scheduled_date }} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>
							{{ SiteHelpers::activeLang('Eng Description', (isset($fields['eng_description']['language'])? $fields['eng_description']['language'] : array())) }}	
						</td>
						<td>{{ $row->eng_description }} </td>
						
					</tr>
				
			</tbody>	
		</table>  
			
		 	

@if($setting['form-method'] =='native')
	</div>	
</div>	
@endif	

<script>
$(document).ready(function(){

});
</script>	
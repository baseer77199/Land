<!--to display saved records-->
@extends('layouts.header')
@section('content')
   <form>
			{{ csrf_field() }}
			
				<div class="card">

					
					<span class="ui_close_btn"><a href="{{ URL::to('documents') }}" class="collapse-close pull-right btn-danger"></a></span>
				<div class="card-body card-block normalform">
	<div class="row">
    <div class="col-md-12">

        <div class="invoice-box" id="section-to-print">

            <table cellpadding="0" cellspacing="0">
                <tbody>

                    <h2 class="heads1">Calibration Details</h2>

                    <tr class="information">
                        <td colspan="6">
                            <table>
                                <tbody>

                                    <tr>
                                        <td>
                                            <p><b>Frequency:</b>{!! $header->frequency!!} </p>
                                            <br> 
                                             <p><b>Valid From:</b>{!! $header->valid_from !!}</p>
                                            <br> 
                                             </td>
                                         <td>
                                             <p><b>Valid To:</b>{!! $header->valid_to !!}</p>
                                            <br> 
                                             <p><b>Department Name:</b>{!! $header->department_name !!}</p> 
                                          <br>
                                           </td>
                                         <td>
                                           
                                          <p><b>Renewal Date:</b>{!! $header->renewal_date !!}</p>
                                            <br> 
                                          <p><b>Remainder Days:</b>{!! $header->remainder_days !!}</p>
                                            <br> 
                                        </td>
                                         <td>
                                         
                                          <p><b>Frequency Name:</b>{!! $header->frequency_name !!}</p>
                                            <br> 
                                          <p><b>Description:</b>{!! $header->description !!}</p>
                                            <br> 
                                        </td>
                                      <tr>  
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                </tbody>
            </table>
        </div>

    </div>

</div>
</div>
</div>
</form>
@endsection



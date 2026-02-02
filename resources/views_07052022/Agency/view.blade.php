<!--to display saved records-->
@extends('layouts.header')
@section('content')
   <form>
			{{ csrf_field() }}
			
				<div class="card">

					
					<span class="ui_close_btn"><a href="{{ URL::to('agency') }}" class="collapse-close pull-right btn-danger"></a></span>
				<div class="card-body card-block normalform">
	<div class="row">
    <div class="col-md-12">

        <div class="invoice-box" id="section-to-print">

            <table cellpadding="0" cellspacing="0">
                <tbody>

                    <h2 class="heads1">Agency Details</h2>

                    <tr class="information">
                        <td colspan="6">
                            <table>
                                <tbody>

                                    <tr>
                                        <td>
                                            <p><b>Agency Name:</b>{!! $header->agency_name!!} </p>
                                            <br>
                                           <p><b>Mobile No:</b>{!! $header->mobile_no!!} </p>
                                            <br> 
                                             <p><b>Country:</b>{!! $header->state_name !!}</p>
                                            <br> 
                                             </td>
                                         <td>
                                             <p><b>State:</b>{!! $header->state_name !!}</p>
                                            <br> 
                                             <p><b>City:</b>{!! $header->state_name !!}</p>
                                            <br> 
                                        
                                          <p><b>Email:</b>{!! $header->email!!} </p>
	                                      <br>
                                           </td>
                                         <td>
                                           <p><b>Address:</b>{!! $header->address !!}</p> 
                                          <br>
                                          <p><b>Active:</b>{!! $header->active !!}</p>
                                            <br> 
                                          <p><b>Created By:</b> </p> 

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



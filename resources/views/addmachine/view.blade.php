@extends('layouts.header')
@section('content')
<style type="text/css">

    .invoice-box table td {
   padding: 10px;
  
}
</style>

{{ csrf_field() }}


<div class="card">


<div class="card-header">

<span class="ui_close_btn"><a class="collapse-close pull-right btn-danger closeurl" href="{{URL::to('addmachine')}}" ></a></span>
</div>



<div class="card-body card-block normalform">


<div class="row">
<div class="col-md-12">

<div class="invoice-box" id="section-to-print">

    <table cellpadding="0" cellspacing="0">
        <tbody>

            <h2 class="heads1">MACHINE</h2>

            <tr class="information">
                <td colspan="6">
                    <table>
                        <tbody>

                            <tr>
                                <td>
                                    <p><b>Machine Number:</b>{!!$header->machine_no !!}</p>
                                    <br>
                                    <p><b>Machine Name:</b>{!!$header->machine_name !!} </p>
                                    <br>
                                  <p><b>Department Name:</b>{!!$header->department_name !!}  </p>
                                    <br>
                                     <p><b>Machine Capacity:</b>{!!$header->machine_name !!} </p>
                                      <br>
                                     <p><b>Asset Code:</b>{!!$header->asset_code!!} </p>
                                    <br>    
                                </td>
                                <td >
                       <p><b>Location:</b>{!!$header->location!!}</p>
                                    <br>
  <p><b>Relocated Date::</b> {!! date(\Session::get('p_date_format'),strtotime($header->relocated_date)) !!}</p>
                                    <br>
    <p><b>Purchased Date::</b> {!! date(\Session::get('p_date_format'),strtotime($header->purchased_date)) !!}</p>
                    </br>
                      <p><b>Machine Make:</b>{!!$header->machine_make!!}</p>
                                    <br>
                        <p><b>Created By:</b>{!!$header->username!!}</p>
                        <br>
                                </td>
<td>
                        <p><b>Machine Remarks:</b>{!!$header->remarks!!}</p>
                         <br>

                        <p><b>Machine Cost:</b>{!!$header->cost!!}</p>
                                    <br>             
                                </td>
                            </tr>

                            <tr>
                                <td colspan="6" class="ref">
                                    <h4 class="head-style-1">Vendor Details</h4></td>
                            </tr>



                            <tr>
                                <td>
                                    <p><b>Vendor:</b> {!!$header->vendorname!!}</p>
                   <br>
                    <p><b>From Date::</b> {!! date(\Session::get('p_date_format'),strtotime($header->from_date)) !!}</p>
                                    <br>
                  <p><b>Renewal Date::</b> {!! date(\Session::get('p_date_format'),strtotime($header->renewal_date)) !!}</p>  
                                    <br>
                                 
                                   
      
                                </td>
                       <td>
                <p><b>AMC Vendor:</b>{!!$header->amcvendor!!} </p>
                                  
                                    <br>
         <p><b>To Date::</b> {!! date(\Session::get('p_date_format'),strtotime($header->to_date)) !!}</p>  
                          <br>
          
                                </td>
                             
                            </tr>
                            <tr>
                            </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="heading">
                <table class="table table-bordered table-hover ">
    <thead>
      <tr>
      <th>Line No</th>
      <th>Frequency</th>
      <th>Date</th>
      </tr>
      </thead>
<tbody>
  <?php foreach ($linesdata as $key => $value): ?>
<tr>
     <td>{!! $key+1 !!}</td>
     <td>{!!$value->frequency_id!!} </td>
     <td>
      {!! date(\Session::get('p_date_format'),strtotime($value->frequency_date)) !!}
   </td>

     
   </tr>
  <?php endforeach; ?>

</tbody>
                </table>
            </tr>

        </tbody>
    </table>
</div>



  
</div>  
</div>



</div>

</div>

@endsection
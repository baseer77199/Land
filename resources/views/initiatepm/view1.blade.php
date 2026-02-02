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

<span class="ui_close_btn"><a class="collapse-close pull-right btn-danger closeurl" href="{{URL::to('initiatepmreschedule')}}" ></a></span>
</div>



<div class="card-body card-block normalform">


<div class="row">
<div class="col-md-12">

<div class="invoice-box" id="section-to-print">

    <table cellpadding="0" cellspacing="0">
        <tbody>

            <h2 class="heads1">Initiate PM Details</h2>

            <tr class="information">
                <td colspan="6">
                    <table>
                        <tbody>

                            <tr>
                                <td>
                                   <p><b>Department Name:</b>{!!$header->department_name !!}  </p>
                                    <br>
                                </td>
                                <td >
                       <p><b>Machine Name:</b>{!!$header->asset_code !!}-{!!$header->machine_name !!} </p> <br>
                                </td>
                              <td>
                         <p><b>Frequency Name:</b>{!!$header->frequency_name!!}</p>
                         <br>
            </td>
                            </tr>
                              <tr>
                                <td>
                                   <p><b>Machine Number:</b>{!!$header->machine_no !!}  </p>
                                    <br>
                                </td>
                                <td >
                       <p><b>Actual PM Date:</b>{!!$header->actual_pm_date !!} </p> <br>
                                </td>
                              <td>
                         <p><b>Initiate PM Date:</b>{!!$header->initiate_date!!}</p>
                         <br>
            </td>
                            </tr>
                            <tr>
                                <td>
                                   <p><b>PM No:</b>{!!$header->pm_no !!}  </p>
                                    <br>
                                </td>
                                <td >
                       <p><b>User Department Clearance:</b>{!!$user !!} </p> <br>
                                </td>
                           
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
          

        </tbody>
    </table>
</div>



  
</div>  
</div>



</div>

</div>

@endsection
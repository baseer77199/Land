@extends('layouts.header')
@section('content')
<style type="text/css">
    .heads1{
        width: 100%;
    }
</style>

 



<form>

<div class="card">
<div class="card-header">
 <span class="ui_close_btn"><a class="collapse-close pull-right btn-danger closeurl active1" href="{{ URL::to('sopupload') }}"></a></span>
<div class="card-body card-block normalform">
    
   <div class="row">
    <div class="col-md-12">
        
        <div class="invoice-box" id="section-to-print">

            <table cellpadding="0" cellspacing="0">

 


                <tbody >
                
                 <h2 class="heads1">Sop Details</h2> 
                   <tr class="information">
                        <td colspan="6">
                            <table>
                                <tbody>

                                    <tr>
                                        <td>
                                            <p><b>Ticket Number:</b>{!! $ticket_number !!}</p>
                                            <br><br>
                                            <p><b>Department:</b> {!! $department_name !!}</p>
                                            <br><br>
                                            <p><b>Machine:</b> {!! $machine_name !!}</p>
                                            <br><br>
                                            <p><b>Breakdown Type:</b> {!! $breakdown_name !!}</p>
                                            <br> <br>
                                            
                                        </td>
										 <td>
                                            <p><b>Issue Date:</b> {!! $issue_date !!}</p>
                                            <br><br>
                                            <p><b>Causes of Breakdown:</b> {!! $causes !!}</p>
                                            <br><br>
                                            <p><b>Breakdown Severity:</b> {!! $severity_name !!}</p>
                                            <br><br>
                                             <p><b>Preventive Action:</b>{!! $preventive_action !!}</p>  
                                             <br><br>
                                        </td>
                                        <td>
                                             <p><b>Maintenance Type:</b> {!! $maintenance_type !!}</p>
                                             <br><br>
                                             <p><b>Is Breakdown ?</b> {!! $is_breakdown !!}</p>
                                             <br><br>
                                              <p><b>Repair Start Date</b> {!! $start_date !!}</p>
                                             <br><br>
                                              <p><b>Repair End Date</b> {!! $end_date !!}</p>
                                             <br><br>
                                        </td>


                                        <td>
                                             <p><b>Allocate Engineer:</b> {!! $e_name !!}</p>
                                             <br><br>
                                             <p><b>Allocate Technician:</b> {!! $t_name !!}</p>
                                             <br><br>
                                             <p><b>Error Code:</b> {!!$error_code !!}</p>
                                             <br><br>
                                             <p><b>Shift:</b> {!!$shift !!}</p>
                                             <br><br>
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



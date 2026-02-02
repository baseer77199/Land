@extends('layouts.header')
@section('content')



<form>

<div class="card">
<div class="card-header">
<h2>Vendor Details</h2> 
<span class="ui_close_btn"><a href="{{url('vendor')}}" class="collapse-close pull-right btn-danger" onclick='location.href="{{url('vendor')}}"'></a></span>
</div>
<div class="card-body card-block normalform">
    <div class="row">
    <div class="col-md-12">

        <div class="invoice-box" id="section-to-print">

            <table cellpadding="0" cellspacing="0">
                <tbody>

                    <h2 class="heads1">Vendor Details</h2>

                    <tr class="information">
                        <td colspan="6">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>
                                            <p><b>Vendor Name:</b> {{$headerdata->vendor_name }}</p>
                                            <br>
                                            <p><b>Address:</b> {{ $headerdata->address }}</p>
                                            <br>
                                        </td>
                                        <td class="text-right">
                                             <p><b>Mail Id:</b> {{ $headerdata->email_id }}</p>
                                            <br>
                                            <p><b>Contact No:</b> {{ $headerdata->contact_no }}</p>
                                            <br>
                                            <p><b>Active:</b> {{ $headerdata->active }}</p>
                                            <br>
                                            
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
</form>
@endsection













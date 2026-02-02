@extends('layouts.header')
@section('content')



<form>

<div class="card">
<div class="card-header">
<h2>Company Details</h2> 
<span class="ui_close_btn"><a href="../company" class="collapse-close pull-right btn-danger" onclick='location.href="{{ url($pageModule) }}"'></a></span>
</div>
<div class="card-body card-block normalform">
    <div class="row">
    <div class="col-md-12">

        <div class="invoice-box" id="section-to-print">

            <table cellpadding="0" cellspacing="0">
                <tbody>

                    <h2 class="heads1">Company Details</h2>

                    <tr class="information">
                        <td colspan="6">
                            <table>
                                <tbody>

                                    <tr>
                                        <td>
                                            <p><b>Company Name:</b> {{$headerdata->company_name }}</p>
                                            <br>
                                            <p><b>Company Code:</b> {{ $headerdata->company_code }}</p>
                                            <br>
                                            <p><b>Website Address:</b> {{ $headerdata->website_address }}</p>
                                            <br>
                                            <p><b>Email Id:</b> {{ $headerdata->email_id }}</p>
                                            <br>
                                            <p><b>Contact No:</b> {{ $headerdata->contact_no }}</p>
                                            <br>
                                            <p><b>GST No:</b> {{$headerdata->gst_no }}</p>
                                            <br>

                                        </td>
                                        <td class="text-right">
                                            <p><b>Service Tax Reg No:</b> {{ $headerdata->tax_reg_no }}</p>
                                            <br>
                                            <p><b>Excise Reg No:</b> {{ $headerdata->excise_registration_no }}</p>
                                            <br>
                                            <p><b>CIN No:</b> {{ $headerdata->cin_no }}</p>
                                            <br>
                                            <p><b>Pan No:</b> {{ $headerdata->pan_no }}</p>
                                            <br>
                                            <p><b>Active:</b> {{ $headerdata->active }}</p>
                                            <br>
                                            
                                        </td>
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
                                <th>Location Name</th>
                                <th>Description</th>
                                
                                </tr>
                                </thead>
                    <tbody>
                        <?php foreach ($linesdata as $key => $value): ?>
                    <tr>
                         <td>{!! $key+1 !!}</td>
                         <td>{!! $value->location_name !!}</td>
                         <td>{!! $value->description !!}</td>
                        
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
</form>
@endsection













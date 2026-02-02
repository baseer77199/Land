@extends('layouts.header')
@section('content')
<form>
{{ csrf_field() }}
<div class="card">
<div class="card-header">
<span class="ui_close_btn"><a href="../lookup" class="collapse-close pull-right btn-danger" onclick="../lookup"></a></span>
</div>
<div class="card-body card-block normalform">
    <div class="row">
    <div class="col-md-12">

        <div class="invoice-box" id="section-to-print">

            <table cellpadding="0" cellspacing="0">
                <tbody>

                    <h2 class="heads1">Common Lookup Details</h2>

                    <tr class="information">
                        <td colspan="6">
                            <table>
                                <tbody>

                                    <tr>
                                   
                                        <td class="text-centre">
                                              <p><b>Field Option:</b> {!!$vdata[0]->lookup_type !!}</p>
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
								<th>Field Option</th>
								<th>Field Option Meaning</th>
								<th>Active</th>
								</tr>
								</thead>
					<tbody>
						<?php foreach ($vlinesdata as $key => $value): ?>
					<tr>
					     <td>{!! $key+1 !!}</td>
					     <td>{!! $value->lookup_code !!}</td>
					     <td>{!! $value->lookup_meaning !!}</td>
					      <td>{!! $value->active !!}</td>
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













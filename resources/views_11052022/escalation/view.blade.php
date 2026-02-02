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

<span class="ui_close_btn"><a class="collapse-close pull-right btn-danger closeurl" href="{{URL::to('pmchecksheet')}}" ></a></span>
</div>



<div class="card-body card-block normalform">


<div class="row">
<div class="col-md-12">

<div class="invoice-box" id="section-to-print">

    <table cellpadding="0" cellspacing="0">
        <tbody>

            <h2 class="heads1">Machine Checklist</h2>

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
                       <p><b>Machine Name:</b>{!!$header->machine_name !!} </p> <br>
                                </td>
                              <td>
                         <p><b>Frequency Name:</b>{!!$header->frequency_name!!}</p>
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
      <th>Checklist</th>
      </tr>
      </thead>
<tbody>
  <?php foreach ($linesdata as $key => $value): ?>
<tr>
     <td>{!! $key+1 !!}</td>
     <td>{!!$value->checklist_name!!} </td>
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
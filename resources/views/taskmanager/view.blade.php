@extends('layouts.header')
@section('content')

<form>
    {{ csrf_field() }}
    
    <div class="card">
        <div class="card-header">
            <span class="ui_close_btn">  <a href="../taskmanager" class="collapse-close pull-right btn btn-xs btn-danger" onclick="taskmanager"></a></span>
        </div>

        <div class="card-body card-block">   
        <div class="row">
        <div class="col-md-12">



<div class="invoice-box" id="section-to-print">

    <table cellpadding="0" cellspacing="0">
        <tbody>

            <h2 class="heads1">Taskmanager Details</h2>

            <tr class="information">
                <td colspan="6">
                    <table>

                        <tbody>

                            <tr>
                                <td>
                                    <p><b>Department:</b>{{ $department }}</p> <br>
                                    <p><b>Start Date:</b>{{$taskmanager->start_date}}</p> <br>
                                    <p><b>Department Lead:</b>{{$department_lead}}</p> <br>
                                    <p><b>Created By:</b> {{ $created_by }}</p> <br>                                    
                                </td>
                                <td class="text-right">
                                    
                                    <p><b>Assigned To:</b> {{$assigned_to }}</p> <br>
                                    <p><b>End Date:</b>{{$taskmanager->end_date}}</p> <br>
                                    <p><b>Task:</b> {{$taskmanager->task }}</p> <br>
                                    <p><b>Description:</b> {{$taskmanager->description }}</p> <br>
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


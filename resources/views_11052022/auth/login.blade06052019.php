@extends('layouts_login.app')

@section('content')

 <div class="row">   
<div class="col-md-4 " >
            <div class="panel panel-default">
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                           <div class="form-group{{ $errors->has('employee_number') ? ' has-error' : '' }}">
                            <label for="employee_number" class="control-label">Employee Number</label>

                            <div>
                                <input id="employee_number" type="text" class="form-control" name="employee_number" 
                                value="{{ old('employee_number') }}" required autofocus style="color:#fff;font-weight:bolder;background: url(images/doctor.png);">

                                @if ($errors->has('employee_number'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('employee_number') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="control-label">Password</label>

                            <div>
                                <input id="password" type="password" class="form-control" name="password" required style="color:#fff;font-weight:bolder;background: url(images/key.png);" >

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        
                        <div class="form-group{{ $errors->has('company_id') ? ' has-error' : '' }}">
                            <label for="company" class="control-label">Company</label>

                            <div>
                                <select name='company_id' rows='5' class='form-control company_id select2'  data-show-subtext="true" data-live-search="true"  required>
              
               
                                {!! config('global.CONT')->jCombologin('m_company_t','company_id','company_name','')!!}
								</select>
                                @if ($errors->has('company_id'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('company_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        
                        
                        
                        <div class="form-group">

                        <div class="c-checkbox">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span class="check_mark"></span> <label class="loginlink"> Remember Me</label></div>

                            


                        </div>

                        <div class="form-group">
                            <center>
                                <button type="submit" class="btn btn-primary custom">
                                    Login
                                </button><br>
                                <a class="loginlink" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
                            </center>
                           
                        </div>
                    </form>
                </div>
                 <div class="panel-footer text-center" style="color:#fff;font-weight: bolder;font-size: 13px;text-shadow: 0px 1px 1px rgba(0,0,0,1)">Powered By <img src="{{ asset('images/logo.png') }}" style="width: 45px;height: 35px !important;vertical-align: baseline;"> i Five Technology Pvt Ltd</div>
            
            </div>
        </div>
        <div class="col-md-8 ">
           <div id="player-overlay">
               <video   autoplay="autoplay"  muted="muted"  loop class="fullscreen-bg__video" >
                <source src="{{asset('video/homepage_video.webm')}}" type="video/webm">
                 <source src="{{asset('video/homepage_video.mp4')}}" type="video/mp4">   
            </video>
               </div>      
        
        </div>
 </div>
   




    


<script>
	(function(){
	$(".company_id").jCombologin("{{ URL::to('jcomboform?table=m_company_t:company_id:company_name')}}&order_by=company_name asc",
	 		{selected_value:""});
	});
    
</script>
<script>


</script>
@endsection

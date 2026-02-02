@extends('layouts_login.app')

@section('content')

    
            <div class="panel panel-default" style="width:38%;">
                <div class="panel-heading" style="color:#fff;">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}
                        <div class="row">
                        <div class="col-md-12">

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }} row">
                            <label for="email" class="col-md-5 form-control-label">E-Mail Address</label>

                            <div class="col-md-7">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
</div>
                                <div class="row">
<div class="col-md-12">
                        <div class="form-group row">
                           <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                         
                    </form>
                </div>
            </div>
       

@endsection

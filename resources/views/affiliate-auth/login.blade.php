@extends('_layouts.guest')

@section('content')
<!-- BEGIN LOGIN FORM -->
<form class="login-form" action="{{ url('affiliate-user/login') }}" method="post">
    {{ csrf_field() }}
    <h3 class="form-title">Affiliates Sign in</h3>
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button>
        <span>Enter email and password. </span>
    </div>
    @if (isset($errors) && ($errors->has('email') or $errors->has('password')))
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span>User or password is incorrect.</span>
        </div>
    @endif
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}" autofocus/>
    </div>
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" />
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-success uppercase">Login</button>
        <label class="rememberme check">
            <input type="checkbox" name="remember" value="1" />Remember
        </label>

    </div>
    <div class="create-account">
        <p>
            <a href="javascript:;" id="forget-password" class="forget-password uppercase">Forgot Password?</a>
        </p>
    </div>
</form>

<form class="forget-form" action="{{ url('/password/email') }}" method="post">
    {{ csrf_field() }}
    <h3>Forget Password ?</h3>
    <p>
        Enter your e-mail address below to reset your password.
    </p>
    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}" />
    </div>
    <div class="form-actions">
        <button type="button" id="back-btn" class="btn btn-default">Back</button>
        <button type="submit" class="btn btn-success uppercase pull-right">Send Password Reset Link</button>
    </div>
</form>
<!-- END FORGOT PASSWORD FORM -->
@endsection

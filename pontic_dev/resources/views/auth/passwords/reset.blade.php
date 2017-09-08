@extends('layouts.app')

@section('content')


<div class="topBackBtnSec"><a href="{{ url('/') }}"><i class="material-icons">keyboard_arrow_left</i></a></div>

<div class="loginBgSec">
    <div class="logoSec"> <img src="{{ secure_url('images/logo-login.png') }}" /> </div>
    <div class="loginFormSec card">
        <form  method="POST" action="{{ url('/password/reset') }}">
            {{ csrf_field() }}
            <input type="hidden" name="token" value="{{ $token }}">
            <input  type="hidden" name="email" value="{{ $email or old('email') }}">

            <div class="loginRows">
                <div class="input-field">
                    <input class="validate" type="password" id="password" name="password" value="{{ old('password') }}" />
                    <label for="password">Password</label>
                </div>


                @if ($errors->has('password'))
                <div class="errorMessage">
                    {{ $errors->first('password') }}
                </div>
                @endif
            </div>   
            <div class="loginRows">
                <div class="input-field">
                    <input class="validate" type="password" id="password_confirmation" name="password_confirmation"  value="{{ old('password_confirmation') }}"/>
                    <label for="password_confirmation">Confirm password</label>
                </div>


                @if ($errors->has('password_confirmation'))
                <div class="errorMessage">
                    {{ $errors->first('password_confirmation') }}
                </div>
                @endif
            </div> 
            <!--Error Message Start-->
            <div class="errorMessage" style="display:none;">Incorrect password.</div>
            <!--Error Message End-->
            <div class="clear"></div>
            <div class="loginRows submitBtnSec">
                <input type="submit" value="Reset password" class="waves-effect waves-light btn" />

            </div>
        </form>

    </div>



</div>                                                 

@endsection


@section('script')

@endsection


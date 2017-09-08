@extends('layouts.app')

@section('content')
<div class="loginBgSec">
    <div class="mainBgColor">
       
        <div class="loginFormSec card">
          <div class="logoSec">
            <img src="{{ secure_url('images/logo-login.png') }}" />
        </div>
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">

                <div class="loginBoxBg">
                    <div class="fieldSec">
                        @if (session('warning'))
                        <div class="row createFormText textCenter">
                            {!! session('warning') !!}
                        </div>
                        @endif

                        {{ csrf_field() }}

                        <div class="row">
                            <div class="input-field userNameRow">
            					<i class="material-icons">email</i> 
                                <input class="validate" type="text" id="email" name="email" value="{{ old('email') }}" />
                                <label for="email">Email address</label>
                            </div>
                            @if ($errors->has('email'))
                            <div class="errorMessage">
                                {{ $errors->first('email') }}
                            </div>
                            @endif

                        </div>
                        <div class="row">
                            <div class="loginRows passWordRow">
                                <div class="input-field">
            						<i class="material-icons">lock</i>
                                    <input class="validate" type="password" id="password" name="password" value="{{ old('password') }}" />
                                    <label for="password">Password</label>
                                </div>
                            </div>


                            @if ($errors->has('password'))

                            <div class="errorMessage">

                                {{ $errors->first('password') }}
                            </div>

                            @endif


                        </div>
                        <div class="rmbrPassSec">
                            <input type="checkbox" class="filled-in" id="filled-in-box" checked="checked">
                            <label for="filled-in-box">Remember password?</label>
                        </div>
                        <div class="loginRows">

                            <input type="submit" value="Login" class="waves-effect waves-light btn inputBtn" />

                        </div>
                        <div class="forgotPasswordSec">
                            <div class="loginForgotPassLink"><a href="{{ url('/password/reset') }}">Forgot password?</a></div>
                            <div class="clear"></div>
                        </div>
                        <div class="loginOrLine">
                            <div class="lineFirst"></div>
                            <div class="orTextSec">or</div>
                            <div class="lineLast"></div>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>

                        <div class="clear dividerLine"></div>
                        <div class="clear"></div>
                        <div class="loginRows">
                            <a href="{{ url('/register') }}" class="waves-effect waves-light btn createAccBtnSec">Create an account</a>
                        </div>
                    </div>
                </div>

            </form>

        </div>


        <div class="popUpSecMain">
            <div class="popUpSec">
                <div class="employeesFormSec">
                    <div class="clear">&nbsp;</div>
                    <div class="row">
                        <div class="col12 textCenter">
                            @if (session('status'))
                             {{ session('status') }}
                            @endif
                        </div>
                    </div>

                    <div class="clear">&nbsp;</div>

                    <div class="row">
                        <div class="popBtnSec floatRight"><input type="button" class="submitBtn loginPage okBtn" onclick="closePopUp()" value="Ok" /></div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
	
	<div class="footerContentSec">
        	<a class="modal-trigger" href="#modal1">Terms and Conditions</a> and <a class="modal-trigger" href="#modal2">Privacy Policy</a>
            <div class="clear"></div>
            <a title="DMCA.com Protection Status" class="dmca-badge" href="https://www.dmca.com/Protection/Status.aspx?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"> 
            <img alt="DMCA.com Protection Status" src="https://images.dmca.com/Badges/dmca_protected_sml_120k.png?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"></a>
            <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
        </div>
</div>

@include('includes.terms')

@endsection


@section('script')

@if (session('status'))
<script>
    $(document).ready(function () {
        // executes when HTML-Document is loaded and DOM is ready
        $('.popUpSecMain').show();
    });
</script>
@endif

<script>


    function closePopUp() {
        $('.popUpSecMain').hide();
    }

</script>

@endsection

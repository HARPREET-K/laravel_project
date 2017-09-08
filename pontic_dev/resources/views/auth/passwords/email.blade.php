@extends('layouts.app')

@section('content')

<div class="topBackBtnSec"><a href="{{ secure_url('/home') }}"><i class="material-icons">keyboard_arrow_left</i></a></div>
<div class="loginBgSec">         

    <div class="logoSec"> <img src="{{ secure_url('images/logo-login.png') }}" /> </div>
    <div class="loginFormSec card">
        <form method="POST" action="{{ secure_url('/password/email') }}">

            {{ csrf_field() }}
 
            <div class="loginRows">
                <div class="input-field">
                    <input class="validate" type="text" id="email" name="email" value="{{ old('email') }}" />
                    <label for="email">Enter your email</label>
                </div>


                @if ($errors->has('email'))
                <div class="errorMessage">
                    {{ $errors->first('email') }}
                </div>
                @endif


            </div>
            <!--Error Message Start-->
            <div class="errorMessage" style="display:none;">Invalid email.</div>
            <!--Error Message End-->
            @if (session('status'))

            <div class="textRows textCenter">
                You will receive an email to reset your password.
            </div>

            @endif  

            <div class="clear"></div>
            <div class="loginRows submitBtnSec">
                <input type="submit" value="Submit" class="waves-effect waves-light btn"  />
                <!--</a>-->
            </div>

            <div class="clear"></div>


        </form>


    </div>
    <div class="clear">&nbsp;</div>
</div>
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
</html>

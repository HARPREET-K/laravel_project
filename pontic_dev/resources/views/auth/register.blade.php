@extends('layouts.app')

@section('content')

<div class="topBackBtnSec"><a href="{{ url('/') }}"><i class="material-icons">keyboard_arrow_left</i></a></div>

<div class="loginBgSec">
    <div class="mainBgColor">



        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
            <div class="logoSec">
                <img src="{{ URL::asset('images/LOGO_transparent.png') }}" />
            </div>
            <div class="loginFormSec card">
                        {{ csrf_field() }}

                        <div class="loginRows userTypeSelect">
                            <div class="input-field">
                                <select id="user_type" name="user_type" value="{{ old('user_type') }}">
                                    <option value="" disabled selected>I am a</option>
                                    @foreach ($userTypes as $userType)
                                    <option value="{{ $userType->id }}">{{ $userType->user_type }}</option>
                                    @endforeach
                                </select>

                                <label for="user_type">User Type</label>
                            </div>

                            @if ($errors->has('user_type'))

                            <div class="errorMessage">
                                {{ $errors->first('user_type') }}
                            </div>

                            @endif


                        </div>
                        <div class="loginRows">        
                            <div class="input-field">
                                <input id="name" type="text" class="validate" name="name"  value="{{ old('name') }}">
                                <label for="name">Full Name</label>
                            </div>
                            <div class="errorMessage" style="display:none;">Invalid Name.</div>
                            @if ($errors->has('name'))

                            <div class="errorMessage">
                                {{ $errors->first('name') }}
                            </div>

                            @endif
                        </div>
                        <div class="loginRows">        
                            <div class="input-field">
                                <input id="email" type="text" class="validate" name="email"  value="{{ old('email') }}">
                                <label for="email">E-mail</label>
                            </div>
                            <div class="errorMessage" style="display:none;">Invalid Email.</div>
                            @if ($errors->has('email'))

                            <div class="errorMessage">
                                {{ $errors->first('email') }}
                            </div>

                            @endif
                        </div>
                         <div class="loginRows">
                            <div class="input-field">
                                <input type="password" id="password" class="validate" name="password" value="{{ old('password') }}" />
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
                                <input class="validate" type="password" id="password_confirmation" name="password_confirmation"  value="{{ old('password_confirmation') }}"  />
                                <label for="password_confirmation" >Verify password</label>
                            </div>


                            @if ($errors->has('password_confirmation'))

                            <div class="errorMessage">
                                {{ $errors->first('password_confirmation') }}
                            </div>

                            @endif

                        </div>

                        <div class="loginRows">
                            <div class="input-field">
                                <input class="validate" type="text" id="zipcode" name="zipcode" value="{{ old('zipcode') }}" />
                                <label for="zipcode">Zip code</label>
                            </div>

                            @if ($errors->has('zipcode'))

                            <div class="errorMessage">
                                {{ $errors->first('zipcode') }}
                            </div>

                            @endif


                        </div>

                        <!--Error Message Start-->
                        <div class="errorMessage" style="display:none;">Invalid credentials.</div>
                        <!--Error Message End-->


                        <div class="clear"></div>
                        <div class="rmbrPassSec">
                            <input type="checkbox" class="filled-in" id="filled-in-box" name="terms_conditions"<?php
                            if (old('terms_conditions')) {
                                echo 'checked=checked';
                            };
                            ?> >
                            <label for="filled-in-box">I have read and agreed <a class="modal-trigger" href="#modal2">Privacy Policy</a> and <a class="modal-trigger" href="#modal1">Legal Notice</a>.</label>
                            <div class="clear"></div>
                        </div>



                        <div class="clear"></div> 


                        <div class="loginRows">
                            <input type="submit" value="Create an account" class="waves-effect waves-light btn" />
                        </div>


                        <div class="clear"></div>

                    
                
            </div>

        </form>



        





    </div>
</div>

<!-- Modal Structure -->
 

<div class="popUpSecMain" id="popupEmailExist">
    <div class="popUpSec">
        <div class="employeesFormSec">
            <div class="clear">&nbsp;</div>
            <div class="popContRow">
                <div class="textCenter">
                    The email has already been taken.
                </div>
            </div>

            <div class="clear">&nbsp;</div>
            <div class="popBtnRow">
                <div class="popBtnSec floatRight">
                    <input type="button" class="submitBtn loginPage" onclick="closePopupEmailExist()" value="Ok" />
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>


<div class="popUpSecMain" id="popupPrivacyPolicy">
    <div class="popUpSec">
        <div class="employeesFormSec">
            <div class="clear">&nbsp;</div>
            <div class="popContRow">
                <div class="textCenter">
                    You have to agree Terms of Services and Privacy Policy.
                </div>
            </div>

            <div class="clear">&nbsp;</div>


            <div class="popBtnRow">
                <div class="popBtnSec floatRight">
                    <input type="button" class="submitBtn loginPage" onclick="closePopupPrivacyPolicy()" value="Ok" />
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>

@include('includes.terms')
@endsection


@section('script')  

<script>
    function popUpPrivacy() {
        var divShow = document.getElementById("popUp").style.display = "block";
    }
    function closePopUpPrivacy() {
        var divShow = document.getElementById("popUp").style.display = "none";
    }

</script>


@if ($errors->has('terms_conditions') && !$errors->has('password_confirmation'))
<script>
    $(document).ready(function () {
        // executes when HTML-Document is loaded and DOM is ready
        $('#popupPrivacyPolicy').show();
    });
</script>
@endif
<!-- The email has already been taken. -->

@if ($errors->has('email') && strpos($errors->first('email'), 'email has already been') > 0 && !$errors->has('terms_conditions'))
<script>
    $(document).ready(function () {
        // executes when HTML-Document is loaded and DOM is ready
        $('#popupEmailExist').show();
    });
</script>
@endif



<script>


    function closePopupEmailExist() {
        $('.popUpSecMain').hide();
    }

    function closePopupPrivacyPolicy() {
        $('.popUpSecMain').hide();
    }

</script>

@endsection

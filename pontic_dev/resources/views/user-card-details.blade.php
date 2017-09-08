@extends('layouts.app')

@section('content')
 
<div class="clear"></div>
<div id="mainBodyDiv" class="bodyContSec">   
    <ddiv class="paymentInfoPageContSec">
        <div class="headingText1">Payment Information</div>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/makePaymentInfo') }}">
            <div class="formSec">
                <div class="rowSec">
                    <div class="lableSec">Payment Type</div>
                    <div class="cardTypeSec">
                        <div class="imgSec">
                            <img src="{{ URL::asset('images/card-visa.png') }}" />
                            <img src="{{ URL::asset('images/card-master.png') }}" />
                            <img src="{{ URL::asset('images/card-am-ex.png') }}" />
                            <img src="{{ URL::asset('images/card-discover.png') }}" />
                            <img src="{{ URL::asset('images/card-paypal.png') }}" />
                            <img src="{{ URL::asset('images/card-none.png') }}" />
                        </div>
                        <div class="textSec">All types of cards are accepted</div>
                    </div>
                </div>

                @if (session('warning'))
                <div class="row createFormText textCenter">
                    {{ session('warning') }}
                </div>
                @endif
                {{ csrf_field() }}
                <input type="hidden" name="plan" value="{{$subscription_type}}"/>
                <input type="hidden" name="plan" value="{{$user->id}}"/>
                <div class="rowSec cardName">
                    <div class="lableSec">Name On card</div>
                    <div class="fieldSec"><input type="text" name="card_name" /></div>
                    <div class="clear"></div>
                    @if ($errors->has('card_name'))
                    <div class="errorMessage">
                        {{ $errors->first('card_name') }}
                    </div>
                    @endif
                </div>
                <div class="rowSec cardName">
                    <div class="lableSec">Card Number</div>
                    <div class="fieldSec"><input type="text" name="card" /></div>
                    <div class="clear"></div>
                    @if ($errors->has('card'))
                    <div class="errorMessage">
                        {{ $errors->first('card') }}
                    </div>
                    @endif
                </div>
                <div class="rowSec expiresBoxesSec">
                    <div class="lableSec">Expires</div>
                    <div class="fieldSec">
                        <div class="expiresMonth"><input type="text" placeholder="MM" name="expiry_month"/></div>
                        <div class="separatorSec">/</div>
                        <div class="expiresYear"><input type="text" placeholder="YYYY" name="expiry_year"/></div>
                    </div>
                    <div class="clear"></div>
                    @if ($errors->has('expiry_month'))
                    <div class="errorMessage">
                        {{ $errors->first('expiry_month') }}
                    </div>
                    @endif
                    @if ($errors->has('expiry_year'))
                    <div class="errorMessage">
                        {{ $errors->first('expiry_year') }}
                    </div>
                    @endif
                </div>
                <div class="rowSec">
                    <div class="lableSec">Security code</div>
                    <div class="fieldSec">
                        <div class="securityCodeBox"><input type="text" placeholder="CVC" name="cvc"/></div>
                    </div>
                    <div class="clear"></div>
                    @if ($errors->has('cvc'))
                    <div class="errorMessage">
                        {{ $errors->first('cvc') }}
                    </div>
                    @endif
                </div>
                <div class="clear"></div>
                <div class="btnSec">
                    <input type="submit" value="Continue" class="continueBtn" />
                    <input type="cancel" value="Cancel" class="cancelBtn" />
                    <div class="clear"></div>
                </div>
                <div class="clear"></div> 
            </div>
        </form>
        <div class="clear"></div>


</div>

</div>


@include('includes.terms')

@endsection


@section('script') 

<script>
    $(document).ready(function () {
        $("#btnYear").click(function () {
            $("#planPerYear").show(1000);
            $("#planPerMonth").hide(1000);
            $("#btnYear").addClass('activeBtnYear');
            $("#btnMonth").removeClass('activeBtnMonth');
        });

        $("#btnMonth").click(function () {
            $("#planPerYear").hide(1000);
            $("#planPerMonth").show(1000);
            $("#btnYear").removeClass('activeBtnYear');
            $("#btnMonth").addClass('activeBtnMonth');
        });
    });
</script>

@endsection

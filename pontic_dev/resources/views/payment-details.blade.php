@extends('layouts.app')

@section('content')

<div class="clear"></div>
<div id="mainBodyDiv">
    <div class="userSubsContSec">
        <div class="contTextSec">
            <div class="topBackBtnSec"><a  onclick="javascript:window.history.go(-1);"><i class="material-icons">keyboard_arrow_left</i></a></div>
            <div class="headingText1">Subscription</div>
            <div>Prices include unlimited access to our network & job postings. No hidden fees.</div>
        </div>
        <div class="clear"></div>
        <div class="montYearBtnSec">
            <div class="btnYear" id="btnYear">6 Month Commitment</div>
            <div class="btnMonth activeBtnMonth" id="btnMonth">Month-to-Month</div>
            <div class="clear"></div>
        </div>
        <div class="planBoxRowSec" id="planPerYear" style="display:none">

            <div class="planBoxes">
                @if($user->expiry_date == NULL)
                <div class="iconBadge"><a href="{{ url('/freePlan/'.$user->id)}}"><img src="{{ URL::asset('images/icon-Badge.png') }}" /></a></div>
                @endif
                <div class="iconSec"><img src="{{ URL::asset('images/icon-dental-office.png') }}" /></div>
                <div class="boxType">Dental Office</div>
                <div class="yearBoxPrice">$200</div>

                @if($user->userType == 1)
                <div class="boxBtnSec">
                    <form action="{{ url('/paymentProcess') }}" method="POST">
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{env('STRIPE_PUBLISH')}}"
                            data-amount="20000"
                            data-name="{{$user->name}}"
                            data-email="{{$user->email}}"
                            data-description="6-Months Package"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-locale="auto">
                        </script>
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{$user->id}}" />
                        <input type="hidden" name="plan" value="1" />
                    </form>

                </div>
                @endif
            </div>

            <div class="planBoxes">
                <div class="iconSec"><img src="{{ URL::asset('images/icon-dentist.png') }}" /></div>
                <div class="boxType">Front Office</div>
                <div class="yearBoxPrice">&nbsp;
                </div>
                @if ($user->userType == 2)
               <div class="boxBtnSec">
                    <a href="{{ url('/freePlan2/'.$user->id)}}"><button class="btn">Free Account</button></a>
                </div>
                @endif
            </div>
            <div class="colTwoClear"></div>
            <div class="planBoxes">
                <div class="iconSec"><img src="{{ URL::asset('images/icon-hygienist.png') }}" /></div>
                <div class="boxType">Hygienist</div>
                <div class="yearBoxPrice">&nbsp;</div>
                @if($user->userType == 3)
               <div class="boxBtnSec">
                    <a href="{{ url('/freePlan2/'.$user->id)}}"><button class="btn">Free Account</button></a>
                </div>
                @endif
            </div>

            <div class="planBoxes">
                <div class="iconSec"><img src="{{ URL::asset('images/icon-dental-assistant.png') }}" /></div>
                <div class="boxType">Dental Assistant</div>
                <div class="yearBoxPrice">&nbsp;</div>
                @if($user->userType == 4)
                <div class="boxBtnSec">
                    <a href="{{ url('/freePlan2/'.$user->id)}}"><button class="btn">Free Account</button></a>
                </div>
                @endif
            </div>

            <div class="clear"></div>
        </div>
        <div class="planBoxRowSec" id="planPerMonth">

            <div class="planBoxes">
                @if($user->expiry_date == NULL)
                <div class="iconBadge"><a href="{{ url('/freePlan/'.$user->id)}}"><img src="{{ URL::asset('images/icon-Badge.png') }}" /></a></div>
                @endif
                <div class="iconSec"><img src="{{ URL::asset('images/icon-dental-office.png') }}" /></div>
                <div class="boxType">Dental Office</div>
                <div class="boxPrice">$40/mo</div>
                @if($user->userType == 1)
                <div class="boxBtnSec">
                    <form action="{{ url('/paymentProcess') }}" method="POST">
                        <script
                            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{env('STRIPE_PUBLISH')}}"
                            data-amount="4000"
                            data-name="{{$user->name}}"
                            data-email="{{$user->email}}"
                            data-description="Monthly Package"
                            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                            data-locale="auto">
                        </script>
                        {{ csrf_field() }}
                        <input type="hidden" name="user_id" value="{{$user->id}}" />
                        <input type="hidden" name="plan" value="2" />
                    </form>

                </div>
                @endif
            </div>

            <div class="planBoxes">
                <div class="iconSec"><img src="{{ URL::asset('images/icon-dentist.png') }}" /></div>
                <div class="boxType">Front Office</div>
                <div class="boxPrice">&nbsp;</div>
                @if($user->userType == 2)
                <div class="boxBtnSec">
                    <a href="{{ url('/freePlan2/'.$user->id)}}"><button class="btn">Free Account</button></a>
                </div>
                @endif
            </div>
             <div class="colTwoClear"></div>
            <div class="planBoxes">
                <div class="iconSec"><img src="{{ URL::asset('images/icon-hygienist.png') }}" /></div>
                <div class="boxType">Hygienist</div>
                <div class="boxPrice">&nbsp;</div>
                @if($user->userType == 3)
               <a href="{{ url('/freePlan2/'.$user->id)}}"><button class="btn">Free Account</button></a>
                @endif
            </div>

            <div class="planBoxes">
                <div class="iconSec"><img src="{{ URL::asset('images/icon-dental-assistant.png') }}" /></div>
                <div class="boxType">Dental Assistant</div>
                <div class="boxPrice">&nbsp;</div>
                @if($user->userType == 4)
                <div class="boxBtnSec">
                    <a href="{{ url('/freePlan2/'.$user->id)}}"><button class="btn">Free Account</button></a>
                </div>
                @endif
            </div>

            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="skipTextSec">Subscription will automatically reoccur at the end of the billing cycle.</div>

    </div>

</div>

<div class="pageLoadSec" style="display:none;">
    <div class="loaderSec">
        <div class="preloader-wrapper active">
            <div class="spinner-layer spinner-red-only">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
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

        $(".Button-animationWrapper-child--primary Button").click(function () {
            /* AJAX calls and insertion into #productionForm */
            $(".pageLoadSec").show();
            setTimeout(function () {
                $(".pageLoadSec").hide();
            }, 2000);
        });

    });
</script>

@endsection

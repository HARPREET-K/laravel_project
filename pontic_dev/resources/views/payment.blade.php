@extends('layouts.app')

@section('content')

<!--Left Section Start-->
@include('includes.sidebar')
<!--Left Section End-->
<div class="headerSec">
    <div class="topHeader">
            <div id="topMenuIcon" class="topMenuIcon"><a href="#"><i class="material-icons">menu</i></a><div class="mainTitleSec">Pontic<!--<img src="images/logo-login.png" />--></div></div>


        <div class="menuSec">
            <div class="dashBoardMainMenu">
                <ul class="tabs">
                    <li class="tab"><a  href="#accountSettings">Account</a></li>
                    <li class="tab"><a href="#changePassword">Password</a></li>
                    <li class="tab"><a class="active" href="#billing">Billing</a></li>
                    <!-- <li class="tab"><a href="#feedback">Feedback</a></li> -->
                </ul>
            </div>
        </div>

    </div>
</div>
<div class="clear"></div>
<div id="mainBodyDiv" class="bodyContSec">   
<div class="userSubsContSec">
	<div class="contTextSec">
        <div class="headingText1">Subscription</div>
        <div>Prices include unlimited access to our network & job postings. No hidden fees.</div>
    </div>
    <div class="clear"></div>
    <div class="montYearBtnSec">
    	<div class="btnYear" id="btnYear">6 Month Commitment</div>
        <div class="btnMonth activeBtnMonth" id="btnMonth">Month-to-month</div>
        <div class="clear"></div>
    </div>
    <div class="planBoxRowSec" id="planPerYear" style="display:none">
         
    	<div class="planBoxes">
        	<div class="iconSec"><img src="{{ URL::asset('images/icon-dental-office.png') }}" /></div>
            <div class="boxType">Dental Office</div>
            <div class="boxPrice">$75/year</div>
            @if($user->userType == 1)
            <div class="boxBtnSec">
                <a href="{{ url('/paymentProcess/1') }}" ><button class="btn">Get Started</button></a>
            </div>
              @endif
        </div>
          
    	<div class="planBoxes">
        	<div class="iconSec"><img src="{{ URL::asset('images/icon-dentist.png') }}" /></div>
            <div class="boxType">Dentist</div>
            <div class="boxPrice">$50/year</div>
            @if ($user->userType == 2)
            <div class="boxBtnSec">
                <a href="{{ url('/paymentProcess/1') }}" ><button class="btn">Get Started</button></a>
            </div>
            @endif
        </div>
          
    	<div class="planBoxes">
        	<div class="iconSec"><img src="{{ URL::asset('images/icon-hygienist.png') }}" /></div>
            <div class="boxType">Hygienist</div>
            <div class="boxPrice">$50/year</div>
             @if($user->userType == 3)
            <div class="boxBtnSec">
                <a href="{{ url('/paymentProcess/1') }}" ><button class="btn">Get Started</button></a>
            </div>
            @endif
        </div>
            
    	<div class="planBoxes">
        	<div class="iconSec"><img src="{{ URL::asset('images/icon-dental-assistant.png') }}" /></div>
            <div class="boxType">Dental Assistant</div>
            <div class="boxPrice">$50/year</div>
            @if($user->userType == 4)
            <div class="boxBtnSec">
                <a href="{{ url('/paymentProcess/1') }}" ><button class="btn">Get Started</button></a>
            </div>
            @endif
        </div>
           
        <div class="clear"></div>
    </div>
    <div class="planBoxRowSec" id="planPerMonth">
        
    	<div class="planBoxes">
        	<div class="iconSec"><img src="{{ URL::asset('images/icon-dental-office.png') }}" /></div>
            <div class="boxType">Dental Office</div>
            <div class="boxPrice">$40/mo</div>
            @if($user->userType == 1)
            <div class="boxBtnSec">
                <a href="{{ url('/paymentProcess/2') }}" ><button class="btn">Get Started</button></a>
            </div>
            @endif 
        </div>
         
    	<div class="planBoxes">
        	<div class="iconSec"><img src="{{ URL::asset('images/icon-dentist.png') }}" /></div>
            <div class="boxType">Dentist</div>
            <div class="boxPrice">$10/mo</div>
            @if($user->userType == 2)
            <div class="boxBtnSec">
                <a href="{{ url('/paymentProcess/2') }}" ><button class="btn">Get Started</button></a>
            </div>
            @endif 
        </div>
         
    	<div class="planBoxes">
        	<div class="iconSec"><img src="{{ URL::asset('images/icon-hygienist.png') }}" /></div>
            <div class="boxType">Hygienist</div>
            <div class="boxPrice">$10/mo</div>
             @if($user->userType == 3)
            <div class="boxBtnSec"> 
                <a href="{{ url('/paymentProcess/2')}}" ><button class="btn">Get Started</button></a>
            </div>
            @endif 
        </div>
          
    	<div class="planBoxes">
        	<div class="iconSec"><img src="{{ URL::asset('images/icon-dental-assistant.png') }}" /></div>
            <div class="boxType">Dental Assistant</div>
            <div class="boxPrice">$10/mo</div>
             @if($user->userType == 4)
            <div class="boxBtnSec">
                <a href="{{ url('/paymentProcess/2')}}" ><button class="btn">Get Started</button></a>
            </div>
            @endif 
        </div>
           
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
     @if($user->expiry_date == NULL)
   
    <div class="skipTextSec"><a href="#">Skip and try one month free. </a></div>
    <div class="skipTextSec">Subscription will automatically reoccur at the end of the billing cycle.</div>
    @endif
    
</div>

</div>
 

@include('includes.terms')

@endsection


@section('script') 

<script>
$(document).ready(function(){
    $("#btnYear").click(function(){
        $("#planPerYear").show(1000);
        $("#planPerMonth").hide(1000);
        $("#btnYear").addClass('activeBtnYear');
        $("#btnMonth").removeClass('activeBtnMonth');
    });

    $("#btnMonth").click(function(){
        $("#planPerYear").hide(1000);
        $("#planPerMonth").show(1000);
        $("#btnYear").removeClass('activeBtnYear');
        $("#btnMonth").addClass('activeBtnMonth');
    });
});
</script>
 
@endsection

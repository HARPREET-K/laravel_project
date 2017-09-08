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
<ddiv class="paymentInfoPageContSec">
	<div class="headingText1">Payment Information</div>
        <form action="" method="post">
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
        
    	<div class="rowSec cardName">
    		<div class="lableSec">Card Number</div>
                <div class="fieldSec"><input type="text" name="card_number"/></div>
            <div class="clear"></div>
        </div>
    	<div class="rowSec expiresBoxesSec">
    		<div class="lableSec">Expires</div>
            <div class="fieldSec">
                <div class="expiresMonth"><input type="text" placeholder="MM" name="month"/></div>
                <div class="separatorSec">/</div>
                <div class="expiresYear"><input type="text" placeholder="YYYY" name="year"/></div>
            </div>
            <div class="clear"></div>
        </div>
    	<div class="rowSec">
    		<div class="lableSec">Security code</div>
            <div class="fieldSec">
                <div class="securityCodeBox"><input type="text" placeholder="CVC" name="cvc"/></div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="btnSec">
            <input type="button" value="Continue" class="continueBtn" />
            <input type="button" value="Cancel" class="cancelBtn" />
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

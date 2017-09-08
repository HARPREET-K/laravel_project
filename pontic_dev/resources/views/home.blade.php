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
                    <li class="tab"><a class="active" href="#currentContractors">Current Contractors</a></li>
                    <li class="tab"><a href="#scheduledContractors">Scheduled Contractors</a></li>
                </ul>
            </div>
        </div>
        
    </div>
</div>
<!--Body Section Start-->
<div id="mainBodyDiv" class="bodyContSec">
<div class="dashboardContSec">


<div id="currentContractors" class="">
<div class="dashboardContRows">
        	<div class="threeDotSec">
            	<a class="dropdown-button" href="#!" data-activates="dropDown1"><i class="material-icons">more_vert</i></a>
                <!-- Dropdown Structure -->
                <ul id="dropDown1" class="dropdown-content">
                  <li><a class="modal-trigger" href="#shareViaEmail">Share via email</a></li>
                  <!--<li class="divider"></li>-->
                </ul>
            </div>
        	<div class="imgContractorSec">
            	<div class="imgContractor">
                	<img src="images/contractor-img.png" />
                </div>
            </div>
            <div class="detailsContractorSec">
            	<div class="contRows nameSec">
                	<div class="name"><span class="headText">Name </span> Fannie Webb</div>
                </div>
                <div class="contRows locationSec"><span class="headText">Location </span> Denver</div>
                <div class="contRows hourRateSec"><span class="headText">Hourly Rate </span> $50</div>
                <div class="contRows estiTotSec"><span class="headText">Estimated Total </span> $1,200</div>
                <div class="contRows modStartRat">
                	<i class="material-icons">star</i>4.5
                </div>
                <div class="starRatingSec">
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                    <i class="material-icons">star_half</i>
                    <i class="material-icons">star_border</i>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        
<div class="dashboardContRows">
        	<div class="threeDotSec">
            	<a class="dropdown-button" href="#!" data-activates="dropDown2"><i class="material-icons">more_vert</i></a>
                <!-- Dropdown Structure -->
                <ul id="dropDown2" class="dropdown-content">
                  <li><a class="modal-trigger" href="#shareViaEmail">Share via email</a></li>
                  <!--<li class="divider"></li>-->
                </ul>
            </div>
        	<div class="imgContractorSec">
            	<div class="imgContractor">
                	<img src="images/contractor-img.png" />
                </div>
            </div>
            <div class="detailsContractorSec">
            	<div class="contRows nameSec">
                	<div class="name"><span class="headText">Name </span> Fannie Webb</div>
                </div>
                <div class="contRows locationSec"><span class="headText">Location </span> Denver</div>
                <div class="contRows hourRateSec"><span class="headText">Hourly Rate </span> $50</div>
                <div class="contRows estiTotSec"><span class="headText">Estimated Total </span> $1,200</div>
                <div class="contRows modStartRat">
                	<i class="material-icons">star</i>4.5
                </div>
                <div class="starRatingSec">
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                    <i class="material-icons">star_half</i>
                    <i class="material-icons">star_border</i>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
<div class="clear">&nbsp;</div>
</div>
<div id="scheduledContractors" class="">

<div class="dashboardContRows">
        	<div class="threeDotSec">
            	<a class="dropdown-button" href="#!" data-activates="dropDown3"><i class="material-icons">more_vert</i></a>
                <!-- Dropdown Structure -->
                <ul id="dropDown3" class="dropdown-content">
                  <li><a class="modal-trigger" href="#shareViaEmail">Share via email</a></li>
                  <!--<li class="divider"></li>-->
                </ul>
            </div>
        	<div class="imgContractorSec">
            	<div class="imgContractor">
                	<img src="images/contractor-img.png" />
                </div>
            </div>
            <div class="detailsContractorSec">
            	<div class="contRows nameSec">
                	<div class="name"><span class="headText">Name </span> Fannie Webb</div>
                </div>
                <div class="contRows locationSec"><span class="headText">Location </span> Denver</div>
                <div class="contRows hourRateSec"><span class="headText">Hourly Rate </span> $50</div>
                <div class="contRows estiTotSec"><span class="headText">Estimated Total </span> $1,200</div>
                <div class="contRows modStartRat">
                	<i class="material-icons">star</i>4.5
                </div>
                <div class="starRatingSec">
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                    <i class="material-icons">star_half</i>
                    <i class="material-icons">star_border</i>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
        
<div class="dashboardContRows">
        	<div class="threeDotSec">
            	<a class="dropdown-button" href="#!" data-activates="dropDown4"><i class="material-icons">more_vert</i></a>
                <!-- Dropdown Structure -->
                <ul id="dropDown4" class="dropdown-content">
                  <li><a class="modal-trigger" href="#shareViaEmail">Share via email</a></li>
                  <li class="divider"></li>
                  <li><a href="#!">Cancel</a></li>
                  <!--<li class="divider"></li>-->
                </ul>
            </div>
        	<div class="imgContractorSec">
            	<div class="imgContractor">
                	<img src="images/contractor-img.png" />
                </div>
            </div>
            <div class="detailsContractorSec">
            	<div class="contRows nameSec">
                	<div class="name"><span class="headText">Name </span> Fannie Webb</div>
                </div>
                <div class="contRows locationSec"><span class="headText">Location </span> Denver</div>
                <div class="contRows hourRateSec"><span class="headText">Hourly Rate </span> $50</div>
                <div class="contRows estiTotSec"><span class="headText">Estimated Total </span> $1,200</div>
                <div class="contRows modStartRat">
                	<i class="material-icons">star</i>4.5
                </div>
                <div class="starRatingSec">
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                    <i class="material-icons">star</i>
                    <i class="material-icons">star_half</i>
                    <i class="material-icons">star_border</i>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>


</div>


<!--
	<div class="pageTitle1">Current Contractors</div>
        
    <div class="pageTitle1">Scheduled Contractors</div>-->
        
</div>
    
    
     <div class="footerContentSec">
        	<a class="modal-trigger" href="#modal1">Terms and Conditions</a> and <a class="modal-trigger" href="#modal2">Privacy Policy</a>
            <div class="clear"></div>
            <a title="DMCA.com Protection Status" class="dmca-badge" href="https://www.dmca.com/Protection/Status.aspx?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"> 
            <img alt="DMCA.com Protection Status" src="https://images.dmca.com/Badges/dmca_protected_sml_120k.png?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"></a>
            <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
        </div>
</div>



 
<!--Body Section End-->             
  <!-- Modal Structure -->
  <div id="shareViaEmail" class="modal smallPopUp modal-fixed-footer">
    <div class="modal-content">
      
      <div class="privPolicyContentSec">
      <h4 class="privPoliHead">Share Via Email</h4>
      	
        <div class="input-field">
          <input id="emailId" type="text" class="validate">
          <label for="emailId">Enter Your Email</label>
        </div>
        
      </div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="waves-effect waves-green btn-flat ">Submit</a>
      <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</a>
    </div>
  </div>



<div id="maskMenuBg"></div>

@include('includes.terms')
@endsection


@section('script')
 <script>
 $(document).ready(function(){
    $('ul.tabs').tabs();
  });
</script>

 


<script>
    $( "#topMenuIcon, #maskMenuBg, #closeMenuIcon" ).click(function() {
  $( "#mobRightMenu" ).toggleClass( "leftMenuBlock", 1000, "easeOutSine" );
  $( "#mainBodyDiv" ).toggleClass( "withMenuBody", 400, "easeOutSine" );
  $( "#maskMenuBg" ).toggleClass( "menuMaskOn", 400, "easeOutSine" );
});
$(window).scroll(function() {
    var scroll = $(window).scrollTop();

    if (scroll >= 50) {
        $(".headerSec").addClass("darkHeader");
    } else {
        $(".headerSec").removeClass("darkHeader");
    }
});
</script>

@endsection
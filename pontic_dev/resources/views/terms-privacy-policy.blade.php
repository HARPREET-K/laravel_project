@extends('layouts.app')

@section('content')
<!--Left Section Start-->
@include('includes.sidebar')
<!--Left Section End-->
@include('includes.header')

<div class="mainBgColor">

<div class="topBackButton">
    <a href="{{ url('/register') }}">
        <div class="backIconSec">
            <img src="images/icon-back.png" />
        </div>
    </a>
</div>

<div class="bodyContaintSec">
        	<div class="bodyContBox termsBgSec">
            	<div class="bodySec">
                	<div class="pageTittle">Terms of Service and Privacy Policy</div>


                        <ol>
                            <li>Terms</li>
                            <div class="contentSec">
                            By accessing the website at https://Timetracker.com, you are agreeing to be bound by these terms of service, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws. If you do not agree with any of these terms, you are prohibited from using or accessing this site. The materials contained in this website are protected by applicable copyright and trademark law.
                            </div>
                            <li>Use License</li>
                            <div class="contentSec">
                            Permission is granted to temporarily download one copy of the materials (information or software) on TimeTracker's website for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:
                        
                        modify or copy the materials;
                        
                        use the materials for any commercial purpose, or for any public display (commercial or non-commercial);
                        
                        attempt to decompile or reverse engineer any software contained on TimeTracker's website;
                        
                        remove any copyright or other proprietary notations from the materials; or
                        
                        transfer the materials to another person or "mirror" the materials on any other server.
                        
                        This license shall automatically terminate if you violate any of these restrictions and may be terminated by TimeTracker at any time. Upon terminating your viewing of these materials or upon the termination of this license, you must destroy any downloaded materials in your possession whether in electronic or printed format.
                            </div>
                            <li>Disclaimer</li>
                            <div class="contentSec">
                            The materials on TimeTracker's website are provided on an 'as is' basis. TimeTracker makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties including, without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights.
                        
                        Further, TimeTracker does not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the materials on its website or otherwise relating to such materials or on any sites linked to this site.
                            </div>
                        </ol>




                	</div>
            	</div>
        	</div>

</div>


@endsection


@section('script')
 <script>
 $(document).ready(function(){
    $('ul.tabs').tabs();
  });
</script>

<script>
$( "#topMenuIcon" ).click(function() {
  $( "#mobRightMenu" ).toggleClass( "leftMenuBlock", 1000, "easeOutSine" );
  $( "#mainBodyDiv" ).toggleClass( "withMenuBody", 400, "easeOutSine" );
});
</script>


<script>
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

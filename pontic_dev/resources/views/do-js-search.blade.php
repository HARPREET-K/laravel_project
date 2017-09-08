@extends('layouts.app')

@section('content')
<!--Left Section Start-->
@include('includes.sidebar')
<!--Left Section End-->


<div class="headerSec">
    <div class="topHeader">
            <div id="topMenuIcon" class="topMenuIcon"><a href="#"><i class="material-icons">menu</i></a><div class="mainTitleSec">Pontic<!--<img src="images/logo-login.png" />--></div></div>
        <div class="menuSec">
            <div class="searchBoxSec">
                <form method="get" action="{{ secure_url('jobseekers-search') }}" id="search_form">
                    <div class="textBoxSec"><input type="text" placeholder="Search by Name" name="search_term" id="search_term" value="{{ Request::get('search_term') }}" /></div> 
                    <input type="button" value="Search" class="searchBtnSec" onclick="return search();" />
                </form>
            </div>

        </div>

    </div>
</div>

<!--Body Section Start-->
<div id="mainBodyDiv" class="bodyContSec withOutTopMenu">




    <div class="doProfileFindWorker">

        <div class="filterBtnSec">
            <div class="filterBtn"><a class="modal-trigger" href="#jsFindJobPopUpmain"><input type="button" value="Filter" class="btn"  /></a></div>
            <div class="clear"></div>
        </div>

        @if(count($jobseekers) > 0)
        <?php
//for ($i = 0; $i <= 9; $i++) {
//}
        ?>            

        @foreach($jobseekers as $key => $jobseeker)

        <div class="pageContSec jsFindJobRowSec">
            <div class="pageContSec">
                <div class="pageContBox">
                    @if(!empty($jobseeker->profile_image_thumb))
                    <a  href="{{ secure_url('jsDetails/'.$jobseeker->id) }}">

                        <div class="profileImgSec" style="background-image:url({{ Config('constants.s3_url') . $jobseeker->profile_image_thumb}});">
                        </div>
                    </a>  
                    @else
                    <a  href="{{ secure_url('jsDetails/'.$jobseeker->id) }}">

                        <div class="profileImgSec">
                            <img src="{{ secure_url('images/profile-img.png') }}" />
                        </div>
                    </a> 

                    @endif

                    <div class="profileDetailsSec">
                        <div class="profileRightBtnSec">
                            <a href="{{ secure_url('message/'.$jobseeker->id) }}" class="btn">Chat</a>
                        </div> 
                        <div class="threeDotSec">
                            <a class="dropdown-button" href="javascript:;" data-activates="dropDown{{ $jobseeker->id }}"><i class="material-icons">more_vert</i></a>                      
                            <ul id="dropDown{{ $jobseeker->id  }}" class="dropdown-content">
                                <li>  <a href="{{ secure_url('message/'.$jobseeker->id) }}" class="btn btnMobile">Chat</a></li>                         
                            </ul>
                        </div> 
                        <div class="nameSec">
                            <a  href="{{ secure_url('jsDetails/'.$jobseeker->id) }}">
                                @if($jobseeker->title != null)
                                {{ $jobseeker->title.'.'}}
                                @endif
                                @if($jobseeker->credential != null)
                                {{$jobseeker->name.', '.$jobseeker->credential }}
                                @else
                                {{$jobseeker->name}}
                                @endif
                            </a>
                            <br>
                            <span class="userType">
                                @if($jobseeker->userType == 2)
                                {{ 'Front Office' }}
                                @elseif($jobseeker->userType == 3)
                                {{ 'Hygienist' }}
                                @elseif($jobseeker->userType == 4)
                                {{ 'Assistant'}}
                                @else
                                {{' '}}
                                @endif
                            </span>
                        </div>
                        <div class="rowSec">
                            <div class="leftTextSec">Years of Experience</div>
                            <div class="rightTextSec">{{ $jobseeker->experience }}</div>
                            <div class="clear"></div>
                        </div>
                        <div class="rowSec">                    
                            <div class="leftTextSec">Expected Pay</div>
                            <div class="rightTextSec">{{ $jobseeker->expected_pay }}/hr</div>
                            <div class="clear"></div>
                        </div>
                        <div class="rowSec">                    
                            <div class="leftTextSec">Location</div>
                            <div class="rightTextSec">@if($jobseeker->city != NULL){{' '.$jobseeker->city}}@endif
                                @if($jobseeker->state!=NULL){{', '.$jobseeker->state }}@endif</div>
                            <div class="clear"></div>
                        </div>
                        <div class="rowSec">                    
                            <div class="leftTextSec">State License</div>
                            <div class="rightTextSec">{{ $jobseeker->state_license}} </div>
                            <div class="clear"></div>
                        </div>
                        <div class="rowSec">
                            <div class="leftTextSec">Availability</div>
                            <div class="rightTextSec"><?php
                            //show availability dates
        if (${"i{$key}"} == '') {

        } else {

            $weekDays = explode("=", ${"i{$key}"});

            if ($weekDays[0] != '-1') {
                $mon = 'Mon,';
            } else {
                $mon = '';
            }
            if ($weekDays[1] != '-1') {
                $tue = 'Tue,';
            } else {
                $tue = '';
            }
            if ($weekDays[2] != '-1') {
                $wed = 'Wed,';
            } else {
                $wed = '';
            }
            if ($weekDays[3] != '-1') {
                $thu = 'Thu,';
            } else {
                $thu = '';
            }
            if ($weekDays[4] != '-1') {
                $fri = 'Fri,';
            } else {
                $fri = '';
            }
            if ($weekDays[5] != '-1') {
                $sat = 'Sat,';
            } else {
                $sat = '';
            }
            if ($weekDays[6] != '-1') {
                $sun = 'Sun,';
            } else {
                $sun = '';
            }
            $string = $mon . $tue . $wed . $thu . $fri . $sat . $sun;
            $string = str_replace(',', ', ', $string);
            echo rtrim($string, ', ');
        }
        ?> </div>
                            <div class="clear"></div>
                        </div>

                       <div class="rowSec" id="showinfo{{ $jobseeker->id }}" style="display:none;">                    
                            <div class="leftTextSec">Contact info</div>
                            <div class="rightTextSec">Email: {{ $jobseeker->email }}<br>
                                Phone: {{ $jobseeker->mobile_number }}</div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <!-----<div class="rowSec">
          No jobseekers found yet...
           <div class="clear"></div>
      </div>----->

        @endforeach


        <div class="paginationDivSec">

            @include('pagination.default', ['paginator' => $jobseekers->appends(Request::except('page'))])

        </div>
        <!--'Other Available Job Seekers' Code - Commented by Harpreet for sort preriod of time-->
        <!--<div class="othersAvailableJs">

            <p class='othersAvailableText'> {{ $available }} </p>

        </div>
        @if(count($available_jobseekers) > 0 && $available_jobseekers != '')

        @foreach($available_jobseekers as $jobseeker)
        <div class="pageContSec jsFindJobRowSec">
            <div class="pageContSec">
                <div class="pageContBox">
                    @if(!empty($jobseeker->profile_image_thumb))
                    <a  href="{{ secure_url('jsDetails/'.$jobseeker->id) }}">

                        <div class="profileImgSec" style="background-image:url({{ Config('constants.s3_url') . $jobseeker->profile_image_thumb}});">
                        </div>
                    </a>  
                    @else
                    <a  href="{{ secure_url('jsDetails/'.$jobseeker->id) }}">

                        <div class="profileImgSec">
                            <img src="{{ secure_url('images/profile-img.png') }}" />
                        </div>
                    </a> 

                    @endif

                    <div class="profileDetailsSec">
                        <div class="profileRightBtnSec">
			    <a href="{{ secure_url('message/'.$jobseeker->id) }}" class="btn">Chat</a>
                        </div> 
                        <div class="threeDotSec">
                            <a class="dropdown-button" href="javascript:;" data-activates="dropDown{{ $jobseeker->id }}"><i class="material-icons">more_vert</i></a>                      
                            <ul id="dropDown{{ $jobseeker->id  }}" class="dropdown-content">
				<li>  <a href="{{ secure_url('message/'.$jobseeker->id) }}" class="btn">Chat</a></li>
                            </ul>
                        </div>     
                        <div class="nameSec">
                            <a  href="{{ secure_url('jsDetails/'.$jobseeker->id) }}">
                                @if($jobseeker->title != null)
                                {{ $jobseeker->title.'.'}}
                                @endif
                                @if($jobseeker->credential != null)
                                {{$jobseeker->name.', '.$jobseeker->credential }}
                                @else
                                {{$jobseeker->name}}
                                @endif
                            </a>
                            <br>
                            <span class="userType">
                                @if($jobseeker->userType == 2)
                                {{ 'Front Office' }}
                                @elseif($jobseeker->userType == 3)
                                {{ 'Hygienist' }}
                                @elseif($jobseeker->userType == 4)
                                {{ 'Assistant'}}
                                @else
                                {{' '}}
                                @endif
                            </span>
                        </div>
                        <div class="rowSec">
                            <div class="leftTextSec">Years of Experience</div>
                            <div class="rightTextSec">{{ $jobseeker->experience }}</div>
                            <div class="clear"></div>
                        </div>
                        <div class="rowSec">                    
                            <div class="leftTextSec">Expected Pay</div>
                            <div class="rightTextSec">{{ $jobseeker->expected_pay }}/hr</div>
                            <div class="clear"></div>
                        </div>
                        <div class="rowSec">                    
                            <div class="leftTextSec">Location</div>
                            <div class="rightTextSec">@if($jobseeker->city != NULL){{' '.$jobseeker->city}}@endif
                                @if($jobseeker->state!=NULL){{', '.$jobseeker->state }}@endif</div>
                            <div class="clear"></div>
                        </div>
                        <div class="rowSec">                    
                            <div class="leftTextSec">State License</div>
                            <div class="rightTextSec">{{ $jobseeker->state_license}} </div>
                            <div class="clear"></div>
                        </div>
                        <div class="rowSec">                    
                            <div class="leftTextSec">Availability</div>
                            <div class="rightTextSec"><?php
                                //if (${"i{$key}"} == '') {
                                    
                                //} else {

                                   // $weekDays = explode("=", ${"i{$key}"});

                                  //  if ($weekDays[0] != '-1') {
                                     //   $mon = 'Mon,';
                                   // } else {
                                    //    $mon = '';
                                   // }
                                   // if ($weekDays[1] != '-1') {
                                   //     $tue = 'Tue,';
                                   // } else {
                                   //     $tue = '';
                                   // }
                                    //if ($weekDays[2] != '-1') {
                                     //   $wed = 'Wed,';
                                    //} else {
                                     //   $wed = '';
                                   // }
                                   // if ($weekDays[3] != '-1') {
                                     //   $thu = 'Thu,';
                                    //} else {
                                      //  $thu = '';
                                   // }
                                    //if ($weekDays[4] != '-1') {
                                      //  $fri = 'Fri,';
                                    //} else {
                                      //  $fri = '';
                                    //}
                                    //if ($weekDays[5] != '-1') {
                                      //  $sat = 'Sat,';
                                    //} else {
                                      //  $sat = '';
                                   // }
                                   // if ($weekDays[6] != '-1') {
                                       // $sun = 'Sun,';
                                    //} else {
                                      //  $sun = '';
                                    //}
                                    //$string = $mon . $tue . $wed . $thu . $fri . $sat . $sun;
                                    //$string = str_replace(',', ', ', $string);
                                //    echo rtrim($string, ', ');
                                //}
        ?>  </div>
                            <div class="clear"></div>
                        </div>
                        <div class="rowSec" id="showinfo{{ $jobseeker->id }}" style="display:none;">                    
                            <div class="leftTextSec">Contact info</div>
                            <div class="rightTextSec">Email: {{ $jobseeker->email }}<br>
                                Phone: {{ $jobseeker->mobile_number }}</div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="clear"></div>
        </div>

        <!-----<div class="rowSec">
          No jobseekers found yet...
           <div class="clear"></div>
      </div>----->

        
        <!--@endforeach<div class="paginationDivSec">
            <ul class="pagination"><li class="page-item disabled">
                    <a class="page-link" href="{{ secure_url('jsList?page=1') }}jsList?page=1" aria-label="Previous">
                        <span aria-hidden="true">«</span> 
                    </a>
                </li><li class="page-item disabled">
                    <a class="page-link" href="{{ secure_url('jsList?page=1') }}">1</a>
                </li><li class="page-item ">
                    <a class="page-link" href="{{ secure_url('jsList?page=2') }}">2</a>
                </li><li class="page-item "><a class="page-link" href="{{ secure_url('jsList?page=2') }}" aria-label="Next">
                        <span aria-hidden="true">»</span>
                    </a></li></ul>  
        </div>
        @else

        @endif -->
        @else
<?php
//validation if user address is empty//
foreach ($usersss as $value) {
    $lat = $value->latitude;
    $lon = $value->longitude;
}
?>
        @if($lat==''&&$lon=='')

        <div class="rowSec">
            <p class="noAddressAlert">Please enter an address so we can find matches near you.</p>
            <div class="clear"></div>
        </div>
        @else
        <div class="rowSec">
            No Job Seekers match your search.
            <div class="clear"></div>
        </div>
        @endif
        @endif


    </div>


    <div class="footerContentSec">
        <a class="modal-trigger" href="#modal1">Terms and Conditions</a> and <a class="modal-trigger" href="#modal2">Privacy Policy</a>
        <div class="clear"></div>
        <a title="DMCA.com Protection Status" class="dmca-badge" href="https://www.dmca.com/Protection/Status.aspx?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"> 
            <img alt="DMCA.com Protection Status" src="https://images.dmca.com/Badges/dmca_protected_sml_120k.png?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"></a>
        <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"></script>
    </div>

</div>

<!--Body Section End-->

<!-- Modal Structure -->
<div id="jsFindJobPopUpmain" class="modal modal-fixed-footer jsFindJobPopUpSec">
    <div class="modalHeader">
        Filter
        <div class="closeBtnSec"><a href="#!" class="modal-action modal-close"><i class="material-icons">close</i></a></div>
    </div>
    <div class="modalContentSec">
        <div>
            <form method="get" action="{{ secure_url('jobseekers-search') }}" id="filters_form">

                <!----<div class="formRowSec">
                    <div class="fieldHeadingSec">Date Range</div>            
                    <div class="input-field colSecOne">
                        <input id="from_date" type="text" class="validate" name="from_date" value="{{ Request::get('from_date') }}">
                        <label for="from_date">From</label>
                    </div>            
                    <div class="input-field colSecTwo">
                        <input id="to_date" type="text" class="validate" name="to_date" value="{{ Request::get('to_date') }}">
                        <label for="to_date">To</label>
                    </div>
                   <div class="clear"></div>
                </div>-----> 
                <div class="formRowSec">
                    <div class="fieldHeadingSec">Job Seeker Type: </div>            
                    <div class="input-field">
                        <span> <label><input id="userType" type="radio" class="validate" name="userType" value="4">Assistant</label></span>
                        <span><label><input id="userType" type="radio" class="validate" name="userType" value="2">Front Office</label></span>
                        <span><label><input id="userType" type="radio" class="validate" name="userType" value="3"> Hygienist</label></span>
                    </div> 
                </div>
                <div class="formRowSec">
                    <div class="fieldHeadingSec">Credentials: </div>            
                    <div class="input-field">
                        @foreach($credentials as $credential)
                        <span><label> <input id="credential" type="checkbox" multiple="multiple" class="validate" name="credential[]" value="{{ $credential->name }}"> {{ $credential->name }}</label></span>
                        @endforeach
                    </div> 
                </div>

                <div class="formRowSec">
                    <div class="fieldHeadingSec">Expected Pay: </div>            
                    <div class="input-field">
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="1,2,3,4,5"> 0-5</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="6,7,8,9,10"> 6-10</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="11,12,13,14,15"> 11-15</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="16,17,18,19,20"> 16-20</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="21,22,23,24,25"> 21-25</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="26,27,28,29,30"> 26-30</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="31,32,33,34,35"> 31-35</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="36,37,38,39,40"> 36-40</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="41,42,43,44,45"> 41-45</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="46,47,48,49,50"> 46-50</label></span>
                        <span><label> <input id="expected_pay" type="radio" class="validate" name="expected_pay" value="51,52,53,54,55"> 51-55</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="56,57,58,59,60"> 56-60</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="61,62,63,64,65"> 61-65</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="66,67,68,69,70"> 66-70</label></span>
                        <span><label><input id="expected_pay" type="radio" class="validate" name="expected_pay" value="<?php
for ($i = 71; $i < 151; $i++) {
    echo $i . ',';
}
?>"> 70+</label></span>
                    </div> 
                </div>
                <div class="formRowSec">
                    <div class="fieldHeadingSec">Years Experience: </div>            
                    <div class="input-field">
                        <span><label><input id="experience" type="radio" class="validate" name="experience" value="1,2,3,4,5"> 0-5</label></span>
                        <span><label><input id="experience" type="radio" class="validate" name="experience" value="6,7,8,9,10"> 6-10</label></span>
                        <span><label><input id="experience" type="radio" class="validate" name="experience" value="11,12,13,14,15"> 11-15</label></span>
                        <span><label> <input id="experience" type="radio" class="validate" name="experience" value="16,17,18,19,20"> 16-20</label></span>
                        <span><label><input id="experience" type="radio" class="validate" name="experience" value="21,22,23,24,25"> 21-25</label></span>
                        <span><label><input id="experience" type="radio" class="validate" name="experience" value="26,27,28,29,30"> 26-30</label></span>
                        <span><label><input id="experience" type="radio" class="validate" name="experience" value="31,32,33,34,35"> 31-35</label></span>
                        <span><label><input id="experience" type="radio" class="validate" name="experience" value="36,37,38,39,40"> 36-40</label></span>
                        <span><label><input id="experience" type="radio" class="validate" name="experience" value="<?php
for ($i = 41; $i < 101; $i++) {
    echo $i . ',';
}
?>"> 40+</label></span>
                    </div> 
                </div>
                <!----<div class="fieldRowSec">
                    <div class="fieldHeadingSec">Travel Distance: </div>  
                    <div class="input-field">                            
                        <select id="travel_distance" name="travel_distance">
                            <option value="" selected>Any</option>
                            <option value="5">   5 miles</option>
                            <option value="10">  10 miles</option>
                            <option value="15">  15 miles</option>
                            <option value="20">  20 miles</option>
                            <option value="25">  25 miles</option>
                            <option value="30">  30 miles</option>
                            <option value="35">  35 miles</option>
                            <option value="40">  40 miles</option> 
                            <option value="45">  45 miles</option> 
                        </select>
                    </div>
                </div>---->
                <div class="formRowSec">
                    <div class="fieldHeadingSec">Software (Dentrix, EagleSoft, etc.): </div> 
                    @foreach($sofaware_skillss as $sofaware_skill)
                    <span><label><input id="software" type="checkbox" class="validate" multiple="multiple" name="software[]" value="{{ $sofaware_skill->id }}">{{ $sofaware_skill->skill }}</label></span>
                    @endforeach
                </div>
                <div class="formRowSec">
                    <div class="fieldHeadingSec">Radiology (DEXIS, ScanX, etc.): </div>  
                    @foreach($radiology_skills as $radiology_skill)
                    <span><label> <input id="radiology" type="checkbox" class="validate" multiple="multiple" name="radiology[]" value="{{ $radiology_skill->id }}">{{ $radiology_skill->skill }}</label></span>
                    @endforeach
                </div>
                <div class="formRowSec">
                    <div class="fieldHeadingSec">Language: </div>            
                    <div class="input-field">
                        @foreach($languages as $language)
                        <span><label><input id="language" type="checkbox" class="validate" name="language[]" multiple="multiple" value="{{ $language->name }}"> {{ $language->name }}</label></span>
                        @endforeach
                    </div> 
                </div>
                <div class="formRowSec">
                    <div class="fieldHeadingSec">Certifications: </div>            
                    <div class="input-field">
                        @foreach($certifications as $certification)
                        <span><label><input id="certification" type="checkbox" multiple="multiple" class="validate" name="certification[]" value="{{ $certification->name }}"> {{ $certification->name }}  </label></span>  
                        @endforeach
                    </div> 
                </div>

<?php
//validation if user address is empty//
foreach ($usersss as $value) {
    $lat = $value->latitude;
    $lon = $value->longitude;
}
?>
                <input id="latitude" type="hidden" name="latitude" class="validate" value="{{ $lat }}">
                <input id="longitude" type="hidden" name="longitude" class="validate" value="{{ $lon }}">
                <!-----<div class="formRowSec">
                    <div class="fieldHeadingSec">Location </div>            
                    <div class="input-field">
                        <input id="location" type="text" class="validate" name="location" value="{{ Request::get('location') }}">
                        <label for="location">User Location</label>
                    </div> 
                </div>----->
                <div class="formBtnSec">
                    <input type="button" value="See Result" onclick="return filter();" />
                </div>
            </form>
        </div>
    </div>
</div>
<div id="maskMenuBg"></div>

@include('includes.terms')
@endsection


@section('script')
<script  src="{{ secure_url('js/moment-with-locales.min.js') }}"></script>

<script   src="{{ secure_url('js/bootstrap-material-datetimepicker.js') }}"></script>
<script   src="{{ secure_url('js/materialize.clockpicker.js') }}"></script>
<script>
                        $(document).ready(function () {
                        $('ul.tabs').tabs();
                        });</script>

<script>
    $("#topMenuIcon, #maskMenuBg, #closeMenuIcon").click(function () {
    $("#mobRightMenu").toggleClass("leftMenuBlock", 1000, "easeOutSine");
    $("#mainBodyDiv").toggleClass("withMenuBody", 400, "easeOutSine");
    $("#maskMenuBg").toggleClass("menuMaskOn", 400, "easeOutSine");
    });
    function display(id) {
    $("#showinfo" + id).show();
    }
</script>

<script>
    $(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll >= 50) {
    $(".headerSec").addClass("darkHeader");
    } else {
    $(".headerSec").removeClass("darkHeader");
    }
    });
    function display(id){
    $("#showinfo" + id).show();
    }
    function filter(){
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    var location = $("#location").val();
    var searchterm = $("#search_term").val();
    var lat = $("#latitude").val();
    var lon = $("#longitude").val();
    if (((!lat) || (lat.length == 0)) && ((!lon) || (lon.length == 0))){
    Materialize.toast("Please enter an address so we can find matches near you.", 4000, 'redMessage');
    return false;
    }

    if (((!from_date) || (from_date.length == 0)) && ((!to_date) || (to_date.length == 0)) && ((!location) || (location.length == 0)) && ((!search_term) || (search_term.length == 0))){
    Materialize.toast("Please enter advanced search option", 4000, 'redMessage');
    return false;
    } else{
    $("#filters_form").append('<input type="hidden"  name="search_term" value="' + searchterm + '" />');
    $("#filters_form").submit();
    return true;
    }
    var lat = $("#latitude").val();
    var lon = $("#longitude").val();
    if (((!lat) || (lat.length == 0)) && ((!lon) || (lon.length == 0))){
    Materialize.toast("Please enter an address so we can find matches near you.", 4000, 'redMessage');
    return false;
    }
    }

    function search(){
    var searchterm = $("#search_term").val();
    if (searchterm.length == 0){
    Materialize.toast("Please enter search keywords", 4000, 'redMessage');
    return false;
    } else{
    //var from_date = $("#from_date").val();
    //var to_date = $("#to_date").val();
    //var location = $("#location").val();
    //$("#search_form").append('<input type="hidden"  name="from_date" value="' + from_date + '" />');
    //$("#search_form").append('<input type="hidden"  name="to_date" value="' + to_date + '" />');
    //$("#search_form").append('<input type="hidden"  name="location" value="' + location + '" />');
    $("#search_form").submit();
    return true;
    }
    }


    $('#from_date').bootstrapMaterialDatePicker({weekStart: 0, time: false, switchOnClick: true, okButton: false});
    $('#to_date').bootstrapMaterialDatePicker({weekStart: 0, time: false, switchOnClick: true, okButton: false});
    $(document).ready(function () {
    $('#from_date').bootstrapMaterialDatePicker
            ({
            time: false,
                    switchOnClick: true,
                    okButton: false
            });
    $('#to_date').bootstrapMaterialDatePicker
            ({
            time: false,
                    switchOnClick: true,
                    okButton: false
            });
    });
</script>
<style>
    #filters_form [type="checkbox"]:not(:checked), [type="checkbox"]:checked {
        left: 0px !important;
        opacity: 1 !important;
    }
</style>


@endsection

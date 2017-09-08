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
                <form method="get" action="{{ secure_url('jobs') }}" id="search_from">

                    <div class="textBoxSec"><input type="text" placeholder="Search by Name" name="search_term" id="search_term" /></div> 
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
            <div class="filterBtn"><a class="modal-trigger" href="#jsFindJobPopUpSec"><input type="button" value="Filter" class="btn"  /></a></div>
            <div class="clear"></div>
        </div>
        @if($data['status'] != 401)
       
            @if(count($jobs) > 0)
            <?php $i = 0; ?>
            @foreach($jobs as $job)
             <div class="pageContSec jsFindJobRowSec">
            <div class="pageContBox">
                   @if($job->image_url != null)
                  <a href="{{ url('dentalOfficeDetails/'.$job->office_id) }}" >
                <div class="profileImgSec" style="background-image:url({{ Config('constants.s3_url') . $job->image_url}});">
                <!--<img src="{{ Config('constants.s3_url') . $user->profile_image_thumb}}" />-->
                </div>
                </a>
                @else
             <a href="{{ url('dentalOfficeDetails/'.$job->office_id) }}" >
                <div class="profileImgSec" >
                  <img src="{{ secure_url('images/do-profile-placeholder.png') }}" />
                </div>
                </a>
                @endif
               

                <div class="profileDetailsSec">
                    <div class="profileRightBtnSec">
                    <a href="{{ url('message/'.$job->user_id) }}" class="btn">Chat</a>
                    </div>
                    <div class="threeDotSec">
                        <a class="dropdown-button" href="javascript:;" data-activates="dropDown{{ $job->id }}"><i class="material-icons">more_vert</i></a>                      
                        <ul id="dropDown{{ $job->id }}" class="dropdown-content">
                            <li> <a href="{{ url('message/'.$job->user_id) }}" class="btn">Chat</a></li>                         
                        </ul>
                    </div>
                
                    <div class="nameSec">
                        <a href="{{ url('dentalOfficeDetails/'.$job->office_id) }}" >{{  $job->name }}</a></div>

                    <div class="rowSec">                    
                        <div class="leftTextSec">Location </div>
                        <div class="rightTextSec locationBlueText"><a  target="_blank" href="https://maps.google.com/?q=   {{ $job->street.'  '.$job->city.'  '.$job->state.' '.$job->zipcode }}">
                               {{ $job->street}}
                               @if($job->city != NULL){{', '.$job->city}}@endif
                               @if($job->state!=NULL){{', '.$job->state }}@endif
                               @if($job->zipcode!=NULL){{', '.$job->zipcode }}@endif
                                            
                            </a></div>
                         <div class="clear"></div>
                    </div>
                     <div class="rowSec">                    
                        <div class="leftTextSec">Job Position </div>
                        <div class="rightTextSec">
                            @foreach($user_types as $user_type)
                            @if($user_type->id == $job->job_position)
                            {{ $user_type->user_type }} 
                            @endif
                            @endforeach
                        </div>
                         <div class="clear"></div>
                    </div>
                    <div class="rowSec">                    
                        <div class="leftTextSec">Type </div>
                        <div class="rightTextSec">
                            @foreach($job_types as $jobType)
                            @if($jobType->id == $job->type_id)
                            {{ $jobType->name }} 
                            @endif
                            @endforeach
                        </div>
                         <div class="clear"></div>
                    </div>
                    <div class="rowSec">                    
                        <div class="leftTextSec">Distance</div>
                        <div class="rightTextSec">{{ $job->distance }} miles</div>
                         <div class="clear"></div>
                    </div>
                    <div class="rowSec" id="showinfo{{ $job->id }}" style="display:none;">                    
                        <div class="leftTextSec">Contact info</div>
                        <div class="rightTextSec">Email: {{ $job->email }}<br>
                            Phone: {{ $job->phone_number }}</div>
                         <div class="clear"></div>
                    </div>
                    <div class="rowSec">  
                        <div class="rightTextSec">
                            <a  href="{{ secure_url('postDetails/'.$job->id) }}">View Full Posting</a>
                        </div>
                         <div class="clear"></div>
                    </div>
                </div>

                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <?php $i++; ?>
             </div>
            @endforeach
            <div class="clear"></div>
       
        <div class="paginationDivSec">
 
             @include('pagination.default', ['paginator' => $jobs->appends(Request::except('page'))])
        </div>
        @else
        <div class="rowSec">
            No jobs found yet..
             <div class="clear"></div>
        </div>
        @endif
        @else
        <div class="paginationDivSec">
            <p class="noAddressAlert">Please update your address before searching for jobs.</p>
        </div>
        @endif

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
<div id="jsFindJobPopUpSec" class="modal modal-fixed-footer jsFindJobPopUpSec">
    <div class="modalHeader">
        Filter
        <div class="closeBtnSec"><a href="#!" class="modal-action modal-close"><i class="material-icons">close</i></a></div>
    </div>
    <div class="modalContentSec">
        <div>
            <form method="get" action="{{ secure_url('jobs') }}" id="filters_form">

                <div class="formRowSec">
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
                </div>
                <div class="formRowSec">
                    <div class="input-field">                            
                         <select id="job_type" name="job_type">
                            <option selected value="">Any</option>
                            @foreach ($job_types as $job_type)
                            <option value="{{ $job_type->id }}">{{ $job_type->name  }}</option>
                            @endforeach

                        </select>
					 
                        <label for="job_type">Job Type</label>
                    </div>           
                    <div class="input-field">                            
                        <select id="job_position" name="job_position">
                            <option selected value="">Any</option>
                            @foreach ($user_types as $user_type)
                            <option value="{{ $user_type->id }}">{{ $user_type->user_type  }}</option>
                            @endforeach
                        </select>
                        <label for="job_position ">Job Position </label>
                    </div>
                    <div class="clear"></div>
                </div>
           
               
                 <?php
                  //validation if user address is empty//
                 foreach ($usersss as $value) {
             $lat =  $value->latitude;
             $lon =  $value->longitude;
          }
        ?>
                <input id="latitude" type="hidden" name="latitude" class="validate" value="{{ $lat }}">
                <input id="longitude" type="hidden" name="longitude" class="validate" value="{{ $lon }}">
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
                        $(document).ready(function(){
                        $('ul.tabs').tabs();
                        });</script>

<script>
    $("#topMenuIcon, #maskMenuBg, #closeMenuIcon").click(function() {
    $("#mobRightMenu").toggleClass("leftMenuBlock", 1000, "easeOutSine");
    $("#mainBodyDiv").toggleClass("withMenuBody", 400, "easeOutSine");
    $("#maskMenuBg").toggleClass("menuMaskOn", 400, "easeOutSine");
    });
    function display(id){
    $("#showinfo" + id).show();
    }
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
    function search(){
    var searchterm = $("#search_term").val();
    if (searchterm.length == 0){
    Materialize.toast("Please enter search term", 4000, 'redMessage');
    return false;
    } else{
    var from_date = $("#from_date").val();
    var to_date = $("#to_date").val();
    var travel_distance = $("#travel_distance").val();
    var job_type = $("#job_type").val();
    var job_position = $("#job_position").val();
    $("#search_from").append('<input type="hidden"  name="from_date" value="' + from_date + '" />');
    $("#search_from").append('<input type="hidden"  name="to_date" value="' + to_date + '" />');
     if(travel_distance != null && travel_distance.length > 0){
    $("#search_from").append('<input type="hidden"  name="travel_distance" value="' + travel_distance + '" />');
    }
     if(job_type != null && job_type.length > 0){
    $("#search_from").append('<input type="hidden"  name="job_type" value="' + job_type + '" />');
    }if(job_position != null && job_position.length > 0){
    $("#search_from").append('<input type="hidden"  name="job_position" value="' + job_position + '" />');
    }
    $("#search_from").submit();
    return true;
    }
    }
    function filter(){
    var from_date = $.trim($("#from_date").val());
    var to_date = $.trim($("#to_date").val());
    var travel_distance = $.trim($("#travel_distance").val());
    var searchterm = $.trim($("#search_term").val());
    var job_type = $.trim($("#job_type").val());
    var job_position = $.trim($("#job_position").val());
    var lat = $("#latitude").val() ;
         var lon = $("#longitude").val() ;
        if (((!lat) || (lat.length == 0)) && ((!lon) || (lon.length == 0))){
    Materialize.toast("Please enter an address so we can find matches near you.", 4000, 'redMessage');
    return false;
    }
    if (((!from_date) || (from_date.length == 0)) && ((!to_date) || (to_date.length == 0)) && ((!travel_distance) || (travel_distance.length == 0)) && ((!job_type) || (job_type.length == 0)) && ((!job_position) || (job_position.length == 0))){
    Materialize.toast("Please enter advanced search option", 4000, 'redMessage');
    return false;
    } else{
    $("#filters_form").append('<input type="hidden"  name="search_term" value="' + searchterm + '" />');
    $("#filters_form").submit();
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


@endsection
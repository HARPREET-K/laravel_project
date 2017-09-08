@extends('layouts.app')

@section('content')
<!--Left Section Start-->
@include('includes.sidebar')
<!--Left Section End-->


<div class="headerSec">
    <div class="topHeader">
            <div id="topMenuIcon" class="topMenuIcon"><a href="#"><i class="material-icons">menu</i></a><div class="mainTitleSec">Pontic<!--<img src="images/logo-login.png" />--></div></div>


    </div>
</div>

<!--Body Section Start-->
<div id="mainBodyDiv" class="bodyContSec withOutTopMenu">

    <div class="createProfilePage">
        <div class="pageContSec">
            <div class="pageContBox viewProfileListBox">
              
                
                 @if(!empty($jobseeker->profile_image_thumb))
                <div class="profileImgSec" style="background-image:url({{ Config('constants.s3_url') . $jobseeker->profile_image_thumb}});">
                <!--<img src="{{ Config('constants.s3_url') . $user->profile_image_thumb}}" />-->
                </div>
                @else
                <div class="profileImgSec" >
                <img src="{{ secure_url('images/profile-img.png') }}" />
                </div>
                @endif
                <div class="profileDetailsSec">
                    <div class="profileDetailsRows">
                        <div class="headingText">Name</div>
                        <div class="normalTextSec">
                             @if($jobseeker->title != null)
                            {{ $jobseeker->title.'.'}}
                            @endif
                            @if($jobseeker->credential != null)
                            {{$jobseeker->name.', '.$jobseeker->credential }}
                            @else
                            {{$jobseeker->name}}
                            @endif
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
                            </span></div>
							 
                        <div class="clear"></div>
                    </div>
                   
                    <div class="profileDetailsRows">
                        <div class="headingText">Years of Experience</div>
                        <div class="normalTextSec">{{ $jobseeker->experience }} </div>
                        <div class="clear"></div>
                    </div>
                    <div class="profileDetailsRows">
                        <div class="headingText">Expected Pay</div>
                        <div class="normalTextSec">${{ $jobseeker->expected_pay }}/hr</div>
                        <div class="clear"></div>
                    </div>
                     <div class="profileDetailsRows">
                                        <div class="headingText">Location</div>
                                        <div class="normalTextSec">                                            
                                        
                                            @if($jobseeker->city != NULL){{' '.$jobseeker->city}}@endif
                                            @if($jobseeker->state!=NULL){{', '.$jobseeker->state }}@endif
                                            
                                        </div>
                                         </a>
                                        <div class="clear"></div>
                                    </div>
                    <div class="profileDetailsRows">
                        <div class="headingText">State License</div>
                        <div class="normalTextSec">{{ $jobseeker->state_license }}</div>
                        <div class="clear"></div>
                    </div>
					 
			 <div class="profileRightBtnSec">
             <a href="{{ secure_url('message/'.$jobseeker->id) }}" class="btn">Chat</a>
                            
						  </div>		
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="pageContSec">
            <div class="row">
                <ul class="tabs">
                    <li class="tab col s6"><a class="active" href="#additionalInformation">Additional Information</a></li>
                    <li class="tab col s6"><a href="#availability">Availability</a></li>
                </ul>
                <div id="additionalInformation" class="addiInfoSec">
                    <div class="pageContBox">
                        <div class="formSec">
                            <div id="skillFormSec">

                            
                                <div class="contactDetailsSec">
                                     @if($jobseeker->make_private ==0 )
                                    <div class="pageTitle2">Contact</div>

                                   
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Email</div>
                                        <div class="normalTextSec">
                                            <a href="mailto:{{ $jobseeker->contact_email }}">{{ $jobseeker->contact_email }}</a></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Phone Number</div>
                                        <div class="normalTextSec">{{ $jobseeker->mobile_number }}</div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Additional Number</div>
                                        <div class="normalTextSec">{{ $jobseeker->aditional_number }}</div>
                                        <div class="clear"></div>
                                    </div>
                                     
                                     @endif
                                       <div class="pageTitle2">Additional Information</div>
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Travel Distance</div>
                                        @if($jobseeker->travel_distance >0)
                                        <div class="normalTextSec">{{ $jobseeker->travel_distance.' miles' }}</div>
                                        @else
                                        <div class="normalTextSec">{{ '0 miles' }}</div>
                                        @endif
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                               <div class="headingText">Malpractice Insurance</div>                                    
                                        <div class="normalTextSec">
                                            &nbsp;
                                            @if($jobseeker->malpractice_insurance ==1)
                                            {{ 'Yes' }}
                                            @else
                                            {{ 'No' }}
                                            @endif
                                        </div>
                                        
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                               <div class="headingText">Languages</div>
                                        <div class="normalTextSec">
                                            {{ $jobseeker->languages }}
                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                     
                                    
                                    <div class="clear"></div>

                                </div>
                                <div class="skillsSec">
                                    <div class="pageTitle2">Professional Summary</div>
                                    <div class="professionalSummaryBoxSec">{{ $jobseeker->user_note }}</div>
                                   

                                    <div class="profileDetailsRows">
                                        <div class="headingText">Software</div>
                                        <div class="normalTextSec">

                                            {{ $user_skills_software }}


                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Radiology</div>
                                        <div class="normalTextSec">
                                            {{ $user_skills_radiology  }}
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Education</div>
                                        <div class="normalTextSec">
                                          
                                             <?php 
                                            $edu = json_decode(json_encode($user_education), True);
                                            $edus = array();
                                            foreach($edu as $educa){ 
                                                ?>
                                            {{ $educa['qualification'].', '}}<b>{{$educa['year'] }}</b>
                                            <br>
                                            <?php } ?>
                                            
                                          
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Specialties </div>
                                        <div class="normalTextSec">
                                           {{ $user_exprience[0]->position or '' }}
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Certifications</div>
                                        <div class="normalTextSec">
                                          
                                            <?php 
                                             
                                            $array = json_decode(json_encode($user_certifications), True);
                                            $tags = array();
                                            foreach($array as $cert){?>
                                            {{ $cert['certification'].', '}}<b>{{$cert['year'] }}</b>
                                            
                                           <br>
                                            <?php } ?>
                                            
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>

                                </div>
                            </div>


                         
                            <div class="clear"></div>
                        </div>
                    </div>

                </div>
                <div id="availability">
                    <div class="availabilityTabSec">
                        <div class="enterAvailabilFormSec" id="enterAvailabilitySec">
                        
                             
                            <div class="pageTitle2">Office Hours</div>
                            
                                <div class="dayTimeRowSec">
                                <div class="daySec">
                                    Monday
                                </div>
                                <div class="timeSec">
                                   
                                    @if(count($available_timings) > 0 && $available_timings[0]->start_time != -1 )                                    
                                    {{ date('h:i A',strtotime($available_timings[0]->start_time)).'-'.date('h:i A',strtotime($available_timings[0]->end_time))  }} 
                                    @else
                                       {{ 'Not Available' }}                                
                                    @endif
                                </div>
                                <div class="clear"></div>
                            </div>
                             
                            <div class="dayTimeRowSec">
                                <div class="daySec">
                                    Tuesday
                                </div>
                                <div class="timeSec">
                                    @if(count($available_timings) > 0 && $available_timings[1]->start_time != -1)
                                    {{ date('h:i A',strtotime($available_timings[1]->start_time)).'-'.date('h:i A',strtotime($available_timings[1]->end_time))  }}
                                    @else
                                  {{ 'Not Available' }} 
                                   @endif
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="dayTimeRowSec">
                                <div class="daySec">
                                    Wednesday
                                </div>
                                <div class="timeSec">
                                    @if(count($available_timings) > 0 && $available_timings[2]->start_time != -1)
                                    {{ date('h:i A',strtotime($available_timings[2]->start_time)).'-'.date('h:i A',strtotime($available_timings[2]->end_time))  }}
                                    
                                    @else
                                   {{ 'Not Available' }}
                                   @endif
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="dayTimeRowSec">
                                <div class="daySec">
                                    Thursday
                                </div>
                                <div class="timeSec">
                                    @if(count($available_timings) > 0 && $available_timings[3]->start_time != -1)
                                   {{ date('h:i A',strtotime($available_timings[3]->start_time)).'-'.date('h:i A',strtotime($available_timings[3]->end_time))  }}
                                    @else
                                   {{ 'Not Available' }}
                                 @endif
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="dayTimeRowSec">
                                <div class="daySec">
                                    Friday
                                </div>
                                <div class="timeSec">
                                    @if(count($available_timings) > 0 && $available_timings[4]->start_time != -1)
                                      {{ date('h:i A',strtotime($available_timings[4]->start_time)).'-'.date('h:i A',strtotime($available_timings[4]->end_time))  }}
                                  @else
                                   {{ 'Not Available' }}
                                    @endif
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="dayTimeRowSec">
                                <div class="daySec">
                                    Saturday
                                </div>
                                <div class="timeSec">
                                     @if(count($available_timings) > 0 && $available_timings[5]->start_time != -1)
                                    {{ date('h:i A',strtotime($available_timings[5]->start_time)).'-'.date('h:i A',strtotime($available_timings[5]->end_time))  }}
                                    @else
                                   {{ 'Not Available' }}
                                   @endif
                                </div>
                                <div class="clear"></div>
                            </div>
                            <div class="dayTimeRowSec">
                                <div class="daySec">
                                    Sunday
                                </div>
                                <div class="timeSec">
                                    @if(count($available_timings) > 0 &&  $available_timings[6]->start_time != -1)
                                    {{ date('h:i A',strtotime($available_timings[6]->start_time)).'-'.date('h:i A',strtotime($available_timings[6]->end_time))  }}
                                    @else
                                    {{ 'Not Available' }}
                                   @endif
                                </div>
                                <div class="clear"></div>
                            </div>
                            </div>
                            <div class="clear"></div>
                        
                  
                        </div>
                        <div class="clear"></div>

                     
                    </div>


                </div>
            </div>
        </div>
    
     <div class="footerContentSec">
        	<a class="modal-trigger" href="#modal1">Terms and Conditions</a> and <a class="modal-trigger" href="#modal2">Privacy Policy</a>
            <div class="clear"></div>
            <a title="DMCA.com Protection Status" class="dmca-badge" href="https://www.dmca.com/Protection/Status.aspx?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"> 
            <img alt="DMCA.com Protection Status" src="https://images.dmca.com/Badges/dmca_protected_sml_120k.png?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"></a>
            <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
        </div>

    </div>

</div>

<!--Body Section End-->


<div id="maskMenuBg"></div>
@include('includes.terms')
 
@endsection


@section('script')
<script>
    $(document).ready(function () {
        $('ul.tabs').tabs();
    });</script>
<script>
    $(document).ready(function () {
        $('ul.tabs').tabs();
        $("#enterAvailabilFormSec").hide();
        $("#enterAvailabilityBtn, #enterAvailabilityBtn1, #enterAvailabilityBtn2").click(function () {
            $("#enterAvailabilitySec").hide();
            $("#enterAvailabilFormSec").show();
        });
        $("#editSkillFormSec").hide();
        $("#editSkillBtn, #editSkillBtn1").click(function () {
            $("#skillFormSec").hide();
            $("#editSkillFormSec").show();
                  
    });
   
    });</script>



<script>
            $("#topMenuIcon, #maskMenuBg, #closeMenuIcon").click(function () {
        $("#mobRightMenu").toggleClass("leftMenuBlock", 1000, "easeOutSine");
        $("#mainBodyDiv").toggleClass("withMenuBody", 400, "easeOutSine");
        $("#maskMenuBg").toggleClass("menuMaskOn", 400, "easeOutSine");
    });
    $(window).scroll(function () {
        var scroll = $(window).scrollTop();
        if (scroll >= 50) {
            $(".headerSec").addClass("darkHeader");
        } else {
            $(".headerSec").removeClass("darkHeader");
        }
    });


</script>


@endsection

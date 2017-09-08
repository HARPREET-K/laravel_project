
@extends('layouts.app')

@section('content') 

@include('includes.sidebar')



<div class="headerSec">
    <div class="topHeader">
            <div id="topMenuIcon" class="topMenuIcon"><a href="#"><i class="material-icons">menu</i></a><div class="mainTitleSec">Pontic<!--<img src="images/logo-login.png" />--></div></div>


    </div>
</div>

<!--Body Section Start-->
<div id="mainBodyDiv" class="bodyContSec withOutTopMenu">

    <div class="createProfilePage doProfileCreateSec">
        <div class="pageContSec">
            <div class="pageContBox">
                <div class="formSec">
                    <div class="genInfoFormSec">
                          @if(!empty($officeInformation->profilePic))
                            <div class="upLoadImgSec" style="background-image:url({{ Config('constants.s3_url') . $officeInformation->profilePic}});">
                              <div class="clear">&nbsp;</div>
                              </div>
                            @else
                            <div class="upLoadImgSec">
                             <img src="{{ secure_url('images/do-office-profile.jpg') }}" />
                             <div class="clear">&nbsp;</div>
                             </div>
                            @endif
                      
                        <div class="detailFormSec row">
                            <div class="pageTitle2">{{ $officeInformation->name  }}</div>
				<div class="profileRightBtnSec">
				   <a href="{{ secure_url('message/'.$officeInformation->user_id) }}" class="btn" style="float:right; width:110px;">Chat</a>
				</div>
                            <div class="commonRow">
                                <div class="headingText">Website</div>
                                <div class="normalText">{{ $officeInformation->website }}</div>
                            </div>
                            <div class="commonRow">
                                <div class="headingText">Office Specialty</div>
                                <div class="normalText">{{ $officeInformation->office_speciality }}</div>
                            </div>
                            <div class="commonRow">
                                <div class="headingText">Dentists</div>
                                <div class="normalText">
                                    @if(count($officeDentists)>0)

                                    @foreach ($officeDentists as $dentist)
                                    {{ $dentist->title.'.'.$dentist->name.', '.$dentist->credential.'  '}}
                                    @endforeach
                                    @else
                                    No dentists found
                                    @endif
                                </div>
                            </div>
                            <div class="clear"></div>

                           @if(count($officeImages) > 0)
                            <div class="officeImagesListSec">
                                <div>
                                    <div id="owl-demo" class="owl-carousel officePhotoGallery">
                                        @foreach($officeImages as $officeImage)
                                        <div class="item">
                                           
                                        <a href="{{ url(Config('constants.s3_url').$officeImage->image_url) }}" style="background-image:url({{ url(Config('constants.s3_url').$officeImage->thumb_url) }});" >
                                                <img class="lazyOwl" data-src="{{ url(Config('constants.s3_url').$officeImage->thumb_url) }}" alt="Lazy Owl Image">
                                                </a>
                                        </div>        
                                        @endforeach
                                    </div>
                                </div>
                            </div>   
                            @endif

                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pageContSec">
            <div class="row">
                <div class="s12">
                    <ul class="tabs">
                        <li class="tab col s6"><a  href="#additionalInformation">Additional Information</a></li>
                        <li class="tab col s6"><a class="active" href="#jobOpening">Job Opening</a></li>
                    </ul>
                </div>
                <div id="additionalInformation" class="addiInfoSec">


                    <div class="pageContBox">
                        <div class="formSec" id="viewContactDetailsDiv">

                            <div class="contactDetailsSec">
                                <div class="pageTitle2">Contact</div>
                                <div class="fieldRowSec">
                                    <div class="headingText">Email</div>
                                    <div class="normalText">
                                        <a href="mailto:{{ $officeInformation->email }}">{{ $officeInformation->email }}</a></div>
                                </div>
                                <div class="fieldRowSec">
                                    <div class="headingText">Contact Person</div>
                                    <div class="normalText">{{ $officeInformation->contact_person_name.', '.$officeInformation->job_position }}</div>
                                </div>
                                <div class="fieldRowSec">
                                    <div class="headingText">Phone Number</div>
                                    <div class="normalText">{{ $officeInformation->phone_number }}</div>
                                </div>
                                <div class="fieldRowSec">
                                    <div class="headingText">Additional Number</div>
                                    <div class="normalText">{{ $officeInformation->aditional_number }}</div>
                                </div>
                                <div class="fieldRowSec">
                                    <div class="headingText">Address</div>
                                    <div class="normalText">
                                        <a  target="_blank" href="https://maps.google.com/?q= {{ $officeInformation->street.'  '.$officeInformation->city.'  '.$officeInformation->state }}">
                                            {{ $officeInformation->street}}
                                            @if($officeInformation->city != NULL){{', '.$officeInformation->city}}@endif
                                            @if($officeInformation->state!=NULL){{', '.$officeInformation->state }}@endif
                                            @if($officeInformation->zipcode!=NULL){{', '.$officeInformation->zipcode }}
                                            @endif
                                        </a>
                                    </div>
                                </div>








                                <div class="clear"></div>
                                <div class="pageTitle2 pageSecondHeading">Software & Radiology</div>
                                <div class="clear"></div>

                                <div class="fieldRowSec">
                                    <div class="headingText">Software</div>
                                    <div class="normalText">{{ $office_skills_software }}</div>
                                </div>

                                <div class="fieldRowSec">
                                    <div class="headingText">Radiology</div>
                                    <div class="normalText">{{ $office_skills_radiology }}</div>
                                </div>





                            </div>
                            <div class="skillsSec">
                                <div class="pageTitle2">Hours of Operation</div>

                                <div class="fieldRowSec">
                                    <div class="headingText">Monday</div>
                                    <div class="normalText">{{ $officeTimings[0]->Mon or 'Closed' }}</div>
                                </div>
                                <div class="fieldRowSec">
                                    <div class="headingText">Tuesday</div>
                                    <div class="normalText">{{ $officeTimings[0]->Tue or 'Closed' }}</div>
                                </div>
                                <div class="fieldRowSec">
                                    <div class="headingText">Wednesday</div>
                                    <div class="normalText">{{ $officeTimings[0]->Wed or 'Closed' }}</div>
                                </div>
                                <div class="fieldRowSec">
                                    <div class="headingText">Thursday</div>
                                    <div class="normalText">{{ $officeTimings[0]->Thu or 'Closed' }}</div>
                                </div>
                                <div class="fieldRowSec">
                                    <div class="headingText">Friday</div>
                                    <div class="normalText">{{ $officeTimings[0]->Fri or 'Closed' }}</div>
                                </div>
                                <div class="fieldRowSec">
                                    <div class="headingText">Saturday</div>
                                    <div class="normalText">{{ $officeTimings[0]->Sat or 'Closed' }}</div>
                                </div>
                                <div class="fieldRowSec">
                                    <div class="headingText">Sunday</div>
                                    <div class="normalText">{{ $officeTimings[0]->Sun or 'Closed' }}</div>
                                </div>

                                <div class="clear"></div>
                                <div class="pageTitle2 specCertiHeading">About Us</div>
                                <div class="clear"></div>
                                <div class="proSummaryTextareaSec">
                                    {{ $officeInformation->note }}
                                </div>

                            </div>
                            <div class="clear"></div>


                        </div>

                    </div>




                </div>
                <div id="jobOpening">
                    <div class="clear"></div>
                    <div class="denOffOpenDetailSec" id="jobOpeningFormSec">
                        <div class="pageContBox">
                            <div class="formSec formBoxesSec">
                                <div class="backBtn"><a href="" onclick="history.go(-1);"><i class="material-icons">arrow_back</i> Back </a></div>

                                <div class="clear"></div>
                                <div class="boxLeftSec">
                                    <div class="fieldRowSec">
                                        <div class="headingText">Type of job</div>
                                        <div class="normalText">
                                            @foreach($job_types as $jobType)
                                            @if($jobType->id == $job['type_id'])
                                            {{ $jobType->name }} 
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="boxRightSec">
                                    <div class="fieldRowSec">
                                        <div class="headingText">Job Postion</div>
                                        <div class="normalText"> 
                                            @foreach($user_types as $user_type)
                                            @if($user_type->id == $job['job_position'])
                                            {{ $user_type->user_type }} 
                                            @endif
                                            @endforeach</div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div>
                                    <div class="fieldRowSec">
                                        <div class="headingText">Job Description</div>
                                        <div class="normalText">{{ $job['description'] }}</div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>


                    <div class="clear"></div>
                </div>
            </div>
        </div>

    </div>

    <div class="footerContentSec">
	 <a href="mailto:contact@pontic.com" target="_top">Send your feedback</a>
                    <div class="clear"></div>
        <a class="modal-trigger" href="#modal1">Terms and Conditions</a> and <a class="modal-trigger" href="#modal2">Privacy Policy</a>
        <div class="clear"></div>
        <a title="DMCA.com Protection Status" class="dmca-badge" href="https://www.dmca.com/Protection/Status.aspx?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"> 
            <img alt="DMCA.com Protection Status" src="https://images.dmca.com/Badges/dmca_protected_sml_120k.png?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"></a>
        <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"></script>
    </div>
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
        $("#editContactDetailsDiv").hide();
        $("#editContactBtn, #editContactBtn1").click(function () {
            $("#viewContactDetailsDiv").hide();
            $("#editContactDetailsDiv").show();
        });
        $("#editJobOpeningForm").hide();
        $("#editJobOpening").click(function () {
            $("#jobOpeningFormSec").hide();
            $("#editJobOpeningForm").show();
        });

    }
    );

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

<script src="{{ secure_url('js/jquery.classybox.min.js') }}"></script>
<script src="{{ secure_url('js/owl.carousel.js') }}"></script>

<script>


    $(document).ready(function () {

        $("#doJobOpeninBack").click(function () {
            $("#editJobOpeningForm").hide();
            $("#jobOpeningFormSec").show();

        });

        $("#owl-demo").owlCarousel({
            items: 5,
            lazyLoad: true,
            navigation: true
        });
        $(".officePhotoGallery .item a").ClassyBox();

    });






</script>



@endsection

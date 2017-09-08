
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
                        <div class="editBtnSec">
                            <a class="modal-trigger waves-effect waves-light btn linkBtn generalEditBtn" href="#editGeneralInfo">Edit</a>

                            <a class="dropdown-button threeDotDrop" href="#!" data-activates="dropDown1"><i class="material-icons">more_vert</i></a>
                            <!-- Dropdown Structure -->
                            <ul id="dropDown1" class="dropdown-content">
                                <li><a class="modal-trigger" href="#editGeneralInfo">Edit</a></li>
                                <!--<li class="divider"></li>-->
                            </ul>
                        </div>
                        <div class="upLoadImgSec">
                            @if(!empty($user->profile_image_thumb))
                            <img src="{{ Config('constants.s3_url') . $user->profile_image_thumb}}" />
                            @else
                            <img src="{{ secure_url('images/do-office-profile.jpg') }}" />
                            @endif
                            <div class="clear">&nbsp;</div>
                            <!--<button class="waves-effect waves-light btn upProfImgBtn">Upload Profile Image</button>-->
                            <div class="clear"></div>
                        </div>
                        <div class="detailFormSec row">
                            <div class="pageTitle2">{{ $officeInformation->name or 'Dental Office' }}</div>
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
                                        <div class="item"><a href="{{ url(Config('constants.s3_url').$officeImage->image_url) }}"><img class="lazyOwl" data-src="{{ url(Config('constants.s3_url').$officeImage->image_url) }}" alt="Lazy Owl Image"></a></div>
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
                            <div class="editBtnSec">
                                <input type="button" value="Edit" class="waves-effect waves-light btn generalEditBtn" id="editContactBtn" />

                                <a class="dropdown-button threeDotDrop" href="#!" data-activates="dropDown3"><i class="material-icons">more_vert</i></a>
                                <!-- Dropdown Structure -->
                                <ul id="dropDown3" class="dropdown-content">
                                    <li><a id="editContactBtn1">Edit</a></li>
                                    <!--<li class="divider"></li>-->
                                </ul>
                            </div>
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
                        <div class="formSec loaderParentDiv" id="editContactDetailsDiv">
                            <form   id="additional_infor_form" role="form" method="POST" action="" > 
                                <input type="hidden" name="_token" value="{{ csrf_token()}}">   
                                <div class="contactDetailsSec">
                                    <div class="pageTitle2">Contact</div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="name" type="text" class="validate" name="contact_name" value="{{ $officeInformation->name }}">
                                            <label for="name">Contact Person Name</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="job-position" type="text" class="validate" name="job_position"  value="{{ $officeInformation->job_position }}">
                                            <label for="job-position">Job Position</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="email" type="text" class="validate" name="email" value="{{ $officeInformation->email }}">
                                            <label for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="office-number" type="text" class="validate" name="Office_number" value="{{ $officeInformation->phone_number }}">
                                            <label for="office-number">Office Number</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="additional-number" type="text" class="validate" name="aditional_number" value="{{ $officeInformation->aditional_number }}">
                                            <label for="additional-number">Additional Number</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="Street address" type="text" class="validate" name="street" value="{{ $officeInformation->street }}">
                                            <label for="email">Street Address</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="city" type="text" class="validate" name="city" value="{{ $officeInformation->city }}">
                                            <label for="city">City</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="state" type="text" class="validate" name="state" value="{{ $officeInformation->state }}">
                                            <label for="state">State</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="zip-code" type="text" class="validate" name="zipcode" value="{{ $officeInformation->zipcode }}">
                                            <label for="zip-code">Zip Code</label>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                    <div class="pageTitle2 pageSecondHeading">Software & Radiology</div>
                                    <div class="clear"></div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <select multiple id="skills_software" name="software_skills[]">
                                                <option value="" disabled >Choose your Skills</option>
                                                @foreach ($sofaware_skills as $sofaware_skill)

                                                <option value="{{ $sofaware_skill->id }}" {{ (in_array($sofaware_skill->id, $s_skillIDS) ? "selected":"") }}>{{ $sofaware_skill->skill }}</option>

                                                @endforeach

                                            </select>
                                            <label for="software">Software (Dentrix, EagleSoft, etc.)</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <select multiple id="skills_radiology" name="radiology_skills[]">
                                                <option value="" disabled >Choose your Skills</option>
                                                @foreach ($radiology_skills as $radiology_skill)
                                                <option value="{{ $radiology_skill->id }}" {{ (in_array($radiology_skill->id, $r_skillIDS) ? "selected":"") }} >{{ $radiology_skill->skill }}</option>
                                                @endforeach
                                            </select>
                                            <label for="radiology">Radiology (DEXIS, ScanX, etc.)</label>
                                        </div>
                                    </div>






                                </div>
                                <div class="skillsSec">
                                    <div class="pageTitle2">Hours of Operation</div>

                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="monday" type="text" class="validate" name="Monday" value="{{ $officeTimings[0]->Mon or '' }}">
                                            <label for="monday">Monday</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="tuesday" type="text" class="validate" name="Tuesday" value="{{ $officeTimings[0]->Tue or '' }}">
                                            <label for="tuesday">Tuesday</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="wednesday" type="text" class="validate" name="Wednesday" value="{{ $officeTimings[0]->Wed or '' }}">
                                            <label for="wednesday">Wednesday</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="thursday" type="text" class="validate" name="Thursday" value="{{ $officeTimings[0]->Thu or '' }}">
                                            <label for="thursday">Thursday</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="friday" type="text" class="validate" name="Friday" value="{{ $officeTimings[0]->Fri or '' }}">
                                            <label for="friday">Friday</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="saturday" type="text" class="validate" name="Saturday" value="{{ $officeTimings[0]->Sat or '' }}">
                                            <label for="saturday">Saturday</label>
                                        </div>
                                    </div>
                                    <div class="fieldRowSec">
                                        <div class="input-field">
                                            <input id="sunday" type="text" class="validate" name="Sunday" value="{{ $officeTimings[0]->Sun or '' }}">
                                            <label for="sunday">Sunday</label>
                                        </div>
                                    </div>




                                    <div class="clear"></div>
                                    <div class="pageTitle2 specCertiHeading">About Us</div>
                                    <div class="clear"></div>
                                    <div class="proSummaryTextareaSec">
                                        <div class="input-field">
                                            <textarea class="materialize-textarea" name="note">{{ $officeInformation->note }}</textarea>
                                        </div>
                                    </div>

                                </div>
                                <div class="clear"></div>
                                <div class="fieldRowSec">
                                    <div class="saveBtnSec">
                                        <input type="button" class="waves-effect waves-light btn" value="Cancel" onclick="location.href='/pontic_dev/dentalOfficeProfile';" id="cancleEdit" />
                                        <input type="button" class="waves-effect waves-light btn" value="Save" id="additional_info"/>
                                    </div>
                                </div>
                                <div class="loaderBodySec" id="additionalinfoloader" style="display: none;">
                                    <div class="preloader-wrapper active" >
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
                                <div class="clear"></div>
                            </form>
                        </div>
                    </div>




                </div>
                <div id="jobOpening">
                    <div class="clear"></div>
                    <div class="denOffOpenDetailSec" id="jobOpeningFormSec">
                        <div class="pageContBox">
                            <div class="formSec formBoxesSec">
                                <div class="backBtn"><a href="{{ url('/dentalOfficeProfile#jobOpening') }}"><i class="material-icons">arrow_back</i> Back </a></div>
                                <div class="topRightBtnSec">
                                    @if($job['is_completed'] == 0)
                                    <input type="button" value="Edit" class="editBtn btn" id="editJobOpening" />
                                    @endif
                                    <input type="button" value="Delete" class="deleteBtn btn" id="deleteJobBtn"/>
                                    <input type="button" value="{{ ( $job['is_completed'] == 0  ? "Not Completed":"Completed") }}" class="completeBtn btn" id="completeJobBtn"/>
                                    <form  id="delete_job_form" role="form" method="POST" action="" >
                                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                        <input type="hidden" name="job_id" value="{{ $job['id'] }}">
                                    </form>
                                    <form  id="complete_job_form" role="form" method="POST" action="" >
                                        <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                        <input type="hidden" name="job_id" value="{{ $job['id'] }}">
                                    </form>

                                </div>
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
                                <!----<div class="boxRightSec">
                                    <div class="fieldRowSec">
                                        <div class="headingText">Start Date</div>
                                        <div class="normalText">{{ date('M d, Y', $job['start_date']) }}</div>
                                    </div>
                                    <div class="clear"></div>
                                </div>----->
                                <div class="boxLeftSec">
                                    <div class="fieldRowSec">
                                        <div class="headingText">Job Postion</div>
                                        <div class="normalText">
                                            @foreach($user_types as $user_type)
                                            @if($user_type->id == $job['job_position'])
                                            {{ $user_type->user_type }} 
                                            @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                               <!----- <div class="boxRightSec">
                                    <div class="fieldRowSec">
                                        <div class="headingText">End Date</div>
                                        <div class="normalText">{{ date('M d, Y', $job['end_date']) }}</div>
                                    </div>
                                    <div class="clear"></div>
                                </div>----->
                                <div>
                                    <div class="fieldRowSec">
                                        <div class="headingText">Job Description</div>
                                        <div class="normalText">
                                            {{ $job['description'] }}
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                    <div class="clear"></div>

                    <div class="jobOpeningFormSec addiInfoSec loaderParentDiv" id="editJobOpeningForm">
                        <div class="pageContBox">
                            <form  id="edit_job_form" role="form" method="POST" action="" >
                                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                <input type="hidden" name="job_id" value="{{ $job['id'] }}">
                                <div class="formSec formBoxesSec">
                                    <div class="backBtn" id="doJobOpeninBack"><i class="material-icons">arrow_back</i> Back</div>
                                    <div class="clear"></div>

                                    <div class="boxLeftSec">
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <select  id="type_of_job" name="job_type">
                                                    <option value="">Choose Job Type</option>
                                                    @foreach ($job_types as $job_type)

                                                    <option value="{{ $job_type->id }}" {{ ($job_type->id == $job['type_id'] ? "selected":"") }}>{{ $job_type->name  }}</option>

                                                    @endforeach

                                                </select>
                                                <label for="type-of-job">Type of job</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <select  id="job_position" name="job_Position">
                                                    <option value="">Choose Job Postiion</option>
                                                    @foreach ($user_types as $user_type)

                                                    <option value="{{ $user_type->id }}" {{ ($user_type->id == $job['job_position'] ? "selected":"") }}>{{ $user_type->user_type  }}</option>

                                                    @endforeach

                                                </select>
                                                <label for="type-of-job">Job Position</label>
                                            </div>
                                        </div>
                                        <!-----<div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="startdate" type="text"   name="start_date" value="{{ date('M d, Y', $job['start_date']) }}">
                                                <label for="startdate">Start Date</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="enddate" type="text"  name="end_date" value="{{ date('M d, Y', $job['end_date']) }}">
                                                <label for="enddate">End Date</label>
                                            </div>
                                        </div>----->
                                        <div class="clear"></div>
                                    <div class="pageTitle2 specCertiHeading">Job Description</div>
                                    <div class="clear"></div>
                                    <div class="proSummaryTextareaSec">
                                        <div class="input-field">
                                            <textarea class="materialize-textarea" name="job_description">{{ $job['description'] }}</textarea>
                                        </div>
                                    </div>
                                    

                                        <div class="clear"></div>


                                    </div>

                                    <div class="clear"></div>

                                    <div class="boxFullSizeSec">

                                        <div class="fieldBtnRowSec">
                                            <input type="reset" class="waves-effect waves-light btn cancelBtn" value="Cancel" id="doJobOpeninBack2" />
                                            <input type="button" class="waves-effect waves-light btn" value="Complete" id="saveJobBtn" />
                                        </div>
                                    </div>

                                </div>
                                <div class="loaderBodySec" id="job_formloader" style="display: none;">
                                    <div class="preloader-wrapper active" >
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


                                <div class="clear"></div>
                            </form>
                        </div>
                    </div>

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

 
<!-- Modal Structure -->
<div id="editGeneralInfo" class="modal modal-fixed-footer profilePopUpSec">
    <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >
        <input type="hidden" name="_token" value="{{ csrf_token()}}">
        <div class="modal-content">
            <div class="genInfoFormSec">
                <div class="upLoadImgSec">

                    <div id="image_preview"> 
                        <img src="{{ secure_url('images/do-profile-placeholder.png') }}" id="profile_img_preview" />
                    </div>


                    <div class="clear">&nbsp;</div>
                    <!--<button class="waves-effect waves-light btn upProfImgBtn">Upload Profile Image</button>-->
                    <div class="file-field input-field upProfBtnRow">
                        <div class="btn upProfImgBtn">
                          <!--<span>Upload Profile Image</span>-->
                            <span><i class="material-icons">photo_camera</i></span>
                            <input type="file" name="images[]" multiple accept='image/*' id="imgInp">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>

                    <div class="textCenter">You can upload up to 8 files.</div>
                    <div class="clear"></div>
                </div>
                <div class="detailFormSec row">
                    <div class="commonRow">
                        <div class="input-field">
                            <input id="ofice-name" type="text" class="validate" name="name" value="{{ $officeInformation->name }}">
                            <label for="ofice-name">Office Name</label>
                        </div>
                    </div>
                    <div class="commonRow">
                        <div class="input-field">
                            <input id="website" type="text" class="validate" name="website" value="{{ $officeInformation->website }}">
                            <label for="website">Website</label>
                        </div>
                    </div>
                    <div class="commonRow">
                        <div class="input-field">
                            <input id="office-specialty" type="text" class="validate" name="office_speciality" value="{{ $officeInformation->office_speciality }}">
                            <label for="office-specialty">Office Specialty</label>
                        </div>
                    </div>  
                    <div class="clear"></div> 
                    @if ($i=0) @endif
                    @foreach ($officeDentists as $dentist)

                    <div class="addDentistsRowSec">     
                        @if(!empty($dentist->id))
                        <input id="id" type="hidden"   name="dentist[{{$i}}][id]" value="{{$dentist->id}}">
                        @endif
                        <div class="titleRow">
                            <div class="input-field">
                                <input id="title" type="text" class="validate dentists" name="dentist[{{$i}}][title]" value="{{$dentist->title}}">
                                <label for="title">Title</label>
                            </div>
                        </div>
                        <div class="nameRow">
                            <div class="input-field">
                                <input id="name" type="text" class="validate dentists" name="dentist[{{$i}}][name]" value="{{$dentist->name}}">
                                <label for="name">Name</label>
                            </div>
                        </div>
                        <div class="credentialRow">
                            <div class="input-field">
                                <input id="credential" type="text" class="validate dentists" name="dentist[{{$i}}][credential]" value="{{$dentist->credential}}">
                                <label for="credential">Credential</label>
                            </div>
                        </div>
                        <div class="removeAddMoreBtn" id="removeMoreFields"><i class="material-icons">close</i></div>
                    </div>
                    @if ($i++) @endif
                    @endforeach
                    <div class="clear"></div>
                    <div class="addDentistsTextSec" id="addMoreFields">+ Add more dentists</div>


                </div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="popLoaderSec">
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
        <div class="modal-footer">
            <input type="button" value="Save" class="waves-effect btn-flat " id="genaral_info" onclick="return genralInfo();"/>
            <input type="reset" class="modal-action modal-close waves-effect btn-flat" value="Cancel" id="editGeneralInfo" />
        </div>
    </form>
</div>

@include('includes.terms')
 

@endsection


@section('script')
<script>
    $(document).ready(function () {
    $('ul.tabs').tabs();
            $("#editContactDetailsDiv").hide();
            $("#editContactBtn, #editContactBtn1").click(function(){
    $("#viewContactDetailsDiv").hide();
            $("#editContactDetailsDiv").show();
    });
            $("#editJobOpeningForm").hide();
            $("#editJobOpening").click(function(){
    $("#jobOpeningFormSec").hide();
            $("#editJobOpeningForm").show();
    });
            $("#doJobOpeninCancel").click(function(){
    $("#jobOpeningFormSec").show();
            $("#editJobOpeningForm").hide();
    });
            var template = $('.addDentistsRowSec'), id = {{$i - 1}};
    $('#addMoreFields').click(function () {
        var row = ++id;
        $(this).before('<div class="addDentistsRowSec"><div class="titleRow"><div class="input-field"><input id="title" type="text" class="validate dentists" name="dentist[' + (row) + '][title]"><label for="title">Title</label></div></div><div class="nameRow"><div class="input-field"><input id="name" type="text" class="validate dentists" name="dentist[' + (row) + '][name]"><label for="name">Name</label></div></div><div class="credentialRow"><div class="input-field"><input id="credential" name="dentist[' + (row) + '][credential]" type="text" class="validate dentists"><label for="credential">Credential</label></div></div><div class="removeAddMoreBtn" id="removeMoreFields"><i class="material-icons">close</i></div></div>');
    });
    $(document).on('click', '#removeMoreFields', function () {
    $(this).parent('.addDentistsRowSec').remove();
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
<script  src="{{ secure_url('js/moment-with-locales.min.js') }}"></script>

<script src="{{ secure_url('js/jquery.classybox.min.js') }}"></script>
<script src="{{ secure_url('js/owl.carousel.js') }}"></script>

<script   src="{{ secure_url('js/bootstrap-material-datetimepicker.js') }}"></script>
<script   src="{{ secure_url('js/materialize.clockpicker.js') }}"></script>

<script>


    $(document).ready(function () {

        $("#additional_info").click(function () {
            $('#additionalinfoloader').show();
            $.ajax({
                url: "{{ url('/officeAdditionalInfo') }}",
                data: new FormData($("#additional_infor_form")[0]),
                dataType: 'json',
                async: true,
                type: 'post',
                processData: false,
                contentType: false,
                success: function (response) {
                    var responseString = JSON.stringify(response);
                    var jsonResponse = JSON.parse(responseString);
                    if (jsonResponse['status'] == 200) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse['message'], 4000);
                        location.reload(1);
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['email'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['email'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['job_position'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['job_position'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Office_number'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Office_number'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['aditional_number'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['aditional_number'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['street'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['street'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['city'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['city'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['state'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['state'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['zipcode'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['zipcode'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Monday'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Monday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Tuesday'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Tuesday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Wednesday'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Wednesday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Thursday'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Thursday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Friday'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Friday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Saturday'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Saturday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Sunday'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Sunday'], 4000, 'redMessage');

                    } else {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse['message'], 4000, 'redMessage');
                    }
                }
            });
        });
$("#cancleEdit").click(function () {
            $("#editContactDetailsDiv").hide();
            $("#viewContactDetailsDiv").show();

        });
        $("#saveJobBtn").click(function () {
            $('#job_formloader').show();
            //Estimated total calculation
            $.ajax({
                url: "{{ url('/updateJobDetails') }}",
                data: new FormData($("#edit_job_form")[0]),
                dataType: 'json',
                async: true,
                type: 'post',
                processData: false,
                contentType: false,
                success: function (response) {
                    var responseString = JSON.stringify(response);
                    var jsonResponse = JSON.parse(responseString);

                    if (jsonResponse['status'] == 200) {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse['message'], 4000);
                        location.reload("{{ url('/dentalOfficeProfile#jobOpening') }}");
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['job_type'] != undefined) {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse[0]['job_type'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['job_position'] != undefined) {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse[0]['job_position'], 4000, 'redMessage');

                    //} else if (jsonResponse['status'] == 201 && jsonResponse[0]['start_date'] != undefined) {
                        //$('#job_formloader').hide();
                        //Materialize.toast(jsonResponse[0]['start_date'], 4000, 'redMessage');

                    //} else if (jsonResponse['status'] == 201 && jsonResponse[0]['end_date'] != undefined) {
                      //  $('#job_formloader').hide();
                       // Materialize.toast(jsonResponse[0]['end_date'], 4000, 'redMessage');

                    } else {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse['message'], 4000, 'redMessage');
                    }
                }
            });
        });
        $("#deleteJobBtn").click(function () {

            $.ajax({
                url: "{{ url('/deleteJobDetails') }}",
                data: new FormData($("#delete_job_form")[0]),
                dataType: 'json',
                async: true,
                type: 'post',
                processData: false,
                contentType: false,
                success: function (response) {
                    var responseString = JSON.stringify(response);
                    var jsonResponse = JSON.parse(responseString);
                    if (jsonResponse['status'] == 200) {
                        Materialize.toast(jsonResponse['message'], 4000);
                        location.href = "{{ url('/dentalOfficeProfile#jobOpening') }}";
                    } else {
                        Materialize.toast(jsonResponse['message'], 4000, 'redMessage');
                    }
                }
            });
        });
        $("#completeJobBtn").click(function () {

            $.ajax({
                url: "{{ url('/completeJob') }}",
                data: new FormData($("#complete_job_form")[0]),
                dataType: 'json',
                async: true,
                type: 'post',
                processData: false,
                contentType: false,
                success: function (response) {
                    var responseString = JSON.stringify(response);
                    var jsonResponse = JSON.parse(responseString);
                    if (jsonResponse['status'] == 200) {
                        Materialize.toast(jsonResponse['message'], 4000);
                        location.href = "{{ url('/dentalOfficeProfile') }}";
                    } else {
                        Materialize.toast(jsonResponse['message'], 4000, 'redMessage');
                    }
                }
            });
        });


        $("#doJobOpeninBack").click(function () {
            $("#editJobOpeningForm").hide();
            $("#jobOpeningFormSec").show();

        });
        $("#doJobOpeninBack2").click(function () {
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


    function genralInfo() {

        //validating dentists list
        var isValid = false;
        $(".dentists").each(function () {
            var element = $(this);
            if (element.val() == "") {
                isValid = true;
            }
        });
        if (isValid == true) {
            Materialize.toast('Please provide dentists details', 4000, 'redMessage');
            return true;
        }
        $.ajax({
            url: "{{ url('/officeGenaralInfo') }}",
            data: new FormData($("#upload_form")[0]),
            dataType: 'json',
            async: true,
            onLoading: $('.popLoaderSec').show(),
            type: 'post',
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {

                var responseString = JSON.stringify(response);
                ;
                var jsonResponse = JSON.parse(responseString);
                if (jsonResponse['status'] == 201 && jsonResponse[0]['name'] != undefined) {
                    $('.popLoaderSec').css('display', 'none');
                    Materialize.toast(jsonResponse[0]['name'], 4000, 'redMessage');
                } else if (jsonResponse['status'] == 201 && jsonResponse[0]['website'] != undefined) {
                    $('.popLoaderSec').css('display', 'none');
                    Materialize.toast(jsonResponse[0]['website'], 4000, 'redMessage');

                } else if (jsonResponse['status'] == 201 && jsonResponse[0]['office_speciality'] != undefined) {
                    $('.popLoaderSec').css('display', 'none');
                    Materialize.toast(jsonResponse[0]['office_speciality'], 4000, 'redMessage');

                } else if (jsonResponse['status'] == 400) {
                    $('.popLoaderSec').css('display', 'none');
                    Materialize.toast(jsonResponse['message'], 4000, 'redMessage');
                } else if (jsonResponse['status'] == 200) {
                    Materialize.toast(jsonResponse['message'], 2000);
                    location.reload();
                } else {
                    $('.popLoaderSec').css('display', 'none');
                    Materialize.toast(jsonResponse['message'], 4000);
                }
            }
        });
    }
    function readURL(input) {
        /*
         if (input.files && input.files[0]) {
         var reader = new FileReader();
         reader.onload = function (e) {
         $('#profile_img_preview').attr('src', e.target.result);
         }
         
         reader.readAsDataURL(input.files[0]);
         }
         */
        var total_file = document.getElementById("imgInp").files.length;
        $('#image_preview').empty();
        for (var i = 0; i < total_file; i++)
        {
            $('#image_preview').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "'>");
        }
    }

    $("#imgInp").change(function () {
        readURL(this);
    });

</script>

<script>
    $('#starttime').pickatime();
    $('#endtime').pickatime();
    $('#enddate').bootstrapMaterialDatePicker({weekStart: 0, time: false, minDate: new Date(), switchOnClick: true, okButton: false, format: 'MMMM  DD  YYYY'});
    $('#startdate').bootstrapMaterialDatePicker({weekStart: 0, time: false, minDate: new Date(), switchOnClick: true, okButton: false, format: 'MMMM  DD  YYYY'});
    $(document).ready(function () {
        $('#startdate').bootstrapMaterialDatePicker
                ({
                    time: false,
                    switchOnClick: true,
                    okButton: false
                });
        $('#enddate').bootstrapMaterialDatePicker
                ({
                    time: false,
                    switchOnClick: true,
                    okButton: false
                });
    });
</script>

@endsection

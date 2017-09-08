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
                            @if(count($officeImages) > 0)
                            <img src="{{ Config('constants.s3_url') . $officeImages[0]->image_url}}" />
                            @else
                            <img src="images/do-office-profile.jpg" />
                            @endif
                            <div class="clear">&nbsp;</div>
                            <!--<button class="waves-effect waves-light btn upProfImgBtn">Upload Profile Image</button>-->

                            <div class="clear"></div>
                        </div>
                        <div class="detailFormSec row">
                            <div class="pageTitle2">{{ $officeInformation->name or 'Office Profile' }}</div>
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
                                    {{ $dentist->title.'.'.$dentist->name.', '.$dentist->credential}}
                                    <br>
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
                        <li class="tab col s6"><a class="active" href="#additionalInformation">Additional Information</a></li>
                        <li class="tab col s6"><a href="#jobOpening">Job Opening</a></li>
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
                                            {{ $officeInformation->street.'  '.$officeInformation->city.'  '.$officeInformation->state }}
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
                                            <input id="name" type="text" class="validate" name="contact_name" value="{{ $officeInformation->contact_person_name }}">
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
                    @if(count($jobs) === 0)

                    <div class="avaiBoxSec" id="jobOpeningSec">
                        <div class="bigTextSec">No jobs created, yet.</div>
                        <div class="smallTextSec">Please create and post a job.</div>
                        <div class="enterAvailableBtn"><input type="button" value="Create Job" class="waves-effect waves-light btn" id="jobOpeningBtn" /></div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    @else
                    <div id="jobOpeningListSec">

                        <div class="pageContBox jobOpeningListSec">
                            <div class="createJobBtn"><input type="button" value="Create Job" class="btn"  id="jobOpeningBtn"/></div>
                            <div class="jobListTableSec">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Hourly Rate</th>
                                        <th>Estimated Total</th>
                                        <th>Type of Job</th>
                                        <th>Job Description</th>
                                    </tr>
                                    @foreach($jobs as $job)

                                    <tr>

                                        <td><a href="{{ url('/jobDetails/'.$job->id) }}"> {{ date('F d, Y', strtotime($job->date))  }}</a></td>
                                        <td><a href="{{ url('/jobDetails/'.$job->id) }}">{{ $job->start_time.' - '.$job->end_time }}</a></td>
                                        <td><a href="{{ url('/jobDetails/'.$job->id) }}">{{ $job->hourly_rate }}</a></td>
                                        <td><a href="{{ url('/jobDetails/'.$job->id) }}">{{ $job->estimated_cost  }}</a></td>
                                        <td><a href="{{ url('/jobDetails/'.$job->id) }}">
                                                @foreach ($job_types as $job_type)
                                                @if($job->type_id == $job_type->id)

                                                {{ $job_type->name  }} 
                                                @endif
                                                @endforeach

                                            </a></td>
                                        <td><a href="{{ url('/jobDetails/'.$job->id) }}">{{ $job->description }}</a></td>


                                    </tr>

                                    @endforeach

                                </table>
                            </div>
                            <div class="clear"></div>
                            <!--                            <div class="paginationDivSec">
                                                            <ul>
                                                                <li class="pagePrev"> < Prev</li>
                                                                <li class="pageNo">1</li>
                                                                <li class="pageNo">2</li>
                                                                <li class="pageNo">3</li>
                                                                <li class="textBox"><input type="text" maxlength="3" /></li>
                                                                <li class="pageNo">8</li>
                                                                <li class="pageNo">9</li>
                                                                <li class="pageNo">0</li>
                                                                <li class="pageNext">Next > </li>
                                                            </ul>
                                                            <div class="clear"></div>
                                                        </div>-->
                        </div>

                    </div>
                    <div class="clear"></div>

                    @endif
                    <div class="jobOpeningFormSec addiInfoSec loaderParentDiv" id="jobOpeningFormSec">
                        <form  id="create_job_form" role="form" method="POST" action="" >
                            <input type="hidden" name="_token" value="{{ csrf_token()}}">
                            <div class="pageContBox">

                                <div class="formSec formBoxesSec">
                                    <div class="backBtn" id="doJobOpeninBack"><i class="material-icons">arrow_back</i> Back</div>
                                    <div class="clear"></div>
                                    <div class="boxLeftSec">
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <select  id="type_of_job" name="job_type">
                                                    <option value="">Choose Job Type</option>
                                                    @foreach ($job_types as $job_type)

                                                    <option value="{{ $job_type->id }}">{{ $job_type->name  }}</option>

                                                    @endforeach

                                                </select>
                                                <label for="type-of-job">Type of job</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="hourly-rate" type="text"  name="hourly_rate">
                                                <label for="hourly-rate">Hourly Rate ($/hour)</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="estimated-total" type="text" class="validate" name="estimated_total">
                                                <label for="estimated-total">Estimated Total ($/hour)</label>
                                            </div>
                                        </div>

                                        <div class="clear"></div>


                                    </div>
                                    <div class="boxRightSec">
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="jobdate" type="text"  name="date">
                                                <label for="jobdate">Date</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="starttime" type="text" name="start_time">
                                                <label for="starttime">Start Time</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="endtime" type="text"   name="end_time">
                                                <label for="endtime">End Time</label>
                                            </div>
                                        </div>




                                        <div class="clear"></div>


                                    </div>
                                    <div class="clear"></div>
                                    <div class="boxFullSizeSec">
                                        <div class="pageTitle2 pageSecondHeading">Job Description</div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="monday" type="text"   name="description">
                                                <label for="monday">Type here</label>
                                            </div>
                                        </div>
                                        <div class="fieldBtnRowSec">
                                            <input type="button" class="waves-effect waves-light btn cancelBtn" value="Cancel" id="doJobOpeninCancel" />
                                            <input type="button" class="waves-effect waves-light btn" value="Complete" id="saveJobBtn" />
                                        </div>
                                    </div>

                                </div>



                                <div class="clear"></div>
                            </div>
                        </form>
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


                    </div>
                    <div class="clear"></div>



                </div>
            </div>
        </div>

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
                        <img src="images/do-profile-placeholder.png" id="profile_img_preview" />
                    </div>

                    <div class="clear">&nbsp;</div>
                    <!--<button class="waves-effect waves-light btn upProfImgBtn">Upload Profile Image</button>-->
                    <div class="file-field input-field upProfBtnRow" id="imageData">
                        <div class="btn upProfImgBtn">
                          <!--<span>Upload Profile Image</span>-->
                            <span><i class="material-icons">photo_camera</i></span>
                            <input type="file" name="images[]" multiple  accept='image/*' id="fileupload" onchange="preview_image();">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>

                    <div class="textCenter">You can upload up to 8 files.</div>
                    <div class="clear"></div>
                    <div id="image_previewer">

                    </div>

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
            <a href="#!" class="modal-action modal-close waves-effect btn-flat ">Cancel</a>
        </div>
    </form>
</div>










@endsection


@section('script')
<script>
    $(document).ready(function () {
    $('ul.tabs').tabs();
            $("#jobOpeningFormSec").hide();
            $("#jobOpeningBtn").click(function () {
    $("#jobOpeningSec").hide();
            $("#jobOpeningListSec").hide();
            $("#jobOpeningFormSec").show();
    });
            $("#doJobOpeninBack, #doJobOpeninCancel").click(function () {
    $("#jobOpeningSec").show();
            $("#jobOpeningListSec").show();
            $("#jobOpeningFormSec").hide();
    });
            $("#editContactDetailsDiv").hide();
            $("#editContactBtn, #editContactBtn1").click(function () {
    $("#viewContactDetailsDiv").hide();
            $("#editContactDetailsDiv").show();
    });
            $("#searchJobBtn").click(function () {
    $("#jobOpeningFormSec").hide();
            $("#jobOpeningListSec").show();
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
    );</script>




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
<script  src="{{ URL::asset('js/moment-with-locales.min.js') }}"></script>

<script src="{{ URL::asset('js/jquery.classybox.min.js') }}"></script>
<script src="{{ URL::asset('js/owl.carousel.js') }}"></script>

<script   src="{{ URL::asset('js/bootstrap-material-datetimepicker.js') }}"></script>
<script   src="{{ URL::asset('js/materialize.clockpicker.js') }}"></script>

<script>

    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });
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

        $("#saveJobBtn").click(function () {
            $('#job_formloader').show();
            $.ajax({
                url: "{{ url('/createJob') }}",
                data: new FormData($("#create_job_form")[0]),
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
                     //   window.location.href ="{{ url('/dentalOfficeProfile#jobOpening') }}";
                        location.reload();
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['job_type'] != undefined) {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse[0]['job_type'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['hourly_rate'] != undefined) {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse[0]['hourly_rate'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['estimated_total'] != undefined) {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse[0]['estimated_total'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['date'] != undefined) {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse[0]['date'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['start_time'] != undefined) {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse[0]['start_time'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['end_time'] != undefined) {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse[0]['end_time'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['description'] != undefined) {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse[0]['description'], 4000, 'redMessage');

                    } else {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse['message'], 4000, 'redMessage');
                    }
                }
            });
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
                    $('#image_previewer').html();
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
    
function preview_image() 
{
     
 var total_file=document.getElementById("fileupload").files.length;
 if(total_file < 9){
     $('#image_previewer').html();
 for(var i=0;i<total_file;i++)
 {
  $('#image_previewer').append("<img style='width:50%;padding:1px'src='"+URL.createObjectURL(event.target.files[i])+"'>");
  
 }
 }else{
 Materialize.toast("Only 8 images are allowed", 4000,'redMessage');
 }
}

</script>

<script>
    $('#starttime').pickatime();
    $('#endtime').pickatime();
    $('#jobdate').bootstrapMaterialDatePicker({weekStart: 0, time: false, minDate: new Date(), switchOnClick: true, okButton: false,format : 'MMMM  DD  YYYY'});
    $(document).ready(function () {
        $('#jobdate').bootstrapMaterialDatePicker
                ({
                    time: false,

                    //clearButton: true,
                    //closeOnSelect:true,
                    switchOnClick: true,
                    okButton: false
                            //okButton:false,
                            //cancelButton:false,
                });
    });
</script>

@endsection
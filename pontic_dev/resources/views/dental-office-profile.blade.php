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
                            <div class="threeDotDrop">
                            <a class="dropdown-button" href="#!" data-activates="dropDown1"><i class="material-icons">more_vert</i></a>
                            <!-- Dropdown Structure -->
                            <ul id="dropDown1" class="dropdown-content">
                                <li><a class="modal-trigger" href="#editGeneralInfo">Edit</a></li>
                                <!--<li class="divider"></li>-->
                            </ul>
                            </div>
                        </div>
                        
                            @if(count($officeImages) > 0)
                            <div class="upLoadImgSec" style="background-image:url({{ Config('constants.s3_url') . $officeImages[0]->image_url}});">
                              <div class="clear">&nbsp;</div>
                            @else
                            <div class="upLoadImgSec">
                            <img src="{{ secure_url('images/do-office-profile.jpg') }}" />
                             <div class="clear">&nbsp;</div>
                            @endif
                           
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
                        <li class="tab col s6"><a class="active" href="#additionalInformation">Additional Information</a></li>
                        <li class="tab col s6"><a href="#jobOpening">Post A Job</a></li>
                    </ul>
                </div>
                <div id="additionalInformation" class="addiInfoSec">


                    <div class="pageContBox">
                        <div class="formSec" id="viewContactDetailsDiv">
                            <div class="editBtnSec">
                                <input type="button" value="Edit" class="waves-effect waves-light btn generalEditBtn" id="editContactBtn" />
                                <div class="threeDotDrop">
                                <a class="dropdown-button" href="#!" data-activates="dropDown3"><i class="material-icons">more_vert</i></a>
                                <!-- Dropdown Structure -->
                                <ul id="dropDown3" class="dropdown-content">
                                    <li><a id="editContactBtn1">Edit</a></li>
                                    <!--<li class="divider"></li>-->
                                </ul>
                                </div>
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
                                    <div class="normalText">
                                        @if($officeInformation->contact_person_name != ''){{ $officeInformation->contact_person_name.','}}@endif
                                        {{$officeInformation->job_position }}</div>
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
                                               @if($officeInformation->street != ''){{ $officeInformation->street.','}}@endif
                                                @if($officeInformation->city != ''){{$officeInformation->city.', '}}@endif
                                                @if(!empty($officeInformation->state)) {{ $officeInformation->state.', ' }}@endif
                                                @if(!empty($officeInformation->zipcode)) {{ $officeInformation->zipcode }}@endif

                                           
                                            
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
                                            <select id="state" name="state">
                                                    <option value="" disabled >Choose your state</option>
                                                    <option value="">None Selected</option>
                                                    @foreach ($states as $state)

                                                    <option value="{{ $state->name }}" <?php if($officeInformation->state == $state->name ){ ?> selected="selected" <?php } ?>>{{ $state->name }}</option>

                                                    @endforeach

                                                </select>
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
                                                <option value="" disabled >Choose your software</option>
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
                                                <option value="" disabled >Choose your radiology type</option>
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
                                <div class="fieldRowSec11">
                                    <input type="button" class="waves-effect waves-light btn" value="Cancel" onclick="location.href='/pontic_dev/dentalOfficeProfile';" id="cancleEdit" />
                                    <input type="button" class="waves-effect waves-light btn" value="Save" id="additional_info"/>
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
                        <div class="smallTextSec">Available Job Seekers will be notified of your job posting.</div>
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
                                        <!--<th>Start Date</th>
                                        <th>End Date</th> -->
                                        <th>Type of Job</th>
                                        <th>Job Position</th>
                                        <th>View</th>
                                    </tr>
                                    @foreach($jobs as $job)

                                    <tr>

                                        <!--<td><a href="{{ url('/jobDetails/'.$job->id) }}"> {{ date('M d, Y', $job->start_date)  }}</a></td>
                                        <td><a href="{{ url('/jobDetails/'.$job->id) }}">{{ date('M d, Y', $job->end_date)  }}</a></td>-->
                                        <td><!--<a href="{{ url('/jobDetails/'.$job->id) }}">-->
                                                @foreach ($job_types as $job_type)
                                                @if($job->type_id == $job_type->id)

                                                {{ $job_type->name  }} 
                                                @endif
                                                @endforeach

                                            <!--</a>--></td>
                                        <td><!--<a href="{{ url('/jobDetails/'.$job->id) }}">-->
                                                @foreach ($user_types as $user_type)
                                                @if($job->job_position == $user_type->id)
                                                    {{ $user_type->user_type  }} 
                                                @endif
                                                @endforeach

                                            <!--</a>--></td>
                                        <td><a href="{{ url('/jobDetails/'.$job->id) }}" class="viewBtn">View</a></td>
                                    </tr>
                                    @endforeach

                                </table>
                            </div>
                            <div class="clear"></div>
                         
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
                                               <select  id="type_of_job" name="job_position">
                                                    <option value="">Choose Job Position</option>
                                                    @foreach ($user_types as $user_type)
                                                    <option value="{{ $user_type->id }}">{{ $user_type->user_type  }}</option>
                                                    @endforeach

                                                </select>
                                                <label for="type-of-job">Job Position</label>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    <div class="pageTitle2 specCertiHeading">Job Description</div>
                                    <div class="clear"></div>
                                    <div class="proSummaryTextareaSec">
                                        <div class="input-field">
                                            <textarea class="materialize-textarea" name="job_description"></textarea>
                                        </div>
                                    </div>
                                     
                                        <div class="clear"></div>


                                    </div>
                                    <!----<div class="boxRightSec">
                                       
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="jobdate" type="text"  name="start_date">
                                                <label for="jobdate">Start Date</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="enddate" type="text"  name="end_date">
                                                <label for="enddate">End Date</label>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                    </div>----->
                                    <div class="clear"></div>
                                    <div class="boxFullSizeSec">
                                         
                                        <div class="fieldBtnRowSec">
                                            <input type="reset" class="waves-effect waves-light btn cancelBtn" value="Cancel" id="doJobOpeninCancel" />
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
    <div class="footerContentSec">
	 <a href="mailto:contact@pontic.com" target="_top">Send your feedback</a>
                    <div class="clear"></div>
        	<a class="modal-trigger" href="#modal1">Terms and Conditions</a> and <a class="modal-trigger" href="#modal2">Privacy Policy</a>
            <div class="clear"></div>
            <a title="DMCA.com Protection Status" class="dmca-badge" href="https://www.dmca.com/Protection/Status.aspx?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"> 
            <img alt="DMCA.com Protection Status" src="https://images.dmca.com/Badges/dmca_protected_sml_120k.png?ID=82ae8276-f62d-4e4b-987e-eab04219a6f1"></a>
            <script src="https://images.dmca.com/Badges/DMCABadgeHelper.min.js"> </script>
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
                    <?php $uploadDisplay=''; ?>
                    @if(count($officeImages) > 7)
                   <?php $uploadDisplay = 'display:none';?>
                     @endif
                    <div class="file-field input-field" id="image1" style="{{ $uploadDisplay }}">
                        <div class="btn">
                            <span>Upload Photo</span>

                            <input type="file" name="images"    accept='image/*' id="fileupload" class="uploadimages" onchange="preview_image();">
                        </div>
                        <div class="file-path-wrapper btnUploadTextBox">
                            <input class="file-path validate" type="text" placeholder="Upload Photo">
                        </div>


                    </div>
                     
                     <div class="clear"></div>
                    <div align="center" style="width:100%; display:none; margin: 10px 0px;" id="imageLoader">
                        <img src="{{ secure_url('images/ellipsis.gif') }}" style="height:10px !important;width: 80px !important;">
                    </div>
               
                    
                    <div class="clear">&nbsp;</div>
                    <div class="textCenter">You can upload up to 8 files.</div>
                    <div class="clear"></div>

                    <div id="image_previewer">
                         @if(count($officeImages) > 0)
                       
                           @foreach($officeImages as $officeImage)
                        
                         <div class="thumbPrevImg" id="{{ str_limit($officeImage->image_url, $limit = 6, $end = '') }}"  style="background-image:url({{ url(Config('constants.s3_url').$officeImage->image_url) }});">
                             <!--<img class="thumb" src="{{ url(Config('constants.s3_url').$officeImage->image_url) }}">-->
                             <span class="remove_img_preview previewClsBtn" onclick="delteimage('{{ $officeImage->image_url }}')">X</span>
                         </div>
                          <input type="hidden" class="{{ str_limit($officeImage->image_url, $limit = 6, $end = '') }}" id="uploaded" name="uploaded[]" value="{{ $officeImage->image_url }}">
                         @endforeach
                            @endif
                    </div>
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
                    <div class="addDentistsTextSec" id="addMoreFields">+ Add Dentists</div>


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
     $("#cancleEdit").click(function () {
            $("#editContactDetailsDiv").hide();
            $("#viewContactDetailsDiv").show();

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
    );
</script>




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
<script  src="{{ secure_url('js/moment-with-locales.min.js') }}"></script>

<script src="{{ secure_url('js/jquery.classybox.min.js') }}"></script>
<script src="{{ secure_url('js/owl.carousel.js') }}"></script>

<script   src="{{ secure_url('js/bootstrap-material-datetimepicker.js') }}"></script>
<script   src="{{ secure_url('js/materialize.clockpicker.js') }}"></script>

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

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['contact_name'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['contact_name'], 4000, 'redMessage');

                    }else if (jsonResponse['status'] == 201 && jsonResponse[0]['job_position'] != undefined) {
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
                        Materialize.toast('Unknown address - please check address fields', 4000, 'redMessage');
                    }
                }
            });
        });

        $("#saveJobBtn").click(function () {
            
            //Estimated total calculation
             var enddate = $('#enddate').val();
            var jobdate  = $('#jobdate').val(); 
                var startTime = new Date(enddate);
            var endTime = new Date(jobdate);
            if( startTime < endTime){
                Materialize.toast('Start date is less than end date', 4000, 'redMessage');
                return false;
            }else{
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

                   // } else if (jsonResponse['status'] == 201 && jsonResponse[0]['start_date'] != undefined) {
                        //$('#job_formloader').hide();
                       // Materialize.toast(jsonResponse[0]['start_date'], 4000, 'redMessage');

                    //} //else if (jsonResponse['status'] == 201 && jsonResponse[0]['end_date'] != undefined) {
                       // $('#job_formloader').hide();
                        //Materialize.toast(jsonResponse[0]['end_date'], 4000, 'redMessage');

                  } else if (jsonResponse['status'] == 201 && jsonResponse[0]['job_position'] != undefined) {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse[0]['job_position'], 4000, 'redMessage');

                    } else {
                        $('#job_formloader').hide();
                        Materialize.toast(jsonResponse['message'], 4000, 'redMessage');
                    }
                }
            });

            }
           
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
        
        //validating how many files are uploaded before this
        var fileCount = $("body #uploaded").length;
        if(fileCount >= 8){
        Materialize.toast('Max 8 imanges allowed', 4000, 'redMessage');
        }else{
        $.ajax({
            url: "{{ url('/imageUploader') }}",
            data: new FormData($("#upload_form")[0]),
            dataType: 'json',
            async: true,
            onLoading: $('#imageLoader').show(),
            type: 'post',
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {

                var responseString = JSON.stringify(response);

                var jsonResponse = JSON.parse(responseString);

                if (jsonResponse['status'] == 200) {
                    $("#fileupload").val('');
                    var imageId = jsonResponse['name'].substring(0, 6);
                    $('#image_previewer').prepend('<div class="thumbPrevImg" id="'+imageId+'" style="background-image:url(' + jsonResponse['thumburl'] + ');"><span class="remove_img_preview previewClsBtn" onclick="delteimage(\'' + jsonResponse['name'] + '\')">X</span></div>');//
                    $('#upload_form').append('<input type="hidden" class="'+imageId+'" id="uploaded" name="uploaded[]" value="' + jsonResponse['name'] + '" />');
                    //<img  class="thumb" src="' + jsonResponse['thumburl'] + '" />
                    var uploadedFileCount = $("body #uploaded").length;
                    if(uploadedFileCount > 7){
                        $("#image1").hide();
                    }
                    $('#imageLoader').hide();
                }
                if (jsonResponse['status'] == 201 && jsonResponse[0]['images'] != undefined) {
                    $('#imageLoader').hide();
                    Materialize.toast(jsonResponse[0]['images'], 4000, 'redMessage');
                } else {
                   $('#imageLoader').hide();
                    Materialize.toast(jsonResponse['message'], 4000);
                }
            }
        });
    }
    }

    function delteimage(image) {
         var imageId = image.substring(0, 6);
        //adding form to page
        $('body').append('<form id="delteFrom"></form>');
        $('#delteFrom').attr("action", "").attr("method", "post");
        $('#delteFrom').append('<input type="hidden" name="image"   value="' + image + '">');
        $('#delteFrom').append('<input type="hidden" name="_token"  value="' + "{{ csrf_token()}}" + '">');

        $.ajax({
            url: "{{ url('/imageDelete') }}",
            data: new FormData($("#delteFrom")[0]),
            dataType: 'json',
            onLoading: $('#imageLoader').show(),
            async: true,
            type: 'post',
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (response) {

                var responseString = JSON.stringify(response);
                var jsonResponse = JSON.parse(responseString);
                if (jsonResponse['status'] == 200) {
                     	$("#"+imageId).remove();  
                        $("."+imageId).remove(); 
                        var uploadedFileCount = $("body #uploaded").length;
                        $('#imageLoader').hide();
                    if(uploadedFileCount < 8){
                        $("#image1").show();
                    }
                } else {
                    $('#imageLoader').hide();
                    Materialize.toast(jsonResponse['message'], 4000);
                }
                $("#delteFrom").remove();
            }
        });
    }
  
</script>

<script>
    
    $('#jobdate').bootstrapMaterialDatePicker({weekStart: 0, time: false, minDate: new Date(), switchOnClick: true, okButton: false, format: 'MMMM  DD  YYYY'});
    $('#enddate').bootstrapMaterialDatePicker({weekStart: 0, time: false, minDate: new Date(), switchOnClick: true, okButton: false, format: 'MMMM  DD  YYYY'});
    
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
                $('#enddate').bootstrapMaterialDatePicker
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
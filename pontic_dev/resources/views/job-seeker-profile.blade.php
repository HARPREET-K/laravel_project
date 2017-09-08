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
                <div class="editBtnSec">
                    <a class="modal-trigger waves-effect waves-light btn linkBtn generalEditBtn" href="#editGeneralInfo">Edit</a>

                    <a class="dropdown-button threeDotDrop" href="#!" data-activates="dropDown1"><i class="material-icons">more_vert</i></a>
                    <!-- Dropdown Structure -->
                    <ul id="dropDown1" class="dropdown-content">
                        <li><a class="modal-trigger" href="#editGeneralInfo">Edit</a></li>
                        <!--<li class="divider"></li>-->
                    </ul>
                </div>
                @if(!empty($user->profile_image_thumb))
                <div class="profileImgSec" style="background-image:url({{ Config('constants.s3_url') . $user->profile_image_thumb}});">
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
                            @if($user->title != null)
                            {{ $user->title.'.'}}
                            @endif
                            @if($user->credential != null)
                            {{$user->name.', '.$user->credential }}
                            @else
                            {{$user->name}}
                            @endif
                            <br>
                            <span class="userType">
                                @if($user->userType == 2)
                                {{ 'Front Office' }}
                                @elseif($user->userType == 3)
                                {{ 'Hygienist' }}
                                @elseif($user->userType == 4)
                                {{ 'Assistant'}}
                                @else
                                {{' '}}
                                @endif
                            </span></div>
                        <div class="clear"></div>
                    </div>
                    <!-----<div class="profileDetailsRows">
                        <div class="headingText">Credentials</div>
                        <div class="normalTextSec">{{ $user->credential }} </div>
                        <div class="clear"></div>
                    </div>----->
                    <div class="profileDetailsRows">
                        <div class="headingText">Years of Experience</div>
                        <div class="normalTextSec">{{ $user->experience }} </div>
                        <div class="clear"></div>
                    </div>
                    <div class="profileDetailsRows">
                        <div class="headingText">Expected Pay</div>
                        <div class="normalTextSec">${{ $user->expected_pay }}/hr</div>
                        <div class="clear"></div>
                    </div>
                    <div class="profileDetailsRows">
                                        <div class="headingText">Location</div>
                                        <div class="normalTextSec">                                            
                                        
                                            @if($user->city != NULL){{' '.$user->city}}@endif
                                            @if($user->state!=NULL){{', '.$user->state }}@endif
                                            
                                        </div>
                                         </a>
                                        <div class="clear"></div>
                                    </div>
                    <div class="profileDetailsRows">
                        <div class="headingText">State License</div>
                        <div class="normalTextSec">{{ $user->state_license }}</div>
                        <div class="clear"></div>
                    </div>
                    <div class="profileDetailsRows">
                                        <div class="headingText">Availability</div>
                                        <div class="normalTextSec">   
                                     <?php //populating the available days from the user_availability_dates ?>
                                    <?php  $mon = (count($available_timings) > 0 && $available_timings[0]->start_time != -1 )? "Mon," : "";
                                    $tue = (count($available_timings) > 0 && $available_timings[1]->start_time != -1 )? "Tue," : "";
                                    $wed = (count($available_timings) > 0 && $available_timings[2]->start_time != -1 )? "Wed," : "";
                                    $thu = (count($available_timings) > 0 && $available_timings[3]->start_time != -1 )? "Thu," : "";
                                    $fri = (count($available_timings) > 0 && $available_timings[4]->start_time != -1 )? "Fri," : "";
                                    $sat = (count($available_timings) > 0 && $available_timings[5]->start_time != -1 )? "Sat," : "";
                                    $sun = (count($available_timings) > 0 && $available_timings[6]->start_time != -1 )? "Sun" : "";
                                    $string = $mon. $tue. $wed. $thu. $fri. $sat. $sun;
                                    $string = str_replace(',', ', ', $string);
                                       echo rtrim($string,', ');
                                         ?>
                                        </div>
                                         </a>
                                        <div class="clear"></div>
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

                                <div class="editBtnSec">
                                    <input type="button" value="Edit" class="waves-effect waves-light btn generalEditBtn" id="editSkillBtn" />
                                    <a class="dropdown-button threeDotDrop" href="#!" data-activates="dropDown2"><i class="material-icons">more_vert</i></a>
                                    <!-- Dropdown Structure -->
                                    <ul id="dropDown2" class="dropdown-content">
                                        <li><a id="editSkillBtn1">Edit</a></li>
                                        <!--<li class="divider"></li>-->
                                    </ul>
                                </div>
                                <div class="contactDetailsSec">
                                    <div class="pageTitle2">Contact</div>


                                    <div class="profileDetailsRows">
                                        <div class="headingText">Email</div>
                                        <div class="normalTextSec">
                                            <a href="mailto:{{ $user->contact_email }}">{{ $user->contact_email }}</a></div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Phone Number</div>
                                        <div class="normalTextSec">{{ $user->mobile_number }}</div>
                                        <div class="clear"></div>
                                    </div>
                                   <div class="profileDetailsRows">
                                        <div class="headingText">Additional Number</div>
                                        <div class="normalTextSec">{{ $user->aditional_number }}</div>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Address</div>
                                        <a  target="_blank" href="https://maps.google.com/?q= {{ $user->street.'  '.$user->city.'  '.$user->state }}">
                                            <div class="normalTextSec">
                                                @if($user->street != ''){{ $user->street.','}}@endif
                                                @if($user->city != ''){{$user->city.', '}}@endif
                                                @if(!empty($user->state)) {{ $user->state.', ' }}@endif
                                                @if(!empty($user->zipcode)) {{ $user->zipcode }}@endif

                                            </div>
                                        </a>
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Travel Distance</div>
                                        @if($user->travel_distance >0)
                                        <div class="normalTextSec">{{ $user->travel_distance.' miles' }}</div>
                                        @else
                                        <div class="normalTextSec">{{ '0 miles' }}</div>
                                        @endif
                                        <div class="clear"></div>
                                    </div>
                                    <div class="profileDetailsRows">
                                        <div class="headingText">Malpractice Insurance</div>
                                        <div class="normalTextSec">
                                            &nbsp;
                                            @if($user->malpractice_insurance ==1)
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
                                            {{ $user->languages }}
                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                    <div class="clear"></div>

                                </div>
                                <div class="skillsSec">
                                    <div class="pageTitle2">Professional Summary</div>
                                    <div class="professionalSummaryBoxSec">{{ $user->user_note }}</div>

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


                            <form   id="additional_infor_form" role="form" method="POST" action="" >
                                <div id="editSkillFormSec" class="loaderParentDiv">

                                    <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                    <div class="contactDetailsSec">
                                        <div class="pageTitle2">Contact</div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="email" type="text" name="email" class="validate" value="{{ $user->contact_email }}">
                                                <label for="email">Email</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="mobile_number" type="text" name="mobile_number" class="validate" value="{{ $user->mobile_number }}">
                                                <label for="phone_number">Phone Number</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="additional_number" type="text" name="additional_number" class="validate" value="{{ $user->aditional_number }}">
                                                <label for="additional_number">Additional Number</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="street_address" type="text" name="street" class="validate" value="{{ $user->street }}">
                                                <label for="street_address">Street Address</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="cityBoxSec">
                                                <div class="input-field">
                                                    <input id="city" type="text" name="city" class="validate" value="{{ $user->city }}">
                                                    <label for="city">City</label>
                                                </div>
                                            </div>
                                            <div class="stateBoxSec">
                                                <div class="input-field">
                                                    <select id="state" name="state">
                                                    <option value="" disabled >Choose your state</option>
                                                    <option value="">None Selected</option>
                                                    @foreach ($states as $state)

                                                    <option value="{{ $state->name }}" <?php if($user->state == $state->name ){ ?> selected="selected" <?php } ?>>{{ $state->name }}</option>

                                                    @endforeach

                                                </select>
                                                    <label for="state">State</label>
                                                </div>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="zip_code" type="text" name="zip_code" class="validate" value="{{ $user->zipcode }}">
                                                <label for="zip_code">Zip Code</label>
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <select id="travel_distance" name="travel_distance">
                                                    <option value="" disabled {{ ($user->travel_distance == '' ||empty($user->travel_distance) ? "selected":"") }}>Choose your Travel Distance</option>
                                                    <option value="5" {{ ($user->travel_distance==5 ? "selected":"") }}  >  5 miles</option>
                                                    <option value="10" {{ ($user->travel_distance==10 ? "selected":"") }} >  10 miles</option>
                                                    <option value="15" {{ ($user->travel_distance==15 ? "selected":"") }} >  15 miles</option>
                                                    <option value="20" {{ ($user->travel_distance==20 ? "selected":"") }} >  20 miles</option>
                                                    <option value="25" {{ ($user->travel_distance==25 ? "selected":"") }} >  25 miles</option>
                                                    <option value="30" {{ ($user->travel_distance==30 ? "selected":"") }} >  30 miles</option>
                                                    <option value="35" {{ ($user->travel_distance==35 ? "selected":"") }} >  35 miles</option>
                                                    <option value="40" {{ ($user->travel_distance==40 ? "selected":"") }} >  40 miles</option>
                                                    <option value="45" {{ ($user->travel_distance==45 ? "selected":"") }} >  45 miles</option>
                                                    <option value="50" {{ ($user->travel_distance==50 ? "selected":"") }} >  50 miles</option>
                                                    <option value="60" {{ ($user->travel_distance==60 ? "selected":"") }} >  60 miles</option>
                                                    <option value="70" {{ ($user->travel_distance==70 ? "selected":"") }} >  70 miles</option>
                                                    <option value="80" {{ ($user->travel_distance==80 ? "selected":"") }} >  80 miles</option>
                                                    <option value="90" {{ ($user->travel_distance==90 ? "selected":"") }} >  90 miles</option>
                                                    <option value="100" {{ ($user->travel_distance==100 ? "selected":"") }} >  100 miles</option>
                                                </select>
                                                <label for="travel_distance">Travel Distance</label>
                                            </div>
                                            <div class="myAddSmallText">
                                                Your address will never be made public. It is only used for calculating distance to the job.
                                            </div>
                                        </div>
                                        <div class="fieldRowSec">
                                            <?php $language = $c_languagename[0]; 
                   $language = str_replace(' ', '', $language);
                    $language_array = explode(",",$language);
                  
                   ?>
                                            <div class="input-field">
                                               <select multiple id="languages" name="languages[]">
                                                    <option value="" disabled >Choose your  Languages</option>
                                                    <option value="">None</option>
                                                    @foreach ($languages as $language)
                                                     <option value="{{ $language->name }}"  {{ (in_array($language->name, $language_array) ? "selected":"") }}>{{ $language->name }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="Languages">Languages</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="skillsSec">
                                        <div class="pageTitle2">Professional Summary</div>
                                        <div class="proSummaryTextareaSec">
                                            <div class="input-field">
                                                <textarea class="materialize-textarea" name="user_note">{{ $user->user_note }}</textarea>
                                            </div>
                                        </div>
                                        <div class="clear"></div>

                                        <div class="fieldRowSec">


                                            <div class="input-field">
                                                <select multiple id="skills_software" name="software_skills[]">
                                                    <option value="" disabled >Choose your software</option>
                                                    @foreach ($sofaware_skills as $sofaware_skill)

                                                    <option value="{{ $sofaware_skill->id }}"  {{ (in_array($sofaware_skill->id, $s_skillIDS) ? "selected":"") }}>{{ $sofaware_skill->skill }}</option>

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
                                                    <option value="{{ $radiology_skill->id }}" {{ (in_array($radiology_skill->id, $r_skillIDS) ? "selected":"") }}>{{ $radiology_skill->skill }}</option>
                                                    @endforeach
                                                </select>
                                                <label for="radiology">Radiology (DEXIS, ScanX, etc.)</label>
                                            </div>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="pageTitle2 specCertiHeading">Education: <span class="addAttributeSec" id="addMoreFields">Add more</span></div>
                                        @if(count($user_education) > 0 )
                                        <?php $i=0; ?>
                                        @foreach($user_education as $education)
                                        <div id="educationforAddnew">
                                        <div class="fieldRowSec" id="addeducationRowSec">
                                            <div class="leftBoxSec">
                                                <div class="input-field">
                                                    <input id="education" type="text" name="education[]" class="validate" value="{{ $education->qualification or '' }}">
                                                    <label for="education">Education Title</label>
                                                </div>
                                            </div>
                                            <div class="rightBoxSec">
                                                <div class="input-field">
                                                    <input id="educationyear" type="text" name="educationyear[]" maxlength="4" class="validate" value="{{ $education->year or '' }}">
                                                    <label for="educationyear">Year Obtained</label>
                                                </div>
                                            </div>
                                               
                                             <div class="removeAddMoreBtn" id="removeMoreFields"><i class="material-icons">close</i></div>
                                             
                                            <div class="clear"></div>
                                        </div>
                                        </div>
                                        <?php $i++; ?>
                                         @endforeach
                                         @else
                                         <div id="educationforAddnew">
                                         <div class="fieldRowSec" id="addeducationRowSec">
                                            <div class="leftBoxSec">
                                                <div class="input-field">
                                                    <input id="education" type="text" name="education[]" class="validate" >
                                                    <label for="education">Education Title</label>
                                                </div>
                                            </div>
                                            <div class="rightBoxSec">
                                                <div class="input-field">
                                                    <input id="educationyear" type="text" maxlength="4" name="educationyear[]" class="validate"  >
                                                    <label for="educationyear">Year Obtained</label>
                                                </div>
                                            </div>

                                            <div class="clear"></div>
                                        </div>
                                         </div>
                                         @endif

                                        <div class="clear"></div>

                                        <div class="pageTitle2 specCertiHeading">Certifications: <span class="addAttributeSec" id="addMoreFields2">Add more</span></div>
                                         @if(count($user_certifications) > 0 )
                                        <?php $j=0; ?>
                                        
                                        @foreach($user_certifications as $certifications)
                                        <div id="certificationforAddnew">
                                        <div class="fieldRowSec" id="addCertificationRowSec">
                                            <div class="leftBoxSec">
                                                <div class="input-field">
                                                    <select id="certifications" name="certifications[]">
                                                    <option value="" disabled >Choose your Certification</option>
                                                    <option value="None"  <?php foreach ($certificate as $certificates) { if($certificates->name == 'None' ){ ?> selected="selected" <?php } } ?>>None Selected</option>
                                                    @foreach ($certificate as $certificates)

                                                    <option value="{{ $certificates->name }}" <?php if($certifications->certification == $certificates->name ){ ?> selected="selected" <?php } ?>>{{ $certificates->name }}</option>

                                                    @endforeach

                                                </select>
                                                    <!--<input id="certifications" type="text" class="validate" name="certifications[]"  value="{{ $certifications->certification or '' }}">-->
                                                    <label for="certifications">Certifications Title</label>
                                                </div>
                                            </div>
                                            <div class="rightBoxSec">
                                                <div class="input-field">
                                                    <input id="certificationyear" type="text" maxlength="4" class="validate" name="certificationyear[]" value="{{ $certifications->year or '' }}">
                                                    <label for="certificationyear">Year Obtained</label>
                                                </div>
                                            </div>
                                             
                                             <div class="removeAddMoreBtn" id="removeMoreFields2"><i class="material-icons">close</i></div>
                                         
                                            <div class="clear"></div>
                                        </div>
                                        </div>
                                       <?php $j++; ?>
                                        @endforeach
                                         @else
                                          <div id="certificationforAddnew">
                                         <div class="fieldRowSec" id="addCertificationRowSec">
                                            <div class="leftBoxSec">
                                                <div class="input-field">
                                                    <select id="certifications" name="certifications[]">
                                                    <option value="" disabled >Choose your Certification</option>
                                                    <?php  //$credenn = $c_certifications[0]; 
                   
                     //$creden_arrayy = explode(",",$credenn);
                    
                  
                   ?>                               <option value="">None Selected</option>
                                                    @foreach ($certificate as $certificates)

                                                    <option value="{{ $certificates->name }}" >{{ $certificates->name }}</option>

                                                    @endforeach

                                                </select>
                                                    <!--<input id="certifications" type="text" class="validate" name="certifications[]" >-->
                                                    <label for="certifications">Certifications Title</label>
                                                </div>
                                            </div>
                                            <div class="rightBoxSec">
                                                <div class="input-field">
                                                    <input id="certificationyear" type="text" maxlength="4" class="validate" name="certificationyear[]"  >
                                                    <label for="certificationyear">Year Obtained</label>
                                                </div>
                                            </div>

                                            <div class="clear"></div>
                                        </div>
                                          </div>
                                         @endif
                                        <div class="clear"></div>

                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="other_specialties" name="user_exprience" type="text" class="validate" value="{{ $user_exprience[0]->position or '' }}" >
                                                <label for="other_specialties">Other Specialties</label>
                                            </div>
                                        </div>

                                        <div class="fieldRowSec">
                                            <div class="input-field">
                                                <input id="malpractice_insurance"  name="malpractice_insurance" type="checkbox" class="validate" value="1" {{ ($user->malpractice_insurance ==1 ? "checked":"") }} >
                                                <label for="malpractice_insurance">Malpractice Insurance  </label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col s12">
                        
                                            <input type="button" onclick="location.href='/pontic_dev/userProfile';" class="waves-effect waves-light btn" value="Cancel" id="cancleEdit" />
                 
                                            <input type="button" class="waves-effect waves-light btn" value="Save" id="additional_info" />
                         
                                    </div>
                                    <div class="clear"></div>


                                    <div class="loaderBodySec" id="additionalinfoloader">
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
                                </div>
                            </form>
                            <div class="clear"></div>
                        </div>
                    </div>

                </div>
                <div id="availability">
                    <div class="availabilityTabSec">
                        <div class="enterAvailabilFormSec" id="enterAvailabilitySec">

                            @if(count($available_timings) == 0)
                            <div class="avaiBoxSec" id="enterAvailabilitySec">
                                <div class="bigTextSec">You haven’t entered availability</div>
                                <div class="smallTextSec">Please provide your office hours.</div>
                                <div class="enterAvailableBtn"><input type="button" id="enterAvailabilityBtn2" value="Enter Availability" class="waves-effect waves-light btn" id="enterAvailabilityBtn" /></div>
                                <div class="clear"></div>
                            </div>
                            <div class="clear"></div>
                            @else
                            <div class="editBtnSec">
                                <input type="button" value="Edit" class="waves-effect waves-light btn generalEditBtn" id="enterAvailabilityBtn" />

                                <a class="dropdown-button threeDotDrop" href="#!" data-activates="dropDown3"><i class="material-icons">more_vert</i></a>
                                <!-- Dropdown Structure -->
                                <ul id="dropDown3" class="dropdown-content">
                                    <li><a id="enterAvailabilityBtn1">Edit</a></li>
                                    <!--<li class="divider"></li>-->
                                </ul>
                            </div>
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
                            <div class="clear"></div>

                            @endif
                        </div>
                        <div class="clear"></div>
                        <div class="newEnterAvailabilFormSec" id="enterAvailabilFormSec">
                            <form   id="time_availabil_form" role="form" method="POST" action="" >
                                <input type="hidden" name="_token" value="{{ csrf_token()}}">
                                <div class="pageTitle2">Office Hours</div>
                                <div class="hoursRowSec">
                                    <div class="dayFieldSec">
                                        <div class="days"> Monday </div>
                                    </div>
                                    <div class="startTimeSec">
                                        <div class="input-field">
                                            <?php
                                            $open_time = strtotime("00:00");
                                            $close_time = strtotime("23:59");
                                            $now = time();
                                            ?>
                                            <select  id="mon_start_time"  name="start_time[]" class="start_time1">
                                                <option value="-1" {{ ($available_timings[0]->start_time == -1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{($available_timings[0]->start_time == date("H:i",$i)? 'selected':'')}}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="mon_start_time">Start Time</label>
                                        </div>
                                    </div>
                                    <div class="endTimeSec">
                                        <div class="input-field">
                                            <select  id="mon_end_time"  name="end_time[]" class="end_time1">
                                                <option value="-1" {{ ($available_timings[0]->end_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[0]->end_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="mon_end_time">End Time</label>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="hoursRowSec">
                                    <div class="dayFieldSec">
                                        <div class="days">Tuesday</div>
                                    </div>
                                    <div class="startTimeSec">
                                        <div class="input-field">
                                            <select  id="tue_start_time" name="start_time[]" class="start_time2">
                                                <option value="-1" {{ ($available_timings[1]->start_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[1]->start_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="tue_start_time">Start Time</label>
                                        </div>
                                    </div>
                                    <div class="endTimeSec">
                                        <div class="input-field">
                                            <select  id="tue_end_time"  name="end_time[]" class="end_time2">
                                                <option value="-1" {{ ($available_timings[1]->end_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[1]->end_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="tue_end_time">End Time</label>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="hoursRowSec">
                                    <div class="dayFieldSec">
                                        <div class="days">Wednesday</div>
                                    </div>
                                    <div class="startTimeSec">
                                        <div class="input-field">
                                            <select  id="wed_start_time" name="start_time[]" class="start_time3">
                                                <option value="-1" {{ ($available_timings[2]->start_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[2]->start_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="wed_start_time">Start Time</label>
                                        </div>
                                    </div>
                                    <div class="endTimeSec">
                                        <div class="input-field">
                                            <select  id="wed_end_time"  name="end_time[]" class="end_time3">
                                                <option value="-1" {{ ($available_timings[2]->end_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[2]->end_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="wed_end_time">End Time</label>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="hoursRowSec">
                                    <div class="dayFieldSec">
                                        <div class="days"> Thursday</div>
                                    </div>
                                    <div class="startTimeSec">
                                        <div class="input-field">
                                            <select  id="thu_start_time"  name="start_time[]" class="start_time4">
                                                <option value="-1" {{ ($available_timings[3]->start_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[3]->start_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="thu_start_time">Start Time</label>
                                        </div>
                                    </div>
                                    <div class="endTimeSec">
                                        <div class="input-field">
                                            <select  id="thu_end_time"  name="end_time[]" class="end_time4">
                                                <option value="-1" {{ ($available_timings[3]->end_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[3]->end_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="thu_end_time">End Time</label>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="hoursRowSec">
                                    <div class="dayFieldSec">
                                        <div class="days">Friday</div>
                                    </div>
                                    <div class="startTimeSec">
                                        <div class="input-field">
                                            <select  id="fri_start_time" name="start_time[]" class="start_time5">
                                                <option value="-1" {{ ($available_timings[4]->start_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[4]->start_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="fri_start_time">Start Time</label>
                                        </div>
                                    </div>
                                    <div class="endTimeSec">
                                        <div class="input-field">
                                            <select  id="fri_end_time"  name="end_time[]" class="end_time5">
                                                <option value="-1" {{ ($available_timings[4]->end_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[4]->end_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="fri_end_time">End Time</label>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="hoursRowSec">
                                    <div class="dayFieldSec">
                                        <div class="days">Saturday</div>
                                    </div>
                                    <div class="startTimeSec">
                                        <div class="input-field">
                                            <select  id="sat_start_time" name="start_time[]" class="start_time6">
                                                <option value="-1" {{ ($available_timings[5]->start_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[5]->start_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="sat_start_time">Start Time</label>
                                        </div>
                                    </div>
                                    <div class="endTimeSec">
                                        <div class="input-field">
                                            <select  id="sat_end_time"  name="end_time[]" class="end_time6">
                                                <option value="-1" {{ ($available_timings[5]->end_time==$s_skillIDS ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[5]->end_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="sat_end_time">End Time</label>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>
                                <div class="hoursRowSec">
                                    <div class="dayFieldSec">
                                        <div class="days">Sunday</div>
                                    </div>
                                    <div class="startTimeSec">
                                        <div class="input-field">
                                            <select  id="sun_start_time" name="start_time[]" class="start_time7">
                                                <option value="-1" {{ ($available_timings[6]->start_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)

                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[6]->start_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="sun_start_time">Start Time</label>
                                        </div>
                                    </div>
                                    <div class="endTimeSec">
                                        <div class="input-field">
                                            <select  id="sun_end_time" name="end_time[]" class="end_time7">
                                                <option value="-1" {{ ($available_timings[6]->end_time==-1 ? "selected":"") }} >Not Availabile</option>
                                                @for( $i=$open_time; $i<$close_time; $i+=1800)
                                                <option value="{{date("H:i",$i)}}" {{ ($available_timings[6]->end_time==date("H:i",$i)? "selected":"") }}>{{  date("h:i A",$i) }}</option>
                                                @endfor

                                            </select>
                                            <label for="sun_end_time">End Time</label>
                                        </div>
                                    </div>
                                    <div class="clear"></div>
                                </div>

                                <div class="saveBtnSec">
                                    <input type="button" onclick="location.href='/pontic_dev/userProfile';" value="Cancel" class="waves-effect waves-light btn cancelBtn" id="cancelButton"/>
                                    <input type="button" value="Save" class="waves-effect waves-light btn" id="available_timings_info"/>
                                </div>
                                <div class="clear"></div>
                            </form>
                            <div class="loadingSec" id="timeinfoloader" style="display: none;">
                                <div class="loaderBodySec">
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

<!--Body Section End-->


<div id="maskMenuBg"></div>



<!-- Modal Trigger
<a class="modal-trigger waves-effect waves-light btn" href="#editGeneralInfo">Modal</a>
-->
<!-- Modal Structure -->
<div id="editGeneralInfo" class="modal modal-fixed-footer profilePopUpSec">
    <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >
        <input type="hidden" name="_token" value="{{ csrf_token()}}">
        <div class="modal-content">
            <div class="genInfoFormSec">
                <div class="upLoadImgSec">

                    <!--@if(!empty($user->profile_image_thumb))
                    <img src="{{ Config('constants.s3_url') . $user->profile_image_thumb}}" id="profile_img_preview"/>
                    @else
                    <img src="images/profile-img.png" id="profile_img_preview" />
                    @endif-->
                     @if(!empty($user->profile_image_thumb))
                <div class="uploadImgSec1" id="profile_img_preview"  style="background-image:url({{ Config('constants.s3_url') . $user->profile_image_thumb}});position:absolute;width:100%;height:100%;border-radius:100%;background-size: cover;">
               
                </div>
                @else
                 <img src="images/profile-img.png" id="profile_img_preview" />
                @endif
                    <div class="clear">&nbsp;</div>
                    <!--<button class="waves-effect waves-light btn upProfImgBtn">Upload Profile Image</button>-->
                    <div class="file-field input-field upProfBtnRow">
                        <div class="btn upProfImgBtn">
                          <!--<span>Upload Profile Image</span>-->
                            <span><i class="material-icons">photo_camera</i></span>
                            <input type="file"  name="profile_picture" id="imgInp">
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text">
                        </div>
                    </div>
                </div>
                <div class="detailFormSec row">
                    <!-----<div class="titleRow">
                        <div class="input-field">
                            <input id="title" type="text" class="validate" name="title" value="{{ $user->title }}">
                            <label for="title">Title</label>
                        </div>
                    </div>----->
                    <div class="nameRow">
                        <div class="input-field">
                            <input id="name" type="text" class="validate" name="name" value="{{ $user->name }}">
                            <label for="name">Name</label>
                        </div>
                    </div>
                    <div class="credentialRow">
                   <?php $creden = $c_credentialname[0]; 
                   $creden = str_replace(' ', '', $creden);
                    $creden_array = explode(",",$creden);
                  
                   ?>
                                            <div class="input-field">
                                               <select multiple id="credential" class="validate" name="credential[]">
                                                   <option <?php if($credentials > 0) { } else { ?>selected="selected"<?php } ?> value="">None</option>
                                                    @foreach ($credentials as $credential)
                                                     <option value="{{ $credential->name }}"  {{ (in_array($credential->name, $creden_array) ? "selected":"") }}>{{ $credential->name }}</option>

                                                    @endforeach
                                                </select>
                                                <label for="radiology">Credential</label>
                                                
                                                <?php //print_r($s_skillIDS) ?>
                                              <!--  <select multiple id="skills_software" name="software_skills[]">
                                                    <option value="" disabled >Choose your software</option>
                                                    @foreach ($sofaware_skills as $sofaware_skill)

                                                    <option value="{{ $sofaware_skill->id }}"  {{ (in_array($sofaware_skill->id, $s_skillIDS) ? "selected":"") }}>{{ $sofaware_skill->skill }}</option>

                                                    @endforeach

                                                </select>
                                                <label for="software">Software (Dentrix, EagleSoft, etc.)</label>
                                                -->
                                            </div>
                                    
                        
                        <!-----<div class="input-field">
                            <input id="credential" type="text" class="validate" name="credential" value="{{ $user->credential }}">
                            <label for="credential">Credential</label>
                        </div>----->
                    </div>
                    <div class="commonRow">
                        <div class="input-field">
                            <input id="years-of-experiece" type="text" class="validate" name="Years_of_Experience" value="{{ $user->experience }}">
                            <label for="years-of-experiece">Years of Experience</label>
                        </div>
                    </div>
                    <div class="commonRow">
                        <div class="input-field">
                            <select name="expected_pay" id="expected_pay" class="validate" required="required">
                                <option value="">Select Expected Pay</option>
                              <?php 
                              $cond = $user->expected_pay; for($i = 0; $i < 151; $i++) { 
                                  if($i == $cond)
                                  {
  echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                  }
                                  if($i != $cond)
                                  {
  echo '<option value="'.$i.'">'.$i.'</option>';
                                  }
}
            ?>                </select>
                            
                            <label for="expected-pay">
                                  {{ 'Expected Pay' }}

                            </label>
                        </div>
                    </div>
                    <div class="commonRow">
                        <div class="input-field">
                            <input id="state-license" type="text" class="validate"  name="state_license" value="{{ $user->state_license }}">
                            <label for="state-license">State License</label>
                        </div>
                    </div>

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
            <input type="button" value="Save" class="modal-action waves-effect btn-flat " id="genaral_info" />
            <input type="button" onclick="location.href='/pontic_dev/userProfile';" class="modal-action modal-close waves-effect btn-flat" value="Cancel" id="editGeneralInfo" />
        </div>
    </form>
</div>

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
        $("#cancelButton").click(function () {
            $("#enterAvailabilFormSec").hide();
            $("#enterAvailabilitySec").show();

        });
        $("#cancleEdit").click(function () {
            $("#editSkillFormSec").hide();
            $("#skillFormSec").show();

        });

 $('#addMoreFields').click(function () {

        $('#educationforAddnew').before('<div class="fieldRowSec" id="addeducationRowSec"><div class="leftBoxSec"><div class="input-field"><input id="education" type="text" name="education[]" class="validate"><label for="education">Education Title</label> </div> </div><div class="rightBoxSec"><div class="input-field"><input id="educationyear" maxlength="4" type="text" name="educationyear[]"class="validate"><label for="educationyear">Year Obtained</label></div></div><div class="removeAddMoreBtn" id="removeMoreFields"><i class="material-icons">close</i></div><div class="clear"></div>  </div> <div class="clear"></div>');
    });
    $(document).on('click', '#removeMoreFields', function () {
    $(this).parent('#addeducationRowSec').remove();
    });
    var n = 1;
    $('#addMoreFields2').click(function () {
          var counter = n++;
          
       $('#certificationforAddnew').before('<div class="fieldRowSec" id="addCertificationRowSec"><div class="leftBoxSec"><div class="input-field"><div class="select-wrapper"><span class="caret">▼</span><input class="select-dropdown select_nEw" readonly="true" id="liId'+counter+'" data-activates="select-options-86060300-932f-0936-b366-77e6c3779be5" onclick="myFunction(this.id)" value="Choose Your Certification" type="text"><ul id="ulId'+counter+'" class="dropdown-content select-dropdown ul_nEw" style="width: 158px; position: absolute; top: 0px; left: 0px; opacity: 1; display: none;"><?php foreach($certificate as $usercertification){ ?><li id="<?php echo str_replace(array('/', ' ','&'), '_',$usercertification->name);?>'+counter+'" onclick="myFunctionn(this.id)" class=""><span><?php echo $usercertification->name; ?></span></li> <?php }  ?></ul><select id="certifications" name="certifications[]" class="initialized"><option value="None" disabled="">Choose your Certification</option><option value="None">None Selected</option><?php foreach($certificate as $usercertification){?><option id="<?php echo str_replace(array('/', ' ','&'), '_',$usercertification->name); ?>'+counter+'" value="<?php echo $usercertification->name; ?>"> <?php echo $usercertification->name; ?> </option><?php } ?> </select></div><label for="certifications">Certifications Title</label> </div> </div><div class="rightBoxSec"><div class="input-field"><input id="certificationyear" type="text" maxlength="4" name="certificationyear[]"class="validate"><label for="certificationyear">Year Obtained</label></div></div><div class="removeAddMoreBtn" id="removeMoreFields2"><i class="material-icons">close</i></div><div class="clear"></div>  </div> <div class="clear"></div>');
    });
    $(document).on('click', '#removeMoreFields2', function () {

    $(this).parent('#addCertificationRowSec').remove();
    });

});
$(document).click(function(e) { 
   if( !$('.select_nEw').is( e.target ) )
      $('.ul_nEw').hide(); 
});

</script>
<script  src="{{ secure_url('js/moment-with-locales.min.js') }}"></script>
<script   src="{{ secure_url('js/bootstrap-material-datetimepicker.js') }}"></script>
<script   src="{{ secure_url('js/materialize.clockpicker.js') }}"></script>



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
    //csrf token for each from
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });
    //csrf token end here

    $(document).ready(function () {
        $('#genaral_info').click(function () {
            //$('.popLoaderSec').css('display', 'block');

            $.ajax({
                url: 'userGenaralInfo',
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
                    if (jsonResponse['status'] == 201 && jsonResponse[0]['expected_pay'] != undefined) {
                        $('.popLoaderSec').css('display', 'none');
                        Materialize.toast(jsonResponse[0]['expected_pay'], 4000, 'redMessage');
                    }
                    else if (jsonResponse['status'] == 201 && jsonResponse[0]['name'] != undefined) {
                    $('.popLoaderSec').css('display', 'none');
                    Materialize.toast(jsonResponse[0]['name'], 4000, 'redMessage');
                   }
                   else if (jsonResponse['status'] == 201 && jsonResponse[0]['Years_of_Experience'] != undefined) {
                    $('.popLoaderSec').css('display', 'none');
                    Materialize.toast(jsonResponse[0]['Years_of_Experience'], 4000, 'redMessage');
                   }
                  
                   else if (jsonResponse['status'] == 400) {
                        $('.popLoaderSec').css('display', 'none');
                        Materialize.toast(jsonResponse['message'], 4000, 'redMessage');
                    } else if (jsonResponse['status'] == 200) {
                        Materialize.toast(jsonResponse['message'], 2000);
                        //location.reload();
                        location.href = "/pontic_dev/userProfile";
                    } else {
                        $('.popLoaderSec').css('display', 'none');
                        Materialize.toast(jsonResponse['message'], 4000);
                    }
                }
            });
        });
        $("#additional_info").click(function () {

            $('#additionalinfoloader').css('display', 'block');
            $.ajax({
                url: 'userAdditionalInfo',
                data: new FormData($("#additional_infor_form")[0]),
                dataType: 'json',
                async: true,
                type: 'post',
                processData: false,
                contentType: false,
                success: function (response) {
                    var responseString = JSON.stringify(response);
                    ;
                    var jsonResponse = JSON.parse(responseString);
                    if (jsonResponse['status'] == 201 && jsonResponse[0]['email'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['email'], 4000, 'redMessage');
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['mobile_number'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['mobile_number'], 4000, 'redMessage');
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['additional_number'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['additional_number'], 4000, 'redMessage');
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['street'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['street'], 4000, 'redMessage');
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['city'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['city'], 4000, 'redMessage');
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['state'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['state'], 4000, 'redMessage');
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['zip_code'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['zip_code'], 4000, 'redMessage');
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['travel_distance'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['travel_distance'], 4000, 'redMessage');
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['certificationyear'] != undefined) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['certificationyear'], 4000, 'redMessage');
                    } else if (jsonResponse['status'] == 400) {
                        $('#additionalinfoloader').hide();
                        Materialize.toast(jsonResponse['message'], 4000, 'redMessage');
                    } else if (jsonResponse['status'] == 200) {
                        Materialize.toast(jsonResponse['message'], 2000);
                        location.href = "/pontic_dev/userProfile";
                    } else {
                        $('#additionalinfoloader').hide();
                        Materialize.toast('Unknown address - please check address fields', 4000, 'redMessage');
                    }
                }
            });
        });

        //time_availabil_form
        $("#available_timings_info").click(function () {
            $('#timeinfoloader').show();


            for (var i = 1; i < 8; i++) {
                var start_time = $(".start_time" + i + " option:selected").val();
                var end_time = $(".end_time" + i + " option:selected").val();
                if (start_time != -1) {
                    var a = start_time.split(':'); // split it at the colons
                    var start_time_seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60;
                    var b = end_time.split(':'); // split it at the colons
                    var end_time_seconds = (+b[0]) * 60 * 60 + (+b[1]) * 60;
                    if (start_time_seconds > end_time_seconds) {
                        Materialize.toast('Please choose valid timings', 4000, 'redMessage');
                        return true;
                        break;
                    }
                }
                if (start_time == -1 && end_time != -1) {
                    $(".start_time" + i).val(-1)
                    $(".end_time" + i).val(-1);
                }
                if (start_time != -1 && end_time == -1) {
                    $(".start_time" + i).val(-1)
                    $(".end_time" + i).val(-1);
                }
            }
            $.ajax({
                url: 'userTimeAvailabilInfo',
                data: new FormData($("#time_availabil_form")[0]),
                dataType: 'json',
                async: true,
                type: 'post',
                processData: false,
                contentType: false,
                success: function (response) {
                    var responseString = JSON.stringify(response);

                    var jsonResponse = JSON.parse(responseString);
                    if (jsonResponse['status'] == 200) {
                        $('#timeinfoloader').hide();
                        Materialize.toast(jsonResponse['message'], 4000);
                        location.reload(1);
                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Monday'] != undefined) {
                        $('#timeinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Monday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Tuesday'] != undefined) {
                        $('#timeinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Tuesday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Wednesday'] != undefined) {
                        $('#timeinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Wednesday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Thursday'] != undefined) {
                        $('#timeinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Thursday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Friday'] != undefined) {
                        $('#timeinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Friday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Saturday'] != undefined) {
                        $('#timeinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Saturday'], 4000, 'redMessage');

                    } else if (jsonResponse['status'] == 201 && jsonResponse[0]['Sunday'] != undefined) {
                        $('#timeinfoloader').hide();
                        Materialize.toast(jsonResponse[0]['Sunday'], 4000, 'redMessage');

                    } else {
                        $('#timeinfoloader').hide();
                        Materialize.toast(jsonResponse['message'], 4000, 'redMessage');
                    }
                }
            });
        });
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                 $("#profile_img_preview").removeAttr("background-image");
                 $("#profile_img_preview").html("<img id='newImage' />");
                $('#profile_img_preview').attr('src', e.target.result);
                $('#newImage').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function () {
        readURL(this);
    });



</script>
<script>
function myFunction(strs) {
    var str1 = strs.replace ( /[^\d.]/g, '' );
   
    
    document.getElementById('ulId'+str1+'').style.display = "block";
     
   
}
function myFunctionn(str) {
    if(str != "")
    {
        var str2 = str.replace ( /[^\d.]/g, '' );
        var strz = str.replace(/[^A-Za-z]/g, ' ');
        //var strz =  str.split('_').join(' ');
    document.getElementById('ulId'+str2+'').style.display = "none";
    document.getElementById('liId'+str2+'').value = strz;
    var strs = str;
    var replaced = strs.split(' ').join('');
    $("#certifications [id="+replaced+"]").attr("selected","selected");
     }
}
$(document).ready(function(){
    $('[id^=certificationyear]').keypress(validateNumber);
});

function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
    	return true;
    }
};
$(document).ready(function(){
    $('[id^=educationyear]').keypress(validateNumber1);
});

function validateNumber1(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keyCode === 46) {
        return true;
    } else if ( key < 48 || key > 57 ) {
        return false;
    } else {
    	return true;
    }
};
</script>


@endsection

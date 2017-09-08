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
<div class="pageTitle1">User Profile</div>
<div class="pageContSec">
    <div class="pageContBox">
        <div class="pageTitle2">General Information</div>
        <div class="formSec">
            <form enctype="multipart/form-data" id="upload_form" role="form" method="POST" action="" >
                <input type="hidden" name="_token" value="{{ csrf_token()}}">
            <div class="genInfoFormSec">
                <div class="upLoadImgSec">
                    <img src="images/profile-img.png" id="profile_img_preview"/>
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
                    <div class="titleRow">
                        <div class="input-field">
                            <input id="title" type="text" class="validate" name="title" value="{{ $user->title }}">
                          <label for="title">Title</label>
                        </div>
                    </div>
                    <div class="nameRow">
                        <div class="input-field">
                          <input id="name" type="text" class="validate" name="name" value="{{ $user->name }}">
                          <label for="name">Name</label>
                        </div>
                    </div>
                    <div class="credentialRow">
                        <div class="input-field">
                            <input id="credential" type="text" class="validate" name="credential" value="{{ $user->credential }}">
                          <label for="credential">Credential</label>
                        </div>
                    </div>
                    <div class="commonRow">
                        <div class="input-field">
                          <input id="years-of-experiece" type="text" class="validate" name="experience" value="{{ $user->experience }}">
                          <label for="years-of-experiece">Years of Experiece</label>
                        </div>
                    </div>
                    <div class="commonRow">
                        <div class="input-field">
                          <input id="credential" type="text" class="validate" name="expected_pay" value="{{ $user->expected_pay }}">
                          <label for="expected-pay">Expected Pay</label>
                        </div>
                    </div>
                    <div class="commonRow">
                        <div class="input-field">
                          <input id="state-license" type="text" class="validate"  name="state_license" value="{{ $user->state_license }}">
                          <label for="state-license">State License</label>
                        </div>
                    </div>
                    <div class="commonRow saveBtnSec">
                    <input type="button" class="waves-effect waves-light btn" id="genaral_info" value="Save" />
                    </div>
                </div>
                <div class="clear"></div>
            </div>
                </form>
        </div>
    </div>
</div>
<div class="pageContSec">
<div class="row">
    <div class="s12">
      <ul class="tabs">
        <li class="tab col s6"><a class="active" href="#additionalInformation">Additional Information</a></li>
        <li class="tab col s6"><a href="#availability">Availability</a></li>
      </ul>
    </div>
    <div id="additionalInformation" class="col s12 addiInfoSec">
        <div class="pageContBox">
            <div class="formSec">
                <div class="row">
                    <div class="contactDetailsSec">
                        <div class="pageTitle2">Contact</div>
                        <div class="col s12">
                            <div class="input-field">
                              <input id="email" type="text" class="validate" value="{{ $user->contact_email }}">
                              <label for="email">Email</label>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="input-field">
                              <input id="phone_number" type="text" class="validate" value="{{ $user->mobile_number }}">
                              <label for="phone_number">Phone Number</label>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="input-field">
                              <input id="additional_number" type="text" class="validate" value="{{ $user->aditional_number }}">
                              <label for="additional_number">Additional Number</label>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="input-field">
                              <input id="street_address" type="text" class="validate" value="{{ $user->street }}">
                              <label for="street_address">Street Address</label>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="input-field">
                              <input id="city" type="text" class="validate" value="{{ $user->city }}">
                              <label for="city">City</label>
                            </div>
                        </div>
                        <div class="col s6">
                            <div class="input-field">
                              <input id="state" type="text" class="validate" value="{{ $user->state }}">
                              <label for="state">State</label>
                            </div>
                        </div>
                        <div class="col s12">
                            <div class="input-field">
                              <input id="zip_code" type="text" class="validate" value="{{ $user->zipcode }}">
                              <label for="zip_code">Zip Code</label>
                            </div>
                        </div>
                    </div>
                    <div class="skillsSec">
                         <div class="pageTitle2"> Skills</div>
                        <div class="input-field col s12">
                            <select multiple id="skills_software">
                              <option value="" disabled selected>Choose your Skills</option>
                              @foreach ($sofaware_skills as $sofaware_skill)
                                    <option value="{{ $sofaware_skill->id }}">{{ $sofaware_skill->skill }}</option>
                                    @endforeach
                            </select>
                            <label>Software Skills</label>
                        </div>
                         
                        <div class="input-field col s12">
                            <select multiple id="skills_radiology">
                              <option value="" disabled selected>Choose your Skills</option>
                             @foreach ($radiology_skills as $radiology_skill)
                                    <option value="{{ $radiology_skill->id }}">{{ $radiology_skill->skill }}</option>
                                    @endforeach
                            </select>
                            <label>Radiology Skills</label>
                        </div>
                      
                        <div class="col s12">
                            <div class="input-field">
                              <textarea id="note" class="materialize-textarea">{{ $user->user_note }}</textarea>
                              <label for="note">Note</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col s12">
                        <div class="saveBtnSec">
                        <input type="button" class="waves-effect waves-light btn" value="Save" />
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div id="availability" class="avaiBoxSec">
    
    	  
          <div class="bigTextSec">You haven’t entered availability</div>
          <div class="smallTextSec">Please provide your office hours.</div>
          <div class="enterAvailableBtn"><input type="button" value="Enter Availability" class="waves-effect waves-light btn" /></div>
		  <div class="clear"></div>
    
    </div>
</div>
</div>
</div>

</div>


<div class="preloader-wrapper active" style="display: none;" id="loaderImg">
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

<!--Body Section End-->


 

<div id="maskMenuBg"></div>




@endsection


@section('script')
<script>
    $(document).ready(function () {
        $('ul.tabs').tabs();
    });
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
  //csrf token for each from 
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });
    //csrf token end here
    
    $(document).ready(function () {
        $('#genaral_info').click(function () {
            $('#loaderImg').css('display','block');
             
            $.ajax({
      url:'userGenaralInfo',
      data: new FormData($("#upload_form")[0]),
      dataType:'json',
      async:false,
      type:'post',
      processData: false,
      contentType: false,
      success:function(response){
          $('#loaderImg').css('display','none');
        console.log(response);
      },
    });
    });
//  $('#genaral_info').click(function () {
//            var make_praviate = +$("#make_praviate").is(':checked');
//
//            $.ajax({
//                url: 'profilesettings',
//                type: "post",
//                data: {'save_user': $('input[name=save_user]').val(), 'make_praviate': make_praviate, '_token': $('input[name=_token]').val()},
//                success: function (data) {
//                    var json = $.parseJSON(data);
//                    Materialize.toast(json['message'], 2000);
//                }
//            });
//
//
//
//        });
        $('#email_notifications').click(function () {

            var email_notify = +$("#email_notifications").is(':checked');

            $.ajax({
                url: 'emailnotifications',
                type: "post",
                data: {'save_user': $('input[name=save_user]').val(), 'email_notify': email_notify, '_token': $('input[name=_token]').val()},
                success: function (data) {
                    var json = $.parseJSON(data);
                    Materialize.toast(json['message'], 2000);
                }
            });



        });


    });

    function updateEmail() {
        var email = $("#user_email").val();
        $.ajax({
            url: 'emailupdate',
            type: "post",
            data: {'save_user': $('input[name=save_user]').val(), 'email': email, '_token': $('input[name=_token]').val()},
            success: function (data) {

                var json = $.parseJSON(data);
                if (json['status'] == 201) {
                    Materialize.toast(json[0]['email'], 2000);
                } else {
                    Materialize.toast(json['message'], 2000);
                }
            }
        });
        return false;
    } 
    $( window ).load(function() {
   var software_skills=  {!! json_encode($user_skills_software) !!};
   var radiology_skills=  {!! json_encode($user_skills_radiology) !!};
    
   
//$.each(software_skills.split(","), function(i,e){
//    $("#skills_software option[value='" + e + "']").prop("selected", true);
//});
//$.each(radiology_skills.split(","), function(i,e){
//    $("#skills_radiology option[value='" + e + "']").prop("selected", true);
//});

});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#profile_img_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$("#imgInp").change(function(){
    readURL(this);
});
</script>


@endsection
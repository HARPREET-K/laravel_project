@extends('layouts.app')

@section('content')
<!--Left Section Start-->
@include('includes.sidebar')
<!--Left Section End-->


<div class="headerSec">
    <div class="topHeader">
            <div id="topMenuIcon" class="topMenuIcon"><a href="#"><i class="material-icons">menu</i></a><div class="mainTitleSec">Pontic<!--<img src="images/logo-login.png" />--></div></div>


        <div class="menuSec">
            <div class="dashBoardMainMenu">
                <ul class="tabs">
                    <li class="tab"><a class="active" href="#accountSettings">Account</a></li>
                    <li class="tab"><a href="#changePassword">Password</a></li>
                    <li class="tab"><a href="#billing">Billing</a></li>
                  <!--   <li class="tab"><a href="#feedback">Feedback</a></li> -->
                </ul>
            </div>
        </div>

    </div>
</div>

<!--Body Section Start-->
<div id="mainBodyDiv" class="bodyContSec">
    <div class="settingPage">
        <div id="accountSettings" class="col s12">
            <div class="pageContSec">
                <div class="row">
                    <div class="tabBodyCont">
                        <div class="setAccountRows">
                            <div class="accountEmailBoxes">
                                <div class="input-field">
                                    <input id="user_email" type="text" class="validate" value="{{ $user->email }}">
                                    <label for="last_name">Email</label>
                                </div>
                            </div>
                            <div class="saveBtn">
                                <input type="submit" value="Save" class="waves-effect waves-light btn" onclick="return updateEmail();"></button>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="clear"></div>

                        <div class="deleteAccoSec">
                            <div class="deleteAccountSec">
                                <a class="modal-trigger waves-effect waves-light btn" href="#deleteAccount">Delete my account.</a>
                            </div>



                            <div class="clear"></div>
                        </div>

                        <!--     <div class="setAccountRows">
                                 <div class="accountEmailBoxes textAccountTab">
                                     Receive email notifications anytime I receive a new message
                                 </div>
                                 <div class="saveBtn">
                                     <div class="switch">
                                         <label>
                                             Off
                                             @if($user->email_notifications == 0)
                                             <input type="checkbox" checked="checked" id="email_notifications">
                                             @else
                                             <input type="checkbox" id="email_notifications">
                                             @endif
                                             <span class="lever"></span>
                                             On
                                         </label>
                                     </div>
                                 </div>
                                 <div class="clear"></div>
                             </div>
                        -->
                        <div class="setAccountRows">
                            <div class="accountEmailBoxes textAccountTab">
                                Make My Profile Private?
                            </div>
                            @if($user->userType == 1)
                            <div class="saveBtn">
                                <div class="switch">
                                    <label>
                                        Off
                                        @if($user->make_private == 1)
                                        <input type="checkbox" checked="checked" id="make_praviate">
                                        @else
                                        <input type="checkbox" id="make_praviate">
                                        @endif
                                        <span class="lever"></span>
                                        On
                                    </label>
                                </div>
                            </div>
                           @else
                            <div class="saveBtn">
                                <div class="switch">
                                    <label>
                                        Off
                                        @if($user->make_private == 1)
                                        <input type="checkbox" checked="checked" id="make_praviate1">
                                        @else
                                        <input type="checkbox" id="make_praviate1">
                                        @endif
                                        <span class="lever"></span>
                                        On
                                    </label>
                                </div>
                            </div>
                          @endif
                           
                            <div class="clear"></div>
                        </div>

                        <div class="clear"></div>



                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
        <div id="changePassword" class="col s12">
            <div class="pageContSec">
                <div class="row">
                    <div class="tabBodyCont">

                        <div class="pageTitle2">Change Password</div>
                        <div class="changePassBoxes">
                            <div class="input-field">
                                <input id="current_password" type="password" class="validate" value="">
                                <label for="current_password">Current Password</label>
                            </div>
                        </div>

                        <div class="changePassBoxes">
                            <div class="input-field">
                                <input id="new_password1" type="password" class="validate" value="">
                                <label for="new_password1">New Password</label>
                            </div>
                        </div>

                        <div class="changePassBoxes">
                            <div class="input-field">
                                <input id="new_password2" type="password" class="validate" value="">
                                <label for="new_password2">Verify Password</label>
                            </div>
                        </div>
                        <div class="changePassBoxes">
                            <div id='error_messages'></div>
                        </div>
                        <div class="changePassBtn btnRowSec">
                            <button class="waves-effect waves-light btn" onclick="return changePassword();">Save</button>
                        </div>


                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
         <div id="billing" class="col s12">
            <div class="pageContSec">
                <div class="row">
                    <div class="tabBodyCont">
                        <div class="settingPlanLeftSec pageTitle2">
                            Your Plan
                        </div>
                        <div class="yourPlanSec settingPlanRightSec">
                          @if($user->package_type == 1)
                           <div class="rows">{{ "Free Trial plan"}}</div>
                          @elseif($user->package_type == 2)
                            <div class="rows">{{ "6 Months Commitment"}}</div>
                          @else
                          <div class="rows"></div>
                           @endif
                          <div class="rows">
                            @if($user->userType == 2)
                            {{ 'Front Office' }}
                            @elseif($user->userType == 3)
                            {{ 'Hygienist' }}
                            @elseif($user->userType == 4)
                            {{ 'Assistant'}}
                            @else
                            {{'Dental Office'}}
                            @endif
                          </div>

                            @if($user->package_type == 2 && $user->userType == 1)
                            <div class="perMontSec">   {{ "$200"}}</div>
                            @elseif($user->package_type == 3 && $user->userType == 1)
                            <div class="perMontSec">  {{"$40/mo"}}</div>
                           @else
                          <div class="rows"></div>
                            @endif
                          <div class="rows"> {{ $subscriptopnMessage }}</div>
                         
                          <div class="cardBtnSec">
                          @if($user->expiry_date !=NULL && $user->package_type == 3)

                           <a href="{{ url('/cancelSubscription') }}" >
                              <button class="waves-effect waves-light btn">Cancel Plan</button>
                            </a>
                           @elseif($user->expiry_date != NULL && $user->package_type == 2)
                           <a href="{{ url('/loadPaymentInfo') }}" >
                           <button class="waves-effect waves-light btn">Extend Plan</button>
                         </a>
                           @else
                           <a href="{{ url('/loadPaymentInfo') }}" >
                           <button class="waves-effect waves-light btn">Select Plan</button>
                         </a>
                           @endif
                            </div>
                        </div>

                        <div class="clear">&nbsp;</div>

                        <div class="settingPlanLeftSec pageTitle2">
                            Card Info
                        </div>
                        <div class="settingPlanRightSec">


                              @if($activeCard['name'] != NULL)
                                <div class="cardNameSec"> {{ $activeCard['name']  }}</div>
                                @endif

                              @if($activeCard['last4'] != NULL)
                            <div class="cardNumberSec">  **** **** **** {{ $activeCard['last4'] }} </div>
                                 @else
                              <div class="cardNameSec">  {{ " No cards are available" }} </div>
                              @endif

                        </div>


                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    <!--  <div id="feedback" class="col s12">
             <div class="tabBodyCont">
                 <div class="input-field">
                     <textarea id="textarea1" class="materialize-textarea" length="400"></textarea>
                     <label for="textarea1">Tell us how we can improve our services.</label>
                 </div>

                 <div class="btnRowSec">
                     <button class="waves-effect waves-light btn">Submit</button>
                 </div>


                 <div class="clear"></div>
             </div>
         </div>-->
        <div class="deleteAccoSec">

            <div class="privacyPolicySec">
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


            <div class="clear"></div>
        </div>
        <input id="user_id" type="hidden" name="save_user" class="validate" value="{{ $user->id }}">
    </div>


</div>
<!--Body Section End-->




<!-- Modal Structure -->
<div id="privacyPolicy" class="modal largePopUp modal-fixed-footer">
    <div class="modal-content">

        <div class="privPolicyContentSec">
            <h4 class="privPoliHead">Privacy Policy and Legal Notice</h4>
            <ol>
                <li>Lorem Ipsum is simply dummy</li>
                <div class="privPolicyContent">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
                <li>Lorem Ipsum is simply dummy</li>
                <div class="privPolicyContent">It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
                <li>Lorem Ipsum is simply dummy</li>
                <div class="privPolicyContent">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</div>
                <li>Lorem Ipsum is simply dummy</li>
                <div class="privPolicyContent">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
                <li>Lorem Ipsum is simply dummy</li>
                <div class="privPolicyContent">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</div>
                <li>Lorem Ipsum is simply dummy</li>
                <div class="privPolicyContent">It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
                <li>Lorem Ipsum is simply dummy</li>
                <div class="privPolicyContent">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</div>
                <li>Lorem Ipsum is simply dummy</li>
                <div class="privPolicyContent">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</div>
            </ol>
        </div>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
    </div>
</div>



<!-- Modal Structure -->
<div id="deleteAccount" class="modal smallPopUp modal-fixed-footer">
    <div class="modal-content">

        <div class="privPolicyContentSec">
            <h4 class="privPoliHead">Delete Account</h4>
            <div>Are you sure you want to Delete your Account</div>
        </div>
    </div>
    <div class="modal-footer">
        <a href="{{ url('/delete') }}" class="modal-action modal-close waves-effect waves-green btn-flat ">Delete</a>
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Cancel</a>
    </div>
</div>

@include('includes.terms')

@endsection


@section('script')
<script>
                                $(document).ready(function () {
                                    $('ul.tabs').tabs();
                                });
</script>



<script>
      $('#make_praviate1').click(function () {
            var make_praviate = +$("#make_praviate1").is(':checked');

            $.ajax({
                url: 'profilesettings',
                type: "post",
                data: {'save_user': $('input[name=save_user]').val(), 'make_praviate': make_praviate, '_token': $('input[name=_token]').val()},
                success: function (data) {
                    var json = $.parseJSON(data);
                    Materialize.toast(json['message'], 2000);
                }
            });



        });
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

<script type="text/javascript">
    $.ajaxSetup({
        headers: {'X-CSRF-Token': $('meta[name=_token]').attr('content')}
    });
    @if (session('cancelSubscription'))
     Materialize.toast(  {{ session('cancelSubscription') }}, 5000);
   @endif
</script>
<script type="text/javascript">
    
      <?php // subscription expiry alert only for dental office
       $usertype = $user->userType;
      if ($usertype == '1') { ?> 
    $(document).ready(function () {
      @if($user->expiry_date == NULL)
      Materialize.toast("Please select your plan in billing section", 5000, 'redMessage');

     @endif;
      <?php } ?>
       

        $('#make_praviate').click(function () {
            var make_praviate = +$("#make_praviate").is(':checked');

            $.ajax({
                url: 'profilesettings',
                type: "post",
                data: {'save_user': $('input[name=save_user]').val(), 'make_praviate': make_praviate, '_token': $('input[name=_token]').val()},
                success: function (data) {
                    var json = $.parseJSON(data);
                    Materialize.toast(json['message'], 2000);
                }
            });



        });
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
                    Materialize.toast(json[0]['email'], 4000, 'redMessage');
                } else {
                    Materialize.toast(json['message'], 4000);
                }
            }
        });
        return false;
    }

    function changePassword() {
        var currentPW = $('#current_password').val();
        var newPW = $('#new_password1').val();
        var matchPW = $('#new_password2').val();

        $.ajax({
            url: 'changePassword',
            type: "post",
            data: {'save_user': $('input[name=save_user]').val(), 'current_password': currentPW, 'password': newPW, 'password_confirmation': matchPW, '_token': $('input[name=_token]').val()},
            success: function (data) {

                var json = $.parseJSON(data);
                if (json['status'] == 201 && json[0]['password'] != null) {
                    Materialize.toast(json[0]['password'], 5000, 'redMessage');

                }
                if (json['status'] == 201 && json[0]['current_password'] != null) {
                    Materialize.toast(json[0]['current_password'], 5000, 'redMessage');

                } else if (json['status'] == 202) {
                    Materialize.toast(json['message'], 5000, 'redMessage');
                } else {
                    Materialize.toast(json['message'], 2000);
                    location.reload();
                }
            }
        });

        return false;
    }
</script>


@endsection

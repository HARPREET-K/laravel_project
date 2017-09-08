<!--Left Section Start-->
<div id="mobRightMenu" class="leftMenuSec">
    <div class="leftSec">

        <div class="leftProfileSec">
             @if(!empty($user->profile_image_thumb))
           <a href="{{secure_url('/userProfile') }}">
            <div class="profileImg" style="background-image:url({{ Config('constants.s3_url') . $user->profile_image_thumb}});">
            </div>
            </a>
           @else
           <div class="profileImg" >
           <a href="{{secure_url('/userProfile') }}"> <img src="{{secure_url('images/profile-img.png') }}" /></a>
           </div>
            @endif
           
            <div class="profileName">
                @if($user->userType === 1 || $user->userType == '')
                <a href="{{ secure_url('/dentalOfficeProfile') }}">

                    @if($officeInformation->name != NULL)
                    {{ $officeInformation->name }}
                    @else
                    {{ 'Office Profile' }}
                    @endif
                </a>
                @else
                <a href="{{ secure_url('/userProfile') }}">{{  $user->name or 'User Profile' }}</a>
                @endif
            </div>
            <div id="closeMenuIcon" class="closeMenuIcon"><i class="material-icons">clear</i></div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <ul>
           <!-- <li {{{ (Request::is('home') ? 'class=active' : '') }}} ><a href="{{ url('/home') }}"><i class="material-icons">dashboard</i>Dashboard</a></li>
            <li><a href="{{ url('/history') }}"><i class="material-icons">history</i>History</a></li>
            <li><a href="{{ url('/find-jobs') }}"><i class="material-icons">work</i>Find Jobs</a></li>
            <li><a href="{{ url('/messages') }}"><i class="material-icons">drafts</i>Messages</a></li> -->
            @if($user->userType ===1 || $user->userType == '')
             <li {{{ (Request::is('search') ? 'class=active' : '') }}}><a href="{{ secure_url('/jsList') }}"><i class="material-icons">search</i>Find Staff</a></li>
             @else
             <li {{{ (Request::is('search') ? 'class=active' : '') }}}><a href="{{ secure_url('/search') }}"><i class="material-icons">search</i>Find Jobs</a></li>
            @endif
            <li {{{ (Route::is('message.welcome') ? 'class=active' : '') }}}><a href="{{ secure_url('/WelcomeMessage') }}"><i class="material-icons">forum</i>Messages <?php if(count($messageCounter) == 0) { }else { ?><span class="messageCounter"><?php  echo count($messageCounter);?></span><?php } ?></a></li>
             <li {{{ (Request::is('settings') ? 'class=active' : '') }}}><a href="{{ secure_url('/settings') }}"><i class="material-icons">settings</i>Settings</a></li>
            <li><a href="{{ secure_url('/logout') }}"><i class="material-icons">exit_to_app</i>Log Out</a>
        </ul>
        <div class="clear"></div>
    </div>

</div>
<style>
    .messageCounter {
    display: block !important;
}
    </style>
<!--Left Section End-->
<?php if(! empty($user) && $user->id != NULL): ?>
<link type="text/css" href="<?php echo e(secure_url('/chat/comet/cometchatcss.php')); ?>" rel="stylesheet" charset="utf-8">
<script type="text/javascript" src="<?php echo e(secure_url('/chat/comet/cometchatjs.php')); ?>" charset="utf-8"></script>
<?php endif; ?>    


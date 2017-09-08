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

    <link rel="stylesheet" href="{{asset('chat/css/reset.css')}}">

    <link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css'>

    <link rel="stylesheet" href="{{asset('chat/css/style.css')}}">





    <div class="container clearfix body">
        @include('partials.peoplelist')
@if(Route::is('message.welcome'))
<div class="chat">
            <div class="chat-header clearfix">
               
            
                <div class="profileImgSec" >
                    
                </div>
                
                <div class="chat-about">
                    
                    <div class="chat-with">
                       

                    </div>
                   
                   
                   
                </div>
                <!--<i class="fa fa-star"></i>-->
            </div>
            <!-- end chat-history -->
            <!-- end chat-header -->



         

        </div> <!-- end chat -->
@else

        <div class="chat">
            <div class="chat-header clearfix">
                @if($checkuserType->userType == 1)
                @if(!empty($officePersonImage->image_url))
                <img class="dentalImage" src="{{ Config('constants.s3_url') . $officePersonImage->image_url}}" />
                @else
                <div class="profileImgSec" >
                    <img src="{{ secure_url('images/profile-img.png') }}" />
                </div>
                @endif
                @else
                @if(!empty($users->profile_image_thumb))
                <img src="{{ Config('constants.s3_url') . $users->profile_image_thumb}}" />
                @else
                <div class="profileImgSec" >
                    <img src="{{ secure_url('images/profile-img.png') }}" />
                </div>
                @endif
                @endif
                <div class="chat-about">
                    @if(isset($users))
                    <div class="chat-with">
                        @if($users->userType == 1)
                        {{ $officePersonName->name }}
                        @else
                        {{ $users->name }}
                        @endif

                    </div>
                    @else
                    <div class="chat-with">No Thread Selected</div>
                    @endif
                </div>
                <!--<i class="fa fa-star"></i>-->
            </div>
            <div class="chat-history" id="messages">
                <div class="loadMorebtn"><span class="show_button">Load earlier messages</span></div>
                <ul id="talkMessages">

                    @foreach($messages as $message)
                    @if($message->sender->id == auth()->user()->id)
                    <li class="clearfix" id="message-{{$message->id}}">
                        <div class="message-data align-right">
                            <span class="message-data-time" >{{$message->humans_time}} ago</span> &nbsp; &nbsp;
                            @if(!empty($user->profile_image_thumb))
                            <img src="{{ Config('constants.s3_url') . $user->profile_image_thumb}}" />
                            @else
                            <div class="profileImgSec" >
                                <img src="{{ secure_url('images/profile-img.png') }}" />
                            </div>
                            @endif<!--<span class="message-data-name" >{{$message->sender->name}}</span>-->
                            <a href="#" class="talkDeleteMessage" data-message-id="{{$message->id}}" title="Delete Message"><i class="fa fa-close"></i></a>
                        </div>
                        <div class="message other-message float-right">
                            {{$message->message}}
                        </div>
                    </li>
                    @else

                    <li id="message-{{$message->id}}">
                        <div class="message-data">
                            @if($checkuserType->userType == 1)
                            @if(!empty($officePersonImage->image_url))
                            <img class="dentalImage" src="{{ Config('constants.s3_url') . $officePersonImage->image_url}}" />
                            @else
                            <div class="profileImgSec" >
                                <img src="{{ secure_url('images/profile-img.png') }}" />
                            </div>
                            @endif
                            @else
                            @if(!empty($users->profile_image_thumb))
                            <img src="{{ Config('constants.s3_url') . $users->profile_image_thumb}}" />
                            @else
                            <div class="profileImgSec" >
                                <img src="{{ secure_url('images/profile-img.png') }}" />
                            </div>
                            @endif
                            @endif
                                              <span class="message-data-name"> <!--<a href="#" class="talkDeleteMessage" data-message-id="{{$message->id}}" title="Delete Message"><i class="fa fa-close" style="margin-right: 3px;"></i></a>--></span>
                            <span class="message-data-time">{{$message->humans_time}} ago</span>
                        </div>
                        <div class="message my-message">
                            {{$message->message}}
                        </div>
                    </li>
                    @endif
                    @endforeach


                </ul>

            </div> <!-- end chat-history -->
            <!-- end chat-header -->



            <div class="chat-message clearfix">
                <form action="" method="post" id="talkSendMessage">
                    <textarea name="message-data" id="message-data" placeholder ="Type your message" rows="3"></textarea>
                    <input type="hidden" name="_id" value="{{@request()->route('id')}}">
                    <button type="submit" id="additional_info">Send</button>
                </form>

            </div> <!-- end chat-message -->

        </div> <!-- end chat -->
        @endif

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
</div><!--Body Section End-->


<script>

var __baseUrl = "{{url('/')}}"
</script>




<script src="{{asset('chat/js/talk.js')}}"></script>
<?php
$messageCount = count($messages);
$count = $messageCount - 10;
?>
<script>
$('ul#talkMessages li:lt(<?php echo $count; ?>)').hide();
var l = $('#talkMessages li').length;
if (l > 10) {
    $('span').show();
} else {
    $('span').hide();
}
$('.show_button').click(function () {
    $('ul#talkMessages li:lt(<?php echo $count; ?>)').toggle('slide');
    $('.show_button').hide();
});
</script>
<script>
    function getMessages(letter) {
        var div = $("#messages");
        div.scrollTop(div.prop('scrollHeight'));
    }
    $(function () {
        getMessages();
    });
    var show = function (data) {
        alert(data.sender.name + " - '" + data.message + "'");
    }

    var msgshow = function (data) {
        var html = '<div id="div"><li id="message-' + data.id + '">' +
                '<div class="message-data">' +
                '<span class="message-data-name"> <a href="#" class="talkDeleteMessage" data-message-id="' + data.id + '" title="Delete Messag"><i class="fa fa-close" style="margin-right: 3px;"></i></a>' + data.sender.name + '</span>' +
                '<span class="message-data-time">11 Second ago</span>' +
                '</div>' +
                '<div class="message my-message">' +
                data.message +
                '</div>' +
                '</li></div>';

        $('#talkMessages').append(html);
    }

</script>
<script>
    var msgshow = function (data) {
        alert('hello');

        console.log(data);
    }
</script>
<?php // for live messaging or real time messaging   ?>
{!! talk_live(['user'=>["id"=>auth()->user()->id, 'callback'=>['msgshow']]]) !!}





</div>
@include('includes.terms')
@endsection
@section('script')
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
</script>
<style>
    .message-data-time{
        display: inline-block !important;
    }
</style>
@endsection

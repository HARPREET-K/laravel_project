<div class="people-list" id="people-list">
    <div class="search" style="text-align: center">
        <div class="inbox"><i class="fa fa-envelope"></i> Inbox </div>
    </div>
    <ul class="list">
        <?php

         $explodeId = explode(',', $countunreadMsgs);
          $officeImages = explode(',', $officeImages);
          $officeName = explode('-', $officeNames);
         ?>
        @foreach($threads as $var => $inbox)
        @if(!is_null($inbox->thread))

        <li class="clearfix <?php
        $str = explode('/', $_SERVER['REQUEST_URI']);
        $result = explode('/', end($str));
        $checkForActive = $result[0];
        if ($checkForActive == $inbox->withUser->id) {
            echo 'active';
        } else {
            
        }
        ?> " >

            <a href="{{route('message.seen', ['id'=>$inbox->withUser->id])}}<?php //echo $inbox->thread->reciever_id;    ?>">
                  @if($inbox->withUser->userType==1)
                @if(!empty($officeImages[$var]))
                <img src="{{ Config('constants.s3_url') . $officeImages[$var]}}" />
                @else
                <div class="profileImgSec" >
                    <img src="{{ secure_url('images/profile-img.png') }}" />
                </div>
                @endif
                @else
                @if(!empty($inbox->withUser->profile_image_thumb))
                <img src="{{ Config('constants.s3_url') . $inbox->withUser->profile_image_thumb}}" />
                @else
                <div class="profileImgSec" >
                    <img src="{{ secure_url('images/profile-img.png') }}" />
                </div>
                @endif
                @endif
                <div class="about">
                    <div class="name">
                @if($inbox->withUser->userType==1)
                   {{ $officeName[$var] }}
                   @else
                   {{$inbox->withUser->name}}
                   @endif
                   </div>
                    @if($explodeId[$var]==0)
                    @else
                    <div class="messageCounterIndividual">{{ $explodeId[$var] }}</div>
                    @endif
                    <div class="status">
                        @if(auth()->user()->id == $inbox->thread->sender->id)
                        <span class="fa fa-reply"></span>
                        @endif
                        <span class="messageThread">{{substr($inbox->thread->message, 0, 15)}}  <?php
                            //if($inbox->thread->is_seen == '0'){
                            // echo '<div style="color:red">New Message</div>';
                            //}
                            // else { 
                            /// }
                            ?></span>
                    </div>
                </div>
            </a>
        </li>
        @endif
        @endforeach

    </ul>
</div>
<style>
    .messageThread {
        display:inline-block !important;
    }
    .fa-reply {
        display:inline-block !important;
    }
</style>

<?php

namespace App\Http\Controllers;

use App\User;
use App\OfficeInformation;
use App\OfficeImages;
use Illuminate\Http\Request;
use Nahid\Talk\Facades\Talk;
use Auth;
use View;
use DB;

class MessageController extends Controller {

    protected $authUser;

    public function __construct() {
        $location = $this->middleware('auth');
        $this->middleware('talk');
        if (!Auth::guest()) {
            Talk::setAuthUserId(Auth::user()->id);
        }

        View::composer('partials.peoplelist', function($view) {

           
 $threads = Talk::threads();
            //check if no message threads 
            if (count($threads) == 0) {

                //check if no unread meesage in database
                $array = array(implode(',', array_fill(0, 10000, 0)));

                $officeImagess[] = 0;
                $officename[] = 0;
                $array[] = 0;
                $countunreadMsgs = implode(',', $array);
                $officeImages = implode(',', $officeImagess);
                $officeNames = implode(',', $officename);
            } else {
                $user = Auth::user();
                foreach ($threads as $var) {
                    $sendersId = $var->withUser->id;
                    //count the number of unread messages from individuals
                    $counterPeruse = DB::select('select * from messages where user_id = ? AND is_seen = ? AND reciever_id = ?', [$sendersId, 0, $user->id]);
                    $officeinfo = DB::select('select * from office_information where user_id = ?', [$sendersId]);
                    foreach ($officeinfo as $officeinformtn) {
                        $officename[] = $officeinformtn->name;
                    }
                    foreach ($officeinfo as $key => $del) {
                         $office_id = $del->id;
                        //show image only for dental office(userType = 1)
                        $officeimages = DB::table('office_images')->where('office_id', '=', $office_id)->take(1)->get();
                        //check if there is no image for dental Office
                        if(count($officeimages)==0){
                            $officeImagess[] ='';
                        }
                        else {
                        foreach ($officeimages as $officeimage) {
                            
              
                             $officeImagess[] = $officeimage->image_url;
                            
                        }
                        }
                    }

                    $var = count($counterPeruse);
                    $array[] = json_decode($var, true);
                }
                if ($sendersId == null) {
                    $userExistenceCheck = 0;
                } else {
                    //check if no message of current user in database(New user)
                    $userExistenceCheck = DB::table('messages')->where('reciever_id', '=', $user->id)->orwhere('user_id', '=', $sendersId)->get();
                }
                if (count($userExistenceCheck) > 0) {
                    
                } else {
                    //check if no unread messages in database
                    $array = array(implode(',', array_fill(0, 10000, 0)));
                }
                if (count($threads) > 0) {
                    $officeImagess[] = 0;
                    $officename[] = 0;
                }
                $countunreadMsgs = implode(',', $array);
                  $officeImages = implode(',', $officeImagess);
                $officeNames = implode('-', $officename);
                
                //count total no. of unread messages of logged in user.
                $messageCounters = DB::select('select * from messages where is_seen = ? AND reciever_id = ?', [0, $user->id]);
            }


            $view->with(compact('threads', 'messageCounters', 'countunreadMsgs', 'officeImages', 'officeNames'));
        });
    }

    public function chatHistory($id) {

        $user = Auth::user();
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        $officePersonName = OfficeInformation::where('user_id', $id)->first();
        if (!empty($officeInformation->id) && $officeInformation->id != NULL) {
            $officeImages = OfficeImages::where('office_id', $officeInformation->id)->get();
            if (count($officeImages) > 0) {
                $user->profile_image_thumb = $officeImages[0]->image_url;
            }
        }
        $messageCounter = DB::select('select * from messages where is_seen = ? AND reciever_id = ?', [0, $user->id]);
        $conversations = Talk::getMessagesByUserId($id);
        $users = '';
        $messages = [];
        if (!$conversations) {
            $users = User::find($id);
            $checkuserType = User::where('id', $id)->first();
            if ($checkuserType->userType == 1) {
            $officeInformations = OfficeInformation::where('user_id', $id)->first();
                $officePersonImage = OfficeImages::where('office_id', $officeInformations->id)->first();
            }
            
        } else {
            $checkuserType = User::where('id', $id)->first();
            if ($checkuserType->userType == 1) {
                $officeInformations = OfficeInformation::where('user_id', $id)->first();
                $officePersonImage = OfficeImages::where('office_id', $officeInformations->id)->first();
            } //else {
                //$officePersonImage = OfficeImages::where('office_id', 15)->first();
            //}
            $users = $conversations->withUser;
            $messages = $conversations->messages;
        }

        return view('messages.conversations', compact('messages', 'checkuserType', 'officeInformation', 'officePersonName', 'officePersonImage', 'messageCounter', 'users', 'user'));
    }

    public function ajaxSendMessage(Request $request) {
        if ($request->ajax()) {
            $rules = [
                'message-data' => 'required',
                '_id' => 'required'
            ];

            $this->validate($request, $rules);

            $body = $request->input('message-data');
            $userId = $request->input('_id');

            if ($message = Talk::sendMessageByUserId($userId, $body)) {
                $users = Auth::user();
                $officeInformation = OfficeInformation::where('user_id', $users->id)->first();
                $officePersonName = OfficeInformation::where('user_id', $users->id)->first();
                if (!empty($officeInformation->id) && $officeInformation->id != NULL) {
                    $officeImages = OfficeImages::where('office_id', $officeInformation->id)->get();
                    if (count($officeImages) > 0) {
                        $users->profile_image_thumb = $officeImages[0]->image_url;
                    }
                }
                $checkuserType = User::where('id', $users->id)->first();
                if ($checkuserType->userType == 1) {
                    $officeInformations = OfficeInformation::where('user_id', $users->id)->first();
                    $officePersonImage = OfficeImages::where('office_id', $officeInformations->id)->first();
                } //else {

                    //$officePersonImage = OfficeImages::where('office_id', 15)->first();
                //}
                $html = view('ajax.newMessageHtml', compact('message', 'officePersonImage', 'checkuserType', 'users'))->render();
                return response()->json(['status' => 'success', 'html' => $html], 200);
            }
        }
    }

    public function ajaxDeleteMessage(Request $request, $id) {
        if ($request->ajax()) {
            if (Talk::deleteMessage($id)) {
                return response()->json(['status' => 'success'], 200);
            }

            return response()->json(['status' => 'errors', 'msg' => 'something went wrong'], 401);
        }
    }

    public function makeSeen($id) {
        $user = Auth::user();
        DB::table('messages')->where([['user_id', '=', $id],
            ['reciever_id', '=', $user->id]])->update(['is_seen' => 1]);
        return redirect('message/' . $id);
    }

    public function welcome() {
        $user = Auth::user();
        $messageCounter = DB::select('select * from messages where is_seen = ? AND reciever_id = ?', [0, $user->id]);
        // show no messages on welcome screen
        $messages = 0;
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        $officePersonName = OfficeInformation::where('user_id', $user->id)->first();
        if (!empty($officeInformation->id) && $officeInformation->id != NULL) {
            $officeImages = OfficeImages::where('office_id', $officeInformation->id)->get();
            if (count($officeImages) > 0) {
                $user->profile_image_thumb = $officeImages[0]->image_url;
            }
        }
        return view('messages.conversations', compact('messages', 'officePersonName', 'officeInformation', 'officePersonImage', 'messageCounter', 'user'));
    }

}
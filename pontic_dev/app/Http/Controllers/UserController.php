<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Validator;
//use Request;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Http\Exception\HttpResponseException;
use App\Classes\Common;
use Auth;
use Session;
use App\User;
use App\OfficeInformation;
use App\OfficeImages;
use App\OfficeDentists;
use App\OfficeTimings;
use App\Jobs;
use Input;
use DB;
use Illuminate\Support\Facades\Hash;
use AWS;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
#Stripe
Use Stripe;
// Image rotate class
use diversen\imageRotate;

class UserController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
        //create global objects for common and date classes.
        $this->MyClassInstance = new Common;
        $this->Common = new Common;

        $this->DateInstance = new \DateTime();
        $this->offset = $this->Common->getLocalOffsetValue();
        $this->utcSeconds = $this->DateInstance->getTimestamp() - $this->offset;
    }

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index() {

        $user = Auth::user();
        if ($user->userType == 1) {
            return redirect()->action('DentalOfficeController@getUserProfile');
        } else {
            return redirect()->action('UserController@getUserProfile');
        }

    }

    public function userSettings() {
        $data['title'] = 'Settings';
        $user = Auth::user();
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        $activeCard['name'] = NULL;
        $activeCard['last4'] = NULL;
        if(!empty($officeInformation->id) && $officeInformation->id!= NULL){
          $officeImages = OfficeImages::where('office_id', $officeInformation->id)->get();
        if (count($officeImages) > 0) {
            $user->profile_image_thumb = $officeImages[0]->image_url;
        }  
        }
         
        if($user->stripe_customer_id != NULL){
          $customerStripe = $stripe->Customers()->find($user->stripe_customer_id);
          $customerCards = $customerStripe['sources'];
          foreach($customerCards['data'] as $card){
            if($card['id'] = $customerStripe['default_source']){
              $activeCard = $card;
            }
          }

        $customerStripe = $stripe->Customers()->find($user->stripe_customer_id);
        $customerCards = $customerStripe['sources'];
        foreach($customerCards['data'] as $card){
          if($card['id'] = $customerStripe['default_source']){
            $activeCard = $card;
          }
        }
      }
      
      
       if($user->package_type != NULL && $user->expiry_date != NULL && ($user->expiry_date > strtotime(date('Y-m-d H:i:s'))) ){
           $subscriptopnMessage ="Your subscription expires on ". date('M d Y',$user->expiry_date);
       }elseif($user->package_type != NULL && $user->expiry_date != NULL && ( $user->expiry_date < strtotime(date('Y-m-d H:i:s')) ) )
       {
         $subscriptopnMessage ="Your subscription expired on ". date('M d Y',$user->expiry_date);
       }else{
           $subscriptopnMessage="";
       }

        return view('settings', compact('data','messageCounter', 'user', 'officeInformation','customerStripe','activeCard',"subscriptopnMessage"));
    }

    public function emailupdate(Request $request) {
        try {

            if ($request->ajax()) {
                $data = $request->all();


                $rules = array(
                    'email' => 'required|email|max:255|unique:users'
                );
                $messsages = array();
                $validator = Validator::make($data, $rules, $messsages);
                if ($validator->fails()) {
                    //echo $this->throwValidationException($request, $validator);
                    echo json_encode(array("status" => 201, $this->formatValidationErrors($validator)));
                } else {
                    $user = User::findOrFail($request->save_user);
                    $user->email = $request->email;
                    $user->updated_at = $this->utcSeconds;
                    $user->save();
                    echo json_encode(array("status" => 200, "message" => "Email updated successfully"));
                }
            } else {
                echo array("status" => 202, "message" => "Problem occured , please try again");
            }
        } catch (Exception $ex) {
            echo json_encode(array("status" => 202, "message" => "Problem occured , please try again"));
        }
    }

    public function userInactive(Request $request) {
        try {
            $user = Auth::user();
            $user->in_active = 0;
            $user->updated_at = $this->utcSeconds;
            $user->save();
            auth()->logout();
            return redirect('/login');
        } catch (Exception $ex) {
            return $this->throwValidationException($ex->getMessage());
        }
    }

    public function getUserProfile() {
        $data['title'] = 'User Profile';
        $user = Auth::user();
                      
        if ($user->userType == 1) {
            return redirect()->action('DentalOfficeController@getPaymentDetails');
        }
       if ($user->userType == 1 && $user->expiry_date == null) {
           return redirect()->action('UserController@userSettings');
       } 
       //commented by harpeet 
       //else {
           // $expiry_date   = date('Y/m/d', $user->expiry_date);
           //$current_expiry_date = \Carbon\Carbon::parse($expiry_date);
          // $current_expiry_date =  strtotime($current_expiry_date->adddays(3));
          // if ($current_expiry_date < $this->utcSeconds) {
                   //return redirect()->action('UserController@getPaymentDetails');
             //  return redirect()->action('UserController@getUserProfile');
          // }
      // }
       
        $sofaware_skills = DB::table('skills')->where('skill_type', '=', 1)->orderBy('skill', 'ASC')->get();
        $radiology_skills = DB::table('skills')->where('skill_type', '=', 2)->orderBy('skill', 'ASC')->get();
         $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();
        $credentials = DB::table('credentials')->orderBy('name', 'ASC')->get();
        $languages = DB::table('languages')->orderBy('name', 'ASC')->get();
        $certifications = DB::table('certifications')->orderBy('name', 'ASC')->get();
        $states = DB::table('states')->orderBy('name', 'ASC')->get();
        $user_skills_software = DB::table('user_skills')
                        ->select('user_skills.skill_id', 'skills.skill')
                        ->leftJoin('skills', 'skills.id', '=', 'user_skills.skill_id')
                        ->where([
                                ['skill_type_id', '=', '1'],
                                ['user_id', '=', $user->id],
                        ])->get();
        $user_skills_radiology = DB::table('user_skills')
                        ->select('user_skills.skill_id', 'skills.skill')
                        ->leftJoin('skills', 'skills.id', '=', 'user_skills.skill_id')
                        ->where([
                                ['skill_type_id', '=', '2'],
                                ['user_id', '=', $user->id],
                        ])->get();
        $user_credentials = DB::table('users')->where('id', '=', $user->id)->get();
        $user_languages = DB::table('users')->where('id', '=', $user->id)->get();
        $user_certifications = DB::table('user_certifications')->where('user_id', '=', $user->id)->orderBy('id', 'ASC')->get();
        $s_skillIDS = array();
        $s_skillNames = array();

        foreach ($user_skills_software as $user_sofware) {
            $s_skillIDS[] = $user_sofware->skill_id;
            $s_skillNames[] = $user_sofware->skill;
        }
        $r_skillIDS = array();
        $r_skillNames = array();

        foreach ($user_skills_radiology as $user_radiology) {
            $r_skillIDS[] = $user_radiology->skill_id;
            $r_skillNames[] = $user_radiology->skill;
        }
         $c_credentialname = array();
        foreach ($user_credentials as $user_credential) {
             $c_credentialname[] = $user_credential->credential;
          }
          $c_languagename = array();
        foreach ($user_languages as $user_language) {
             $c_languagename[] = $user_language->languages;
          }
          $c_certifications = array();
        foreach ($user_certifications as $user_certificationn) {
             $c_certifications[] = $user_certificationn->certification;
          }
          //echo implode(",", $c_credentialIDS);
          //die();
        $user_skills_software = implode(', ', $s_skillNames);
        $user_skills_radiology = implode(', ', $r_skillNames);
        $user_education = DB::table('user_education')->where('user_id', '=', $user->id)->get();
        $user_exprience = DB::table('user_exprience')->where('user_id', '=', $user->id)->get();
        $certificate = DB::table('certifications')->orderBy('id', 'ASC')->get();
        $user_certifications = DB::table('user_certifications')->where('user_id', '=', $user->id)->get();
        //Job seeker available timings
        //$available_timings = DB::table('user_available_timings')->where('user_id', '=', $user->id)->get();
        $available_timings = DB::table('user_avalibility_dates')->where('user_id', '=', $user->id)->get();
        if(count($available_timings) == 0){
            $available_timings[0] = (object)array('start_time'=>'-1','end_time'=>'-1');
             $available_timings[1] = (object)array('start_time'=>'-1','end_time'=>'-1');
             $available_timings[2] = (object)array('start_time'=>'-1','end_time'=>'-1');
             $available_timings[3] = (object)array('start_time'=>'-1','end_time'=>'-1');
             $available_timings[4] = (object)array('start_time'=>'-1','end_time'=>'-1');
             $available_timings[5] = (object)array('start_time'=>'-1','end_time'=>'-1');
             $available_timings[6] = (object)array('start_time'=>'-1','end_time'=>'-1');
        }

        return view('job-seeker-profile', compact('data','messageCounter', 'user','user_certifications','states','c_certifications','certifications','certificate','c_languagename','languages', 'c_credentialname', 'sofaware_skills','credentials', 'radiology_skills', 's_skillIDS', 'user_skills_software', 'r_skillIDS', 'user_skills_radiology', 'user_education', 'user_exprience', 'user_certifications', 'available_timings'));
    }

    public function editUserProfile() {
        $data['title'] = 'Create User Profile';
        $user = Auth::user();
        $sofaware_skills = DB::table('skills')->where('skill_type', '=', 1)->orderBy('skill', 'ASC')->get();
        $radiology_skills = DB::table('skills')->where('skill_type', '=', 2)->orderBy('skill', 'ASC')->get();
        //user soft ware skils selected
        $user_skills_software = DB::table('user_skills')
                        ->select('user_skills.kill_id', 'skills.skill')
                        ->leftJoin('skills', 'skills.id', '=', 'user_skills.skill_id')
                        ->where([
                                ['skill_type_id', '=', '1'],
                                ['user_id', '=', $user->id],
                        ])->get();
        //user raiology skills
        $user_skills_radiology = DB::table('user_skills')
                        ->select('user_skills.skill_id', 'skills.skill')
                        ->leftJoin('skills', 'skills.id', '=', 'user_skills.skill_id')
                        ->where([
                                ['skill_type_id', '=', '2'],
                                ['user_id', '=', $user->id],
                        ])->get();
         $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();                    
        //User education,experience,certifications
        $user_education = DB::table('user_education')->where('user_id', '=', $user->id)->get();
        $user_exprience = DB::table('user_exprience')->where('user_id', '=', $user->id)->get();
        $user_certifications = DB::table('`user_certifications`')->where('user_id', '=', $user->id)->get();

        return view('edit-job-seeker-profile', compact('data', 'user', 'sofaware_skills', 'radiology_skills', 'user_skills_software', 'user_skills_radiology','messageCounter', 'user_education', 'user_exprience', 'user_certifications'));
    }

    public function updateUserGenaralInfo(Request $request) {
        try {
            $postdata = $request->all();
            $rules = array(
                'name' => 'required|max:255',
                'Years_of_Experience' => 'required|numeric'
            );
           $messsages = array();
            $validator = Validator::make($postdata, $rules, $messsages);
            $user = Auth::user();

            if ($validator->fails()) {
                //echo $this->throwValidationException($request, $validator);
                echo json_encode(array("status" => 201, $this->formatValidationErrors($validator)));
            } else {

                if (isset($postdata) && $postdata != null) {
                    $fileObject = $request->file('profile_picture');
                    if (isset($fileObject) && $fileObject != null) {
                        $guid = $this->MyClassInstance->GUID();
                        $file_extention = 'png'; //$request->file('image')->getClientOriginalExtension();
                        $file_name = $guid . '.' . $file_extention;
                        $file = $request->file('profile_picture')->getRealPath();

                        // Code block to reorient profile picture if needed
                        $exif = @exif_read_data($file);

                        // if there is orientation change
                        $exif_orient = isset($exif['Orientation']) ? $exif['Orientation'] : 0;
                        $rotateImage = 0;
                        $filePath = $request->file('profile_picture')->getRealPath();
                        // convert exif rotation to angles
                        if (6 == $exif_orient)
                        {
                            $rotateImage = 90;
                            $imageOrientation = 1;
                        }
                        elseif (3 == $exif_orient)
                        {
                            $rotateImage = 180;
                            $imageOrientation = 1;
                        }
                        elseif (8 == $exif_orient)
                        {
                            $rotateImage = 270;
                            $imageOrientation = 1;
                        }
                        // if the image is rotated
                        if ($rotateImage)
                        {
                            $rotateImage = -$rotateImage;
                            $info   = getimagesize($filePath);
                            $fileType = $info[2];
                            switch ($fileType)
                            {
                            case '2': //image/jpeg
                                $source = imagecreatefromjpeg($filePath);
                                $rotate = imagerotate($source, $rotateImage, 0);
                                imagejpeg($rotate,$filePath);
                                break;
                            case '3': //image/png
                                $source = imagecreatefrompng($filePath);
                                $rotate = imagerotate($source, $rotateImage, 0);
                                imagepng($rotate,$filePath);
                                break;
                            case '1':
                                $source = imagecreatefromgif($filePath);
                                $rotate = imagerotate($source, $rotateImage, 0);
                                imagegif($rotate,$filePath);
                                break;
                            default:
                                break;
                            }
                        }
                        // End of profile picture orientation code

                        $s3 = AWS::createClient('s3');
                        $file_upload = $s3->putObject(array(
                            'Key' => Config('constants.s3_bucket_subfolder') . '/' . $file_name,
                            'Bucket' => Config('constants.s3_bucket'),
                            'SourceFile' => $file
                        ));
                        if (isset($file_upload) && $file_upload['@metadata']['statusCode'] == 200) {
                            //Now create thumbnail from image and upload to s3 bucket.
                            //get image file url
                            $s3file = Config('constants.s3_url') . $file_name;
                            //Create the thumbnail using main file url.
                            $originalimage = $this->MyClassInstance->imagecreatefromfile($s3file, $file_extention);
                            $tmpfile = $this->MyClassInstance->createThumbnail($s3file, $file_extention, $originalimage);
                            $thumbnail_name = $this->MyClassInstance->GUID() . '.' . $file_extention;
                            //upload thumbnail file to s3 bucket
                            $thumbnail_upload = $s3->putObject(array(
                                'Key' => Config('constants.s3_bucket_subfolder') . '/' . $thumbnail_name,
                                'Bucket' => Config('constants.s3_bucket'),
                                'SourceFile' => $tmpfile
                            ));

                            if ($file_upload['@metadata']['statusCode'] == 200 && $thumbnail_upload['@metadata']['statusCode'] == 200) {
                                //update user table with profile pic and thumbnail.
                                User::where(['id' => $user->id])->update(['profile_image' => $file_name, 'profile_image_thumb' => $thumbnail_name]);
                            } else {
                                echo json_encode(array('status' => 400, 'message' => 'File upload failed'));
                            }
                        } else {
                            echo json_encode(array('status' => 400, 'message' => 'File upload failed'));
                        }
                    }
                    //update user genral info
                    if($request->credential==''){
                        $select_value='';
                    }else{
                    $select_value=implode(", ", $request->credential);
                    }
                    User::where(['id' => $user->id])->update(['title' => $request->title,
                        'name' => $request->name,
                        'experience' => $request->Years_of_Experience,
                        'expected_pay' => $request->expected_pay,
                        'state_license' => $request->state_license,
                        'credential'=> $select_value
                        
                        
                    ]);
       
                    echo json_encode(array('status' => 200, 'message' => 'Success'));
                } else {
                    echo json_encode(array('status' => 400, 'message' => 'Invalid data presents'));
                }
            }
        } catch (\Exception $e) {
            echo json_encode(array('status' => 401, 'message' => $e->getMessage()));
        }
    }

    public function updateUserAdditionalInformation(Request $request) {
        try {
            $postdata = $request->all();

            $rules = array(
                'email' => 'required|email|max:255',
                'mobile_number' => 'required|regex:/^(?=.*[0-9])[- +()0-9]+$/|Min:9', //regex:/^(?=.*[0-9])[- +()0-9]+$/',
                'additional_number' => 'regex:/^(?=.*[0-9])[- +()0-9]+$/|Min:9',
                'street' => 'required',
                'city' => 'required|string',
                'state' => 'required|string',
                'zip_code' => 'required|numeric',
                'travel_distance' => 'required',
                //'certificationyear' => 'required'
            );
            $messsages = array('mobile_number' => 'Phone numbner is required', 'aditional_number' => 'Additional not valid');
            $validator = Validator::make($postdata, $rules, $messsages);
            $user = Auth::user();
            if ($validator->fails()) {

                echo json_encode(array("status" => 201, $this->formatValidationErrors($validator)));
            } else {
                if (isset($postdata) && $postdata != null) {
                    $lat_long = $this->MyClassInstance->get_lat_long($request->street . ' ' . $request->city . ' ' . $request->state . ' ' . $request->zip_code);
                    //update user additional info
                    if($request->languages == ''){
                        $select_values= 'English';
                    }
                    else{
                    $select_values=implode(", ", $request->languages);
                    }
                    User::where(['id' => $user->id])->update([
                        'contact_email' => $request->email,
                        'mobile_number' => $request->mobile_number,
                        'aditional_number' => $request->additional_number,
                        'street' => $request->street,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zipcode' => $request->zip_code,
                        'user_note' => $request->user_note,
                        'travel_distance' => $request->travel_distance,
                        'malpractice_insurance' => $request->malpractice_insurance,
                        'latitude' => $lat_long['lat'],
                        'longitude' => $lat_long['lng'],
                        'languages' => $select_values
                    ]);
                    //insert software skills
                    if (count($request->software_skills) > 0) {
                        DB::table('user_skills')->where([['user_id', '=', $user->id], ['skill_type_id', '=', 1]])->delete();
                        foreach ($request->software_skills as $software_skill) {

                            $skill_insert = DB::table('user_skills')->insert(
                                    ['user_id' => $user->id, 'skill_id' => $software_skill, 'skill_type_id' => 1, 'created_at' => $this->utcSeconds, 'updated_at' => $this->utcSeconds]
                            );
                        }
                    }
                    //insert raiology skills
                    if (count($request->radiology_skills) > 0) {
                        DB::table('user_skills')->where([['user_id', '=', $user->id], ['skill_type_id', '=', 2]])->delete();
                        foreach ($request->radiology_skills as $radiology_skill) {

                            $skill_insert = DB::table('user_skills')->insert(
                                    ['user_id' => $user->id, 'skill_id' => $radiology_skill, 'skill_type_id' => 2, 'created_at' => $this->utcSeconds, 'updated_at' => $this->utcSeconds]
                            );
                        }
                    }
              
                   
                    //Insert or update user eduction
                    if (!empty($request->education)) {
                        $user_edcution = DB::table('user_education')->where('user_id', '=', $user->id)->delete();
                        $i=0;
                        foreach($request->education as $education){
                             if (!empty($education)) {
                            DB::table('user_education')->insert(['user_id' => $user->id, 'qualification' => $education,'year'=>$request->educationyear[$i], 'created_at' => $this->utcSeconds]);
                             $i++;
                             }
                        }
                    }
                    if (empty($request->education)) {
                        DB::table('user_education')->where('user_id', '=', $user->id)->delete();
                    }
                       
                    //Insert or update user experince details
                    if (!empty($request->user_exprience)) {
                        $user_edcution = DB::table('user_exprience')->where('user_id', '=', $user->id)->get();
                        if ($user_edcution) {
                            DB::table('user_exprience')->where('user_id', '=', $user->id)->update(['position' => $request->user_exprience]);
                        } else {
                            DB::table('user_exprience')->insert(['user_id' => $user->id, 'position' => $request->user_exprience, 'created_at' => $this->utcSeconds]);
                        }
                    }
                    
                    //Insert or update user experince details
                    //if (!empty($request->certifications)) {
                       
                    //$abs = $request->certifications;
                    //$xyz = $request->certificationyear;
                      //  $cert = implode(',', $abs);
                      //  $year = implode(',', $xyz);
                       //  $result = DB::select('select user_id from user_certifications where user_id=654');
                     // $countt = count($result);
        //if($countt==1){
       /// DB::table('user_certifications')
      //  ->where('user_id', $user->id)  // optional - to ensure only one record is updated.
       // ->update(array('user_id' => $user->id, 'certification' => $cert,'year'=>$year, 'created_at' => $this->utcSeconds));
       // }
       // else {
       //     DB::table('user_certifications')->insert(['user_id' => $user->id, 'certification' => $cert,'year'=>$year, 'created_at' => $this->utcSeconds]);
      //  }
      //  }
                    //Insert or update user experince details
                    if (!empty($request->certifications)) {
                        $user_edcution = DB::table('user_certifications')->where('user_id', '=', $user->id)->delete();
                        $i=0;
                        foreach($request->certifications as $certifications){
                           if (!empty($certifications) && ($certifications != 'None')) {
                              DB::table('user_certifications')->insert(['user_id' => $user->id, 'certification' => $certifications,'year'=>$request->certificationyear[$i], 'created_at' => $this->utcSeconds]);
                           }
                           $i++;
                        }
                     }
                    if (empty($request->certifications)) {
                        $user_edcution = DB::table('user_certifications')->where('user_id', '=', $user->id)->delete();
                    }
                       
                        
                     
                        
                        
                    

                    echo json_encode(array('status' => 200, 'message' => 'Success'));
                } else {
                    echo json_encode(array('status' => 400, 'message' => 'Invalid data presents'));
                }
            }
        } catch (\Exception $e) {
            echo json_encode(array('status' => 401, 'message' => $e->getMessage()));
        }
    }

    public function updateUserTimeAvailabilInfo(Request $request) {
        try {
            $postdata = $request->all();

            $user = Auth::user();
            if (isset($postdata) && $postdata != null) {
                //insert or update job seeker available timeings info
                $user_timings = DB::table('user_avalibility_dates')->where('user_id', '=', $user->id)->get();
                if (count($user_timings) > 0) {
                    $i = 0;
                    $start_times = $request->start_time;
                    $end_times = $request->end_time;
                    foreach ($start_times as $time) {
                        DB::table('user_avalibility_dates')->where(['avalible_date' => $i, 'user_id' => $user->id])->update([
                            'start_time' => $time,
                            'end_time' => $end_times[$i],
                            'updated_at' => $request->office_speciality
                        ]);

                        $i++;
                    }
                } else {
                    $i = 0;
                    $start_times = $request->start_time;
                    $end_times = $request->end_time;
                    foreach ($start_times as $time) {

                        DB::table('user_avalibility_dates')->insert(['user_id' => $user->id,
                            'avalible_date' => $i,
                            'start_time' => $time,
                            'end_time' => $end_times[$i],
                            'created_at' => $this->utcSeconds,
                            'updated_at' => $this->utcSeconds]
                        );
                        $i++;
                    }
                }
                echo json_encode(array('status' => 200, 'message' => 'Success'));
            } else {
                echo json_encode(array('status' => 400, 'message' => 'Invalid data presents'));
            }
        } catch (\Exception $e) {
            echo json_encode(array('status' => 401, 'message' => $e->getMessage()));
        }
    }

    public function jobsList(Request $request) {
        $data['title'] = 'User Profile';
        $user = Auth::user();
        if ($user->userType == 1) {
            return redirect()->action('DentalOfficeController@getUserProfile');
        }
       if ($user->userType == 1 && $user->expiry_date == null) {
           return redirect()->action('UserController@getPaymentDetails');
       } //else {
           // $expiry_date   = date('Y/m/d', $user->expiry_date);
           //$current_expiry_date = \Carbon\Carbon::parse($expiry_date);
          // $current_expiry_date =  strtotime($current_expiry_date->adddays(3));
           //if ($current_expiry_date < $this->utcSeconds) {
          //         return redirect()->action('UserController@getPaymentDetails');
          // }
      // }
		    $job_types = DB::table('job_types')->get();
      $usersss = DB::table('users')->where('id','=',$user->id)->get();
       $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();                      
        $user_types = DB::table('user_types')->where('id', '!=', '1')->get();
        if (empty($user->longitude) || empty($user->latitude)) {
            $data['status'] = 401;
            $data['message'] = 'Please update address before searching for jobs';
           return view('jobseeker-search', compact('data', 'user','usersss', 'job_types', 'user_types'));
        } else {
            $data['status'] = 200;
            $data['message'] = 'success';
        }

        $jobs = DB::table('jobs')
                ->select('jobs.*', 'office_information.user_id','office_information.name', 'office_information.email', 'office_information.website', 'office_information.street', 'office_information.city', 'office_information.state', 'office_information.zipcode', 'office_information.phone_number', 'p.image_url')
                ->leftjoin('office_information', 'jobs.office_id', '=', 'office_information.id')
                ->leftJoin(DB::raw("(SELECT * FROM office_images GROUP BY office_id) AS p"), 'p.office_id', '=', 'jobs.office_id')
                ->selectRaw('ROUND(( 3956 * acos( cos( radians(?) ) *
                               cos( radians( latitude ) )
                               * cos( radians( longitude ) - radians(?)
                               ) + sin( radians(?) ) *
                               sin( radians( latitude ) ) )
                             )) AS distance', [$user->latitude, $user->longitude, $user->latitude])
                ->where('office_information.make_private', '=', '0')->groupBy('jobs.id')
                ->orderBy('distance', 'ASC')
                ->paginate(10);


 return view('jobseeker-search', compact('data','messageCounter', 'user','usersss', 'jobs', 'job_types', 'user_types'));
    }

    public function jobsSearch(Request $request) {
        $user = Auth::user();
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        if ($user->userType == 1) {
            return redirect()->action('DentalOfficeController@getUserProfile');
        }
       if ($user->userType == 1 && $user->expiry_date == null) {
           return redirect()->action('UserController@getPaymentDetails');
       } //else {
            //$expiry_date   = date('Y/m/d', $user->expiry_date);
           //$current_expiry_date = \Carbon\Carbon::parse($expiry_date);
          // $current_expiry_date =  strtotime($current_expiry_date->adddays(3));
           //if ($current_expiry_date < $this->utcSeconds) {
                   //return redirect()->action('UserController@getPaymentDetails');
          // }
      // }
	   $job_types = DB::table('job_types')->get();
             $skills = DB::table('skills')->get();
           $usersss = DB::table('users')->where('id','=',$user->id)->get();
        $user_types = DB::table('user_types')->where('id', '!=', '1')->get();
         $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();
        if (empty($user->longitude) || empty($user->latitude)) {
            $data['status'] = 401;
            $data['message'] = 'Please update address before searching for jobs';
             return view('jobseeker-search', compact('data', 'user', 'job_types', 'user_types'));
        } else {
            $data['status'] = 200;
            $data['message'] = 'success';
        }
        $data['title'] = 'User Profile';
        //Get user types from search keyword
        $position = NULL;
        $types = NULL;
        $search_term = $request->search_term;
        $from_date = strtotime($request->from_date);
        $to_date = $request->to_date;
        $travel_distance = $request->travel_distance;
        $job_position = $request->job_position;
        $job_type = $request->job_type;

         $results = DB::table('jobs')
                ->select('jobs.*','office_information.user_id', 'office_information.name', 'office_information.email', 'office_information.website', 'office_information.street', 'office_information.city', 'office_information.state', 'office_information.zipcode', 'office_information.phone_number', 'p.image_url', 'office_skills.skill_id')
                ->orderBy('distance', 'ASC')
                ->leftjoin('office_information', 'jobs.office_id', '=', 'office_information.id')
                ->leftjoin('office_skills', 'jobs.office_id', '=', 'office_skills.office_id')
                ->leftJoin(DB::raw("(SELECT * FROM office_images GROUP BY office_id) AS p"), 'p.office_id', '=', 'jobs.office_id')
                ->selectRaw('ROUND(( 3956 * acos( cos( radians(?) ) *
                               cos( radians( latitude ) )
                               * cos( radians( longitude ) - radians(?)
                               ) + sin( radians(?) ) *
                               sin( radians( latitude ) ) )
                             )) AS distance', [$user->latitude, $user->longitude, $user->latitude])
                ->where(function ($dbquery) use ($search_term) {
                    $dbquery->when($search_term, function($query) use ($search_term) {
                        $query->orWhere('name', 'LIKE', "%" . $search_term . "%");
                   });
                })->where('office_information.make_private', '=', '0')
                ->where(function ($dbquery) use ($from_date) {
                    $dbquery->when($from_date, function($query) use ($from_date) {
                        return $query->orWhere('start_date', '>=', $from_date);
                    });
                })
                ->where(function ($dbquery) use ($to_date) {
                    $dbquery->when($to_date, function($query) use ($to_date) {
                        return $query->orWhere('end_date', '<=', $to_date);
                    });
                })
                ->where(function ($dbquery) use ($job_type) {
                    $dbquery->when($job_type, function($query) use ($job_type) {
                        return $query->where('type_id', '=', $job_type);
                    });
                })
                ->where(function ($dbquery) use ($job_position) {
                    $dbquery->when($job_position, function($query) use ($job_position) {
                        return $query->where('jobs.job_position', '=', $job_position);
                    });
                })
                ->where(function ($dbquery) use ($types) {
                    $dbquery->when($types, function($query) use ($types) {
                        return $query->whereIn('type_id', $types);
                    });
                })
                ->where(function ($dbquery) use ($position) {
                    $dbquery->when($position, function($query) use ($position) {
                        return $query->whereIn('jobs.job_position', $position);
                    });
                })
                ->when($travel_distance, function($query) use ($travel_distance) {
                    return $query->havingRaw("distance <= ?", [$travel_distance]);
                })
                ->where('is_completed', '=', 0)
                ->groupBy('jobs.id')
                ->get();

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $paginate = 10;
        $offSet = ($currentPage * $paginate) - $paginate;
        $currentPageSearchResults = array_slice($results, $offSet, $paginate, true);
        $jobs = new LengthAwarePaginator($currentPageSearchResults, count($results), 10);
        $jobs->setPath($request->path());





        return view('js-search', compact('data','messageCounter', 'user','usersss', 'jobs', 'job_types', 'user_types'));
    }

    public function getOfficeProfile($id) {
        $data['title'] = 'Dental Office Profile';
        $user = Auth::user();
        $expiry_date   = date('Y/m/d', strtotime($user->expiry_date));
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        $current_expiry_date = \Carbon\Carbon::parse($expiry_date);
        $current_expiry_date =  strtotime($current_expiry_date->adddays(3));

         if($user->expiry_date == NULL || $current_expiry_date < $this->utcSeconds){
          //return redirect()->action('UserController@getPaymentDetails');
        }
         $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();
        $officeInformation = OfficeInformation::where('id', $id)->first();
        $officeImages = OfficeImages::where('office_id', $id)->get();
        $officeDentists = OfficeDentists::where('office_id', $id)->get();
        $officeTimings = OfficeTimings::where('office_id', $id)->get();
        $sofaware_skills = DB::table('skills')->where('skill_type', '=', 1)->orderBy('skill', 'ASC')->get();
        $radiology_skills = DB::table('skills')->where('skill_type', '=', 2)->orderBy('skill', 'ASC')->get();
        $office_skills_software = DB::table('office_skills')
                        ->select('office_skills.skill_id', 'skills.skill')
                        ->leftJoin('skills', 'skills.id', '=', 'office_skills.skill_id')
                        ->where([
                                ['skill_type_id', '=', '1'],
                                ['office_id', '=', $id],
                        ])->get();
        $office_skills_radiology = DB::table('office_skills')
                        ->select('office_skills.skill_id', 'skills.skill')
                        ->leftJoin('skills', 'skills.id', '=', 'office_skills.skill_id')
                        ->where([
                                ['skill_type_id', '=', '2'],
                                ['office_id', '=', $id],
                        ])->get();
        $s_skillIDS = array();
        $s_skillNames = array();
        foreach ($office_skills_software as $skill) {
            $s_skillIDS[] = $skill->skill_id;
            $s_skillNames[] = $skill->skill;
        }
        $r_skillIDS = array();
        $r_skillNames = array();
        foreach ($office_skills_radiology as $skill) {
            $r_skillIDS[] = $skill->skill_id;
            $r_skillNames[] = $skill->skill;
        }
        $office_skills_software = implode(',', $s_skillNames);
        $office_skills_radiology = implode(',', $r_skillNames);
        //jobs list
        $jobs = Jobs::where('office_id', $id)->where('is_completed', '0')->get();
        //job types
        $job_types = DB::table('job_types')->get();
        if (count($officeImages) > 0) {
            $officeInformation->profilePic = $officeImages[0]->image_url;
        }
        $user_types = DB::table('user_types')->where('id', '!=', '1')->get();
        return view('js-dental-office-profile', compact('data', 'user', 'officeInformation', 'officeImages', 'officeDentists', 'jobs', 'sofaware_skills', 'radiology_skills', 'officeTimings', 's_skillIDS', 'r_skillIDS', 'office_skills_software','messageCounter', 'office_skills_radiology', 'job_types', 'user_types'));
    }

    public function getJobDetails($id) {
        try {
            $data['title'] = 'Job Details';
            $user = Auth::user();
            $expiry_date   = date('Y/m/d', strtotime($user->expiry_date));
            $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
            $current_expiry_date = \Carbon\Carbon::parse($expiry_date);
            $current_expiry_date =  strtotime($current_expiry_date->adddays(3));

             if($user->expiry_date == NULL || $current_expiry_date < $this->utcSeconds){
              //return redirect()->action('UserController@getPaymentDetails');
            }
            $job = Jobs::where('id', $id)->first();
            //job types
            $job_types = DB::table('job_types')->get();
            $officeInformation = OfficeInformation::where('id', $job->office_id)->first();
            $officeImages = OfficeImages::where('office_id', $officeInformation->id)->get();
            $officeDentists = OfficeDentists::where('office_id', $officeInformation->id)->get();
            $officeTimings = OfficeTimings::where('office_id', $officeInformation->id)->get();
            $sofaware_skills = DB::table('skills')->where('skill_type', '=', 1)->orderBy('skill', 'ASC')->get();
             $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();
            $radiology_skills = DB::table('skills')->where('skill_type', '=', 2)->orderBy('skill', 'ASC')->get();
            $office_skills_software = DB::table('office_skills')
                            ->select('office_skills.skill_id', 'skills.skill')
                            ->leftJoin('skills', 'skills.id', '=', 'office_skills.skill_id')
                            ->where([
                                    ['skill_type_id', '=', '1'],
                                    ['office_id', '=', $officeInformation->id],
                            ])->get();
            $office_skills_radiology = DB::table('office_skills')
                            ->select('office_skills.skill_id', 'skills.skill')
                            ->leftJoin('skills', 'skills.id', '=', 'office_skills.skill_id')
                            ->where([
                                    ['skill_type_id', '=', '2'],
                                    ['office_id', '=', $officeInformation->id],
                            ])->get();
            $s_skillIDS = array();
            $s_skillNames = array();

            foreach ($office_skills_software as $skill) {
                $s_skillIDS[] = $skill->skill_id;
                $s_skillNames[] = $skill->skill;
            }
            $r_skillIDS = array();
            $r_skillNames = array();

            foreach ($office_skills_radiology as $skill) {
                $r_skillIDS[] = $skill->skill_id;
                $r_skillNames[] = $skill->skill;
            }
            $office_skills_software = implode(',', $s_skillNames);
            $office_skills_radiology = implode(',', $r_skillNames);
            if (count($officeImages) > 0) {
                $officeInformation->profilePic = $officeImages[0]->image_url;
            }

            $user_types = DB::table('user_types')->where('id', '!=', '1')->get();
            return view('js-job-details', compact('data', 'user', 'officeInformation', 'officeImages', 'officeDentists', 'job', 'sofaware_skills', 'radiology_skills','messageCounter', 'officeTimings', 's_skillIDS', 'r_skillIDS', 'office_skills_software', 'office_skills_radiology', 'job_types', 'user_types'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function changePassword(Request $request) {
        try {
            if ($request->ajax()) {
                $data = $request->all();

                $rules = array(
                    'current_password' => 'required',
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required',
                );

                $messsages = array();
                $validator = Validator::make($data, $rules, $messsages);
                if ($validator->fails()) {
                    //echo $this->throwValidationException($request, $validator);
                    echo json_encode(array("status" => 201, $this->formatValidationErrors($validator)));
                } else {

                    $user = User::findOrFail($request->save_user);
                    if (Hash::check($request->current_password, $user->password)) {
                        $user->fill([
                            'password' => bcrypt($request->password)
                        ])->save();

                        echo json_encode(array("status" => 200, "message" => "Password updated successfully"));
                    } else {
                        echo json_encode(array("status" => 202, "message" => "Current password not matched"));
                    }
                }
            }
        } catch (Exception $ex) {
            return $this->throwValidationException($ex->getMessage());
        }
    }

    public function saveEmailNotifications(Request $request) {
        if ($request->ajax()) {
            if ($request->email_notify == 0) {
                try {
                    $user = User::findOrFail($request->save_user);
                    $user->email_notifications = 1;
                    $user->updated_at = $this->utcSeconds;
                    $user->save();
                    echo json_encode(array("status" => 200, "message" => "Notifications settings saved successfully"));
                } catch (Exception $ex) {
                    echo json_encode(array("status" => 201, "message" => "Problem occured , please try again"));
                }
            } else {
                try {
                    $user = User::findOrFail($request->save_user);
                    $user->email_notifications = 0;
                    $user->updated_at = $this->utcSeconds;
                    $user->save();
                    echo json_encode(array("status" => 200, "message" => "Notifications settings saved successfully"));
                } catch (Exception $ex) {
                    echo json_encode(array("status" => 201, "message" => "Problem occured , please try again"));
                }
            }
        } else {
            echo array("status" => 201, "message" => "Problem occured , please try again");
        }
    }

    public function makePrivateProfile(Request $request) {
        try {
            if ($request->ajax()) {
                $data = $request->all();
                $user = Auth::user();
                $user = User::findOrFail($request->save_user);
                if ($data['make_praviate'] == 0) {
                    $user = User::findOrFail($request->save_user);
                    $user->make_private = 0;
                    $user->updated_at = $this->utcSeconds;
                    $user->save();
                    DB::update('update office_information set make_private = ? where user_id = ?',[0,$user->id]);
                    DB::update('update users set make_private = ? where id = ?',[0,$user->id]);
                    echo json_encode(array("status" => 200, "message" => "Your profile settings updated successfully"));
                } else {
                    $user = User::findOrFail($request->save_user);
                    $user->make_private = 1;
                    $user->updated_at = $this->utcSeconds;
                    $user->save();
                    DB::update('update office_information set make_private = ? where user_id = ?',[1,$user->id]);
                    DB::update('update users set make_private = ? where id = ?',[1,$user->id]);
                    echo json_encode(array("status" => 200, "message" => "Your profile settings updated successfully"));
                }
            } else {
                echo json_encode(array("status" => 201, "message" => "Problem occured , please try again"));
            }
        } catch (Exception $ex) {
            echo array("status" => 201, "message" => $ex->getMessage());
        }
    }
    
    

  public function getPaymentDetails(){
    $data['title'] = "Payment Process";
    $user = Auth::user();

      return view('payment-details', compact('data','user'));
  }
  public function cancelSubscription(){
    $data['title'] = "Payment Process";
    $user = Auth::user();
    $stripe = Stripe::make(env('STRIPE_SECRET'));
    $customer =  $stripe->Customers()->find($user->stripe_customer_id);
    $subscriptions =  $customer['subscriptions'];
    //checking active subscription
    foreach($subscriptions['data'] as $subscription){
      if($subscription['status']== 'active'){

         $subscription = $stripe->subscriptions()->cancel($user->stripe_customer_id,$subscription['id']);

         if($subscription['status'] == 'canceled')
         {
            //Update user package type to 4 means subscription cancelled
            User::where(['id' => $user->id])->update([
                'package_type' => "4",
                'updated_at' => $this->utcSeconds
            ]);
           Session::put('cancelSubscription', 'Subscription canceled sucessfully');
           return redirect()->action('UserController@userSettings');
         }
         else{
           Session::put('cancelSubscription', 'Please try again');
           return redirect()->action('UserController@userSettings');
         }


      }
    }
    Session::put('cancelSubscription', 'Please try again');
    //return redirect()->action('UserController@userSettings');

  }

}

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

$qwerty = 0;

class DentalOfficeController extends Controller {

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
        /* $data['title'] = 'home';
          return view('home', compact('data', 'user')); */
    }

    public function getUserProfile() {
        $data['title'] = 'Dental Office Profile';
        $user = Auth::user();
        $expiry_date = date('Y/m/d', $user->expiry_date);
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        $current_expiry_date = \Carbon\Carbon::parse($expiry_date);
        $current_expiry_date = strtotime($current_expiry_date->adddays(3));

        if ($user->expiry_date == null) {
            return redirect()->action('UserController@getPaymentDetails');
        } else {
            $expiry_date = date('Y/m/d', $user->expiry_date);
            $current_expiry_date = \Carbon\Carbon::parse($expiry_date);
            $current_expiry_date = strtotime($current_expiry_date->adddays(3));
            if ($user->userType == 1 && $current_expiry_date < $this->utcSeconds) {
                return redirect()->action('UserController@getPaymentDetails');
            }
        }


        $officeImages = OfficeImages::where('office_id', $officeInformation->id)->get();
        if (count($officeImages) > 0) {
            $user->profile_image_thumb = $officeImages[0]->image_url;
        } else {
            $user->profile_image_thumb = NULL;
        }
        $officeDentists = OfficeDentists::where('office_id', $officeInformation->id)->get();
        $officeTimings = OfficeTimings::where('office_id', $officeInformation->id)->get();

        $sofaware_skills = DB::table('skills')->where('skill_type', '=', 1)->orderBy('skill', 'ASC')->get();
        $radiology_skills = DB::table('skills')->where('skill_type', '=', 2)->orderBy('skill', 'ASC')->get();
        $states = DB::table('states')->orderBy('name', 'ASC')->get();
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
        $office_skills_software = implode(', ', $s_skillNames);
        $office_skills_radiology = implode(', ', $r_skillNames);

        //jobs list
        $jobs = Jobs::where('office_id', $officeInformation->id)->get();
        //job types
        $job_types = DB::table('job_types')->get();
        //Job seeker type
        $user_types = DB::table('user_types')->where('id', '!=', '1')->get();
        $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();
        return view('dental-office-profile', compact('data','messageCounter', 'user', 'officeInformation','states', 'officeImages', 'officeDentists', 'jobs', 'sofaware_skills', 'radiology_skills', 'officeTimings', 's_skillIDS', 'r_skillIDS', 'office_skills_software', 'office_skills_radiology', 'job_types', 'user_types'));
    }

    public function updateOfficeInfo(Request $request) {
        try {
            $postdata = $request->all();

            $rules = array(
                'name' => 'required|max:255',
                'website' => 'required|max:255',
                'office_speciality' => 'required',
            );
            $messsages = array();
            $validator = Validator::make($postdata, $rules, $messsages);
            $user = Auth::user();

            if ($validator->fails()) {
                //echo $this->throwValidationException($request, $validator);
                echo json_encode(array("status" => 201, $this->formatValidationErrors($validator)));
            } else {

                if ($postdata != null) {

                    $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
                    $office_id = $officeInformation->id;

                    //Save uploaded images
                    if (count($request->uploaded) > 0) {
                        $OfficeImages = OfficeImages::where('office_id', $office_id)->get();
                        if (count($OfficeImages) > 0) {
                            $deletedRows = OfficeImages::where('office_id', $office_id)->delete();
                        }
                        foreach ($request->uploaded as $imageName) {
                            $thumbname = substr_replace($imageName, '-thumb', -4, 0);
                            $officeImage = new OfficeImages();
                            $officeImage->office_id = $office_id;
                            $officeImage->image_url = $imageName;
                            $officeImage->thumb_url = $thumbname;
                            $officeImage->create_at = $this->utcSeconds;
                            $officeImage->save();
                        }
                    }

                    //update user genral info
                    OfficeInformation::where(['id' => $office_id])->update([
                        'name' => $request->name,
                        'website' => $request->website,
                        'office_speciality' => $request->office_speciality
                    ]);

                    // Insert or update dentists info
                    $deletedRows = \App\OfficeDentists::where('office_id', $office_id)->delete();
                    if (count($request->dentist) > 0) {

                        foreach ($request->dentist as $dentist) {
                            $OfficeDentists = new OfficeDentists();
                            $OfficeDentists->office_id = $office_id;
                            $OfficeDentists->name = $dentist['name'];
                            $OfficeDentists->title = $dentist['title'];
                            $OfficeDentists->credential = $dentist['credential'];
                            $OfficeDentists->save();
                        }
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

    public function updateAdditionalInfo(Request $request) {
        try {
            $postdata = $request->all();
            $rules = array(
                'contact_name' => 'required',
                'job_position' => 'required',
                'email' => 'required|email',
                'Office_number' => 'required|regex:/^(?=.*[0-9])[- +()0-9]+$/|Min:9', //regex:/(01)[0-9]{9}/',
                'aditional_number' => 'regex:/^(?=.*[0-9])[- +()0-9]+$/|Min:9',
                'street' => 'required',
                'city' => 'required|string',
                'state' => 'required|string',
                'zipcode' => 'required|numeric',
                'Monday' => 'required',
                'Tuesday' => 'required',
                'Wednesday' => 'required',
                'Thursday' => 'required',
                'Friday' => 'required',
                'Saturday' => 'required',
                'Sunday' => 'required'
            );
            $messsages = array('Office_number' => 'Phone number is not valid', 'contact_name' => 'Name is required', 'aditional_number' => 'Aditional number is not valid');
            $validator = Validator::make($postdata, $rules, $messsages);

            if ($validator->fails()) {

                echo json_encode(array("status" => 201, $this->formatValidationErrors($validator)));
            } else {
                if ($postdata != null) {
                    //update office additional info
                    $user = Auth::user();
                    $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
                    $office_id = $officeInformation->id;
                    $lat_long = $this->MyClassInstance->get_lat_long($request->street . ' ' . $request->city . ' ' . $request->state . ' ' . $request->zip_code);
                    OfficeInformation::where(['id' => $office_id])->update([
                        'contact_person_name' => $request->contact_name,
                        'email' => $request->email,
                        'job_position' => $request->job_position,
                        'phone_number' => $request->Office_number,
                        'aditional_number' => $request->aditional_number,
                        'street' => $request->street,
                        'city' => $request->city,
                        'state' => $request->state,
                        'zipcode' => $request->zipcode,
                        'note' => $request->note,
                        'latitude' => $lat_long['lat'],
                        'longitude' => $lat_long['lng']
                    ]);

                    //insert software skills
                    if (count($request->software_skills) > 0) {
                        DB::table('office_skills')->where([['office_id', '=', $office_id], ['skill_type_id', '=', '1']])->delete();
                        foreach ($request->software_skills as $software_skill) {
                            $skill_insert = DB::table('office_skills')->insert(
                                    ['office_id' => $office_id, 'skill_id' => $software_skill, 'skill_type_id' => '1']
                            );
                        }
                    }
                    //insert raiology skills
                    if (count($request->radiology_skills) > 0) {
                        DB::table('office_skills')->where([['office_id', '=', $office_id], ['skill_type_id', '=', '2']])->delete();
                        foreach ($request->radiology_skills as $radiology_skill) {

                            $skill_insert = DB::table('office_skills')->insert(
                                    ['office_id' => $office_id, 'skill_id' => $radiology_skill, 'skill_type_id' => '2']
                            );
                        }
                    }
                    //insert or update office timings
                    $office_timings = OfficeTimings::where('office_id', '=', $office_id)->get();
                    if (count($office_timings) > 0) {
                        OfficeTimings::where('office_id', '=', $office_id)
                                ->update(['Mon' => $request->Monday,
                                    'Tue' => $request->Tuesday,
                                    'Wed' => $request->Wednesday,
                                    'Thu' => $request->Thursday,
                                    'Fri' => $request->Friday,
                                    'Sat' => $request->Saturday,
                                    'Sun' => $request->Sunday
                                        ]
                        );
                    } else {
                        $OfficeTimings = new OfficeTimings();
                        $OfficeTimings->office_id = $office_id;
                        $OfficeTimings->Mon = $request->Monday;
                        $OfficeTimings->Tue = $request->Tuesday;
                        $OfficeTimings->Wed = $request->Wednesday;
                        $OfficeTimings->Thu = $request->Thursday;
                        $OfficeTimings->Fri = $request->Friday;
                        $OfficeTimings->Sat = $request->Saturday;
                        $OfficeTimings->Sun = $request->Sunday;
                        $OfficeTimings->save();
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

    public function createNewJob(Request $request) {
        try {
            $user = Auth::user();
            $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
            $office_id = $officeInformation->id;
            if (empty($officeInformation->longitude) || empty($officeInformation->latitude)) {
                echo json_encode(array('status' => 400, 'message' => 'Please update office address before posting new job'));
                die();
            }
            $postdata = $request->all();
            $rules = array(
                'job_type' => 'required',
                //'start_date' => 'required',
                //'end_date' => 'required',
                'job_position' => 'required'
            );
            $messsages = array('job_type' => 'Please choose type of job',
                //'start_date' => 'Start date is required',
                //'end_date' => 'End date is required',
                'job_position' => 'Please choose job position'
            );
            $validator = Validator::make($postdata, $rules, $messsages);
            if ($validator->fails()) {
                echo json_encode(array("status" => 201, $this->formatValidationErrors($validator)));
            } else {
                if ($postdata != null) {
                    //update office additional info
                    $job = new Jobs();
                    $job->office_id = $office_id;
                    $job->type_id = $request->job_type;
                    //$job->start_date = strtotime($request->start_date);
                    //$job->end_date = strtotime($request->end_date);
                    $job->job_position = $request->job_position;
                    $job->description = $request->job_description;
                    $job->create_at = $this->utcSeconds;
                    $job->updated_at = $this->utcSeconds;
                    $job->save();

                    echo json_encode(array('status' => 200, 'message' => 'Success'));
                } else {
                    echo json_encode(array('status' => 400, 'message' => 'Invalid data presents'));
                }
            }
        } catch (\Exception $e) {
            echo json_encode(array('status' => 401, 'message' => $e->getMessage()));
        }
    }

    public function jobDetails($id) {

        try {
            $data['title'] = 'Job Details';

            $user = Auth::user();

            $officeInformation = OfficeInformation::where('user_id', $user->id)->first();

            $officeImages = OfficeImages::where('office_id', $officeInformation->id)->get();

            $officeDentists = OfficeDentists::where('office_id', $officeInformation->id)->get();

            $officeTimings = OfficeTimings::where('office_id', $officeInformation->id)->get();

            $sofaware_skills = DB::table('skills')->where('skill_type', '=', 1)->orderBy('skill', 'ASC')->get();
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

            //jobs list
            $job = Jobs::where('id', $id)->first();

            //job types
            $job_types = DB::table('job_types')->get();
            $user_types = DB::table('user_types')->where('id', '!=', '1')->get();
            $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();
            return view('office-job-details', compact('data','messageCounter', 'user', 'officeInformation', 'officeImages', 'officeDentists', 'job', 'sofaware_skills', 'radiology_skills', 'officeTimings', 's_skillIDS', 'r_skillIDS', 'office_skills_software', 'office_skills_radiology', 'job_types', 'user_types'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function updateJobDetails(Request $request) {

        try {
            $postdata = $request->all();

            $rules = array(
                'job_type' => 'required',
                //'start_date' => 'required',
                //'end_date' => 'required',
                'job_Position' => 'required'
            );
            $messsages = array('job_type' => 'Please choose type of job',
                //'start_date' => 'Start date is required',
                //'end_date' => 'End date is required',
                'job_position' => 'Please choose job position'
            );
            $validator = Validator::make($postdata, $rules, $messsages);

            if ($validator->fails()) {

                echo json_encode(array("status" => 201, $this->formatValidationErrors($validator)));
            } else {
                if ($postdata != null) {
                    //update office additional info
                    $user = Auth::user();
                    $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
                    $office_id = $officeInformation->id;
                    $job = Jobs::findOrFail($request->job_id);

                    $job->type_id = $request->job_type;
                    // $job->start_date = strtotime($request->start_date);
                    //$job->end_date = strtotime($request->end_date);
                    $job->job_position = $request->job_Position;
                    $job->description = $request->job_description;
                    $job->updated_at = $this->utcSeconds;
                    $job->save();

                    echo json_encode(array('status' => 200, 'message' => 'Success'));
                } else {
                    echo json_encode(array('status' => 400, 'message' => 'Invalid data presents'));
                }
            }
        } catch (\Exception $e) {
            echo json_encode(array('status' => 401, 'message' => $e->getMessage()));
        }
    }

    public function delteJobDetails(Request $request) {
        try {
            $postdata = $request->all();

            $rules = array(
                'job_id' => 'required'
            );
            $messsages = array('job_id' => 'Invalid data'
            );
            $validator = Validator::make($postdata, $rules, $messsages);

            if ($validator->fails()) {

                echo json_encode(array("status" => 201, $this->formatValidationErrors($validator)));
            } else {
                if ($postdata != null) {
                    //update office additional info
                    $user = Auth::user();
                    $job = Jobs::find($request->job_id);
                    $job->delete();
                    echo json_encode(array('status' => 200, 'message' => 'Success'));
                } else {
                    echo json_encode(array('status' => 400, 'message' => 'Invalid data presents'));
                }
            }
        } catch (\Exception $e) {
            echo json_encode(array('status' => 401, 'message' => $e->getMessage()));
        }
    }

    public function completeJob(Request $request) {
        try {
            $postdata = $request->all();

            $rules = array(
                'job_id' => 'required'
            );
            $messsages = array('job_id' => 'Invalid data'
            );
            $validator = Validator::make($postdata, $rules, $messsages);

            if ($validator->fails()) {

                echo json_encode(array("status" => 201, $this->formatValidationErrors($validator)));
            } else {
                if ($postdata != null) {
                    //update office additional info
                    $user = Auth::user();
                    $job = Jobs::find($request->job_id);
                    $job->is_completed = 1;
                    $job->updated_at = $this->utcSeconds;
                    $job->save();
                    echo json_encode(array('status' => 200, 'message' => 'Success'));
                } else {
                    echo json_encode(array('status' => 400, 'message' => 'Invalid data presents'));
                }
            }
        } catch (\Exception $e) {
            echo json_encode(array('status' => 401, 'message' => $e->getMessage()));
        }
    }

    public function getUserProfile2() {
        $data['title'] = 'Dental Office Profile';
        $user = Auth::user();
        $expiry_date = date('Y/m/d', $user->expiry_date);
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        $current_expiry_date = \Carbon\Carbon::parse($expiry_date);
        $current_expiry_date = strtotime($current_expiry_date->adddays(3));

        if ($user->expiry_date == NULL || $current_expiry_date < $this->utcSeconds) {
            return redirect()->action('UserController@getPaymentDetails');
        }
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();

        $officeImages = OfficeImages::where('office_id', $officeInformation->id)->get();
        $user->profile_image_thumb = $officeImages[0]->image_url;
        $officeDentists = OfficeDentists::where('office_id', $officeInformation->id)->get();
        $officeTimings = OfficeTimings::where('office_id', $officeInformation->id)->get();

        $sofaware_skills = DB::table('skills')->where('skill_type', '=', 1)->orderBy('skill', 'ASC')->get();
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

        //jobs list
        $jobs = Jobs::where('office_id', $officeInformation->id)->get();
        //job types
        $job_types = DB::table('job_types')->get();
        $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();
        return view('dental-office-profile2', compact('data', 'user','messageCounter', 'officeInformation', 'officeImages', 'officeDentists', 'jobs', 'sofaware_skills', 'radiology_skills', 'officeTimings', 's_skillIDS', 'r_skillIDS', 'office_skills_software', 'office_skills_radiology', 'job_types'));
    }

    public function imageUploader(Request $request) {
        try {
            $postdata = $request->all();
            $user = Auth::user();
            $files = $request->file('images');
            $fileCount = count($files);

            if ($fileCount > 0) {
                $rules = array('images' => 'image|mimes:jpeg,jpg,png,bmp,svg | max:8000'
                );
                $messsages = array();
                $validator = Validator::make($postdata, $rules, $messsages);
                if ($validator->fails()) {

                    echo json_encode(array("status" => 201, $this->formatValidationErrors($validator)));
                    die();
                }
            }
            $uploadCount = 0;

            if (isset($files) && $files != null) {
                $guid = $this->MyClassInstance->GUID();
                $file_extention = 'png'; //$request->file('image')->getClientOriginalExtension();
                $file_name = $guid . '.' . $file_extention;

                $s3 = AWS::createClient('s3');
                $file_upload = $s3->putObject(array(
                    'Key' => Config('constants.s3_bucket_subfolder') . '/' . $file_name,
                    'Bucket' => Config('constants.s3_bucket'),
                    'SourceFile' => $files
                ));
                if (isset($file_upload) && $file_upload['@metadata']['statusCode'] == 200) {
                    //get image file url
                    //get image file url
                    $s3file = Config('constants.s3_url') . $file_name;
                    //Create the thumbnail using main file url.
                    $originalimage = $this->MyClassInstance->imagecreatefromfile($s3file, $file_extention);
                    $tmpfile = $this->MyClassInstance->createThumbnail($s3file, $file_extention, $originalimage);
                    $thumbnail_name = $guid . '-thumb.' . $file_extention;
                    //upload thumbnail file to s3 bucket
                    $thumbnail_upload = $s3->putObject(array(
                        'Key' => Config('constants.s3_bucket_subfolder') . '/' . $thumbnail_name,
                        'Bucket' => Config('constants.s3_bucket'),
                        'SourceFile' => $tmpfile
                    ));

                    if ($file_upload['@metadata']['statusCode'] == 200 && $thumbnail_upload['@metadata']['statusCode'] == 200) {
                        echo json_encode(array('status' => 200, 'url' => Config('constants.s3_url') . $file_name, 'name' => $file_name, 'thumburl' => Config('constants.s3_url') . $thumbnail_name));
                    }
                } else {
                    //echo $this->throwValidationException($request, $validator);
                    echo json_encode(array('status' => 401, 'message' => 'failed'));
                    die();
                }
            }
        } catch (\Exception $e) {
            echo json_encode(array('status' => 401, 'message' => $e->getMessage()));
        }
    }

    public function imageDelete(Request $request) {
        try {
            $postdata = $request->all();
            $user = Auth::user();

            $s3 = AWS::createClient('s3');

            $result = $s3->deleteObject(array(
                'Bucket' => Config('constants.s3_bucket'),
                'Key' => 'media/' . $request->image
            ));
            $thumbName = current(explode(".", $request->image));
            $result2 = $s3->deleteObject(array(
                'Bucket' => Config('constants.s3_bucket'),
                'Key' => 'media/' . $thumbName . '-thumb.png'
            ));
            if (isset($result)) {
                //get image file url

                echo json_encode(array('status' => 200, "message" => $result));
            } else {
                //echo $this->throwValidationException($request, $validator);
                echo json_encode(array('status' => 401, 'message' => 'failed'));
                die();
            }
        } catch (\Exception $e) {
            echo json_encode(array('status' => 401, 'message' => $e->getMessage()));
        }
    }

    public function getJsList(Request $request) {
        $data['title'] = 'User Profile';
        $user = Auth::user();
        $expiry_date = date('Y/m/d', $user->expiry_date);
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        $current_expiry_date = \Carbon\Carbon::parse($expiry_date);
        $current_expiry_date = strtotime($current_expiry_date->adddays(3));

        if ($user->expiry_date == NULL || $current_expiry_date < $this->utcSeconds) {
            return redirect()->action('UserController@getPaymentDetails');
        }
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();

        $officeImages = OfficeImages::where('office_id', $officeInformation->id)->get();
        if (count($officeImages) > 0) {
            $user->profile_image_thumb = $officeImages[0]->image_url;
        } else {
            $user->profile_image_thumb = NULL;
        }
        //distance calculation - dental office user with job seekers
        $haveaddress = DB::table('users')->where('id', '=', $user->id)->get();
        $usersss = DB::table('office_information')->where('user_id', '=', $user->id)->get();
        $credentials = DB::table('credentials')->orderBy('name', 'ASC')->get();
        $languages = DB::table('languages')->orderBy('name', 'ASC')->get();
        $certifications = DB::table('certifications')->orderBy('name', 'ASC')->get();
        $jobseekers = DB::table('users')
                ->select('users.*')
                ->where('latitude', '!=', '')
                ->where('userType', '!=', '1')
                ->where('in_active', '=', '1')
                ->where('make_private', '=', '0')
                // Calculate distance between jobseeker and office, and only return those who would
                //   not have to travel further than their configured travel distance
                ->whereRaw('travel_distance >= ROUND(( 3956 * acos( cos( radians(?) )
                   * cos( radians( latitude ) )
                   * cos( radians( longitude ) - radians(?))
                   + sin( radians(?) )
                   * sin( radians( latitude ) ) )))', [$usersss[0]->latitude, $usersss[0]->longitude, $usersss[0]->latitude])
                ->orderBy('profile_image_thumb', 'DESC')
                ->paginate(10);
//User availabilty showing on jobseekers profile listing.
        if(count($jobseekers) == 0)
                {
                    $jobseeker_id[] = ' ';
                }
        foreach ($jobseekers as $var) {
            $jobseeker_id[] = $var->id;
        }
        $implode_id = implode(' ', $jobseeker_id);
        $explode_id = explode(' ', $implode_id);
        $idInArray = array();
        foreach ($explode_id as $idInLoop) {
          
   $user_avalibility_dates = DB::table('user_avalibility_dates')
                            ->where('user_id', '=', $idInLoop)->get();
 $user_avalibility_dates1 = array();
            foreach ($user_avalibility_dates as $print) {
                $user_avalibility_dates1[] = $print->start_time;
            }
            $idInArray[] = implode("=", $user_avalibility_dates1);
        }
        $user_avalibility_dates2 = implode(",", $idInArray);
        $user_avalibility_dates3 = explode(",", $user_avalibility_dates2);
        //show number of users per page(pagination counter)
        $incremetedId = count($jobseekers);
        if ($incremetedId == '1') {
            $i0 = $user_avalibility_dates3[0];
        }
        if ($incremetedId == '2') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
        }
        if ($incremetedId == '3') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
        }
        if ($incremetedId == '4') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
        }
        if ($incremetedId == '5') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
        }
        if ($incremetedId == '6') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
        }
        if ($incremetedId == '7') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
        }
        if ($incremetedId == '8') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
            $i7 = $user_avalibility_dates3[7];
        }
        if ($incremetedId == '9') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
            $i7 = $user_avalibility_dates3[7];
            $i8 = $user_avalibility_dates3[8];
        }
        if ($incremetedId == '10') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
            $i7 = $user_avalibility_dates3[7];
            $i8 = $user_avalibility_dates3[8];
            $i9 = $user_avalibility_dates3[9];
        }
        //->where('city','like','%'.$request->location.'%')
        $sofaware_skillss = DB::table('skills')->where('skill_type', '=', 1)->orderBy('skill', 'ASC')->get();
        $radiology_skills = DB::table('skills')->where('skill_type', '=', 2)->orderBy('skill', 'ASC')->get();
        $available = '';
        $available_jobseekers = '';
        $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();
        return view('do-js-search', compact('data', 'messageCounter', 'i0', 'i1', 'i2', 'i3', 'i4', 'i5', 'i6', 'i7', 'i8', 'i9', 'user', 'haveaddress', 'credentials', 'available_jobseekers', 'languages', 'available', 'certifications', 'usersss', 'sofaware_skillss', 'radiology_skills', 'jobseekers', 'officeInformation', 'officeImages'));
    }

    public function getJsList2(Request $request) {


        $data['title'] = 'User Profile';
        $user = Auth::user();

        $expiry_date = date('Y/m/d', $user->expiry_date);
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        $current_expiry_date = \Carbon\Carbon::parse($expiry_date);
        $current_expiry_date = strtotime($current_expiry_date->adddays(3));

        if ($user->expiry_date == NULL || $current_expiry_date < $this->utcSeconds) {
            return redirect()->action('UserController@getPaymentDetails');
        }
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        $officeImages = OfficeImages::where('office_id', $officeInformation->id)->get();
        if (count($officeImages) > 0) {
            $user->profile_image_thumb = $officeImages[0]->image_url;
        } else {
            $user->profile_image_thumb = NULL;
        }
        $searchterm = $request->search_term;
        $location = $request->location;
        $userType = $request->userType;
        $travel_distance = $request->travel_distance;
        if (!$request->software) {
            $software = array();
        } else {
            $var = $request->software;
            $qwerty = implode(",", $var);
            $software = explode(",", $qwerty);
        }
        if (!$request->radiology) {
            $radiology = array();
        } else {
            $var = $request->radiology;
            $qwerty = implode(",", $var);
            $radiology = explode(",", $qwerty);
        }
        if (!$request->certification) {
            $certification = array();
        } else {
            $var = $request->certification;
            $qwerty = implode(",", $var);
            $certification = explode(",", $qwerty);
        }
        if (!$request->credential) {
            $credential = array();
        } else {
            $credential = $request->credential;
        }

        if (!$request->language) {
            $language = array();
        } else {
            $language = $request->language;
        }

        $user_type = NULL;
        if ($searchterm != NULL || !empty($searchterm)) {
            $user_types = DB::table('user_types')->select(array('id'))->where('user_type', 'like', '%' . $request->search_term . '%')->get();
            $data = collect($user_types)->map(function($x) {
                        return (array) $x;
                    })->toArray();
            if (count($data) > 0) {
                $user_type = $data[0]['id'];
            }
        }

        $days = array(0, 1, 2, 3, 4, 5, 6);
        $requsetDates = NULL;
        if (!empty($request->from_date) && !empty($request->to_date)) {
            $start = strtotime($request->from_date);
            $end = strtotime($request->to_date);
            $day = (24 * 60 * 60);
            for ($i = $start; $i <= $end; $i += 86400) {
                $requsetDates[] = date('N', $i) - 1;
            }
        }
        $experiencee = $request->experience;
        if ($experiencee == '1,2,3,4,5') {
            $experience = array(1, 2, 3, 4, 5);
        } elseif ($experiencee == '6,7,8,9,10') {
            $experience = array(6, 7, 8, 9, 10);
        } elseif ($experiencee == '11,12,13,14,15') {
            $experience = array(11, 12, 13, 14, 15);
        } elseif ($experiencee == '16,17,18,19,20') {
            $experience = array(16, 17, 18, 19, 20);
        } elseif ($experiencee == '21,22,23,24,25') {
            $experience = array(21, 22, 23, 24, 25);
        } elseif ($experiencee == '26,27,28,29,30') {
            $experience = array(26, 27, 28, 29, 30);
        } elseif ($experiencee == '31,32,33,34,35') {
            $experience = array(31, 32, 33, 34, 35);
        } elseif ($experiencee == '36,37,38,39,40') {
            $experience = array(36, 37, 38, 39, 40);
        } elseif ($experiencee == '41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,') {
            $experience = array(41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60, 61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100,);
        } else {
            $experience = array();
        }

        $expected_pay = $request->expected_pay;
        if ($expected_pay == '1,2,3,4,5') {
            $expected_pay = array(1, 2, 3, 4, 5);
        } elseif ($expected_pay == '6,7,8,9,10') {
            $expected_pay = array(6, 7, 8, 9, 10);
        } elseif ($expected_pay == '11,12,13,14,15') {
            $expected_pay = array(11, 12, 13, 14, 15);
        } elseif ($expected_pay == '16,17,18,19,20') {
            $expected_pay = array(16, 17, 18, 19, 20);
        } elseif ($expected_pay == '21,22,23,24,25') {
            $expected_pay = array(21, 22, 23, 24, 25);
        } elseif ($expected_pay == '26,27,28,29,30') {
            $expected_pay = array(26, 27, 28, 29, 30);
        } elseif ($expected_pay == '31,32,33,34,35') {
            $expected_pay = array(31, 32, 33, 34, 35);
        } elseif ($expected_pay == '36,37,38,39,40') {
            $expected_pay = array(36, 37, 38, 39, 40);
        } elseif ($expected_pay == '41,42,43,44,45') {
            $expected_pay = array(41, 42, 43, 44, 45);
        } elseif ($expected_pay == '46,47,48,49,50') {
            $expected_pay = array(46, 47, 48, 49, 50);
        } elseif ($expected_pay == '51,52,53,54,55') {
            $expected_pay = array(51, 52, 53, 54, 55);
        } elseif ($expected_pay == '56,57,58,59,60') {
            $expected_pay = array(56, 57, 58, 59, 60);
        } elseif ($expected_pay == '61,62,63,64,65') {
            $expected_pay = array(61, 62, 63, 64, 65);
        } elseif ($expected_pay == '66,67,68,69,70') {
            $expected_pay = array(66, 67, 68, 69, 70);
        } elseif ($expected_pay == '71,72,73,74,75,76,77,78,79,80,81,82,83,84,85,86,87,88,89,90,91,92,93,94,95,96,97,98,99,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115,116,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134,135,136,137,138,139,140,141,142,143,144,145,146,147,148,149,150,') {
            $expected_pay = array(71, 72, 73, 74, 75, 76, 77, 78, 79, 80, 81, 82, 83, 84, 85, 86, 87, 88, 89, 90, 91, 92, 93, 94, 95, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 111, 112, 113, 114, 115, 116, 117, 118, 119, 120, 121, 122, 123, 124, 125, 126, 127, 128, 129, 130, 131, 132, 133, 134, 135, 136, 137, 138, 139, 140, 141, 142, 143, 144, 145, 146, 147, 148, 149, 150,);
        } else {
            $expected_pay = array();
        }
        //distance calculation - dental office user with job seekers
        $usersss = DB::table('office_information')->where('user_id', '=', $user->id)->get();
        $credentials = DB::table('credentials')->orderBy('name', 'ASC')->get();
        $languages = DB::table('languages')->orderBy('name', 'ASC')->get();
        $certifications = DB::table('certifications')->orderBy('name', 'ASC')->get();

        $jobseekers = User::select('users.*')
                ->leftjoin('user_avalibility_dates', 'users.id', '=', 'user_avalibility_dates.user_id')
                // Calculate distance between jobseeker and office, and only return those who would
                //   not have to travel further than their configured travel distance
                ->whereRaw('travel_distance >= ROUND(( 3956 * acos( cos( radians(?) )
                            * cos( radians( latitude ) )
                            * cos( radians( longitude ) - radians(?))
                            + sin( radians(?) )
                            * sin( radians( latitude ) ) )))', [$usersss[0]->latitude, $usersss[0]->longitude, $usersss[0]->latitude])
                ->where(function ($dbquery) use ($searchterm, $user_type) {
                    $dbquery->when($searchterm, function($query) use ($searchterm) {
                        return $query->orWhere('name', 'LIKE', "%" . $searchterm . "%");
                    });
                    //commented by Harpreet
                    //->when($searchterm, function($query) use ($searchterm) {
                    //    return $query->orWhere('email', 'LIKE', "%" . $searchterm . "%");
                    //})->when($searchterm, function($query) use ($searchterm) {
                    //    return $query->orWhere('state_license', 'LIKE', "%" . $searchterm . "%");
                    //})->when($searchterm, function($query) use ($searchterm) {
                    //    return $query->orWhere('state', 'LIKE', "%" . $searchterm . "%");
                    //})->when($searchterm, function($query) use ($searchterm) {
                    //    return $query->orWhere('zipcode', 'LIKE', "%" . $searchterm . "%");
                    //})->when($searchterm, function($query) use ($searchterm) {
                    //    return $query->orWhere('city', 'LIKE', "%" . $searchterm . "%");
                    //})->when($user_type, function($query) use ($user_type) {
                    //    return $query->orWhere('userType','=',$user_type);
                    //});
                })
                ->where(function ($dbquery) use ($location) {
                    $dbquery->when($location, function($query) use ($location) {
                        return $query->orWhere('city', 'LIKE', "%" . $location . "%");
                    })->when($location, function($query) use ($location) {
                        return $query->orWhere('state', 'LIKE', "%" . $location . "%");
                    })->when($location, function($query) use ($location) {
                        return $query->orWhere('zipcode', 'LIKE', "%" . $location . "%");
                    })->when($location, function($query) use ($location) {
                        return $query->orWhere('street', 'LIKE', "%" . $location . "%");
                    });
                })
                ->where(function ($dbquery) use ($userType) {
                    $dbquery->when($userType, function($query) use ($userType) {
                        return $query->orWhere('userType', 'LIKE', "%" . $userType . "%");
                    });
                })
                ->where(function ($dbquery) use ($credential) {
                    $dbquery->when($credential, function($query) use ($credential) {
                        foreach ($credential as $cred) {
                            $credResults[] = $query->orWhere('credential', 'LIKE', "%" . $cred . "%");
                        }
			            return $credResults;
                    });
                })
                ->where(function ($dbquery) use ($expected_pay) {
                    $dbquery->when($expected_pay, function($query) use ($expected_pay) {
                        return $query->whereIn('expected_pay', $expected_pay);
                    });
                })
                ->where(function ($dbquery) use ($experience) {
                    $dbquery->when($experience, function($query) use ($experience) {
                        return $query->whereIn('experience', $experience);
                    });
                })
                ->where(function ($dbquery) use ($travel_distance) {
                    $dbquery->when($travel_distance, function($query) use ($travel_distance) {
                        return $query->where('travel_distance', '<=', $travel_distance);
                    });
                })
                ->where(function ($dbquery) use ($language) {
                    $dbquery->when($language, function($query) use ($language) {
                        foreach ($language as $lang) {
                            $langResults[] = $query->orWhere('languages', 'LIKE', "%" . $lang . "%");
                        }
                        return $langResults;
                     });
                })
                ->leftjoin('user_skills', 'users.id', '=', 'user_skills.user_id')
                ->where(function ($dbquery) use ($software) {
                    $dbquery->when($software, function($query) use ($software) {
                        return $query->whereIn('skill_id', $software);
                    });
                })
                ->where(function ($dbquery) use ($radiology) {
                    $dbquery->when($radiology, function($query) use ($radiology) {
                        return $query->whereIn('skill_id', $radiology);
                    });
                })
                ->leftjoin('user_certifications', 'users.id', '=', 'user_certifications.user_id')
                ->Where(function ($dbquery) use ($certification) {
                    $dbquery->when($certification, function($query) use ($certification) {
                        return $query->whereIn('certification', $certification);
                    });
                })
                ->when($requsetDates, function($query) use ($requsetDates) {
                    return $query->whereIn('user_avalibility_dates.avalible_date', $requsetDates)
                            ->where('user_avalibility_dates.start_time', '!=', '-1');
                })
                ->where('userType', '!=', '1')
                ->where('in_active', '=', '1')
                ->where('make_private', '=', '0')
                ->where('latitude', '!=', '')
                ->where('longitude', '!=', '')
                ->orderBy('profile_image_thumb', 'DESC')
                ->groupBy('users.id')
                ->paginate(10);
        //->toSql();
        // echo $jobseekers;
        //exit;
        //User availabilty showing on jobseekers profile listing.
               //check if no result found for name search
                if(count($jobseekers) == 0)
                {
                    $jobseeker_id[] = ' ';
                }
         foreach ($jobseekers as $var) {
             $jobseeker_id[] = $var->id;
        }
     $implode_id = implode(' ', $jobseeker_id);
        $explode_id = explode(' ', $implode_id);
        $idInArray = array();
        foreach ($explode_id as $idInLoop) {
            $idInLoop;

            $user_avalibility_dates = DB::table('user_avalibility_dates')
                            ->where('user_id', '=', $idInLoop)->get();


            $user_avalibility_dates1 = array();
            foreach ($user_avalibility_dates as $print) {
                $user_avalibility_dates1[] = $print->start_time;
            }
            $idInArray[] = implode("=", $user_avalibility_dates1);
        }
        $user_avalibility_dates2 = implode(",", $idInArray);
        //$explode = explode(' ', $implo);
        $user_avalibility_dates3 = explode(",", $user_avalibility_dates2);
        $incremetedId = count($jobseekers);
        if ($incremetedId == '1') {
            $i0 = $user_avalibility_dates3[0];
        }
        if ($incremetedId == '2') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
        }
        if ($incremetedId == '3') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
        }
        if ($incremetedId == '4') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
        }
        if ($incremetedId == '5') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
        }
        if ($incremetedId == '6') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
        }
        if ($incremetedId == '7') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
        }
        if ($incremetedId == '8') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
            $i7 = $user_avalibility_dates3[7];
        }
        if ($incremetedId == '9') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
            $i7 = $user_avalibility_dates3[7];
            $i8 = $user_avalibility_dates3[8];
        }
        if ($incremetedId == '10') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
            $i7 = $user_avalibility_dates3[7];
            $i8 = $user_avalibility_dates3[8];
            $i9 = $user_avalibility_dates3[9];
        }

        $sofaware_skillss = DB::table('skills')->where('skill_type', '=', 1)->orderBy('skill', 'ASC')->get();
        $radiology_skills = DB::table('skills')->where('skill_type', '=', 2)->orderBy('skill', 'ASC')->get();
        if ($request->search_term != '') {
            $available_jobseekers = '';
        } else {
            $available_jobseekers = User::select('users.*')
                    ->leftjoin('user_avalibility_dates', 'users.id', '=', 'user_avalibility_dates.user_id')
                    // Calculate distance between jobseeker and office, and only return those who would
                    //   not have to travel further than their configured travel distance
                    ->whereRaw('travel_distance >= ROUND(( 3956 * acos( cos( radians(?) )
                            * cos( radians( latitude ) )
                            * cos( radians( longitude ) - radians(?))
                            + sin( radians(?) )
                            * sin( radians( latitude ) ) )))', [$usersss[0]->latitude, $usersss[0]->longitude, $usersss[0]->latitude])
                    ->where('userType', '!=', '1')
                    ->where('in_active', '=', '1')
                    ->where('make_private', '=', '0')
                    ->where('latitude', '!=', '')
                    ->where('longitude', '!=', '')
                    ->orderBy('profile_image_thumb', 'DESC')
                    ->groupBy('users.id')
                    ->paginate(10);
               foreach ($available_jobseekers as $var) {
            $jobseeker_id[] = $var->id;
        }
        $implode_id = implode(' ', $jobseeker_id);
        $explode_id = explode(' ', $implode_id);
        $idInArray = array();
        foreach ($explode_id as $idInLoop) {
            $idInLoop;

            $user_avalibility_dates = DB::table('user_avalibility_dates')
                            ->where('user_id', '=', $idInLoop)->get();


            $user_avalibility_dates1 = array();
            foreach ($user_avalibility_dates as $print) {
                $user_avalibility_dates1[] = $print->start_time;
            }
            $idInArray[] = implode("=", $user_avalibility_dates1);
        }
        $user_avalibility_dates2 = implode(",", $idInArray);
        //$explode = explode(' ', $implo);
        $user_avalibility_dates3 = explode(",", $user_avalibility_dates2);
        $incremetedId = count($available_jobseekers);
        if ($incremetedId == '1') {
            $i0 = $user_avalibility_dates3[0];
        }
        if ($incremetedId == '2') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
        }
        if ($incremetedId == '3') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
        }
        if ($incremetedId == '4') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
        }
        if ($incremetedId == '5') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
        }
        if ($incremetedId == '6') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
        }
        if ($incremetedId == '7') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
        }
        if ($incremetedId == '8') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
            $i7 = $user_avalibility_dates3[7];
        }
        if ($incremetedId == '9') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
            $i7 = $user_avalibility_dates3[7];
            $i8 = $user_avalibility_dates3[8];
        }
        if ($incremetedId == '10') {
            $i0 = $user_avalibility_dates3[0];
            $i1 = $user_avalibility_dates3[1];
            $i2 = $user_avalibility_dates3[2];
            $i3 = $user_avalibility_dates3[3];
            $i4 = $user_avalibility_dates3[4];
            $i5 = $user_avalibility_dates3[5];
            $i6 = $user_avalibility_dates3[6];
            $i7 = $user_avalibility_dates3[7];
            $i8 = $user_avalibility_dates3[8];
            $i9 = $user_avalibility_dates3[9];
        }
        }
        if ($request->search_term != '') {
            $available = '';
        } else {
            $available = 'Other Available Job Seekers';
        }
        
        $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();
        return view('do-js-search', compact('data','messageCounter', 'i0', 'i1', 'i2', 'i3', 'i4', 'i5', 'i6', 'i7', 'i8', 'i9', 'credentials', 'languages', 'certifications', 'available_jobseekers', 'available', 'user', 'usersss', 'sofaware_skillss', 'radiology_skills', 'jobseekers', 'officeInformation', 'officeImages'));
        }

    public function jobSeekerDetails($id) {
        $data['title'] = 'Job Seeker Profile';
        $user = Auth::user();
        $expiry_date = date('Y/m/d', $user->expiry_date);
        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        $current_expiry_date = \Carbon\Carbon::parse($expiry_date);
        $current_expiry_date = strtotime($current_expiry_date->adddays(3));

        if ($user->userType = 1 && ($user->expiry_date == NULL || $current_expiry_date < $this->utcSeconds)) {
            return redirect()->action('UserController@getPaymentDetails');
        }

        $officeInformation = OfficeInformation::where('user_id', $user->id)->first();
        $officeImages = OfficeImages::where('office_id', $officeInformation->id)->get();
        if (count($officeImages) > 0) {
            $user->profile_image_thumb = $officeImages[0]->image_url;
        } else {
            $user->profile_image_thumb = NULL;
        }
        $jobseeker = User::where('id', $id)->first();
        $sofaware_skills = DB::table('skills')->where('skill_type', '=', 1)->orderBy('skill', 'ASC')->get();
        $radiology_skills = DB::table('skills')->where('skill_type', '=', 2)->orderBy('skill', 'ASC')->get();
        $user_skills_software = DB::table('user_skills')
                        ->select('user_skills.skill_id', 'skills.skill')
                        ->leftJoin('skills', 'skills.id', '=', 'user_skills.skill_id')
                        ->where([
                            ['skill_type_id', '=', '1'],
                            ['user_id', '=', $jobseeker->id],
                        ])->get();
        $user_skills_radiology = DB::table('user_skills')
                        ->select('user_skills.skill_id', 'skills.skill')
                        ->leftJoin('skills', 'skills.id', '=', 'user_skills.skill_id')
                        ->where([
                            ['skill_type_id', '=', '2'],
                            ['user_id', '=', $jobseeker->id],
                        ])->get();
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
        $user_skills_software = implode(', ', $s_skillNames);
        $user_skills_radiology = implode(', ', $r_skillNames);
        $user_education = DB::table('user_education')->where('user_id', '=', $jobseeker->id)->get();
        $user_exprience = DB::table('user_exprience')->where('user_id', '=', $jobseeker->id)->get();
        $user_certifications = DB::table('user_certifications')->where('user_id', '=', $jobseeker->id)->get();
        //Job seeker available timings
        $available_timings = DB::table('user_avalibility_dates')->where('user_id', '=', $jobseeker->id)->get();
        if (count($available_timings) == 0) {
            $available_timings[0] = (object) array('start_time' => '-1', 'end_time' => '-1');
            $available_timings[1] = (object) array('start_time' => '-1', 'end_time' => '-1');
            $available_timings[2] = (object) array('start_time' => '-1', 'end_time' => '-1');
            $available_timings[3] = (object) array('start_time' => '-1', 'end_time' => '-1');
            $available_timings[4] = (object) array('start_time' => '-1', 'end_time' => '-1');
            $available_timings[5] = (object) array('start_time' => '-1', 'end_time' => '-1');
            $available_timings[6] = (object) array('start_time' => '-1', 'end_time' => '-1');
        }
        $messageCounter = DB::table('messages')->where('is_seen', '=', 0)->where('reciever_id', $user->id)->get();
        return view('do-js-profile', compact('data', 'messageCounter', 'user', 'jobseeker', 'officeInformation', 'officeImages', 'sofaware_skills', 'radiology_skills', 's_skillIDS', 'user_skills_software', 'r_skillIDS', 'user_skills_radiology', 'user_education', 'user_exprience', 'user_certifications', 'available_timings'));
    }

}

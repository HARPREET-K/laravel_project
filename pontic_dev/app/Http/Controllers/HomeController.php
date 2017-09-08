<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Classes\Common;
use Auth;
use Redirect;

#Stripe
Use Stripe;
#Models
use App\User;
use App\UserSubscriptions;
use App\UserCards;
use App\UserPayments;
use Input;
use DB;
use Illuminate\Support\Facades\Hash;
use AWS;
use Mail;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {

        $this->Common = new Common;
        $this->DateInstance = new \DateTime();
        $this->offset = $this->Common->getLocalOffsetValue();
        $this->utcSeconds = $this->DateInstance->getTimestamp() - $this->offset;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $company = Auth::user();
        return view('home', compact('company'));
    }

    public function getPaymentDetails() {

        $data['title'] = 'Payment Details';

        return view('payment-details', compact('data', 'user'));
    }

    public function loadPaymentScreen($plan, $userid) {
        $user = User::findOrFail($userid);
        $subscription_type = $plan;
        $data['title'] = 'Payment Details';
        return view('user-card-details', compact('data', 'user', 'subscription_type'));
    }

    public function userFreeSubscription($userid) {
        try {
            $user = User::findOrFail($userid);
            $stripe = Stripe::make(env('STRIPE_SECRET'));

            $current = \Carbon\Carbon::now();
            $expiry_date = strtotime($current->addMonths(1));
            // Create a Customer:
            $customer = $stripe->customers()->create(array(
                "email" => $user->email,
            ));
            $subscription = $stripe->subscriptions()->create($customer['id'], array(
                "plan" => "subscription_1",
                "trial_end" => $expiry_date,
            ));

            //save subscription details
            UserSubscriptions::create([
                'user_id' => $user->id,
                'subscription_type' => $subscription['plan']['id'],
                'subscription_id' => $subscription['id'],
                'created_at' => $this->utcSeconds
            ]);
            User::where(['id' => $user->id])->update([
                'expiry_date' => $expiry_date,
                'package_type' => "1",
                'updated_at' => $this->utcSeconds
            ]);

            //sending transaction details



            $data = array('id' => $subscription['plan']['id'],
             'name' => $user->name,
             "expiry_date"=> date("M d Y", $expiry_date),
             "package_type" => "Free Plan for 1 month",
             "amount" => 0);
          Mail::send('transaction-details', $data, function ($m) use ($user) {
              $m->to($user->email, 'Pontic')->subject('Thanks for CoNNeCTiNG with PONTIC.');
          });
            Auth::login($user);

            return Redirect::to('/');
          //  return redirect('/login')->with('status', 'Your subscription updated successfully');
        } catch (Exception $e) {
            return redirect('/login')->with('status', $e->getMessage());
        }
    }
    public function userFreeSubscription2($userid) {
        try {
            $user = User::findOrFail($userid);
            $stripe = Stripe::make(env('STRIPE_SECRET'));

            $current = \Carbon\Carbon::now();
            $expiry_date = strtotime($current->addMonths(1));
            
            //save subscription details
            
            User::where(['id' => $user->id])->update([
                'expiry_date' => $expiry_date,
                'package_type' => "1",
                'updated_at' => $this->utcSeconds
            ]);

            //sending transaction details



//            $data = array('id' => "Free Plan",
//             'name' => $user->name,
//             "expiry_date"=> date("M d Y", $expiry_date),
//             "package_type" => "Free Plan",
//             "amount" => 0);
//          Mail::send('transaction-details', $data, function ($m) use ($user) {
//              $m->to($user->email, 'Pontic')->subject('Thanks for CoNNeCTiNG with PONTIC.');
//          });
            Auth::login($user);

            return Redirect::to('/');
          //  return redirect('/login')->with('status', 'Your subscription updated successfully');
        } catch (Exception $e) {
            return redirect('/login')->with('status', $e->getMessage());
        }
    }

    public function makeSubscription(Request $request) {
          $user = User::findOrFail($request->user_id);
        try {
            $token = $request->stripeToken;
            $user = User::findOrFail($request->user_id);
            $stripe = Stripe::make(env('STRIPE_SECRET'));
            // Create a Customer if not exist
             $customer = $stripe->customers()->create(array(
                  "email" => $user->email,
                  "source" => $token,
              ));
           
            
            $current = \Carbon\Carbon::now();

            if ($request->plan == 1) {
                //6 months subscription
                if($user->expiry_date != NULL ){
                //  Adding 6 months from user subscription expiry date
                $next_expiry_date =  \Carbon\Carbon::parse(date('Y-m-d',$user->expiry_date)) ;
                $expiry_date =  strtotime($next_expiry_date->addMonths(6));
                }else {
                  /*
                  *adding 6 months to current date to new user
                  */
                  $expiry_date = strtotime($current->addMonths(6));
                }
                $usertypes = DB::table('user_types')->get();
                    if ($user->userType == 1) {
                        $amount = 200;
                        $subscription = $stripe->subscriptions()->create($customer['id'], array(
                      "plan" => "subscription_6",
                  ));
                    } else {
                        $amount = 0;
                        $subscription = $stripe->subscriptions()->create($customer['id'], array(
                      "plan" => "subscription_7",
                  ));
                    }
//                // Charge the Customer instead of the card:
//                $charge = $stripe->charges()->create(array(
//                    "amount" => $amount,
//                    "currency" => "usd",
//                    "customer" => $customer['id']
//                ));
                //create subscription for dental office users with $200 for 6 months 
                
                 UserSubscriptions::create([
                    'user_id' => $user->id,
                    'subscription_type' => $subscription['plan']['id'],
                    'subscription_id' => $subscription['id'],
                    'created_at' => $this->utcSeconds
                ]);
                User::where(['id' => $user->id])->update([
                    'stripe_customer_id' => $customer['id'],
                    'expiry_date' => $expiry_date,
                    'package_type' => "3",
                    'updated_at' => $this->utcSeconds
                ]);
//                //  save customer stripe id, expiry date, and plan type
//                User::where(['id' => $user->id])->update([
//                  'stripe_customer_id' => $customer['id'],
//                    'expiry_date' => $expiry_date,
//                    'package_type' => "2",
//                    'updated_at' => $this->utcSeconds
//                ]);
                //save subscription details
//                $payment = DB::table('user_payments')->insert(
//                        ['user_id' => $user->id, 'payment_date' => $this->utcSeconds, 'transaction_id' => $charge['id'], 'subscription_type' => 1, 'expiry_date' => $expiry_date, 'created_at' => $this->utcSeconds]
//                );

                // send an email to user with transaction details
                $data = array('id' => $subscription['plan']['id'],
                 'name' => $user->name,
                 "expiry_date"=> date("M d Y", $expiry_date),
                 "amount" => substr($subscription['plan']['amount'],0, -2),
                 "package_type" => "6 Months");
              Mail::send('transaction-details', $data, function ($m) use ($user) {
                  $m->to($user->email, 'Pontic')->subject('Thanks for CoNNeCTiNG with PONTIC.');
              });
            }
             else {
                //monthly subscription
                if($user->expiry_date != NULL ){
                //  Adding 6 months from user subscription expiry date
                $next_expiry_date =  \Carbon\Carbon::parse(date('Y-m-d',$user->expiry_date)) ;
                $expiry_date =  strtotime($next_expiry_date->addMonth());
                }else {
                  /*
                  *adding 6 months to current date to new user
                  */
                  $expiry_date = strtotime($current->addMonth());
                }
                if ($user->userType == 1) {
                  $subscription = $stripe->subscriptions()->create($customer['id'], array(
                      "plan" => "subscription_4",
                  ));
                 } else {
                   $subscription = $stripe->subscriptions()->create($customer['id'], array(
                       "plan" => "subscription_5",
                   ));
                 }
                 

                //save subscription details
                UserSubscriptions::create([
                    'user_id' => $user->id,
                    'subscription_type' => $subscription['plan']['id'],
                    'subscription_id' => $subscription['id'],
                    'created_at' => $this->utcSeconds
                ]);
                User::where(['id' => $user->id])->update([
                    'stripe_customer_id' => $customer['id'],
                    'expiry_date' => $expiry_date,
                    'package_type' => "3",
                    'updated_at' => $this->utcSeconds
                ]);

                $data = array('id' => $subscription['plan']['id'],
                 'name' => $user->name,
                 "expiry_date"=> date("M d Y", strtotime($current->addMonth())),
                 "amount" => substr($subscription['plan']['amount'],0, -2),
                 "package_type" => "Monthly");
              Mail::send('transaction-details', $data, function ($m) use ($user) {
                  $m->to($user->email, 'Pontic')->subject('Thanks for CoNNeCTiNG with PONTIC.');
              });
            }
            Auth::login($user);

            return Redirect::to('/');
          //  return redirect('/login')->with('status', 'Your subscription updated successfully');
        } catch (Exception $ex) {
             $data = array(
                 'name' => $user->name,
                 'message'=>  $e->getMessage()
                 );

              Mail::send('transaction-failed', $data, function ($m) use ($user) {
                  $m->to($user->email, 'Pontic')->subject('Transaction Failed with PONTIC.');
              });
             return redirect('/login')->with('status', $e->getMessage());
        }
    }
    public function stripeWebhook(Request $request){
        $stripe = Stripe::make(env('STRIPE_SECRET'));
        // Retrieve the request's body and parse it as JSON
       $input = @file_get_contents("php://input");
       $event_json = json_decode($input);
      $user = User::where('stripe_customer_id', $event_json['data']['customer'])->first();
      $next_expiry_date =  \Carbon\Carbon::parse(date('Y-m-d',$user->expiry_date)) ;
      $expiry_date =  strtotime($next_expiry_date->addMonth());

       User::where(['id' => $user->id])->update([
           'expiry_date' => $expiry_date,
           'updated_at' => $this->utcSeconds
       ]);
       $data = array('id' => $event_json['id'],
        'name' => $event_json['data']['source']['name'],
        "expiry_date"=> date("M d Y", strtotime($expiry_date)),
        "amount" => substr($event_json['data']['amount'],0, -2),
        "package_type" => "Monthly");

     Mail::send('transaction-details', $data, function ($m) use ($user) {
         $m->to($user->email, 'Pontic')->subject('Potnic Transaction Details');
     });
       http_response_code(200);


    }

    public function sendEmailNotification(){

      //get list of users who's account expires in one week
        $usersList = DB::select( DB::raw("SELECT * FROM  users where date(FROM_UNIXTIME(expiry_date)) = date(UTC_TIMESTAMP())") );
      foreach ($usersList as $user) {
          $expiry_date =  \Carbon\Carbon::parse(date('Y-m-d',$user->expiry_date)) ;

        if($user->package_type == 1){
          $package_type = "FREE Package";
        }elseif($user->package_type  == 2){
          $package_type = "6 Months Package";
        }else{
          $package_type = "Monthly Package";
        }
        $data = array(
         'name' => $user->name,
         "expiry_date"=> date("M d Y", strtotime($expiry_date)),
         "package_type" => $package_type);

      Mail::send('subscription_notification', $data, function ($m) use ($user) {
          $m->to($user->email, 'Pontic')->subject('Potnic account expiration');
      });
        }

    }


}

<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */


Route::auth();

/* * *******     Web Portal Routes Start **************** */

Route::get('/', 'UserController@index');
Route::get('/home', 'UserController@index');
Route::get('user/activation/{token}', 'Auth\AuthController@activateUser')->name('user.activate');
Route::get('history', 'UserController@userHistory');
Route::get('settings', 'UserController@userSettings');
Route::post('emailnotifications', 'UserController@saveEmailNotifications');
Route::post('profilesettings', 'UserController@makePrivateProfile');
Route::post('emailupdate', 'UserController@emailupdate');
Route::get('delete', 'UserController@userInactive');
Route::post('changePassword', 'UserController@changePassword');
Route::get('userProfile', 'UserController@getUserProfile');
Route::get('editUserProfile', 'UserController@editUserProfile');
Route::post('userGenaralInfo', 'UserController@updateUserGenaralInfo');
Route::post('userAdditionalInfo', 'UserController@updateUserAdditionalInformation');
Route::post('userTimeAvailabilInfo', 'UserController@updateUserTimeAvailabilInfo');
Route::get('dentalOfficeProfile', 'DentalOfficeController@getUserProfile');
Route::post('officeGenaralInfo', 'DentalOfficeController@updateOfficeInfo');
Route::post('officeAdditionalInfo', 'DentalOfficeController@updateAdditionalInfo');
Route::post('createJob', 'DentalOfficeController@createNewJob');

Route::post('updateJobDetails', 'DentalOfficeController@updateJobDetails');
Route::post('deleteJobDetails', 'DentalOfficeController@delteJobDetails');
Route::get('jobDetails/{id}', 'DentalOfficeController@jobDetails');
Route::post('completeJob', 'DentalOfficeController@completeJob');
Route::get('jsDetails/{id}', 'DentalOfficeController@jobSeekerDetails');



Route::get('search', 'UserController@jobsList');
Route::get('/jobs', ['uses' => 'UserController@jobsSearch']);
Route::get('/jobseekerssearch', ['uses' => 'UserController@jobSeekersSearch']);

Route::get('dentalOfficeDetails/{id}', 'UserController@getOfficeProfile');
Route::get('/postDetails/{id}', 'UserController@getJobDetails');

Route::post('imageUploader', 'DentalOfficeController@imageUploader');
Route::post('imageDelete', 'DentalOfficeController@imageDelete');


Route::get('jsList', 'DentalOfficeController@getJsList');


Route::get('jobseekers-search', ['uses' => 'DentalOfficeController@getJsList2']);

Route::get('userpayment',['uses' => 'UserController@getPaymentDetails']);


Route::get('loadPaymentInfo',['uses' =>'UserController@getPaymentDetails']);
Route::post('paymentProcess',['uses' => 'HomeController@makeSubscription']);
Route::get('freePlan/{id}',['uses' => 'HomeController@userFreeSubscription']);
Route::get('freePlan2/{id}',['uses' => 'HomeController@userFreeSubscription2']);
Route::post('makePaymentInfo',['uses' =>'HomeController@addPaymentInfo']);
Route::get('cancelSubscription',['uses'=> 'UserController@cancelSubscription']);

Route::post('subscriptionupdate',['uses'=>'HomeController@stripeWebhook']);

Route::post('subscriptionchecking',['uses'=>'HomeController@sendEmailNotification']);
//Messenger Routes
Route::get('tests', 'MessageController@tests');
Route::get('message', 'MessageController@chatHistory');
//Route::get('/home', 'HomeController@index');

Route::get('WelcomeMessage', 'MessageController@welcome')->name('message.welcome');
Route::get('message/{id}', 'MessageController@chatHistory')->name('message.read');
Route::get('messageseen/{id}', 'MessageController@makeSeen')->name('message.seen');
Route::group(['prefix'=>'ajax', 'as'=>'ajax::'], function() {
   Route::post('message/send', 'MessageController@ajaxSendMessage')->name('message.new');
   Route::delete('message/delete/{id}', 'MessageController@ajaxDeleteMessage')->name('message.delete');
});






/*********     Web Portal Routes End *****************/

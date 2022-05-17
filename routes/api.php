<?php
include app_path() . '/global_constants.php';
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; 
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(['namespace' => 'Api'], function () { // 'middleware' => ['auth:api'],
    Route::any('/register', array('as'=>'Api.register','uses'=>'\App\Http\Controllers\AdminUsersController@store'));    
    // Route::any('/test', array('as'=>'Api.test','uses'=>'\App\Http\Controllers\AdminUsersController@test'));    
    Route::any('/login', array('as'=>'Api.login','uses'=>'ApiController@login'));    
    Route::any('/forgetpassword', array('as'=>'Api.forgetpassword','uses'=>'ApiController@userForgetPassword'));    
    Route::any('/verifyforgototp', array('as'=>'Api.verifyforgot.otp','uses'=>'ApiController@verifyForgotOtp'));    
    Route::any('/verifysignupotp', array('as'=>'Api.verifysignup.otp','uses'=>'ApiController@verifySignupOtp'));    
    Route::any('/resetpassword', array('as'=>'Api.resetpassword','uses'=>'ApiController@userResetPasswordValidationAndSave'));    
    Route::any('/faq', array('as'=>'Api.faq','uses'=>'ApiController@faqList'));    
    Route::any('/carwashdetails', array('as'=>'Api.carwash.details','uses'=>'ApiController@carwashDetails'));   
    Route::any('/contact_us', array('as'=>'Api.contactUs','uses'=>'\App\Http\Controllers\contactMailController@send'));   
    Route::any('/change_password', array('as'=>'Api.changePassword','uses'=>'ApiController@changePassword'));   
    Route::any('/edit_profile', array('as'=>'Api.editProfile','uses'=>'ApiController@editProfile'));   
    Route::any('/notify_setting', array('as'=>'Api.notifySetting','uses'=>'ApiController@notifySetting'));   
    Route::any('/get_address_list', array('as'=>'Api.getAddressList','uses'=>'ApiController@getAddressList'));   
    Route::any('/get_address_details', array('as'=>'Api.getAddressDetail','uses'=>'ApiController@getAddressDetail'));   
    Route::any('/save_update_address', array('as'=>'Api.saveUpdateAddress','uses'=>'ApiController@saveUpdateAddress')); 
    Route::any('/delete_address', array('as'=>'Api.deleteAddress','uses'=>'ApiController@deleteAddress'));   
    Route::any('/delete_vehicle', array('as'=>'Api.deleteUserVehicle','uses'=>'ApiController@deleteUserVehicle'));   
    Route::any('/get_vechicle_attribute', array('as'=>'Api.getVechicleAttribute','uses'=>'ApiController@getVechicleAttribute'));  
    Route::any('/get_vechicle_model', array('as'=>'Api.getVechicleModel','uses'=>'ApiController@getVechicleModel'));  
    Route::any('/get_home_page_data', array('as'=>'Api.getHomePageData','uses'=>'ApiController@getHomePageData'));  
    Route::any('/get_zip_code', array('as'=>'Api.getZipCode','uses'=>'ApiController@getZipCode'));   
    Route::any('/save_new_vehicle', array('as'=>'Api.saveNewVehicle','uses'=>'ApiController@saveNewVehicle'));   
    Route::any('/get_new_vehicle', array('as'=>'Api.getNewVehicleList','uses'=>'ApiController@getNewVehicleList'));   
    Route::any('/get_vehicle_details', array('as'=>'Api.getVehicleDetails','uses'=>'ApiController@getVehicleDetails'));   
    Route::any('/get_washing_plans', array('as'=>'Api.getWashingPlanList','uses'=>'ApiController@getWashingPlanList'));   
    Route::any('/get_washing_plan_detail', array('as'=>'Api.getWashingPlanDetails','uses'=>'ApiController@getWashingPlanDetails'));   
    Route::any('/get_booking_shedule', array('as'=>'Api.getValidBookingShedule','uses'=>'ApiController@getValidBookingShedule'));   
    Route::any('/get_cleaner_exist', array('as'=>'Api.getCleanerExist','uses'=>'ApiController@getCleanerExist'));   
    Route::any('/resend_otp', array('as'=>'Api.resendOtp','uses'=>'ApiController@resendOtp'));   
    Route::any('/verify_temp_email_mobile', array('as'=>'Api.VerifyTempEmailMobile','uses'=>'ApiController@VerifyTempEmailMobile'));   
    Route::any('/get_user_details', array('as'=>'Api.getUserDetails','uses'=>'ApiController@getUserDetails'));   
    Route::any('/resend_otp_temp_email_mobile', array('as'=>'Api.resendOtpForChangeAuth','uses'=>'ApiController@resendOtpForChangeAuth'));   
    Route::any('/book_appointment', array('as'=>'Api.bookAppointment','uses'=>'ApiController@bookAppointment'));   
    Route::any('/book_appointment_addon', array('as'=>'Api.bookAppointmentAddon','uses'=>'ApiController@bookAppointmentAddon'));   
    Route::any('/get_booking_final_details', array('as'=>'Api.getBookingFinalDetails','uses'=>'ApiController@getBookingFinalDetails'));   
    Route::any('/get_booking_details', array('as'=>'Api.getBookingDetails','uses'=>'ApiController@getBookingDetails'));   
    Route::any('/get_booking_apoointment_listing', array('as'=>'Api.getAppointmentBookingListing','uses'=>'ApiController@getAppointmentBookingListing'));
    Route::any('/get_booking_apoointment_payment_listing', array('as'=>'Api.getAppointmentPaymentBookingListing','uses'=>'ApiController@getAppointmentPaymentBookingListing'));   
    Route::any('/cancel_booked_appointment', array('as'=>'Api.cancelBookedAppointment','uses'=>'ApiController@cancelBookedAppointment'));   
    Route::any('/accept_booked_appointment', array('as'=>'Api.acceptBookedAppointment','uses'=>'ApiController@acceptBookedAppointment'));   
    Route::any('/reshedule_booked_appointment', array('as'=>'Api.resheduleBookedAppointment','uses'=>'ApiController@resheduleBookedAppointment'));  
    Route::any('/get_addone_services', array('as'=>'Api.getAddoneServices','uses'=>'ApiController@getAddoneServices'));   
    Route::any('/get_banners', array('as'=>'Api.getBannerList','uses'=>'ApiController@getBannerList')); 
    Route::any('/logout', array('as'=>'Api.logout','uses'=>'ApiController@logout')); 
    Route::any('/upload_cleaner_pre_wash_photo', array('as'=>'Api.uploadCleanerPreWashPhoto','uses'=>'ApiController@uploadCleanerPreWashPhoto'));
    Route::any('/upload_cleaner_post_wash_photo', array('as'=>'Api.uploadCleanerPostWashPhoto','uses'=>'ApiController@uploadCleanerPostWashPhoto'));          
    Route::any('/get_cleaner_all_booking_list', array('as'=>'Api.getCleanerAllBookingList','uses'=>'ApiController@getCleanerAllBookingList'));   
    Route::any('/update_cleaner_status', array('as'=>'Api.updateCleanerStatus','uses'=>'ApiController@updateCleanerStatus')); 
    Route::any('/cleaner_daily_opening', array('as'=>'Api.cleanerDailyOpening','uses'=>'ApiController@cleanerDailyOpening')); 
    Route::any('/coupon_applicble_amount', array('as'=>'Api.couponApplicbleAmount','uses'=>'ApiController@couponApplicbleAmount')); 
    Route::any('/coupon_list', array('as'=>'Api.couponList','uses'=>'ApiController@couponList')); 
    Route::any('/penalty_charges', array('as'=>'Api.penaltyCharges','uses'=>'ApiController@penaltyCharges')); 
    Route::any('/get_banners', array('as'=>'Api.getBannerList','uses'=>'ApiController@getBannerList'));  
    Route::any('/faq', array('as'=>'Api.faq','uses'=>'ApiController@faqList'));  
    Route::any('/upload_cleaner_pre_wash_photo', array('as'=>'Api.uploadCleanerPreWashPhoto','uses'=>'ApiController@uploadCleanerPreWashPhoto'));
    Route::any('/upload_cleaner_post_wash_photo', array('as'=>'Api.uploadCleanerPostWashPhoto','uses'=>'ApiController@uploadCleanerPostWashPhoto'));     
    Route::any('/cleaner_booking_start', array('as'=>'Api.cleanerBookingStart','uses'=>'ApiController@cleanerBookingStart'));
    Route::any('/send_cleaner_booking_start_otp', array('as'=>'Api.sendCleanerBookingStartOTP','uses'=>'ApiController@sendCleanerBookingStartOTP'));
    Route::any('/get_notification_listing', array('as'=>'Api.getUserNotificationListing','uses'=>'ApiController@getUserNotificationListing'));
    Route::any('/user_review_rating', array('as'=>'Api.userReviewRating','uses'=>'ApiController@userReviewRating'));
    Route::any('/appointment_unavailabile', array('as'=>'Api.appointmentUnavailabile','uses'=>'ApiController@appointmentUnavailabile'));
    Route::any('/unavailabile_booking_cancel', array('as'=>'Api.unavailabileBookingCancel','uses'=>'ApiController@unavailabileBookingCancel'));

    Route::any('/read_user_notification', array('as'=>'Api.readUserNotification','uses'=>'ApiController@readUserNotification'));
    Route::any('/delete_user_notification', array('as'=>'Api.deleteUserNotification','uses'=>'ApiController@deleteUserNotification'));
    Route::any('/store_franchise_cleaner_vehicle', array('as'=>'Api.storeFranchiseCleanerVehicle','uses'=>'ApiController@storeFranchiseCleanerVehicle'));   
    Route::any('/store_franchise_cleaner_vehicle_details', array('as'=>'Api.storeFranchiseCleanerVehicleDetails','uses'=>'ApiController@storeFranchiseCleanerVehicleDetails'));  

    Route::group(['middleware' => ['jwt.refresh']], function() {
    });
    Route::any('/refresh', array('as'=>'Api.refresh','uses'=>'ApiController@refresh'));   

    Route::group(['middleware' => ['jwt.verify']], function() {  
    });

    //Route::any('/team/store', array('as'=>'Api.admin.team','uses'=>'\App\Http\Controllers\AdminTeamController@store'));    
});
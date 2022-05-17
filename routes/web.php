<?php
use App\Company_social;
use App\Contact;
use App\Gallery;
use App\Opening_hour;
use App\Service;
use App\Social_team;
use App\Team;
use App\Vehicle_type;
use App\Washing_plan;
use App\Washing_plan_include;
use App\Washing_price;
use App\FAQ;
use App\Page;
use App\Banner;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Api;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::resource('/', 'HomePageController');
Auth::routes();
Route::get('/home', function ()
{
    return Redirect('/');
});
Route::any('/videos', 'HomePageController@view_all')->name('viewAll');
Route::any('/galleries', 'HomePageController@view_all_gallery')
    ->name('viewAllGallery');

Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@getLogin']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@getRegister']);
Route::get('password/reset', ['as' => 'passwords.reset', 'uses' => 'Auth\ForgotPasswordController@showResetPassword']);
Route::get('password/reset{token}', ['as' => 'passwords.reset.token', 'uses' => 'Auth\ResetPasswordController@showResetForm']);
Route::any('reset-password/{validatestring}', 'Auth\ResetPasswordController@reset')
    ->name('user.resetpassword');
Route::any('reset-password-update', 'Auth\ResetPasswordController@resetPasswordUpdate')
    ->name('password.request');

Route::post('subscribe', 'mailChimpController@subscribe');
Route::post('subscribe', 'HomePageController@mailError');
Route::get('/contact-us', 'contactMailController@index');
Route::post('/contact-us', 'contactMailController@send');
Route::get('/404', function ()
{
    $company_socials = Company_social::all();
    $services = Service::all();
    $opening_times = Opening_hour::all();
    $contacts = Contact::all();
    return view('404', compact('company_socials', 'services', 'opening_times', 'contacts'));
});
Route::any('download-invoice/{id}', array(
    'as' => 'users.exportInvoicePDF',
    'uses' => 'AdminUsersController@exportInvoicePDF'
));
Route::get('/403', function ()
{
    $company_socials = Company_social::all();
    $services = Service::all();
    $opening_times = Opening_hour::all();
    $contacts = Contact::all();
    return view('403', compact('company_socials', 'services', 'opening_times', 'contacts'));
});

Route::get('/pricing_plan', function ()
{
    $company_socials = Company_social::all();
    $services = Service::all();
    $opening_times = Opening_hour::all();
    $contacts = Contact::all();
    $washing_plans = Washing_plan::all();
    $washing_includes = Washing_plan_include::with('washing_plan')->get();
    $vehicle_types = Vehicle_type::all();
    $washing_prices = Washing_price::all();
    return view('pricing_plan', compact('company_socials', 'services', 'opening_times', 'contacts', 'washing_plans', 'washing_includes', 'vehicle_types', 'washing_prices'));
});
Route::get('/faq', function ()
{
    $categories = FAQ::all();
    $company_socials = Company_social::all();
    $services = Service::all();
    $opening_times = Opening_hour::all();
    $contacts = Contact::all();
    return view('faq', compact('company_socials', 'services', 'opening_times', 'contacts', 'categories'));
});
Route::get('/banners', function ()
{
    $banners = Banner::all();
    return view('admin.banners.index', compact('banners'));
});
Route::post('/add-apply_franchise', function (Request $request)
{
    $input = $request->all();
    FranchiseRequest::create($input);
    return view('apply_franchise', compact('input'));
});
Route::any('pages/{slug}', 'HomePageController@pageCmsContent')->name('pagecmscontent.index');
Route::get('/coming_soon', function ()
{
    $company_socials = Company_social::all();
    $services = Service::all();
    $opening_times = Opening_hour::all();
    $contacts = Contact::all();
    return view('coming_soon', compact('company_socials', 'services', 'opening_times', 'contacts'));
});
Route::get('/under_construction', function ()
{
    $company_socials = Company_social::all();
    $services = Service::all();
    $opening_times = Opening_hour::all();
    $contacts = Contact::all();
    return view('under_construction', compact('company_socials', 'services', 'opening_times', 'contacts'));
});
Route::get('/gallery', function ()
{
    $company_socials = Company_social::all();
    $services = Service::all();
    $opening_times = Opening_hour::all();
    $contacts = Contact::all();
    $galleries = Gallery::all();
    return view('gallery', compact('company_socials', 'services', 'opening_times', 'contacts', 'galleries'));
});
Route::get('/team', function ()
{
    $company_socials = Company_social::all();
    $services = Service::all();
    $opening_times = Opening_hour::all();
    $contacts = Contact::all();
    $teams = Team::all();
    $socials = Social_team::with('teams')->get();
    return view('team', compact('company_socials', 'services', 'opening_times', 'contacts', 'teams', 'socials'));
});
Route::get('/testimonial', function ()
{
    $testimonials = Testimonial::all();
    return view('testimonial', compact('testimonials'));
});
Route::group(['prefix' => 'apply-franchise'], function ()
{
    Route::post('/add-apply_franchise', array(
        'as' => 'layouts.theme',
        'uses' => 'ApplyFranchiseController@savefranchise'
    ));
});
Route::group(['prefix' => 'contact-us'], function ()
{
    Route::post('/contact-us', array(
        'as' => 'contact-us',
        'uses' => 'AdminContactController@savecontact'
    ));
});

Route::group(['middleware' => 'iscommon'], function ()
{
    Route::get('/admin', 'AdminController@index');
    Route::get('/admin/profile', function ()
    {
        return view('profile');
    });
    Route::resource('admin/appointment', 'AdminAppointmentController');
    Route::resource('/admin/cleaners', 'AdminCleanerController');
    
});
#####  Event MODULE  ROUTING START HERE
Route::group(['prefix' => 'admin', 'middleware' => 'iscommon'], function ()
{

    Route::any('users', 'AdminUsersController@index')->name('users.index');
    Route::get('create', array(
        'as' => 'users.create',
        'uses' => 'AdminUsersController@create'
    ));
    Route::post('add-users', array(
        'as' => 'users.store',
        'uses' => 'AdminUsersController@store'
    ));
    Route::get('users/edit/{id}', array(
        'as' => 'admin.users.edit',
        'uses' => 'AdminUsersController@edit'
    ));
    Route::any('users/all-cleaners-bookings/{paymentId?}', array(
        'as' => 'users.cleanersBookings',
        'uses' => 'AdminUsersController@allCleanersBookings'
    ));
    Route::any('users/all-franchies-appoinments', array(
        'as' => 'users.freanchies.all',
        'uses' => 'AdminUsersController@allFreanchiesAppoinment'
    ));
    Route::any('users/all-cleaner-appoinments/{id}', array(
        'as' => 'users.cleanersAppointmnents',
        'uses' => 'AdminUsersController@allcleanersAppoinment'
    ));
    Route::any('users/all-franchies-appoinments/view/{id}', array(
        'as' => 'users.freanchies.show',
        'uses' => 'AdminUsersController@allFreanchiesAppoinmentDetail'
    ));
    Route::any('users/all-franchies-appoinments/{id}', array(
        'as' => 'users.view1',
        'uses' => 'AdminUsersController@view1'
    ));
    Route::any('users/all-franchies-appoinments/refund/{id}', array(
        'as' => 'users.refund',
        'uses' => 'AdminUsersController@refund'
    ));
    Route::any('users/all-franchies-appoinments/status/{id}', array(
        'as' => 'users.status',
        'uses' => 'AdminUsersController@updateStatus'
    ));
    Route::any('users/reschedule_bookings/{id}', array(
        'as' => 'users.reschedule_bookings',
        'uses' => 'AdminUsersController@rescheduleBookings'
    ));
    //Route::get('users/downloadExcel/{type}', array('as' => 'users.excel','uses' =>'AdminUsersController@downloadExcel'));
    Route::get('users/export', 'AdminUsersController@export');
    Route::get('users/csv', 'AdminUsersController@exportcsv');
    Route::post('users/{user}', array(
        'as' => 'users.update',
        'uses' => 'AdminUsersController@update'
    ));
    Route::any('users/appoinment/{id}/{appointment_id}', array(
        'as' => 'users.view',
        'uses' => 'AdminUsersController@view'
    ));
    Route::any('users/delete-users/{id}/{type?}', array(
        'as' => 'users.destroy',
        'uses' => 'AdminUsersController@destroy'
    ));
    Route::any('users/update-block/{id}', array(
        'as' => 'users.block',
        'uses' => 'AdminUsersController@updateBlockStatus'
    ));
    Route::any('users/appoinment/{id}', array(
        'as' => 'users.appoinment',
        'uses' => 'AdminUsersController@cleanerAppoinment'
    ));
    Route::any('users/all-franchies-appoinments/reschedule/{appointment_id}/{cleaner_id}/{user_id}', array(
        'as' => 'users.reschedule',
        'uses' => 'AdminUsersController@Reschedule'
    ));
    Route::group(['prefix' => 'penalty-charges'], function ()
    {
        Route::any('show', array(
            'as' => 'penalty.edit',
            'uses' => 'AdminPenaltyChargesController@show'
        ));
        Route::any('cancellation_charges_amount', array(
            'as' => 'penalty.index',
            'uses' => 'AdminPenaltyChargesController@cancellationChargesAmount'
        ));
        Route::post('cancellation_charges_amount/penalty_amount', 'AdminPenaltyChargesController@cancellationValidation')
            ->name('penaltyAmount');
        Route::any('cancellation_charges_amount/refund_transaction/{type}/{id}', 'AdminPenaltyChargesController@refundTransaction')
            ->name('refundTransaction');
    });
    Route::get('/vehicle_coordinate_data', 'VehicleCoordinateController@index')
        ->name('vehicle.index');
    Route::post('/vehicle_coordinate_data/add', 'VehicleCoordinateController@VehicleCoordinate')
        ->name('vehicle.add');
    Route::post('/vehicle_current_location', 'VehicleCoordinateController@VehicleLocation')
        ->name('vehicle.location');
    Route::group(['prefix' => 'email-logs'], function ()
    {
        #####  Email logs MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'EmailLogs.index',
            'uses' => 'AdminEmailLogsController@listlogs'
        ));
        Route::get('create', array(
            'as' => 'EmailLogs.add',
            'uses' => 'AdminEmailLogsController@addlogs'
        ));
        Route::post('add-email-logs', array(
            'as' => 'EmailLogs.save',
            'uses' => 'AdminEmailLogsController@savelogs'
        ));
        Route::get('edit/{id}', array(
            'as' => 'EmailLogs.edit',
            'uses' => 'AdminEmailLogsController@editlogs'
        ));
        Route::post('edit-email-logs/{id}', array(
            'as' => 'EmailLogs.update',
            'uses' => 'AdminEmailLogsController@updatelogs'
        ));
        Route::post('/email-logs/get_constant', 'EmailLogsController@getConstant')
            ->name('AdminEmailLogs.getConstant');
        Route::any('delete-email-logs/{id}', array(
            'as' => 'EmailLogs.delete',
            'uses' => 'AdminEmailLogsController@deleteEmaillogs'
        ));
    });

    Route::group(['prefix' => 'FranchiseList'], function ()
    {
        #####  Email logs MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'franchiselist.index',
            'uses' => 'AdminFranchiseListController@listlogs'
        ));
        Route::any('update-status/{id}', array(
            'as' => 'franchiselist.status',
            'uses' => 'AdminFranchiseListController@updateStatus'
        ));
        Route::any('delete-franchise-list/{id}', array(
            'as' => 'franchiselist.delete',
            'uses' => 'AdminFranchiseListController@deleteFranchiseList'
        ));
    });
    Route::group(['prefix' => 'ContactUsList'], function ()
    {
        #####  ContactUs MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'contactUsList.index',
            'uses' => 'AdminContactUsController@listlogs'
        ));
        Route::any('update-status/{id}', array(
            'as' => 'contactUsList.status',
            'uses' => 'AdminContactUsController@updateStatus'
        ));
        Route::any('delete-ContactUs-list/{id}', array(
            'as' => 'contactUsList.delete',
            'uses' => 'AdminContactUsController@deleteFranchiseList'
        ));
    });
    Route::group(['prefix' => 'cancel_refunds'], function ()
    {
        #####  Cancel Refunds MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'cancelRefundsList.index',
            'uses' => 'AdminCancelRefundsController@cancelRefundsList'
        ));
    });
    //Accounting Services
    Route::group(['prefix' => 'accounting-services'], function ()
    {
        #####  EmailTemplate MODULE  ROUTING START HERE
        Route::any('/', 'AdminAccountingServicesController@index')
            ->name('accounting_services.index');
        Route::get('create', ['as' => 'accounting_services.create', 'uses' => 'AdminAccountingServicesController@create']);
        Route::post('add-accounting-services', ['as' => 'accounting_services.save', 'uses' => 'AdminAccountingServicesController@store']);
        Route::get('edit/{id}', ['as' => 'accounting_services.edit', 'uses' => 'AdminAccountingServicesController@edit']);
        Route::post('edit-accounting-services/{id}', ['as' => 'accounting_services.update', 'uses' => 'AdminAccountingServicesController@update']);
        Route::any('delete-accounting-services/{id}', ['as' => 'accounting_services.delete', 'uses' => 'AdminAccountingServicesController@destroy']);
    });
    // EmailTemplate
    Route::group(['prefix' => 'email-template'], function ()
    {
        #####  EmailTemplate MODULE  ROUTING START HERE
        Route::any('/', 'AdminEmailTemplateController@listTemplate')
            ->name('EmailTemplate.index');
        Route::get('create', array(
            'as' => 'EmailTemplate.add',
            'uses' => 'AdminEmailTemplateController@addTemplate'
        ));
        Route::post('add-email-template', array(
            'as' => 'EmailTemplate.save',
            'uses' => 'AdminEmailTemplateController@saveTemplate'
        ));
        Route::get('edit/{id}', array(
            'as' => 'EmailTemplate.edit',
            'uses' => 'AdminEmailTemplateController@editTemplate'
        ));
        Route::post('edit-email-template/{id}', array(
            'as' => 'EmailTemplate.update',
            'uses' => 'AdminEmailTemplateController@updateTemplate'
        ));
        Route::post('get_constant', 'AdminEmailTemplateController@getConstant')
            ->name('EmailTemplate.getConstant');
        Route::any('delete-email-template/{id}', array(
            'as' => 'EmailTemplate.delete',
            'uses' => 'AdminEmailTemplateController@deleteEmailTemplate'
        ));
    });
    Route::group(['prefix' => 'banners'], function ()
    {
        #####  banners MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'banners.index',
            'uses' => 'BannersController@index'
        ));
        Route::get('create', array(
            'as' => 'banners.create',
            'uses' => 'BannersController@create'
        ));
        Route::post('add-banners', array(
            'as' => 'banners.save',
            'uses' => 'BannersController@store'
        ));
        Route::get('edit/{id}', array(
            'as' => 'banners.edit',
            'uses' => 'BannersController@edit'
        ));
        Route::post('edit-banners/{id}', array(
            'as' => 'banners.update',
            'uses' => 'BannersController@update'
        ));
        // Route::post('get_constant', 'AdminEmailTemplateController@getConstant')->name('EmailTemplate.getConstant');
        Route::any('delete-banners/{id}', array(
            'as' => 'banners.delete',
            'uses' => 'BannersController@destroy'
        ));
    });
    Route::group(['prefix' => 'blocks'], function ()
    {
        #####  banners MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'pages.index',
            'uses' => 'PagesController@index'
        ));
        Route::get('create', array(
            'as' => 'pages.create',
            'uses' => 'PagesController@create'
        ));
        Route::post('add-blocks', array(
            'as' => 'pages.save',
            'uses' => 'PagesController@store'
        ));
        Route::get('edit/{id}', array(
            'as' => 'pages.edit',
            'uses' => 'PagesController@edit'
        ));
        Route::post('edit-blocks/{id}', array(
            'as' => 'pages.update',
            'uses' => 'PagesController@update'
        ));
        Route::any('delete-blocks/{id}', array(
            'as' => 'pages.delete',
            'uses' => 'PagesController@destroy'
        ));
    });
    Route::group(['prefix' => 'cms'], function ()
    {
        #####  banners MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'cms.index',
            'uses' => 'CMSController@index'
        ));
        Route::get('create', array(
            'as' => 'cms.create',
            'uses' => 'CMSController@create'
        ));
        Route::post('add-cms', array(
            'as' => 'cms.save',
            'uses' => 'CMSController@store'
        ));
        Route::get('edit/{id}', array(
            'as' => 'cms.edit',
            'uses' => 'CMSController@edit'
        ));
        Route::post('edit-cms/{id}', array(
            'as' => 'cms.update',
            'uses' => 'CMSController@update'
        ));
        Route::any('delete-cms/{id}', array(
            'as' => 'cms.delete',
            'uses' => 'CMSController@destroy'
        ));
    });
    Route::group(['prefix' => 'push-notifications'], function ()
    {
        #####  notifications MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'PushNotification.index',
            'uses' => 'AdminPushNotificationController@listTemplate'
        ));
        Route::get('create', array(
            'as' => 'PushNotification.add',
            'uses' => 'AdminPushNotificationController@addTemplate'
        ));
        Route::post('add-push-notifications', array(
            'as' => 'PushNotification.save',
            'uses' => 'AdminPushNotificationController@saveTemplate'
        ));
        Route::get('edit/{id}', array(
            'as' => 'PushNotification.edit',
            'uses' => 'AdminPushNotificationController@editTemplate'
        ));
        Route::post('edit-push-notifications/{id}', array(
            'as' => 'PushNotification.update',
            'uses' => 'AdminPushNotificationController@updateTemplate'
        ));
        Route::post('/push-notifications/get_constant', 'AdminPushNotificationController@getConstant')
            ->name('PushNotification.getConstant');
        Route::any('delete-push-notifications/{id}', array(
            'as' => 'PushNotification.delete',
            'uses' => 'AdminPushNotificationController@deletePushNotification'
        ));
    });
    Route::group(['prefix' => 'settings'], function ()
    {
        Route::resource('roles', 'RolesController');
        Route::resource('settings', 'AdminSettingsController');
        Route::get('navigations/order', 'NavigationOrderController@index');
        Route::post('navigations/order', 'NavigationOrderController@updateOrder');
        Route::resource('navigations', 'NavigationsController');
    });
    Route::group(['prefix' => 'faqs/categories'], function ()
    {
        #####  faqs category MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'faqs_categories.index',
            'uses' => 'AdminCategoriesController@index'
        ));
        Route::get('create', array(
            'as' => 'faqs_categories.create',
            'uses' => 'AdminCategoriesController@create'
        ));
        Route::post('add-faq-categories', array(
            'as' => 'faqs_categories.store',
            'uses' => 'AdminCategoriesController@store'
        ));
        Route::get('edit/{id}', array(
            'as' => 'faqs_categories.edit',
            'uses' => 'AdminCategoriesController@edit'
        ));
        Route::post('edit-faq-categories/{id}', array(
            'as' => 'faqs_categories.update',
            'uses' => 'AdminCategoriesController@update'
        ));
        Route::any('delete-faq-categories/{id}', array(
            'as' => 'faqs_categories.destroy',
            'uses' => 'AdminCategoriesController@destroy'
        ));
    });
    Route::group(['prefix' => 'faqs'], function ()
    {
        #####  faqs MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'faqs.index',
            'uses' => 'AdminFAQController@index'
        ));
        Route::get('create', array(
            'as' => 'faqs.create',
            'uses' => 'AdminFAQController@create'
        ));
        Route::post('add-faq', array(
            'as' => 'faqs.store',
            'uses' => 'AdminFAQController@store'
        ));
        Route::get('edit/{id}', array(
            'as' => 'faqs.edit',
            'uses' => 'AdminFAQController@edit'
        ));
        Route::post('edit-faq/{id}', array(
            'as' => 'faqs.update',
            'uses' => 'AdminFAQController@update'
        ));
        Route::any('delete-faq/{id}', array(
            'as' => 'faqs.destroy',
            'uses' => 'AdminFAQController@destroy'
        ));
    });
    Route::group(['prefix' => 'coupons'], function ()
    {
        #####  faqs MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'coupons.index',
            'uses' => 'AdminCouponController@index'
        ));
        Route::get('create', array(
            'as' => 'coupons.create',
            'uses' => 'AdminCouponController@create'
        ));
        Route::post('add-coupons', array(
            'as' => 'coupons.store',
            'uses' => 'AdminCouponController@store'
        ));
        Route::get('edit/{id}', array(
            'as' => 'coupons.edit',
            'uses' => 'AdminCouponController@edit'
        ));
        Route::post('edit-coupons/{id}', array(
            'as' => 'coupons.update',
            'uses' => 'AdminCouponController@update'
        ));
        Route::any('update-coupon-status/{id}', array(
            'as' => 'coupons.status',
            'uses' => 'AdminCouponController@updateCouponStatus'
        ));
        Route::any('delete-coupons/{id}', array(
            'as' => 'coupons.destroy',
            'uses' => 'AdminCouponController@destroy'
        ));
    });
    Route::group(['prefix' => 'add_on_services'], function ()
    {
        #####  faqs MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'add_on_services.index',
            'uses' => 'AdminAddOnServicesController@index'
        ));
        Route::get('create', array(
            'as' => 'add_on_services.create',
            'uses' => 'AdminAddOnServicesController@create'
        ));
        Route::post('add-add_on_services', array(
            'as' => 'add_on_services.store',
            'uses' => 'AdminAddOnServicesController@store'
        ));
        Route::get('edit/{id}', array(
            'as' => 'add_on_services.edit',
            'uses' => 'AdminAddOnServicesController@edit'
        ));
        Route::post('edit-add_on_services/{id}', array(
            'as' => 'add_on_services.update',
            'uses' => 'AdminAddOnServicesController@update'
        ));
        Route::any('delete-add_on_services/{id}', array(
            'as' => 'add_on_services.destroy',
            'uses' => 'AdminAddOnServicesController@destroy'
        ));
    });
    Route::group(['prefix' => 'vehicle_company'], function ()
    {
        #####  faqs MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'vehicle_company.index',
            'uses' => 'AdminVehicleCompController@index'
        ));
        Route::get('create', array(
            'as' => 'vehicle_company.create',
            'uses' => 'AdminVehicleCompController@create'
        ));
        Route::post('add-vehicle_company', array(
            'as' => 'vehicle_company.store',
            'uses' => 'AdminVehicleCompController@store'
        ));
        Route::get('edit/{id}', array(
            'as' => 'vehicle_company.edit',
            'uses' => 'AdminVehicleCompController@edit'
        ));
        Route::post('edit-vehicle_company/{id}', array(
            'as' => 'vehicle_company.update',
            'uses' => 'AdminVehicleCompController@update'
        ));
        Route::any('delete-vehicle_company/{id}', array(
            'as' => 'vehicle_company.destroy',
            'uses' => 'AdminVehicleCompController@destroy'
        ));
    });
    Route::group(['prefix' => 'vehicle_company'], function ()
    {
        #####  faqs MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'vehicle_company.index',
            'uses' => 'AdminVehicleCompController@index'
        ));
        Route::get('create', array(
            'as' => 'vehicle_company.create',
            'uses' => 'AdminVehicleCompController@create'
        ));
        Route::post('add-vehicle_company', array(
            'as' => 'vehicle_company.store',
            'uses' => 'AdminVehicleCompController@store'
        ));
        Route::get('edit/{id}', array(
            'as' => 'vehicle_company.edit',
            'uses' => 'AdminVehicleCompController@edit'
        ));
        Route::post('edit-vehicle_company/{id}', array(
            'as' => 'vehicle_company.update',
            'uses' => 'AdminVehicleCompController@update'
        ));
        Route::any('delete-vehicle_company/{id}', array(
            'as' => 'vehicle_company.destroy',
            'uses' => 'AdminVehicleCompController@destroy'
        ));
    });
    Route::group(['prefix' => 'vehicle_modal'], function ()
    {
        #####  faqs MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'vehicle_modal.index',
            'uses' => 'AdminVehicleModalController@index'
        ));
        Route::get('create', array(
            'as' => 'vehicle_modal.create',
            'uses' => 'AdminVehicleModalController@create'
        ));
        Route::post('add-vehicle_modal', array(
            'as' => 'vehicle_modal.store',
            'uses' => 'AdminVehicleModalController@store'
        ));
        Route::get('edit/{id}', array(
            'as' => 'vehicle_modal.edit',
            'uses' => 'AdminVehicleModalController@edit'
        ));
        Route::post('edit-vehicle_modal/{id}', array(
            'as' => 'vehicle_modal.update',
            'uses' => 'AdminVehicleModalController@update'
        ));
        Route::any('delete-vehicle_modal/{id}', array(
            'as' => 'vehicle_modal.destroy',
            'uses' => 'AdminVehicleModalController@destroy'
        ));
    });
    Route::group(['prefix' => 'vehicle_type'], function ()
    {
        #####  faqs MODULE  ROUTING START HERE
        Route::any('/', array(
            'as' => 'vehicle_type.index',
            'uses' => 'AdminVehicleTypeController@index'
        ));
        Route::get('create', array(
            'as' => 'vehicle_type.create',
            'uses' => 'AdminVehicleTypeController@create'
        ));
        Route::post('add-vehicle_type', array(
            'as' => 'vehicle_type.store',
            'uses' => 'AdminVehicleTypeController@store'
        ));
        Route::get('edit/{id}', array(
            'as' => 'vehicle_type.edit',
            'uses' => 'AdminVehicleTypeController@edit'
        ));
        Route::post('edit-vehicle_type/{id}', array(
            'as' => 'vehicle_type.update',
            'uses' => 'AdminVehicleTypeController@update'
        ));
        Route::any('delete-vehicle_type/{id}', array(
            'as' => 'vehicle_type.destroy',
            'uses' => 'AdminVehicleTypeController@destroy'
        ));
    });
});

Route::any('/cleaners_review_rating/{cleaner_id}', 'AdminTeamController@CleanersReviewRating')
    ->name('cleaners_review_rating.index');
Route::any('/franchise_cleaner/{franchise_id}/{cleaners_id}', 'AdminTeamController@CleanersVehicles')
    ->name('cleaners_vehicles.create');
Route::get('franchise/export', 'AdminTeamController@export');
Route::get('franchise/csv', 'AdminTeamController@exportcsv');

Route::group(['middleware' => 'isadmin'], function ()
{
    Route::resource('/admin/team', 'AdminTeamController');
    // Route::resource('admin/coupons', 'AdminCouponController');
    //Route::any('/admin/team/{id}',array('as'=>'team.view','uses'=>'AdminTeamController@view'));
    Route::any('/franchise_zip_code/{franchise_id}/{user_id}', 'AdminTeamController@view')
        ->name('team.view');
    Route::any('/franchise_cleaners_availability/{franchise_id}/{user_id}', 'AdminTeamController@CleanersAvailability')
        ->name('cleaners_availability.update');
    //  Route::any('/franchise_cleaners_availability-update/{franchise_id}/{user_id}', 'AdminTeamController@CleanersAvailabilityUpdate')->name('cleaners_availability.update');
    Route::any('/franchise_daily_ride/{cleaner_id}', 'AdminTeamController@CleanersDailyRide')
        ->name('cleaners_daily.index');
    Route::any('/admin/all_cleaners_ride', 'AdminTeamController@cleanersDailyRideview')
        ->name('cleaners_daily_ride.index');
    Route::any('/franchise_cleaner/{id}', 'AdminTeamController@franchiseCleaners')
        ->name('franchise_cleaner.index');
    Route::resource('/admin/team_social', 'AdminTeamSocialController');
    Route::resource('admin/services', 'AdminServiceController');
    Route::resource('admin/gallery', 'AdminGalleryController');
    Route::get('admin/videos/create', 'AdminVideoController@create')
        ->name('videos.index');
    Route::post('admin/videos/add', 'AdminVideoController@store')
        ->name('videos.store');
    Route::any('admin/videos/', 'AdminVideoController@index')
        ->name('videos.show');
    Route::get('admin/videos/edit/{id}', ['as' => 'videos.edit', 'uses' => 'AdminVideoController@edit']);
    Route::post('admin/videos/edit-videos/{id}', ['as' => 'videos.update', 'uses' => 'AdminVideoController@update']);
    Route::any('admin/videos/delete-videos/{id}', ['as' => 'videos.destroy', 'uses' => 'AdminVideoController@destroy']);
    Route::resource('admin/testimonial', 'AdminTestimonialController');
    Route::resource('admin/washing_plan', 'AdminWashingPlanController');
    Route::resource('admin/washing_include', 'AdminWashingIncludeController');
    Route::resource('admin/washing_price', 'AdminWashingPriceController');
    Route::resource('admin/status', 'AdminTaskStatusController');
    Route::resource('admin/team_task', 'AdminTeamTaskController');
    Route::resource('admin/facts', 'AdminFactsController');
    Route::resource('admin/blog', 'AdminBlogController');
    Route::resource('admin/clients', 'AdminClientsController');
    Route::resource('admin/opening_hours', 'AdminOpeningHoursController');
    Route::resource('admin/company_social', 'AdminCompanySocialController');
    Route::resource('admin/payment_mode', 'AdminPaymentModeController');
    Route::resource('admin/payments', 'AdminPaymentController');
    Route::resource('admin/contact', 'AdminContactController');
    Route::resource('admin/payment', 'AdminPaymentController');
});


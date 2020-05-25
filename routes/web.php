<?php
use Illuminate\Support\Facades\Route;
define('Admin', 'Admin');
define('Setting', 'Setting');
define('Medical', 'Medical');
define('News', 'News');
define('Cars', 'Cars');
define('Payment', 'Payment');
define('DataClean', 'DataClean');
define('EngineeringRecord', 'EngineeringRecord');
define('Merchant', 'Merchant');
define('ComplaintRequest', 'ComplaintRequest');
define('uses', 'uses');
define('Covid19', 'Covid19');
// define('ComplaintRequest', 'ComplaintRequest');


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

Route::get('/', function () {
    return redirect()->route('Dashboard');
});



Auth::routes();




// User ManageMent
//setting
/*Route::group(['middleware'=>['web'], 'prefix' => 'Merchant'],function(){
	Route::get('login'		 ,array('as'=>'MerchantLoginForm'		,'uses'=>'Auth\LoginController@merchantLoginForm'));
	Route::post('login'		 ,array('as'=>'MerchantLogin'		,'uses'=>'Auth\LoginController@merchantLogin'));
	Route::get('/medical/requests'		 ,array('as'=>'Merchant.Medical.Requests'		,'uses'=>'Merchant\MerchantController@listRequests','middleware' => ['auth:merchant']));


});*/
Route::group(['middleware'=>['web','auth','auto-check-permission','auto-check-IP','auto-logs'] /*, 'prefix' => 'Admin'*/],function(){
	// Home Page
		Route::get('/Dashboard', Admin.'\DashboradController@index')->name('Dashboard');
        Route::get('changePassword'	,array('as'=>'User.changePassword','uses'=>Admin.'\UserController@changePassword'));
		Route::post('changePasswordpost',array('as'=>'User.changePasswordPost','uses'=>Admin.'\UserController@changePasswordpost'));
	//Ajax
		Route::any('Search',array('as'=>'Search','uses'=>'AjaxController@Search'));
		Route::get('Ajaxtable'		 ,array('as'=>'Ajaxtable'		,'uses'=>'AjaxController@Ajaxtable'));
		Route::get('AjaxExcel'		 ,array('as'=>'AjaxExcel'		,'uses'=>'AjaxController@AjaxExcel'));
		
		
	// Funcation 
		Route::any('SendMail',array('as'=>'SendMail','uses'=>'AjaxController@SendMail'));
    // Admin
		Route::resource('User'			,Admin.'\UserController');
		Route::resource('Role'			,Admin.'\RoleController');
		Route::resource('Ip'			,Admin.'\IpController');
	//Setting
		Route::resource('NewsType'		,Setting.'\NewsTypeController');
		Route::resource('Country'		,Setting.'\CountryController');
		Route::resource('Governorate'	,Setting.'\GovernorateController');
		Route::resource('Area'			,Setting.'\AreaController');		
		Route::resource('Season'		,Setting.'\SeasonController');
		Route::resource('SystemPage'	,Setting.'\SystemPageController');
		Route::resource('Setting'		,Setting.'\SettingController');		
		Route::resource('Syndicate'		,Setting.'\SyndicateController');
		Route::resource('SubSyndicate'	,Setting.'\SubSyndicateController');
		Route::resource('Place'			,Setting.'\PlaceController');
		Route::resource('SmsLog'		,Setting.'\SmsLogController');
		Route::resource('Complaint' ,Setting.'\ComplaintController');
		Route::resource('ComplaintRequest' ,Setting.'\ComplaintRequestController');
	//News
		Route::resource('News'			,News.'\NewsController');
		//Cars
		Route::resource('Cars'			,Cars.'\CarsController');
	
	//Medical
		Route::resource('MedicalRequest',Medical.'\MedicalRequestController');		
	// Payment
		Route::resource('Transaction'	,Payment.'\TransactionController');
		
	//Call Center
	 Route::POST('/transfer/{id}',Medical.'\MedicalRequestTranferController@receive_request');
        Route::resource('Merchant',Merchant.'\MerchantController');   
	   //covid19
	   Route::resource('Covid19'			,'Covid19\Covid19Controller');
     });
Route::group(array('prefix' => 'api'), function() {

	Route::GET('pullProviders'        ,'API\Medical\MedicalController@pullProviders');

    # Syndicates V2
	Route::GET('v2/Syndicates/Main/syndicates','API\SyndicatesController@all_mainSyndicates');
	Route::POST('v2/Syndicates/Sub/All/byMain','API\SyndicatesController@sub_syndicates');
	Route::POST('v2/Syndicates/Main/By_Id'    ,'API\SyndicatesController@main_syndicates');
	Route::GET('v2/Syndicates/Main/All'       ,'API\SyndicatesController@all_main'); 
	Route::GET('v2/syndicates/All'            ,'API\SyndicatesController@all_syndicates');
	Route::POST('v2/Syndicates/Sub/By_Id'     ,'API\SyndicatesController@sub_syndicates');
	# Syndicate Users 
	Route::post('v2/users/signup','API\UsersController@sign_up');

	# News 
	Route::GET('v2/news/'                ,'API\NewsController@index'  );
	Route::POST('v2/news/main_syndicate/','API\NewsController@news_by');
	Route::POST('v2/news/sub_syndicate/' ,'API\NewsController@news_by');
    
	Route::post('complaints/request'          ,'API\ReceiveComplaintRequestController@receive_request');
    Route::GET('complaintServices'             ,'API\General\ComplaintsServiceController@index');	
    
	Route::GET('Countries'            ,'API\General\CountriesController@index');
	Route::GET('Governorates'         ,'API\General\GovernoratesController@index');
	Route::GET('Areas'                ,'API\General\AreasController@index');
	Route::GET('medical/areas'        ,'API\General\AreasController@index');	
	Route::GET('v2/medical/areas'     ,'API\General\AreasController@index');	
	// Route::GET('services'             ,'API\General\ServicesController@index');	

	# Setting
	Route::GET('min-version'             ,'API\SettingController@androidMinVersion');	
	

	//Route::POST('complaint/request'    ,'API\General\ComplaintRequestController@receive_request');

	# Medical 
	Route::GET('v2/medical/degrees'           ,'API\Medical\DegreesController@index');
	Route::GET('v2/medical/professions'       ,'API\Medical\ProfessionsController@index');
	
	Route::POST('v3/medical/providers'        ,'API\Medical\MedicalController@getProviders');
    Route::POST('v3/medical/providerTypes'    ,'API\Medical\MedicalController@service_provider_types');
	Route::POST('v3/medical/providerDetails'  ,'API\Medical\MedicalController@provider_details');
	Route::POST('v3/medical/doctors'          ,'API\Medical\MedicalController@getDoctors');
    # Medical Requests & Medical Beneficiary validation
	Route::POST('v2/medical/Beneficiary'  ,'API\Medical\MedicalRequestController@beneficiary_validate');
	Route::POST('v2/medical/request'      ,'API\Medical\MedicalRequestController@receive_request');
	Route::POST('v2/medical/request/code' ,'API\Medical\MedicalRequestController@get_request');
    

	# Notifications #########################################################################################	
	Route::POST('notifications'         ,'API\NotificationController@getNotification');
	Route::POST('notification/sign_up'  ,'API\NotificationController@register_token');
	# End Notifications ######################################################################################
	
	# RegistryDataValidation #########################################################################################
    Route::POST('EnginneringRecordsRegistry'         ,'API\EnginneringRecords\RegistryController@validateRegistry');
    Route::POST('EnginneringRecordsRegistry/request' ,'API\EnginneringRecords\RegistryController@store_request');
    # End RegistryDataValidation ######################################################################################
	#data clean
	Route::POST('v1/Engineer/Data'        ,'API\DataClean\EngineerController@getEngineerData');
	Route::POST('v1/Engineer/'        ,'API\DataClean\EngineerController@getEngineer');
	Route::POST('v1/Update/Engineer/'        ,'API\DataClean\EngineerController@updateEngineer');
	Route::GET('v1/Update/Engineer/Data'        ,['as'=>'Update.Engineer.Data',uses=>'API\DataClean\EngineerController@updateEngineerData']);
    Route::POST('Engineer/sendsms'	,'API\DataClean\EngineerController@sendVerifySms');
	Route::POST('v1/RecieveEngineerRquest'		,'API\DataClean\RecieveEngineerRequest@receive_request');
	//Route::get('/edit', [ 'as' => 'EngineeringdataRequest.edit', 'uses' =>  DataClean.'\EngineerRequestController@edit']);

	//covid19
	Route::POST('v1/RecieveCovid19Rquest'		,'API\Covid19\Covid19RequestController@receive_request');

	//AddPropertyRequest

	Route::POST('v1/AddPropertyRequest'		,'API\AddPropertyRequest\AddPropertyRequestController@receive_request');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');






Route::get('/home','CarsHomeController@showFeatures')->name('home');
Route::get('/ReadMore',function(){
return view('ReadMore');
});
Route::get('/Advertising',function(){
    return view('Advertising');
});
Route::post('/property','AddPropertyRequest@recieveRequest');
Route::get('/Homenews','HomeNews\NewsController@showNews');
Route::get('/newCars','newCars\CarsController@showNewCars');
Route::get('/usedCars','newCars\CarsController@showUsedCars');
Route::get('/contact',function(){
    return view('Contact');
});
Route::post('/ContactRequest','API\ReceiveComplaintRequestController@receive_request');
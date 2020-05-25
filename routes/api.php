<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
     Route::group(['prefix' => 'v1'], function() {
        Route::post('/register/member', 'Auth\RegisterController@createMember');
        Route::post('/login/member', 'Auth\LoginController@memberLogin');
        Route::post('/login/member/verification', 'Auth\LoginController@loginByVerificationCode');
        Route::post('/login/member/user-number', 'Auth\LoginController@loginByUserNumber');
        Route::post('/upgrade/member/client', 'Auth\UpgradeController@UpgradeToClient')->middleware('auth:member');
        Route::post('/login/member/mobile', 'Auth\LoginController@loginByMobile');

        Route::group(['namespace' => 'API\Payment','prefix' => 'transactions'], function() {
            Route::post('/generate-hash','TransactionController@generateHash')->middleware('auth:member');
            Route::get('/create','TransactionController@create');
            Route::get('/return','TransactionController@return')->name('transactions.return');
            Route::post('/callback','TransactionController@callback')->name('transactions.callback');
        });
     });

Route::group(array('prefix' => 'api'), function() {
    # Syndicates V2
    // Route::GET('v2/Syndicates/Main/syndicates','syndicates\apiSyndicatesController@all_mainSyndicates');

});

//Update
Route::group(['namespace' => 'API','prefix' => 'v1'], function() {
    //Notification
        Route::POST('countnotification'		,'NotificationController@countUnread');
        Route::POST('listnotification'		,'NotificationController@list');
        Route::GET('shownotification/{id}'  ,'NotificationController@show')->where('id', '[0-9]+');        
//DataClean
        Route::POST('Engineer/search'		,'DataClean\EngineerController@search');
        Route::POST('Engineer/sendverifysms','DataClean\EngineerController@sendVerifySms');
        Route::POST('Engineer/verifysms'    ,'DataClean\EngineerController@verifySms');
        Route::POST('Engineer/update'       ,'DataClean\EngineerController@update');
//Services
        Route::GET('Service/inquiry'        ,'General\ServicesController@inquiry');
            

});
// End Update

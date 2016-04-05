<?php

/*
  |--------------------------------------------------------------------------
  | Routes File
  |--------------------------------------------------------------------------
  |
  | Here is where you will register all of the routes in an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

//Route::get('/', function () {
//    return view('welcome');
//});
/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | This route group applies the "web" middleware group to every route
  | it contains. The "web" middleware group is defined in your HTTP
  | kernel and includes session state, CSRF protection, and more.
  |
 */


Route::group(['middleware' => ['web']], function () {
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
        Route::get('/get-user-addresses', ["as" => "getUserAdd", "uses" => "SystemUsersController@getAddresses"]);
        Route::get('/', ["as" => "adminLogin", "uses" => "LoginController@index"]);
        Route::post('/check-user', ["as" => "check_admin_user", "uses" => "LoginController@chk_admin_user"]);
        Route::get('/admin-logout', ["as" => "adminLogout", "uses" => "LoginController@admin_logout"]);


        //   Route::group(['middleware' => 'CheckUser'], function() {
        Route::get('/dashboard', ["as" => "admin.dashboard", "uses" => "LoginController@dashboard"]);

        Route::group(['prefix' => 'master'], function() {
            Route::group(['prefix' => 'cities'], function() {
                Route::get('/', ['as' => 'admin.cities.view', 'uses' => 'CitiesController@index']);
                Route::get('/add', ['as' => 'admin.cities.add', 'uses' => 'CitiesController@add']);
                Route::post('/save', ['as' => 'admin.cities.save', 'uses' => 'CitiesController@save']);
                Route::get('/edit', ['as' => 'admin.cities.edit', 'uses' => 'CitiesController@edit']);
                Route::get('/delete', ['as' => 'admin.cities.delete', 'uses' => 'CitiesController@delete']);
            });

            Route::group(['prefix' => 'frequency'], function() {
                Route::get('/', ['as' => 'admin.frequency.view', 'uses' => 'FrequencyController@index']);
                Route::get('/add', ['as' => 'admin.frequency.add', 'uses' => 'FrequencyController@add']);
                Route::post('/save', ['as' => 'admin.frequency.save', 'uses' => 'FrequencyController@save']);
                Route::get('/edit', ['as' => 'admin.frequency.edit', 'uses' => 'FrequencyController@edit']);
                Route::get('/delete', ['as' => 'admin.frequency.delete', 'uses' => 'FrequencyController@delete']);
            });

            Route::group(['prefix' => 'timeslot'], function() {
                Route::get('/', ['as' => 'admin.timeslot.view', 'uses' => 'TimeslotController@index']);
                Route::get('/add', ['as' => 'admin.timeslot.add', 'uses' => 'TimeslotController@add']);
                Route::post('/save', ['as' => 'admin.timeslot.save', 'uses' => 'TimeslotController@save']);
                Route::get('/edit', ['as' => 'admin.timeslot.edit', 'uses' => 'TimeslotController@edit']);
                Route::get('/delete', ['as' => 'admin.timeslot.delete', 'uses' => 'TimeslotController@delete']);
            });

            Route::group(['prefix' => 'servicetype'], function() {
                Route::get('/', ['as' => 'admin.servicetype.view', 'uses' => 'ServicetypeController@index']);
                Route::get('/add', ['as' => 'admin.servicetype.add', 'uses' => 'ServicetypeController@add']);
                Route::post('/save', ['as' => 'admin.servicetype.save', 'uses' => 'ServicetypeController@save']);
                Route::get('/edit', ['as' => 'admin.servicetype.edit', 'uses' => 'ServicetypeController@edit']);
                Route::get('/delete', ['as' => 'admin.servicetype.delete', 'uses' => 'ServicetypeController@delete']);
            });

            Route::group(['prefix' => 'wastetype'], function() {
                Route::get('/', ['as' => 'admin.wastetype.view', 'uses' => 'WastetypeController@index']);
                Route::get('/add', ['as' => 'admin.wastetype.add', 'uses' => 'WastetypeController@add']);
                Route::post('/save', ['as' => 'admin.wastetype.save', 'uses' => 'WastetypeController@save']);
                Route::get('/edit', ['as' => 'admin.wastetype.edit', 'uses' => 'WastetypeController@edit']);
                Route::get('/delete', ['as' => 'admin.wastetype.delete', 'uses' => 'WastetypeController@delete']);
            });

            Route::group(['prefix' => 'fueltype'], function() {
                Route::get('/', ['as' => 'admin.fueltype.view', 'uses' => 'FueltypeController@index']);
                Route::get('/add', ['as' => 'admin.fueltype.add', 'uses' => 'FueltypeController@add']);
                Route::post('/save', ['as' => 'admin.fueltype.save', 'uses' => 'FueltypeController@save']);
                Route::get('/edit', ['as' => 'admin.fueltype.edit', 'uses' => 'FueltypeController@edit']);
                Route::get('/delete', ['as' => 'admin.fueltype.delete', 'uses' => 'FueltypeController@delete']);
            });
            
            Route::group(['prefix' => 'additive'], function() {
                Route::get('/', ['as' => 'admin.additive.view', 'uses' => 'AdditiveController@index']);
                Route::get('/add', ['as' => 'admin.additive.add', 'uses' => 'AdditiveController@add']);
                Route::post('/save', ['as' => 'admin.additive.save', 'uses' => 'AdditiveController@save']);
                Route::get('/edit', ['as' => 'admin.additive.edit', 'uses' => 'AdditiveController@edit']);
                Route::get('/delete', ['as' => 'admin.additive.delete', 'uses' => 'AdditiveController@delete']);
            });
            
            Route::group(['prefix' => 'recordtype'], function() {
                Route::get('/', ['as' => 'admin.recordtype.view', 'uses' => 'RecordtypeController@index']);
                Route::get('/add', ['as' => 'admin.recordtype.add', 'uses' => 'RecordtypeController@add']);
                Route::post('/save', ['as' => 'admin.recordtype.save', 'uses' => 'RecordtypeController@save']);
                Route::get('/edit', ['as' => 'admin.recordtype.edit', 'uses' => 'RecordtypeController@edit']);
                Route::get('/delete', ['as' => 'admin.recordtype.delete', 'uses' => 'RecordtypeController@delete']);
            });
        });

        Route::group(['prefix' => 'subscription'], function() {
            Route::get('/', ['as' => 'admin.subscription.view', 'uses' => 'SubscriptionController@index']);
            Route::get('/add', ['as' => 'admin.subscription.add', 'uses' => 'SubscriptionController@add']);
            Route::post('/save', ['as' => 'admin.subscription.save', 'uses' => 'SubscriptionController@save']);
            Route::get('/edit', ['as' => 'admin.subscription.edit', 'uses' => 'SubscriptionController@edit']);
            Route::get('/delete', ['as' => 'admin.subscription.delete', 'uses' => 'SubscriptionController@delete']);
            Route::get('/rmfile', ['as' => 'admin.subscription.rmfile', 'uses' => 'SubscriptionController@rmfile']);
        });
        
          Route::group(['prefix' => 'servicehistory'], function() {
            Route::get('/', ['as' => 'admin.servicehistory.view', 'uses' => 'ServicehistoryController@index']);
            Route::get('/add', ['as' => 'admin.servicehistory.add', 'uses' => 'ServicehistoryController@add']);
            Route::post('/save', ['as' => 'admin.servicehistory.save', 'uses' => 'ServicehistoryController@save']);
            Route::get('/edit', ['as' => 'admin.servicehistory.edit', 'uses' => 'ServicehistoryController@edit']);
            Route::get('/delete', ['as' => 'admin.servicehistory.delete', 'uses' => 'ServicehistoryController@delete']);
        });
        
        Route::group(['prefix' => 'record'], function() {
            Route::get('/', ['as' => 'admin.record.view', 'uses' => 'RecordController@index']);
            Route::get('/add', ['as' => 'admin.record.add', 'uses' => 'RecordController@add']);
            Route::post('/save', ['as' => 'admin.record.save', 'uses' => 'RecordController@save']);
            Route::get('/edit', ['as' => 'admin.record.edit', 'uses' => 'RecordController@edit']);
            Route::get('/delete', ['as' => 'admin.record.delete', 'uses' => 'RecordController@delete']);
            Route::get('/rmfile', ['as' => 'admin.record.rmfile', 'uses' => 'RecordController@rmfile']);
        });

        Route::group(['prefix' => 'schedule'], function() {
            Route::get('/', ['as' => 'admin.schedule.view', 'uses' => 'ScheduleController@index']);
            Route::get('/add', ['as' => 'admin.schedule.add', 'uses' => 'ScheduleController@add']);
            Route::post('/save', ['as' => 'admin.schedule.save', 'uses' => 'ScheduleController@save']);
            Route::get('/edit', ['as' => 'admin.schedule.edit', 'uses' => 'ScheduleController@edit']);
            Route::get('/delete', ['as' => 'admin.schedule.delete', 'uses' => 'ScheduleController@delete']);
        });


        Route::group(['prefix' => 'assets'], function() {
            Route::get('/', ['as' => 'admin.assets.view', 'uses' => 'AssetsController@index']);
            Route::get('/add', ['as' => 'admin.assets.add', 'uses' => 'AssetsController@add']);
            Route::post('/save', ['as' => 'admin.assets.save', 'uses' => 'AssetsController@save']);
            Route::get('/edit', ['as' => 'admin.assets.edit', 'uses' => 'AssetsController@edit']);
            Route::get('/delete', ['as' => 'admin.assets.delete', 'uses' => 'AssetsController@delete']);
        });

        Route::group(['prefix' => 'acl'], function() {
            Route::group(['prefix' => 'roles'], function() {
                Route::get('/', ['as' => 'admin.roles.view', 'uses' => 'RolesController@index']);
                Route::get('/add', ['as' => 'admin.roles.add', 'uses' => 'RolesController@add']);
                Route::post('/save', ['as' => 'admin.roles.save', 'uses' => 'RolesController@save']);
                Route::get('/edit', ['as' => 'admin.roles.edit', 'uses' => 'RolesController@edit']);
                Route::get('/delete', ['as' => 'admin.roles.delete', 'uses' => 'RolesController@delete']);
            });



            Route::group(['prefix' => 'systemusers'], function() {
                Route::post('/chk_existing_username', ['as' => 'chk_existing_username', 'uses' => 'SystemUsersController@chk_existing_username']);

                Route::get('/', ['as' => 'admin.systemusers.view', 'uses' => 'SystemUsersController@index']);
                Route::get('/add', ['as' => 'admin.systemusers.add', 'uses' => 'SystemUsersController@add']);
                Route::post('/save', ['as' => 'admin.systemusers.save', 'uses' => 'SystemUsersController@save']);
                Route::get('/edit', ['as' => 'admin.systemusers.edit', 'uses' => 'SystemUsersController@edit']);
                Route::post('/update', ['as' => 'admin.systemusers.update', 'uses' => 'SystemUsersController@update']);
                Route::get('/delete', ['as' => 'admin.systemusers.delete', 'uses' => 'SystemUsersController@delete']);
            });
        });
        // });
    });
});

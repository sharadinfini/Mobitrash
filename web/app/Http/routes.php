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
    Route::any('/sync/bonfleet', ["as" => "bonfleet.insert", 'namespace'=> 'Admin', "uses" => "Admin\BonfleetController@insert"]);
    Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {        
        Route::get('/get-user-addresses', ["as" => "getUserAdd", "uses" => "SystemUsersController@getAddresses"]);
        Route::get('/get-user-subscriptions', ["as" => "getUserSub", "uses" => "SystemUsersController@getSubscriptions"]);
        Route::get('/get-user-approx-time', ["as" => "getUserApproxTime", "uses" => "SystemUsersController@getApproxTime"]);
        Route::get('/remove-schedule-pickup', ["as" => "removeSchedulePickup", "uses" => "ScheduleController@removePickup"]);
        Route::get('/unauthorised', ["as" => "user.unauthorised", "uses" => "LoginController@unauthorised"]);
        Route::get('/record-index-filter', ["as" => "recordIndexFilter", "uses" => "RecordController@indexFilter"]);
        Route::get('/', ["as" => "adminLogin", "uses" => "LoginController@index"]);
        Route::post('/check-user', ["as" => "check_admin_user", "uses" => "LoginController@chk_admin_user"]);        
        Route::get('/admin-logout', ["as" => "adminLogout", "uses" => "LoginController@admin_logout"]);
        Route::group(['prefix' => 'payment'], function() {
            Route::get('/payment-notification', ["as" => "admin.payment.notification", "uses" => "PaymentController@paymentNotification"]);
        });
        Route::group(['middleware' => 'CheckUser'], function() {
            Route::get('/dashboard', ["as" => "admin.dashboard", "uses" => "PageController@dashboard"]);
            Route::get('/settings', ["as" => "admin.settings", "uses" => "PageController@setting"]);
            Route::get('/map', ["as" => "admin.location.map", "uses" => "PageController@vanLocationMap"]);
            Route::post('/location-get', ["as" => "admin.location.get", "uses" => "PageController@vanLocationGet"]);
            Route::post('/settings-save', ["as" => "admin.settings.save", "uses" => "PageController@settingsSave"]);
            Route::group(['prefix' => 'master'], function() {
                Route::group(['prefix' => 'cities'], function() {
                    Route::get('/', ['as' => 'admin.cities.view', 'uses' => 'CitiesController@index']);
                    Route::get('/add', ['as' => 'admin.cities.add', 'uses' => 'CitiesController@add']);
                    Route::post('/save', ['as' => 'admin.cities.save', 'uses' => 'CitiesController@save']);
                    Route::get('/edit', ['as' => 'admin.cities.edit', 'uses' => 'CitiesController@edit']);
                    Route::get('/delete', ['as' => 'admin.cities.delete', 'uses' => 'CitiesController@delete']);
                });
                Route::group(['prefix' => 'gardenWasteCities'], function() {
                    Route::get('/', ['as' => 'admin.garden.cities.view', 'uses' => 'CitiesController@indexGardenWaste']);
                    Route::get('/add', ['as' => 'admin.garden.cities.add', 'uses' => 'CitiesController@addGardenWaste']);
                    Route::post('/save', ['as' => 'admin.garden.cities.save', 'uses' => 'CitiesController@saveGardenWaste']);
                    Route::get('/edit', ['as' => 'admin.garden.cities.edit', 'uses' => 'CitiesController@editGardenWaste']);
                    Route::get('/delete', ['as' => 'admin.garden.cities.delete', 'uses' => 'CitiesController@deleteGardenWaste']);
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

                Route::group(['prefix' => 'shift'], function() {
                    Route::get('/', ['as' => 'admin.shift.view', 'uses' => 'ShiftController@index']);
                    Route::get('/add', ['as' => 'admin.shift.add', 'uses' => 'ShiftController@add']);
                    Route::post('/save', ['as' => 'admin.shift.save', 'uses' => 'ShiftController@save']);
                    Route::get('/edit', ['as' => 'admin.shift.edit', 'uses' => 'ShiftController@edit']);
                    Route::get('/delete', ['as' => 'admin.shift.delete', 'uses' => 'ShiftController@delete']);
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

                Route::group(['prefix' => 'package'], function() {
                    Route::get('/', ['as' => 'admin.package.view', 'uses' => 'PackageController@index']);
                    Route::get('/add', ['as' => 'admin.package.add', 'uses' => 'PackageController@add']);
                    Route::post('/save', ['as' => 'admin.package.save', 'uses' => 'PackageController@save']);
                    Route::get('/edit', ['as' => 'admin.package.edit', 'uses' => 'PackageController@edit']);
                    Route::get('/delete', ['as' => 'admin.package.delete', 'uses' => 'PackageController@delete']);
                });

                Route::group(['prefix' => 'occupancy'], function() {
                    Route::get('/', ['as' => 'admin.occupancy.view', 'uses' => 'OccupancyController@index']);
                    Route::get('/add', ['as' => 'admin.occupancy.add', 'uses' => 'OccupancyController@add']);
                    Route::post('/save', ['as' => 'admin.occupancy.save', 'uses' => 'OccupancyController@save']);
                    Route::get('/edit', ['as' => 'admin.occupancy.edit', 'uses' => 'OccupancyController@edit']);
                    Route::get('/delete', ['as' => 'admin.occupancy.delete', 'uses' => 'OccupancyController@delete']);
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
                Route::get('/trial', ['as' => 'admin.subscription.trial', 'uses' => 'SubscriptionController@indexTrial']);
                Route::get('/add', ['as' => 'admin.subscription.add', 'uses' => 'SubscriptionController@add']);
                Route::post('/save', ['as' => 'admin.subscription.save', 'uses' => 'SubscriptionController@save']);
                Route::get('/edit', ['as' => 'admin.subscription.edit', 'uses' => 'SubscriptionController@edit']);
                Route::get('/delete', ['as' => 'admin.subscription.delete', 'uses' => 'SubscriptionController@delete']);
                Route::get('/rmfile', ['as' => 'admin.subscription.rmfile', 'uses' => 'SubscriptionController@rmfile']);
            });

            Route::group(['prefix' => 'renewal'], function() {
                Route::get('/', ['as' => 'admin.renewal.view', 'uses' => 'SubscriptionController@renewal']);
            });

            Route::group(['prefix' => 'pipedrive'], function() {
                Route::get('/get-all', ['as' => 'admin.pipedrive.all', 'uses' => 'PipedriveController@getAll']);
                Route::get('/get-trial', ['as' => 'admin.pipedrive.trial', 'uses' => 'PipedriveController@getTrial']);
                Route::get('/get-stages', ['as' => 'admin.pipedrive.stages', 'uses' => 'PipedriveController@getStages']);
            });

            Route::group(['prefix' => 'servicehistory'], function() {
                Route::get('/', ['as' => 'admin.servicehistory.view', 'uses' => 'ServicehistoryController@index']);
                Route::get('/add', ['as' => 'admin.servicehistory.add', 'uses' => 'ServicehistoryController@add']);
                Route::get('/excel', ['as' => 'admin.servicehistory.excel', 'uses' => 'ServicehistoryController@exportExcel']);
                Route::post('/save', ['as' => 'admin.servicehistory.save', 'uses' => 'ServicehistoryController@save']);
                Route::get('/edit', ['as' => 'admin.servicehistory.edit', 'uses' => 'ServicehistoryController@edit']);
                Route::get('/delete', ['as' => 'admin.servicehistory.delete', 'uses' => 'ServicehistoryController@delete']);
            });

            Route::group(['prefix' => 'record'], function() {
                Route::get('/', ['as' => 'admin.record.view', 'uses' => 'RecordController@index']);
                Route::get('/add', ['as' => 'admin.record.add', 'uses' => 'RecordController@add']);
                Route::post('/save', ['as' => 'admin.record.save', 'uses' => 'RecordController@save']);
                Route::get('/edit', ['as' => 'admin.record.edit', 'uses' => 'RecordController@edit']);
                Route::get('/show', ['as' => 'admin.record.show', 'uses' => 'RecordController@show']);
                Route::get('/delete', ['as' => 'admin.record.delete', 'uses' => 'RecordController@delete']);
                Route::get('/rmfile', ['as' => 'admin.record.rmfile', 'uses' => 'RecordController@rmfile']);
            });
            
            Route::group(['prefix' => 'gardenwaste'], function() {
                Route::get('/', ['as' => 'admin.gardenwaste.view', 'uses' => 'GardenwasteController@index']);
                Route::get('/messages', ['as' => 'admin.gardenwaste.messages', 'uses' => 'GardenwasteController@messages']);
                Route::get('/setting', ['as' => 'admin.gardenwaste.setting', 'uses' => 'GardenwasteController@setting']);
                Route::get('/pickupslot', ['as' => 'admin.gardenwaste.pickupslot', 'uses' => 'GardenwasteController@pickupslot']);
                Route::post('/pickupslot-save', ['as' => 'admin.gardenwaste.savepickupslot', 'uses' => 'GardenwasteController@savePickupslot']);
                Route::get('/add', ['as' => 'admin.gardenwaste.add', 'uses' => 'GardenwasteController@add']);
                Route::post('/save', ['as' => 'admin.gardenwaste.save', 'uses' => 'GardenwasteController@save']);
                Route::post('/save-setting', ['as' => 'admin.gardenwaste.savesetting', 'uses' => 'GardenwasteController@saveSetting']);
                Route::get('/edit', ['as' => 'admin.gardenwaste.edit', 'uses' => 'GardenwasteController@edit']);
                Route::get('/show', ['as' => 'admin.gardenwaste.show', 'uses' => 'GardenwasteController@show']);
                Route::get('/delete', ['as' => 'admin.gardenwaste.delete', 'uses' => 'GardenwasteController@delete']);
                Route::get('/gunny-order-delete', ['as' => 'admin.gunnyorder.delete', 'uses' => 'GardenwasteController@deleteGunnyOrder']);
                Route::get('/gunny-order-edit', ['as' => 'admin.gunnyorder.edit', 'uses' => 'GardenwasteController@editGunnyOrder']);
                Route::post('/gunny-order-save', ['as' => 'admin.gunnyorder.save', 'uses' => 'GardenwasteController@saveGunnyOrder']);
                Route::get('/gunny-order', ['as' => 'admin.gunnyorder.view', 'uses' => 'GardenwasteController@gunnyOrders']);
            });
            
            Route::group(['prefix' => 'payment'], function() {
                Route::get('/', ['as' => 'admin.payment.view', 'uses' => 'PaymentController@index']);
                Route::get('/add', ['as' => 'admin.payment.add', 'uses' => 'PaymentController@add']);
                Route::get('/excel', ['as' => 'admin.payment.excel', 'uses' => 'PaymentController@exportExcel']);
                Route::post('/save', ['as' => 'admin.payment.save', 'uses' => 'PaymentController@save']);
                Route::get('/edit', ['as' => 'admin.payment.edit', 'uses' => 'PaymentController@edit']);
                Route::get('/delete', ['as' => 'admin.payment.delete', 'uses' => 'PaymentController@delete']);
                Route::post('/update', ['as' => 'admin.payment.update', 'uses' => 'PaymentController@update']);
            });

            Route::group(['prefix' => 'attendance'], function() {
                Route::get('/', ['as' => 'admin.attendance.view', 'uses' => 'AttendanceController@index']);
                Route::get('/add', ['as' => 'admin.attendance.add', 'uses' => 'AttendanceController@add']);
                Route::get('/delete', ['as' => 'admin.attendance.delete', 'uses' => 'AttendanceController@delete']);
            });
            Route::group(['prefix' => 'gallery'], function() {
                Route::get('/', ['as' => 'admin.gallery.view', 'uses' => 'GalleryController@index']);
                Route::post('/save-image', ['as' => 'admin.gallery.save', 'uses' => 'GalleryController@save']);
                Route::get('/delete', ['as' => 'admin.gallery.delete', 'uses' => 'GalleryController@delete']);
            });

            Route::group(['prefix' => 'schedule'], function() {
                Route::get('/', ['as' => 'admin.schedule.view', 'uses' => 'ScheduleController@index']);
                Route::get('/add', ['as' => 'admin.schedule.add', 'uses' => 'ScheduleController@add']);
                Route::post('/save', ['as' => 'admin.schedule.save', 'uses' => 'ScheduleController@save']);
                Route::post('/update', ['as' => 'admin.schedule.update', 'uses' => 'ScheduleController@update']);
                Route::get('/edit', ['as' => 'admin.schedule.edit', 'uses' => 'ScheduleController@edit']);
                Route::get('/show', ['as' => 'admin.schedule.show', 'uses' => 'ScheduleController@show']);
                Route::get('/map', ['as' => 'admin.schedule.map', 'uses' => 'ScheduleController@map']);
                Route::post('/duplicate', ['as' => 'admin.schedule.duplicate', 'uses' => 'ScheduleController@duplicate']);
                Route::get('/delete', ['as' => 'admin.schedule.delete', 'uses' => 'ScheduleController@delete']);
            });


            Route::group(['prefix' => 'assets'], function() {
                Route::get('/', ['as' => 'admin.assets.view', 'uses' => 'AssetsController@index']);
                Route::get('/add', ['as' => 'admin.assets.add', 'uses' => 'AssetsController@add']);
                Route::post('/save', ['as' => 'admin.assets.save', 'uses' => 'AssetsController@save']);
                Route::get('/edit', ['as' => 'admin.assets.edit', 'uses' => 'AssetsController@edit']);
                Route::get('/show', ['as' => 'admin.assets.show', 'uses' => 'AssetsController@show']);
                Route::get('/delete', ['as' => 'admin.assets.delete', 'uses' => 'AssetsController@delete']);
            });
            
            Route::group(['prefix' => 'bonfleet'], function() {
                Route::get('/', ['as' => 'admin.bonfleet.view', 'uses' => 'BonfleetController@index']);
                Route::post('/save', ['as' => 'admin.bonfleet.save', 'uses' => 'BonfleetController@save']);
                Route::get('/add', ['as' => 'admin.bonfleet.add', 'uses' => 'BonfleetController@add']);
                Route::get('/edit', ['as' => 'admin.bonfleet.edit', 'uses' => 'BonfleetController@edit']);
                Route::get('/show', ['as' => 'admin.bonfleet.show', 'uses' => 'BonfleetController@show']);
                Route::get('/delete', ['as' => 'admin.bonfleet.delete', 'uses' => 'BonfleetController@delete']);
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
                    Route::get('/profile', ['as' => 'admin.systemusers.profile', 'uses' => 'SystemUsersController@Profile']);
                    Route::post('/update', ['as' => 'admin.systemusers.update', 'uses' => 'SystemUsersController@update']);
                    Route::post('/update-password', ['as' => 'admin.systemusers.update.password', 'uses' => 'SystemUsersController@passwordUpdate']);
                    Route::get('/delete', ['as' => 'admin.systemusers.delete', 'uses' => 'SystemUsersController@delete']);
                });

                Route::group(['prefix' => 'users'], function() {
                    Route::get('/', ['as' => 'admin.users.view', 'uses' => 'SystemUsersController@users']);
                    Route::get('/add', ['as' => 'admin.users.add', 'uses' => 'SystemUsersController@addUser']);
                    Route::post('/save', ['as' => 'admin.users.save', 'uses' => 'SystemUsersController@saveUser']);
                    Route::get('/edit', ['as' => 'admin.users.edit', 'uses' => 'SystemUsersController@editUser']);
                    Route::post('/update', ['as' => 'admin.users.update', 'uses' => 'SystemUsersController@updateUser']);
                    Route::get('/rmaddress', ['as' => 'admin.users.rmaddress', 'uses' => 'SystemUsersController@rmAddress']);
                });
            });
        });
    });
    Route::group(['namespace' => 'Frontend', 'prefix' => ''], function() {
        Route::get('/', ["as" => "/", "uses" => "PageController@index"]);
        Route::any('/payment-success', ["as" => "payment.success", "uses" => "PayController@success"]);
        Route::any('/paytm', ["as" => "payment.paytm", "uses" => "PayController@paytm"]);

        Route::get('/faq', ["as" => "user.faq", "uses" => "UsersController@faq"]);
        Route::get('/gallery', ["as" => "user.gallery", "uses" => "UsersController@gallery"]);
        Route::get('/login-garden-waste', ["as" => "user.login.garden", "uses" => "UsersController@loginGarden"]);
        Route::get('/about', ["as" => "user.about", "uses" => "UsersController@about"]);
        Route::get('/contact-us', ['as' => 'user.contact.view', 'uses' => 'UsersController@contact']);
        Route::post('/save-contact', ['as' => 'user.contact.save', 'uses' => 'UsersController@saveContact']);
        Route::get('/terms', ["as" => "user.terms", "uses" => "UsersController@terms"]);
        Route::get('/privacy', ["as" => "user.privacy", "uses" => "UsersController@privacy"]);
        Route::get('/login', ["as" => "user.login", "uses" => "UsersController@login"]);
        Route::get('/user-logout', ["as" => "user.logout", "uses" => "UsersController@userLogout"]);
        Route::get('/forgot-password', ["as" => "user.forgot.password", "uses" => "UsersController@forgotPassword"]);
        Route::post('/forgot-update', ["as" => "user.forgotpassword.update", "uses" => "UsersController@updateForgotPassword"]);
        Route::post('/check-login', ["as" => "user.check.login", "uses" => "UsersController@checkUserLogin"]);
        Route::get('/password-reset', ['as' => 'user.password.reset', 'uses' => 'UsersController@passwordReset']);
        Route::post('/password-update', ['as' => 'user.password.update', 'uses' => 'UsersController@passwordUpdate']);
        Route::get('/register', ["as" => "user.register", "uses" => "UsersController@register"]);
        Route::post('/register-save', ["as" => "user.register.save", "uses" => "UsersController@registerSave"]);
        Route::post('/address-save', ["as" => "user.address.add", "uses" => "UsersController@addressSave"]);
        Route::group(['middleware' => 'CheckWebUser'], function() {
            Route::get('/garden-waste', ["as" => "garden.waste", "uses" => "UsersController@gardenWaste"]);
            Route::get('/pickup-history', ["as" => "user.pickup.history", "uses" => "UsersController@pickupHistory"]);
            Route::get('/pickup-history-view/{id}', ["as" => "pickup.history.view", "uses" => "UsersController@pickupHistoryView"]);
            Route::get('/garden-waste-gunny', ["as" => "garden.waste.emptygunny", "uses" => "UsersController@emptyGunny"]);
            Route::get('/message-us', ["as" => "user.message.view", "uses" => "UsersController@userMessage"]);
            Route::post('/message-save', ["as" => "user.message.save", "uses" => "UsersController@userMessageSave"]);
            Route::post('/garden-save-gunny', ["as" => "garden.waste.savegunny", "uses" => "UsersController@saveGunny"]);
            Route::post('/garden-waste-save', ["as" => "garden.waste.save", "uses" => "UsersController@gardenWasteSave"]);
            Route::any('/pay/{id}', ["as" => "payment.paynow", "uses" => "PayController@index"]);
            Route::get('/my-profile', ["as" => "user.myprofile.view", "uses" => "UsersController@myProfile"]);
            Route::get('/my-password', ["as" => "user.mypassword.view", "uses" => "UsersController@password"]);
            Route::get('/my-account', ["as" => "user.myaccount.view", "uses" => "UsersController@serviceSummary"]);
            Route::get('/payment-info', ["as" => "user.payment.info", "uses" => "UsersController@paymentInfo"]);
            Route::get('/user-subscription', ['as' => 'user.subscription.view', 'uses' => 'UsersController@showUserSubscription']);
            Route::post('/save-subscription', ['as' => 'user.subscription.save', 'uses' => 'UsersController@saveSubscription']);
            Route::post('/profile-update', ['as' => 'user.profile.update', 'uses' => 'UsersController@update']);
            Route::post('/password-change', ['as' => 'user.password.change', 'uses' => 'UsersController@changePassword']);
            Route::get('/users-payment-success', ["as" => "user.payment.success", "uses" => "PayController@paymentSuccess"]);
            Route::get('/pickup-order-success', ["as" => "pickup.order.success", "uses" => "PayController@pickupOrderSuccess"]);
            Route::get('/gunny-order-success', ["as" => "gunny.order.success", "uses" => "PayController@gunnyOederSuccess"]);
        });
    });
    Route::group(['namespace' => 'Frontend', 'prefix' => 'operator'], function() {
        Route::post('/login', ["as" => "operator.login", "uses" => "OperatorController@login"]);
        Route::post('/schedules', ["as" => "operator.schedules", "uses" => "OperatorController@schedules"]);
        Route::post('/pickup-details', ["as" => "operator.pickup.details", "uses" => "OperatorController@pickupDetails"]);
        Route::post('/save-service-details', ["as" => "operator.service.save", "uses" => "OperatorController@serviceSave"]);
        Route::post('/receipt-data', ["as" => "operator.receipt.data", "uses" => "OperatorController@receiptData"]);
        Route::post('/van-data', ["as" => "operator.van.data", "uses" => "OperatorController@vanData"]);
        Route::post('/schedule-list', ["as" => "operator.schedule.list", "uses" => "OperatorController@scheduleList"]);
        Route::post('/save-setting', ["as" => "operator.setting.save", "uses" => "OperatorController@settingSave"]);
        Route::post('/save-logout-time', ["as" => "operator.setting.logout", "uses" => "OperatorController@logoutSave"]);
        Route::post('/cleaning-data', ["as" => "operator.cleaning.data", "uses" => "OperatorController@cleaningData"]);
        Route::post('/attendance', ["as" => "operator.attendance", "uses" => "OperatorController@attendance"]);
        Route::post('/get-attendance', ["as" => "operator.attendance.get", "uses" => "OperatorController@getAttendance"]);
        Route::post('/update-km', ["as" => "operator.kilometer.update", "uses" => "OperatorController@kilometerUpdate"]);
        Route::post('/save-receipt-details', ["as" => "operator.receipt.save", "uses" => "OperatorController@receiptSave"]);
        Route::post('/upload-offline-data', ["as" => "upload.offline.data", "uses" => "OperatorController@offlineDataSave"]);
        Route::post('/update-location', ["as" => "operator.location.update", "uses" => "OperatorController@locationUpdate"]);
    });
});

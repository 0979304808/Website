<?php

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

Route::group(['namespace' => 'BackEnd'], function () {

    // Login và Register
    Route::group(['namespace' => 'Auth'], function () {

        Route::get('/', 'LoginController@index')->name('backend.index');
        Route::post('/login', 'LoginController@login')->name('backend.login');

        Route::get('/register', 'RegisterController@index')->name('backend.register');
        Route::post('/register', 'RegisterController@register')->name('backend.register.create');

    });

    // Login Thành công
    Route::group([
        'middleware' => 'admin'
    ], function () {

        // Dashboard và logout
        Route::get('/dashboard', 'HomeController@index')->name('backend.dashboard');
        Route::get('/logout', 'HomeController@logout')->name('backend.logout');



        // Administrator
        Route::group([
            'prefix' => 'auth',
        ], function(){
            // Account
            Route::group([
                'prefix' => 'accounts',
                'namespace' => 'Auth',
                'middleware' => ['role:administrator']
            ], function(){
                Route::get('/', 'AccountController@list')->name('backend.account');
                Route::put('/', 'AccountController@active')->name('backend.account.active');
                Route::put('update-role', 'AccountController@updateRoleAdmin')->name('backend.account.update.role');
                Route::put('update-permission', 'AccountController@updatePermissionAdmin')->name('backend.account.update.permission');
            });

            // Role
            Route::group([
                'prefix' => 'roles',
                'namespace' => 'Auth',
                'middleware' => ['role:administrator']
            ], function(){
                Route::get('/', 'RoleController@list')->name('backend.role');
                Route::post('/', 'RoleController@create')->name('backend.role.create');
                Route::put('add-permission', 'RoleController@addPermissionToRole')->name('backend.role.add.permission');
                Route::delete('/', 'RoleController@delete')->name('backend.role.delete');
            });

            // Permission
            Route::group([
                'prefix' => 'permissions',
                'namespace' => 'Auth',
                'middleware' => ['role:administrator']
            ], function(){
                Route::get('/', 'PermissionController@list')->name('backend.permission');
                Route::post('/', 'PermissionController@create')->name('backend.permission.create');
            });

            // Profile
            Route::group([
                'prefix' => 'profile',
                'namespace' => 'Admins'
            ], function(){
                Route::group([
                    'prefix' => '{admin}',
                    'where' => ['admin', '[0-9]+']
                ], function(){
                    Route::get('/', 'AdminController@profile')->name('backend.profile');
                    Route::put('image', 'AdminController@updateImage')->name('backend.profile.image');
                    Route::put('update', 'AdminController@updateProfile')->name('backend.profile.update');
                });

            });
        });
    });




});

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
        ], function () {
            // Account
            Route::group([
                'prefix' => 'accounts',
                'namespace' => 'Auth',
                'middleware' => ['role:administrator']
            ], function () {
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
            ], function () {
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
            ], function () {
                Route::get('/', 'PermissionController@list')->name('backend.permission');
                Route::post('/', 'PermissionController@create')->name('backend.permission.create');
            });

            // Profile
            Route::group([
                'prefix' => 'profile',
                'namespace' => 'Admins'
            ], function () {
                Route::group([
                    'prefix' => '{admin}',
                    'where' => ['admin', '[0-9]+']
                ], function () {
                    Route::get('/', 'AdminController@profile')->name('backend.profile');
                    Route::put('image', 'AdminController@updateImage')->name('backend.profile.image');
                    Route::put('update', 'AdminController@updateProfile')->name('backend.profile.update');
                });

            });
        });


        // Post
        Route::group([
            'prefix' => 'post',
            'namespace' => 'Posts',
            'middleware' => ['role:administrator|manager|editor']
        ], function () {

            Route::get('/', 'PostController@list')->name('backend.post');
            Route::put('/category', 'PostController@UpdatePostCategory')->name('backend.post.category');
            Route::put('/tag', 'PostController@UpdatePostTag')->name('backend.post.tag');
            Route::delete('/delete', 'PostController@delete')->name('backend.post.delete');

            Route::get('/create', 'PostController@form')->name('backend.post.form');
            Route::post('/create', 'PostController@create')->name('backend.post.create');

        });

        // Category
        Route::group([
            'prefix' => 'category',
            'namespace' => 'Categories'
        ], function () {

            Route::get('/', 'CategoryController@list')->name('backend.category');
            Route::post('/create', 'CategoryController@createOrupdate')->name('backend.category.create');
            Route::delete('/delete', 'CategoryController@delete')->name('backend.category.delete');

        });

        // Tag
        Route::group([
            'prefix' => 'tag',
            'namespace' => 'Tags'
        ], function () {

            Route::get('/', 'TagController@list')->name('backend.tag');
            Route::post('/create', 'TagController@createOrupdate')->name('backend.tag.create');
            Route::delete('/delete', 'TagController@delete')->name('backend.tag.delete');

        });

        // code
        Route::group([
            'prefix' => 'code',
            'namespace' => 'Code',
            'middleware' => ['role:administrator']
        ], function () {
            Route::get('/transaction', 'CodeController@transaction')->name('backend.code.transaction');
            Route::get('/codesended', 'CodeController@codesended')->name('backend.code.codesended');
            Route::get('/codepurchase', 'CodeController@codepurchase')->name('backend.code.getcodepurchase');
            Route::post('/recalled', 'CodeController@recalled')->name('backend.code.recalled');

        });

        // users
        Route::group([
            'prefix' => 'user',
            'namespace' => 'Users',
            'middleware' => ['role:administrator']
        ], function () {
            Route::get('/usersubscribe', 'UserController@usersubscribe')->name('backend.user.usersubscribe');
        });


        // Social
        Route::group([
            'prefix' => 'social',
            'namespace' => 'Socials',
            'middleware' => ['role:administrator|manager']
        ], function () {


            // Account
            Route::group([
                'prefix' => 'accounts'
            ], function () {
                Route::get('/', 'AccountController@index')->name('backend.social.account');
                Route::post('/', 'AccountController@create')->name('backend.social.account.create');
                Route::delete('/', 'AccountController@delete')->name('backend.social.account.delete');
            });

            // JLPT
            Route::group([
                'prefix' => 'jlpt'
            ], function () {
                Route::get('/', 'JlptController@index')->name('backend.social.jlpt.index');
                Route::get('/create', 'JlptController@create')->name('backend.social.jlpt.create');
                Route::post('/store', 'JlptController@createOrUpdate')->name('backend.social.jlpt.store');
                Route::delete('/delete', 'JlptController@delete')->name('backend.social.jlpt.delete');
            });
        });

    });
});


//routes for ckeditor
Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');
Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');
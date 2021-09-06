<?php
use App\Permission;
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

// Route::delete('/role','BackEnd\Auth\RoleController@delete');


Route::get('/codepurchase','BackEnd\Code\CodeController@codepurchase');

Route::post('/create', 'BackEnd\Socials\PostController@createOrUpdate')->name('backend.social.post.createOrupdate');

Route::post('/test','BackEnd\Socials\PostController@index');

<?php

use App\Mail\RegistrationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('/login', 'LoginController@login');
Route::post('/register', 'UsersController@register');

//Route::middleware('')
//u requestu Authrization header Bearer token

Route::get('catgroup', 'CategoryGroupsController@index');
Route::post('catgroup', 'CategoryGroupsController@store');
Route::get('catgroup/{id}', 'CategoryGroupsController@show');
Route::put('catgroup/{id}', 'CategoryGroupsController@update');
Route::delete('catgroup/{id}', 'CategoryGroupsController@destroy');

Route::get('categories', 'CategoriesController@index');
Route::post('categories', 'CategoriesController@store');
Route::get('categories/{id}', 'CategoriesController@show');
Route::put('categories/{id}', 'CategoriesController@update');
Route::delete('categories/{id}', 'CategoriesController@destroy');

Route::get('countries', 'CountriesController@index');
Route::post('countries', 'CountriesController@store');
Route::get('countries/{id}', 'CountriesController@show');
Route::put('countries/{id}', 'CountriesController@update');
Route::delete('countries/{id}', 'CountriesController@destroy');

Route::get('cities', 'CitiesController@index');
Route::post('cities', 'CitiesController@store');
Route::get('cities/{id}', 'CitiesController@show');
Route::put('cities/{id}', 'CitiesController@update');
Route::delete('cities/{id}', 'CitiesController@destroy');

Route::get('statuses', 'TransactionStatusesController@index');
Route::post('statuses', 'TransactionStatusesController@store');
Route::get('statuses/{id}', 'TransactionStatusesController@show');
Route::put('statuses/{id}', 'TransactionStatusesController@update');
Route::delete('statuses/{id}', 'TransactionStatusesController@destroy');

Route::get('catrequests', 'CategoryRequestsController@index');
Route::post('catrequests', 'CategoryRequestsController@store');
Route::get('catrequests/{id}', 'CategoryRequestsController@show');
Route::put('catrequests/{id}/accept', 'CategoryRequestsController@acceptRequest');
Route::delete('catrequests/{id}', 'CategoryRequestsController@destroy');

Route::get('roles', 'RolesController@index');
Route::post('roles', 'RolesController@store');
Route::get('roles/{id}', 'RolesController@show');
Route::put('roles/{id}', 'RolesController@update');
Route::delete('roles/{id}', 'RolesController@destroy');

Route::get('product', 'ProductsController@index');
Route::post('product', 'ProductsController@store');
Route::get('product/{id}', 'ProductsController@show');
Route::put('product/{id}', 'ProductsController@update');
Route::delete('product/{id}', 'ProductsController@destroy');

Route::get('promotion', 'PromotionRequestsController@index');
Route::post('promotion', 'PromotionRequestsController@store');
Route::get('promotion/{id}', 'PromotionRequestsController@show');
Route::put('promotion/{id}', 'PromotionRequestsController@update');
Route::put('promotion/{id}/approve', 'PromotionRequestsController@approveRequest');
Route::put('promotion/{id}/decline', 'PromotionRequestsController@declineRequest');
Route::delete('promotion/{id}', 'PromotionRequestsController@destroy');

//Route::get('roles', 'RolesController@index');
//Route::post('roles', 'RolesController@store');
//Route::get('roles/{id}', 'RolesController@show');
//Route::put('roles/{id}', 'RolesController@update');
Route::delete('users/{id}', 'UsersController@destroy');

Route::get('/registrationmail', function(){
    Mail::to('email@email.com')->send(new RegistrationMail("Marko", "Markic"));
});

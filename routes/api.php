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

Route::post('/login', 'LoginController@login');
Route::post('/register', 'UsersController@register');

Route::middleware('auth:api')->group(function(){
    Route::post('catgroup', 'CategoryGroupsController@store');
    Route::put('catgroup/{id}', 'CategoryGroupsController@update');
    Route::delete('catgroup/{id}', 'CategoryGroupsController@destroy');

    Route::post('categories', 'CategoriesController@store');
    Route::post('categories/{id}', 'CategoriesController@update');
    Route::delete('categories/{id}', 'CategoriesController@destroy');

    Route::post('statuses', 'TransactionStatusesController@store');
    Route::put('statuses/{id}', 'TransactionStatusesController@update');
    Route::delete('statuses/{id}', 'TransactionStatusesController@destroy');

    Route::post('coupons', 'CouponsController@store');
    Route::delete('coupons/{id}', 'CouponsController@destroy');

    Route::post('catrequests', 'CategoryRequestsController@store');
    Route::put('catrequests/{id}/accept', 'CategoryRequestsController@acceptRequest');
    Route::delete('catrequests/{id}', 'CategoryRequestsController@destroy');

    Route::post('roles', 'RolesController@store');
    Route::put('roles/{id}', 'RolesController@update');
    Route::delete('roles/{id}', 'RolesController@destroy');

    Route::delete('cart-item/{itemId}', 'CartItemsController@destroy');

    Route::post('product', 'ProductsController@store');
    Route::post('product/{id}', 'ProductsController@update');
    Route::post('product/{id}/comments', 'CommentsController@store');
    Route::delete('comments/{id}', 'CommentsController@destroy');
    Route::get('comments/{id}', 'CommentsController@show');

    Route::post('promotion', 'PromotionRequestsController@store');
    Route::put('promotion/{id}', 'PromotionRequestsController@update');
    Route::put('promotion/{id}/approve', 'PromotionRequestsController@approveRequest');
    Route::put('promotion/{id}/decline', 'PromotionRequestsController@declineRequest');
    Route::delete('promotion/{id}', 'PromotionRequestsController@destroy');

    Route::put('users/{id}/promote', 'UsersController@promote');
    Route::put('users/{id}/demote', 'UsersController@demote');
    Route::post('users/{id}', 'UsersController@update');
    Route::post('users/{userId}/buy/{productId}', 'UsersController@buyProduct');
    Route::delete('users/{id}', 'UsersController@destroy');
    Route::put('users/{id}/change-password', 'UsersController@changePassword');

    Route::post('transactions', 'TransactionsController@store');
    Route::put('transactions/{id}', 'TransactionsController@update');
    Route::put('transactions/{id}/cancel', 'TransactionsController@cancelTransaction');
    Route::put('transactions/{id}/ship', 'TransactionsController@shipTransaction');
    Route::delete('transactions/{id}', 'TransactionsController@destroy');
});

Route::get('catgroup', 'CategoryGroupsController@index');
Route::get('catgroup/{id}', 'CategoryGroupsController@show');
Route::get('catgroup/{id}/categories', 'CategoryGroupsController@getCategoriesUnderGroup');

Route::get('categories', 'CategoriesController@index');
Route::get('categories/{id}', 'CategoriesController@show');

Route::get('statuses', 'TransactionStatusesController@index');
Route::get('statuses/{id}', 'TransactionStatusesController@show');

Route::get('coupons', 'CouponsController@index');
Route::get('coupons/{code}', 'CouponsController@show');

Route::get('catrequests', 'CategoryRequestsController@index');
Route::get('catrequests/{id}', 'CategoryRequestsController@show');

Route::get('roles', 'RolesController@index');
Route::get('roles/{id}', 'RolesController@show');

Route::get('product', 'ProductsController@index');
Route::get('product/home', 'ProductsController@homePageProducts');
Route::get('product/{id}', 'ProductsController@show');
Route::get('product/{id}/comments', 'CommentsController@commentsOnProduct');

Route::get('promotion', 'PromotionRequestsController@index');
Route::get('promotion/{id}', 'PromotionRequestsController@show');

Route::get('cart', 'CartsController@index');
Route::get('cart/{id}', 'CartsController@getCartWithId');
Route::get('cart/{id}/items', 'CartsController@cartItems');

Route::get('users', 'UsersController@index');
Route::get('users/{id}', 'UsersController@show');
Route::get('users/{id}/can-promote', 'UsersController@isEligibleForPromotion');
Route::get('users/{id}/transactions', 'TransactionsController@usersTransactions');
Route::get('users/{id}/orders', 'TransactionsController@usersOrders');
Route::get('users/{id}/cart', 'UsersController@usersCart');
Route::get('users/{id}/products', 'UsersController@getAllUsersProducts');
Route::get('users/{id}/latest-comments', 'CommentsController@latestCommentsOnUsersProducts');
Route::get('users/{id}/profit', 'ProductsController@profit');
Route::get('users/{id}/coupons', 'CouponsController@usersCoupons');

Route::get('transactions', 'TransactionsController@index');
Route::get('transactions/{id}', 'TransactionsController@show');

Route::get('/profilePicture/{name}', 'ImagesController@profilePicture');
Route::get('/productImage/{id}', 'ImagesController@productImage');

Route::get('/registrationmail', function(){
    Mail::to('email@email.com')->send(new RegistrationMail("Marko", "Markic"));
});
Route::get('/ordermail', function(){
    Mail::to('email@email.com')->send(new \App\Mail\OrderedMail("Marko", "Markic", "Bikini", "2"));
});
Route::get('/shippedmail', function(){
    Mail::to('email@email.com')->send(new \App\Mail\ShippedItemMail("Bikini"));
});

<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes([
    'verify' => true,
    'reset' => true,
]);

Route::get('/', 'HomeController@index')->name('home');

// Authenticated
Route::group(['middleware' => 'auth'], function () {

    // Admin
    Route::group(['middleware' => 'role:admin', 'namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::resource('users', 'UserController');
        Route::post('users/find', 'UserController@searchByKeyword')->name('users.search');

        Route::resource('communities', 'CommunityController');
        Route::get('communities/member/{id}', 'CommunityController@ajaxMember')->name('communities.find_member');
        Route::put('communities/member/{id}', 'CommunityController@updateMemberRole')->name('communities.update_member');
        Route::delete('communities/member/{id}', 'CommunityController@deleteMember');
        Route::post('communities/member', 'CommunityController@addMember')->name('communities.add_member');
        Route::resource('events', 'CommunityEventController');
        Route::post('events/attendee/add', 'CommunityEventController@addAttendee')->name('events.add_attendee');
        Route::delete('events/attendee/remove', 'CommunityEventController@removeAttendee')->name('events.remove_attendee');
        Route::resource('proposals', 'CommunityProposalController')->except(['store', 'create', 'destroy']);

        Route::resource('stores', 'StoreController');
        Route::resource('products', 'ProductController');
        Route::get('products/{id}/images', 'ProductController@addImage')->name('products.add_image');
        Route::post('products/{id}/images', 'ProductController@uploadImage')->name('products.upload_image');
        Route::delete('products/{id}/images', 'ProductController@deleteImage')->name('products.delete_image');
        Route::resource('payments', 'PaymentController')->only(['index', 'show', 'update']);
        Route::resource('withdrawals', 'WithdrawController')->only(['index', 'edit', 'update']);
    });

    // Seller
    Route::group(['middleware' => 'role:seller', 'namespace' => 'Seller', 'prefix' => 'seller', 'as' => 'seller.'], function () {
       Route::get('dashboard', 'DashboardController@index')->name('dashboard');
       Route::get('community', 'CommunityController@index')->name('community.index');
       Route::get('community/edit', 'CommunityController@edit')->name('community.edit');
       Route::put('community', 'CommunityController@update')->name('community.update');
       Route::resource('events', 'CommunityEventController');
       Route::post('events/attendee/add', 'CommunityEventController@addAttendee')->name('events.add_attendee');
       Route::delete('events/attendee/remove', 'CommunityEventController@removeAttendee')->name('events.remove_attendee');
       Route::get('store', 'StoreController@index')->name('store.index');
       Route::get('store/edit', 'StoreController@edit')->name('store.edit');
       Route::put('store', 'StoreController@update')->name('store.update');
       Route::resource('products', 'ProductController');
       Route::get('products/{id}/images', 'ProductController@addImage')->name('products.add_image');
       Route::post('products/{id}/images', 'ProductController@uploadImage')->name('products.upload_image');
       Route::delete('products/{id}/images', 'ProductController@deleteImage')->name('products.delete_image');
       Route::resource('withdrawals', 'WithdrawController')->except(['destroy', 'edit', 'update']);
       Route::resource('orders', 'OrderController')->except(['destroy', 'create', 'store']);
    });

    // User
    Route::group(['middleware' => 'role:user'], function () {
        Route::group(['prefix' => 'account', 'namespace' => 'User', 'as' => 'user.'], function () {
            Route::get('orders', 'UserController@orders')->name('orders');
            Route::get('orders/{order}', 'UserController@show')->name('orders.show');
            Route::put('orders/{order}', 'UserController@updateOrder')->name('orders.update');
            Route::get('overview', 'UserController@overview')->name('overview');
            Route::get('community/propose', 'UserController@propose')->name('community.propose');
            Route::post('community', 'UserController@storeProposal')->name('community.propose.store');
        });
    });

    Route::get('cart', 'CartController@index')->name('cart');
    Route::post('cart/{product}', 'CartController@addItem')->name('cart.add_item');
    Route::get('cart/refresh', 'CartController@refresh')->name('cart.refresh');
    Route::put('cart/quantity', 'CartController@updateItem')->name('cart.update_item');
    Route::delete('cart', 'CartController@removeItem')->name('cart.delete_item');
    Route::get('checkout', 'CheckoutController@index')->name('checkout');
    Route::post('checkout/process', 'CheckoutController@process')->name('checkout.process');
    Route::get('checkout/success', 'CheckoutController@success')->name('checkout.success');
    Route::post('/rate/{product}', 'ProductController@rate')->name('product.rate');
    Route::post('events/{event}/register', 'HomeController@registerEvent')->name('community.event.register');
});

Route::get('/ajax/provinces', 'AjaxController@provinces')->name('ajax.provinces');
Route::get('/ajax/cities/{province}', 'AjaxController@cities')->name('ajax.cities');
Route::post('/ajax/shipping', 'AjaxController@shippingRate')->name('ajax.shipping');

Route::view('/about-us', 'frontpages.about')->name('about_us');
Route::get('/c/{community}', 'HomeController@show')->name('community.show');
Route::get('/events/{event}', 'HomeController@event')->name('community.event.show');
Route::get('/category/{category}', 'ProductController@category')->name('category');
Route::get('/products', 'ProductController@index')->name('products');
Route::get('/{store}/{product}', 'ProductController@show')->name('product.show');


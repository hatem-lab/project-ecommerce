
<?php

use Illuminate\Support\Facades\Route;



Auth::routes();
Route::get('/','site\SiteController@index') -> name('home');
route::get('category/{name}', 'site\SiteController@productsBySlug')->name('category');
route::get('product/{name}', 'site\SiteController@productsBySlug')->name('product.details');

Route::group(['middleware' => 'auth'], function () {

    Route::post('verify-user/', 'site\VerificationCodeController@verify')->name('verify-user');
    Route::get('verify', 'site\VerificationCodeController@getVerifyPage')->name('get.verification.form');
    Route::post('wishlist', 'site\WishlistController@store')->name('wishlist.store');
    Route::get('wishlist/products', 'site\WishlistController@index')->name('wishlist.products.index');
    Route::delete('wishlist/{id}', 'site\WishlistController@destroy');

    Route::group(['prefix' => 'cart'], function () {
        Route::get('/', 'site\CartController@getIndex')->name('site.cart.index');
         Route::post('/cart/add/', 'site\CartController@postAdd')->name('site.cart.add');
        Route::post('/update/{name}', 'site\CartController@postUpdate')->name('site.cart.update');
        Route::post('/update-all', 'site\CartController@postUpdateAll')->name('site.cart.update-all');
    });
});








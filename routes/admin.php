<?php

use Illuminate\Support\Facades\Route;

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



Auth::routes();

Route::group(['middleware' => 'auth:admin'], function () {

    Route::group(['namespace' => 'Admin'], function () {
        Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
        ######################### Begin Languages Route ########################
        Route::group(['prefix' => 'languages'], function () {
            Route::get('/','LanguageController@index') -> name('admin.languages');
            Route::get('create','LanguageController@create') -> name('admin.languages.create');
            Route::post('store','LanguageController@store') -> name('admin.languages.store');

            Route::get('edit/{id}','LanguageController@edit') -> name('admin.languages.edit');
            Route::post('update/{id}','LanguageController@update') -> name('admin.languages.update');

            Route::get('delete/{id}','LanguageController@destroy') -> name('admin.languages.delete');
        });

    ######################### End Languages Route ########################


        ######################### Begin Main Categoris Routes ########################
        Route::group(['prefix' => 'main_categories'], function () {
            Route::get('/','MainCategoryController@index') -> name('admin.maincategories');
            Route::get('create','MainCategoryController@create') -> name('admin.maincategories.create');
            Route::post('store','MainCategoryController@store') -> name('admin.maincategories.store');
            Route::get('edit/{id}','MainCategoryController@edit') -> name('admin.maincategories.edit');
            Route::post('update/{id}','MainCategoryController@update') -> name('admin.maincategories.update');
            Route::get('delete/{id}','MainCategoryController@destroy') -> name('admin.maincategories.delete');
            Route::get('changeStatus/{id}','MainCategoryController@changeStatus') -> name('admin.maincategories.status');

        });

         ######################### Begin Sub Categoris Routes ########################
         Route::group(['prefix' => 'sub_categories'], function () {
            Route::get('/','SubCategoryController@index') -> name('admin.subcategories');
            Route::get('create','SubCategoryController@create') -> name('admin.subcategories.create');
            Route::post('store','SubCategoryController@store') -> name('admin.subcategories.store');
            Route::get('edit/{id}','SubCategoryController@edit') -> name('admin.subcategories.edit');
            Route::post('update/{id}','SubCategoryController@update') -> name('admin.subcategories.update');
            Route::get('delete/{id}','SubCategoryController@destroy') -> name('admin.subcategories.delete');
            Route::get('changeStatus/{id}','SubCategoryController@changeStatus') -> name('admin.subcategories.status');

        });
        Route::group(['prefix' => 'vendors'], function () {
            Route::get('/','VendorController@index') -> name('admin.vendors');
            Route::get('create','VendorController@create') -> name('admin.vendors.create');
            Route::post('store','VendorController@store') -> name('admin.vendors.store');
            Route::get('edit/{id}','VendorController@edit') -> name('admin.vendors.edit');
            Route::post('update/{id}','VendorController@update') -> name('admin.vendors.update');
            Route::get('delete/{id}','VendorController@destroy') -> name('admin.vendors.delete');
            Route::get('changeStatus/{id}','VendorController@changeStatus') -> name('admin.vendors.status');
        });
         ######################### Begin Products Routes ########################
        Route::group(['prefix' => 'products'], function () {
            Route::get('/','ProductController@index') -> name('admin.products');
            Route::get('create','ProductController@create') -> name('admin.products.create');
            Route::post('store','ProductController@store') -> name('admin.products.store');
            Route::get('edit/{id}','ProductController@edit') -> name('admin.products.edit');
            Route::post('update/{id}','ProductController@update') -> name('admin.products.update');
            Route::get('delete/{id}','ProductController@destroy') -> name('admin.products.delete');
            Route::get('changeStatus/{id}','ProductController@changeStatus') -> name('admin.products.status');
        });
        Route::group(['prefix' => 'sliders'], function () {
            Route::get('/', 'SliderController@addImages')->name('admin.sliders.create');
            Route::post('images', 'SliderController@saveSliderImages')->name('admin.sliders.images.store');
            Route::post('images/db', 'SliderController@saveSliderImagesDB')->name('admin.sliders.images.store.db');

        });
    });



});

Route::group(['namespace'=>'Admin','middleware' => ['guest:admin']], function () {
Route::get('/login', 'LoginController@getLogin')->name('admin.getLogin');
Route::post('/login', 'LoginController@login')->name('admin.login');
});


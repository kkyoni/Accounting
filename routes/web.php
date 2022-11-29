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

Route::group(['middleware' => 'preventBackHistory'],function(){
	Route::get('/', 'HomeController@welcome')->name('welcome');
	Route::get('admin','Admin\Auth\LoginController@showLoginForm')->name('admin.showLoginForm');
	Route::get('admin/login','Admin\Auth\LoginController@showLoginForm')->name('admin.login');
	Route::post('admin/login', 'Admin\Auth\LoginController@login');
	Route::get('admin/resetPassword','Admin\Auth\PasswordResetController@showPasswordRest')->name('admin.resetPassword');
	Route::post('admin/sendResetLinkEmail', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('admin.sendResetLinkEmail');
	Route::get('admin/find/{token}', 'Admin\Auth\PasswordResetController@find')->name('admin.find');
	Route::post('admin/create', 'Admin\Auth\PasswordResetController@create')->name('admin.sendLinkToUser');
	Route::post('admin/reset', 'Admin\Auth\PasswordResetController@reset')->name('admin.resetPassword_set');
		
	Route::group(['prefix' => 'admin','middleware'=>'Admin','namespace' => 'Admin','as' => 'admin.'],function(){
		Route::get('/dashboard','MainController@dashboard')->name('dashboard');
		Route::get('/logout','Auth\LoginController@logout')->name('logout');
		
		//====================> Update Admin Profile =========================
		Route::get('/profile','UsersController@updateProfile')->name('profile');
		Route::post('/updateProfileDetail','UsersController@updateProfileDetail')->name('updateProfileDetail');
		Route::post('/updatePassword','UsersController@updatePassword')->name('updatePassword');

		//====================> Transaction Management =========================
		Route::get('/transaction','TransactionController@index')->name('transaction.index');
		Route::get('/transaction/create','TransactionController@create')->name('transaction.create');
		Route::post('/transaction/store','TransactionController@store')->name('transaction.store');
		Route::post('/transaction/delete/{id}','TransactionController@delete')->name('transaction.delete');
		Route::get('/transaction/show','TransactionController@show')->name('transaction.show');
		Route::get('/transaction/edit/{id}','TransactionController@edit')->name('transaction.edit');
		Route::post('/transaction/update/{id}','TransactionController@update')->name('transaction.update');
		Route::post('/transaction/filter_by_button','TransactionController@index')->name('transaction.filter_by_button');
		Route::post('/transaction/get_sub_category','TransactionController@get_sub_category')->name('transaction.get_sub_category');
		Route::get('/transaction/importshow','TransactionController@importshow')->name('transaction.importshow');
		Route::post('/transaction/importdata', 'TransactionController@importdata')->name('transaction.importdata');
		Route::post('/transaction/change_status', 'TransactionController@change_status')->name('transaction.change_status');

		//====================> Currency Management =========================
		Route::get('/currency','CurrencyController@index')->name('currency.index');
		Route::get('/currency/create','CurrencyController@create')->name('currency.create');
		Route::post('/currency/store','CurrencyController@store')->name('currency.store');
		Route::post('/currency/delete/{id}','CurrencyController@delete')->name('currency.delete');
		Route::get('/currency/edit/{id}','CurrencyController@edit')->name('currency.edit');
		Route::post('/currency/update/{id}','CurrencyController@update')->name('currency.update');

		//====================> Country Management =========================
		Route::get('/country','CountryController@index')->name('country.index');
		Route::get('/country/create','CountryController@create')->name('country.create');
		Route::post('/country/store','CountryController@store')->name('country.store');
		Route::get('/country/edit/{id}','CountryController@edit')->name('country.edit');
		Route::post('/country/update/{id}','CountryController@update')->name('country.update');

		//====================> Category Management =========================
		Route::get('/category','CategoryController@index')->name('category.index');
		Route::get('/category/create','CategoryController@create')->name('category.create');
		Route::post('/category/store','CategoryController@store')->name('category.store');
		Route::get('/category/edit/{id}','CategoryController@edit')->name('category.edit');
		Route::post('/category/update/{id}','CategoryController@update')->name('category.update');

		//====================> SubCategory Management =========================
		Route::get('/subcategory','SubCategoryController@index')->name('subcategory.index');
		Route::get('/subcategory/create','SubCategoryController@create')->name('subcategory.create');
		Route::post('/subcategory/store','SubCategoryController@store')->name('subcategory.store');
		Route::get('/subcategory/edit/{id}','SubCategoryController@edit')->name('subcategory.edit');
		Route::post('/subcategory/update/{id}','SubCategoryController@update')->name('subcategory.update');

		//====================> Type Management =========================
		Route::get('/inwardtype','TypeController@index_inward')->name('type.inwardtype');
		Route::get('/outwardtype','TypeController@index_outward')->name('type.outwardtype');
		Route::get('/othertype','TypeController@index_other')->name('type.othertype');

		//====================> Payment Type Management =========================
		Route::get('/paymenttype','PaymentTypeController@index')->name('paymenttype.index');
		Route::get('/paymenttype/create','PaymentTypeController@create')->name('paymenttype.create');
		Route::post('/paymenttype/store','PaymentTypeController@store')->name('paymenttype.store');
		Route::get('/paymenttype/edit/{id}','PaymentTypeController@edit')->name('paymenttype.edit');
		Route::post('/paymenttype/update/{id}','PaymentTypeController@update')->name('paymenttype.update');

		//====================> Report Management =========================
		Route::get('/report','ReportController@index')->name('report.index');
		Route::post('/report/filter_by_button','ReportController@index')->name('report.filter_by_button');

		//====================> Report Management =========================
		Route::get('/companies','CompaniesController@index')->name('companies.index');
		Route::get('/bank','BankController@index')->name('bank.index');
		Route::get('/clients','CompaniesController@index_clients')->name('clients.index_clients');
	});
});
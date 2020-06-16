<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', 'HomeController@index')
     ->middleware('guest')
     ->name('home');

Route::name('dashboard.')
     ->prefix('/dashboard')
     ->middleware('auth')
     ->group(function () {
         Route::get('/', 'DashboardController@index')->name('index');
         Route::get('/edit', 'DashboardController@edit')->name('edit');
         Route::put('/edit', 'DashboardController@update')->name('update');
     });

Route::name('asigment.')
     ->middleware('is:student,admin')
     ->group(function () {
         Route::get('/new', 'AsigmentController@create')->name('create');
         Route::post('/new', 'AsigmentController@store')->name('store');
         Route::get('/edit/{id}', 'AsigmentController@edit')->name('edit');
         Route::post('/edit/{id}', 'AsigmentController@editStore')->name('editStore');


         Route::prefix('/asigment/{id}')
              ->middleware('owns:student,asigment')
              ->group(function () {
                  Route::get('/', 'AsigmentController@index')->name('index');
                  Route::put('/', 'AsigmentController@update')->name('update');
                  Route::delete('/', 'AsigmentController@delete')->name('delete');
 
		  Route::post('/', 'AsigmentController@finish')->name('finish');

              });

         Route::prefix('/asigment/{id}')
              ->middleware('is:admin')
              ->group(function () {
                  Route::post(
                      '/deposit-voucher',
                      'AsigmentController@storeDepositVoucher'
                  )->name('deposit-voucher');
              });
     });

Route::prefix('/asigment/{id}/checkout')
     ->middleware('is:student')
     ->group(function () {
         Route::get('/', 'CheckoutController@index')->name('checkout.index');
         Route::get('/success', 'CheckoutController@success')->name(
             'checkout.success'
         );
         Route::post('/create', 'CheckoutController@prepare')->name(
             'payment.create'
         );
         Route::get('/execute', 'CheckoutController@execute')->name(
             'payment.execute'
         );
     });

Route::get('/asigment/{id}/room', 'RoomController@index')
     ->middleware('auth')
     ->name('room');

Route::name('invitation.')
     ->prefix('/invitation')
     ->middleware('is:teacher', 'owns:teacher,invitation')
     ->group(function () {
         Route::get('/{id}', 'InvitationController@show')->name('show');
         Route::put('/{id}/{answer}', 'InvitationController@update')
              ->name('update')
              ->where('answer', '[0-1]');
     });

Route::name('choose-account-type')
     ->prefix('/choose-account-type')
     ->middleware('auth')
     ->group(function () {
         Route::get('/', 'ChooseAccountTypeController@index');
         Route::post('/', 'ChooseAccountTypeController@decide');
     });

Route::name('questions')
     ->prefix('questions/{step}')
     ->middleware('is:teacher')
     ->group(function () {
         Route::get('/', 'QuestionsController@index')->where('step', '[1-4]');
         Route::post('/', 'QuestionsController@store')->where('step', '[1-4]');
     });

Route::name('rate.')
     ->prefix('rate/{id}')
     ->middleware('is:student')
     ->group(function () {
         Route::get('/', 'RatesController@index')->name('index');
         Route::post('/', 'RatesController@create')->name('create');
     });

Route::name('teacher.')
     ->prefix('/teachers')
     ->middleware('is:admin,teacher')
     ->group(function () {
         Route::post('/{id}/status', 'TeachersController@updateStatus')->name('status');
         Route::post('/{id}', 'TeachersController@update')->name('update');
         Route::put('/{id}/schedule', 'TeachersController@updateSchedule')->name(
             'schedule'
         );
     });
Route::name('admin.')
     ->prefix('/admin')
     ->group(function () {
	 Route::put('/{id}', 'DashboardController@editarAdmin')->name('editaAdmin');
     });

Route::get('/terms', 'TermsController@index')->name('terms');
Route::get('/privacy-policy', 'PrivacyPolicyController@index')->name(
    'privacy-policy'
);

// Password reset link request routes...
Route::get('password/email', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@resetPassword')->name('password.reseta');

<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', 'PagesController@home');
Route::post('/processLogin','PagesController@processLogin');

Route::get('/home','PagesController@home');

Route::get('/register','PagesController@register');
Route::post('/processRegister','PagesController@processRegister');

Route::get('/forgot','PagesController@forgotPass');
Route::post('/processForgotPassword','PagesController@processForgotPassword');

Route::get('/resetPass/{email?}','PagesController@resetPass');
Route::post('/resetPass/processResetPass','PagesController@processResetPass');

Route::post('/submitPage','PagesController@submitPage');

Route::get('/logout','PagesController@logout');

ROute::get('/x',function(){
	echo "welcome";});

Route::get('/y','MyController@greet');

Route::any('/email',function(){
	Mail::send('/home', array('key' => 'value'), function($message)
	{
		$message->to('rickyshen1991@hotmail.com', 'Ricky Chen')->subject('Welcome to Note-To-Myself!');
	});
});

Route::get('verify/{code}/{email}', 'PagesController@verify');

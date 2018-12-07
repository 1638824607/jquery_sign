<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

# 首页
Route::get('/',  'IndexController@index')->name('home');

# 小说
Route::get('book_detail/{id}',  'BookController@book_detail')->where('id', '[0-9]+');
Route::get('book_chapter_detail/{id}/{bookid?}',  'BookController@book_chapter_detail')->where('id', '[0-9]+')->where('bookid', '[0-9]+');
Route::get('book_recommend',  'BookController@book_recommend');
Route::get('book_list/{reader_type?}/{type?}/{word?}/{order?}',  'BookController@book_list');
Route::get('book_comment/{id}',  'BookController@book_comment')->where('id', '[0-9]+');
Route::get('book_author/{bookid}/{authorname}',  'BookController@book_author');
Route::post('book_collect',  'BookController@book_collect');
Route::get('search/{content?}',  'SearchController@index');

# 用户
Route::get('user',  'UserController@index');
Route::post('user_save', 'UserController@save');
Route::post('register', 'UserController@register');
Route::post('logout', 'UserController@logout');
Route::post('login', 'UserController@login');
Route::get('login', 'UserController@login');

# 邮件发送
Route::post('send_email',  'EmailController@send_email');

Route::get('download_android_apk',  'IndexController@download_android_apk');
Route::get('error',  'IndexController@error');
Route::get('privacy',  'IndexController@privacy');
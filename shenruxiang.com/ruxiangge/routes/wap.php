<?php

/*
|--------------------------------------------------------------------------
| Wab Routes
|--------------------------------------------------------------------------
*/

# 首页
Route::get('/',  'IndexController@index')->name('home');

# 小说
Route::get('book_detail/{id}',  'BookController@book_detail')->where('id', '[0-9]+');
Route::get('book_dir/{id?}/{sort?}/{page?}',  'BookController@book_dir')->where('id', '[0-9]+');
Route::get('book_chapter_detail/{id}/{bookid?}',  'BookController@book_chapter_detail')->where('id', '[0-9]+')->where('bookid', '[0-9]+');
Route::post('book_chapter_detail_load',  'BookController@book_chapter_detail_load');
Route::get('book_rank',  'BookController@book_rank');
Route::get('book_boy',  'BookController@book_boy');
Route::get('book_girl',  'BookController@book_girl');
Route::get('book_category',  'BookController@book_category');
Route::post('book_list_load',  'BookController@book_list_load');
Route::get('book_recommend/{start_day?}/{end_day?}',  'BookController@book_recommend');
Route::get('book_recommend_list',  'BookController@book_recommend_list');
Route::get('book_history',  'BookController@book_history');
Route::post('book_collect_del',  'BookController@book_collect_del');
Route::get('book_collect_list',  'BookController@book_collect_list');
Route::get('register', 'UserController@register');
Route::post('register', 'UserController@register');
Route::get('forget_pass', 'UserController@forget_pass');
Route::post('forget_pass', 'UserController@forget_pass');
Route::get('book_list/{reader_type?}/{type?}/{word?}/{order?}',  'BookController@book_list');
Route::get('book_comment/{id}',  'BookController@book_comment')->where('id', '[0-9]+');
Route::get('book_author/{bookid}/{authorname}',  'BookController@book_author');
Route::post('book_collect',  'BookController@book_collect');

# 搜索
Route::get('inside_search/{content?}',  'SearchController@inside_search');
Route::get('inside_search_list/{content?}',  'SearchController@inside_search_list');
Route::get('outside_search',  'SearchController@outside_search');
Route::get('outside_search_list/{content?}',  'SearchController@outside_search_list');
Route::post('del_search_history',  'SearchController@del_search_history');

# 用户
Route::get('user',  'UserController@index');
Route::post('user_save', 'UserController@save');
Route::post('suggest', 'UserController@suggest');
Route::post('upload_avatar', 'UserController@upload_avatar');
Route::post('logout', 'UserController@logout');
Route::post('login', 'UserController@login');
Route::get('login', 'UserController@login');
Route::get('signin', 'UserController@signin');

# 邮件发送
Route::post('send_email',  'EmailController@send_email');

# 追书聚合
Route::get('poly/cate_list',  'PolyController@cate_list');
Route::get('poly/cate',  'PolyController@cate');
Route::post('poly/cate',  'PolyController@cate')->name('poly/cate');
Route::get('poly/detail/{id}',  'PolyController@detail');
Route::get('poly/content/{chapterId?}/{bookId}',  'PolyController@content');
Route::post('poly/content/{chapterId?}/{bookId}',  'PolyController@content');
Route::get('poly/dir/{bookId}',  'PolyController@dir');
Route::post('poly/collect',  'PolyController@collect');
Route::get('poly/author/{authorName}',  'PolyController@author');
Route::get('poly/book_list',  'PolyController@book_list')->name('poly/book_list');
Route::post('poly/book_list',  'PolyController@book_list');
Route::get('poly/book_detail/{bookListId}',  'PolyController@book_detail');
Route::get('poly/rank/{gender}',  'PolyController@rank');
Route::get('poly/rank_detail/{rankId}/{gender}',  'PolyController@rank_detail');

Route::get('poly/outside_search',  'PolyController@outside_search');
Route::get('poly/outside_search_list/{content?}',  'PolyController@outside_search_list');
Route::get('poly/book_history',  'PolyController@book_history');
Route::get('poly/book_collect_list',  'PolyController@book_collect_list');
Route::get('poly/user',  'PolyController@user');


Route::post('yaozhanhui',  'PolyController@yaozhanhui');

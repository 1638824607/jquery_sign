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
# 首页
Route::get('index', 'IndexController@index');
Route::get('theme', 'IndexController@theme');

# 登陆
Route::get('login', 'LoginController@login')->name('login');
Route::post('ajax_login', 'LoginController@ajax_login');
Route::get('logout', 'LoginController@logout');

# 后台首页
    Route::get('home/index', 'HomeController@index');
    Route::get('home/system', 'HomeController@system');

# 权限管理
    # 用户管理
    Route::get('auth/user_list',  'AuthController@user_list');
    Route::post('auth/user_list', 'AuthController@user_list');

    Route::post('auth/user_save', 'AuthController@user_save');
    Route::post('auth/user_del',  'AuthController@user_del');

    Route::post('auth/ajax_user_role_list',  'AuthController@ajax_user_role_list');
    Route::post('auth/ajax_user_role_save',  'AuthController@ajax_user_role_save');

    # 角色管理
    Route::get('auth/role_list',  'AuthController@role_list');
    Route::post('auth/role_list', 'AuthController@role_list');

    Route::post('auth/role_save', 'AuthController@role_save');
    Route::post('auth/role_del',  'AuthController@role_del');

    Route::post('auth/ajax_role_user_list',  'AuthController@ajax_role_user_list');
    Route::post('auth/ajax_role_permission_list',  'AuthController@ajax_role_permission_list');
    Route::post('auth/ajax_role_permission_save',  'AuthController@ajax_role_permission_save');

    # 权限管理
    Route::get('auth/permission_list',  'AuthController@permission_list');
    Route::post('auth/permission_list', 'AuthController@permission_list');

    Route::post('auth/permission_save', 'AuthController@permission_save');

    Route::post('auth/permission_del',  'AuthController@permission_del');

    # 用户信息
    Route::get('auth/user_info',  'AuthController@user_info');
    Route::post('auth/user_avatar_upload',  'AuthController@user_avatar_upload');

    # 修改密码
    Route::get('auth/pass_edit',  'AuthController@pass_edit');
    Route::post('auth/pass_edit',  'AuthController@pass_edit');

# 小说管理
    # 小说
    Route::get('book/book_list',  'BookController@book_list');
    Route::post('book/book_list',  'BookController@book_list');
    Route::post('book/book_cover_upload',  'BookController@book_cover_upload');
    Route::post('book/book_save',  'BookController@book_save');
    Route::post('book/book_del',  'BookController@book_del');

    Route::get('book/book_reader_list',  'BookController@book_reader_list');
    Route::post('book/book_reader_list',  'BookController@book_reader_list');
    Route::post('book/book_reader_save',  'BookController@book_reader_save');
    Route::post('book/book_reader_del',  'BookController@book_reader_del');

    Route::get('book/book_type_list',  'BookController@book_type_list');
    Route::post('book/book_type_list',  'BookController@book_type_list');
    Route::post('book/book_type_save',  'BookController@book_type_save');
    Route::post('book/book_type_del',  'BookController@book_type_del');

    Route::get('book/book_chapter_check',  'BookController@book_chapter_check');
    Route::post('book/book_chapter_check',  'BookController@book_chapter_check');
    Route::post('book/book_chapter_sort_create',  'BookController@book_chapter_sort_create');
    Route::post('book/book_chapter_sort_recreate',  'BookController@book_chapter_sort_recreate');
    Route::post('book/chapter_name_recreate',  'BookController@chapter_name_recreate');
    Route::post('book/chapter_order_recreate',  'BookController@chapter_order_recreate');
    Route::post('book/book_chapter_edit',  'BookController@book_chapter_edit');

    Route::get('book/book_chapter_list',  'BookController@book_chapter_list');
    Route::get('book/book_chapter_content',  'BookController@book_chapter_content');
    Route::post('book/book_chapter_list',  'BookController@book_chapter_list');
    Route::post('book/book_chapter_save',  'BookController@book_chapter_save');
    Route::post('book/book_chapter_del',  'BookController@book_chapter_del');

# 系统管理
    # web系统设置
    Route::get('system/web_setting',  'SystemController@web_setting');
    Route::post('system/setting_save',  'SystemController@setting_save');
    # wap系统设置
    Route::get('system/wap_setting',  'SystemController@wap_setting');
    # app系统设置
    Route::get('system/app_setting',  'SystemController@app_setting');

# 首页管理
    # 导航列表
    Route::get('index/nav_list',  'NavController@nav_list');
    Route::post('index/nav_list',  'NavController@nav_list');
    Route::post('index/nav_save',  'NavController@nav_save');
    Route::post('index/nav_del',  'NavController@nav_del');
    # 友情链接列表
    Route::get('index/link_list',  'LinkController@link_list');
    Route::post('index/link_list',  'LinkController@link_list');
    Route::post('index/link_save',  'LinkController@link_save');
    Route::post('index/link_del',  'LinkController@link_del');
    # 网站资讯列表
    Route::get('index/new_list',  'NewController@new_list');
    Route::post('index/new_list',  'NewController@new_list');
    Route::post('index/new_save',  'NewController@new_save');
    Route::post('index/new_del',  'NewController@new_del');
    # 轮播图列表
    Route::get('index/carousel_list',  'IndexController@carousel_list');
    # app系统设置
    Route::get('index/carousel_save',  'IndexController@carousel_save');

# 爬虫管理
    # 爬虫列表
    Route::get('reptile/reptile_list', 'ReptileController@reptile_list');
    Route::post('reptile/reptile_list', 'ReptileController@reptile_list');
    Route::post('reptile/reptile_save', 'ReptileController@reptile_save');
    Route::post('reptile/reptile_del', 'ReptileController@reptile_del');
    Route::post('reptile/reptile_run', 'ReptileController@reptile_run');
    # 爬虫日志
    Route::get('reptile/reptile_log_list', 'ReptileController@reptile_log_list');
    Route::post('reptile/reptile_log_list', 'ReptileController@reptile_log_list');





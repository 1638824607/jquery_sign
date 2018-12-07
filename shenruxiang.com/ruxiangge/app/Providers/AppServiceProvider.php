<?php

namespace App\Providers;

use App\Admin\BookReader;
use App\Admin\BookType;
use App\Admin\Link;
use App\Admin\Nav;
use App\Admin\System;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        # 获取Web网站信息
        $systemInfo = Cache::rememberForever('system_info', function() {
            return System::where('type', 1)->first()->toArray();
        });

        # 获取web网站设置
        $systemSet = Cache::rememberForever('system_set', function() {
            return System::where('type', 2)->first()->toArray();
        });

        # 获取友情链接
        $linkList = Cache::rememberForever('link_list', function() {
            return Link::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray();
        });

        # 获取分类导航
        $navList = Cache::rememberForever('nav_list', function() {
            return Nav::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray();
        });

        # 获取小说类型
        $bookTypeList = Cache::rememberForever('book_type_list', function() {
            return BookType::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray();
        });

        # 获取小说性向
        $bookReaderList = Cache::rememberForever('book_reader_list', function() {
            return BookReader::where('status', 1)->orderBy('sort', 'DESC')->get()->keyBy('id')->toArray();
        });


        View::share('systemInfo', $systemInfo);
        View::share('systemSet', $systemSet);
        View::share('navList', $navList);
        View::share('bookTypeList', $bookTypeList);
        View::share('bookReaderList', $bookReaderList);
        View::share('linkList', $linkList);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

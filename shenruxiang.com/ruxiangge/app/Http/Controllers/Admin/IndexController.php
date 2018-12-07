<?php

namespace App\Http\Controllers\Admin;

use App\Admin\Nav;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class IndexController extends BaseController
{
    /**
     * 后台首页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/7 14:24
     */
    public function index(Request $request)
    {
        $authList = $request->get('authList');

        $menuList = $this->getMenuList($authList);

        $userInfo = $request->user();

        return view('', ['menuList' => $menuList, 'userInfo' => $userInfo]);
    }

    public function theme()
    {
        return view('');
    }

    /**
     * 获取菜单目录
     * @param $authList
     * @return array
     * @author shenruxiang
     * @date 2018/8/7 14:53
     */
    public function getMenuList($authList)
    {
        $temp_menu_list = [];

        foreach($authList as $value) {
            $temp_menu_list[$value['id']] = $value;
        }

        $menu_list = [];

        foreach($temp_menu_list as $key => $value)
        {
            if(isset($temp_menu_list[$value['parent']])) {
                $temp_menu_list[$value['parent']]['son'][] = &$temp_menu_list[$key];
            }else {
                $menu_list[] = &$temp_menu_list[$key];
            }
        }

        return $menu_list;
    }
}

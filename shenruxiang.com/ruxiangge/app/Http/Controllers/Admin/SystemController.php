<?php

namespace App\Http\Controllers\Admin;

use App\Admin\System;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SystemController extends BaseController
{
    /**
     * pc端系统设置
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @author shenruxiang
     * @date 2018/8/24 14:47
     */
    public function web_setting()
    {
        # 获取网站基本信息
        $webInfoSettingRow = System::where('type', 1)->first();

        # 获取网站控制信息
        $webControllerSettingRow = System::where('type', 2)->first();

        return view('', ['webInfoSettingRow' => json_decode( ! empty($webInfoSettingRow['content']) ? $webInfoSettingRow['content'] : ''), 'webControllerSettingRow' => json_decode( ! empty($webControllerSettingRow['content']) ? $webControllerSettingRow['content'] : '')]);
    }

    /**
     * 网站信息设置
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @author shenruxiang
     * @date 2018/8/24 16:39
     */
    public function setting_save(Request $request)
    {
        $webSettingRow = $request->input();

        if($webSettingRow['type'] == 2 && ! empty($webSettingRow['site_oauth'])) {
            $webSettingRow['site_oauth'] = implode(',', $webSettingRow['site_oauth']);
        }

        $dbWebSettingRow = System::where('type', $webSettingRow['type'])->first();

        if(! empty($dbWebSettingRow)) {
            System::where('id', $dbWebSettingRow['id'])->update(['content' => json_encode($webSettingRow)]);
        }else {
            System::create([
                'type'    => $webSettingRow['type'],
                'content' => json_encode($webSettingRow)
            ]);
        }

        # 缓存web端网站系统信息
        Cache::forever('system_info', json_decode((System::where('type', 1)->first()->toArray())['content']));
        # 缓存web端网站系统设置
        Cache::forever('system_set', json_decode((System::where('type', 2)->first()->toArray())['content']));

        return $this->retJson(3, '操作成功');
    }

    public function wap_setting()
    {
        abort(404);
        # 获取网站基本信息
        $webInfoSettingRow = System::where('type', 1)->first();

        # 获取网站控制信息
        $webControllerSettingRow = System::where('type', 2)->first();

        return view('', ['webInfoSettingRow' => json_decode( ! empty($webInfoSettingRow['content']) ? $webInfoSettingRow['content'] : ''), 'webControllerSettingRow' => json_decode( ! empty($webControllerSettingRow['content']) ? $webControllerSettingRow['content'] : '')]);
    }

    public function app_setting()
    {
        abort(404);
        # 获取网站基本信息
        $webInfoSettingRow = System::where('type', 1)->first();

        # 获取网站控制信息
        $webControllerSettingRow = System::where('type', 2)->first();

        return view('', ['webInfoSettingRow' => json_decode( ! empty($webInfoSettingRow['content']) ? $webInfoSettingRow['content'] : ''), 'webControllerSettingRow' => json_decode( ! empty($webControllerSettingRow['content']) ? $webControllerSettingRow['content'] : '')]);
    }
}

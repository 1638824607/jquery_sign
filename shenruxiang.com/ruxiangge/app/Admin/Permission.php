<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "permissions";

    protected $fillable = [
        'name', 'display_name', 'description' , 'is_show', 'menu_icon', 'sort', 'parent'
    ];

    /**
     * 根据主键数组批量获取权限
     * @param $permissionIdArr
     * @return array
     * @author shenruxiang
     * @date 2018/8/7 11:16
     */
    public function getPermissionListByIdArr($permissionIdArr)
    {
        $permissionIdArr = empty($permissionIdArr) ? 0 : array_unique(array_map('intval', $permissionIdArr));

        if(empty($permissionIdArr)) {
            return [];
        }

        return $this->whereIn('id', $permissionIdArr)->orderBy('parent', 'asc')->orderBy('sort', 'desc')->get()->toArray();
    }

}

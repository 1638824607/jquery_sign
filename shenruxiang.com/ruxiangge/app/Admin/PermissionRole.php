<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{
    protected $table = "permission_role";

    /**
     * 根据角色获取关联权限列表
     * @param $roleIdArr
     * @return array
     * @author shenruxiang
     * @date 2018/8/7 11:12
     */
    public function getPermissListByRoleIdArr($roleIdArr)
    {
        $roleIdArr = empty($roleIdArr) ? 0 : array_unique(array_map('intval', $roleIdArr));

        if(empty($roleIdArr)) {
            return [];
        }

        return $this->whereIn('role_id', $roleIdArr)->get()->toArray();
    }
}

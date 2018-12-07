<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = "role_user";

    /**
     * 获取用户角色列表
     * @param $userId
     * @return array
     * @author shenruxiang
     * @date 2018/8/7 10:50
     */
    public function getRoleListByUid($userId)
    {
        $userId = empty($userId) ? 0 : intval($userId);

        if(empty($userId)) {
            return [];
        }

        return $this->where('user_id', $userId)->get()->toArray();
    }
}

<?php

namespace App\Admin;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";

    protected $fillable = [
        'name', 'display_name', 'description',
    ];

    public function getRoleListByUid($userId)
    {
        return $this->where('id', $userId)->first()->toArray();
    }
}

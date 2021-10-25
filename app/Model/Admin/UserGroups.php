<?php

namespace App\Model\Admin;

use App\User;
use Illuminate\Database\Eloquent\Model;

class UserGroups extends Model
{
    protected $table="user_groups";

    public function users()
    {
        return $this->hasMany(User::class,'group_id','id');
    }
}

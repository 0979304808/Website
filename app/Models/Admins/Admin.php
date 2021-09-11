<?php

namespace App\Models\Admins;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laratrust\Traits\LaratrustUserTrait;
use App\Models\Roles\Role;
use App\Models\Permissions\Permission;
use App\Models\Posts\Post;
use App\Models\Codes\CodePurchase;

class Admin extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'admins';

    protected $guard = 'admin';

    protected $guarded = [];

    public function setPassWordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function setUsername($username)
    {
        $this->username = strtolower($username);
    }

    public function getUsername()
    {
        return ucwords($this->username);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withPivotValue('user_type', self::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withPivotValue('user_type', self::class);
    }

    public function getPermissionsViaRoles(){
        return $this->load('roles', 'roles.permissions')
            ->roles->flatMap(function ($role) {
                return $role->permissions;
            })->sort()->values();
    }

    public function posts()
    {
        return $this->hasMany(Post::class,'admin_id');
    }

    public function codepurchase()
    {
        return $this->hasMany(CodePurchase::class,'admin_id');
    }
}

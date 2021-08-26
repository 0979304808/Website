<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

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
        $this->attributes['password'] = bcrypt(($password));
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
}

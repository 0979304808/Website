<?php

namespace App\Models\Admins;

use Illuminate\Database\Eloquent\Model;

class MaziiAdminUser extends Model
{
    protected $connection = 'mazii';
    protected $table = 'mazii_admin_user';
    protected $guarded = ['password'];
}

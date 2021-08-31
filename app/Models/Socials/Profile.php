<?php

namespace App\Models\Socials;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $connection = 'mazii';
    protected $table = 'profile';
    protected $primaryKey = 'profile_id';
    protected $guarded = [];
}

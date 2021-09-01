<?php

namespace App\Models\Jobs;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\UserMazii;

class Job extends Model
{
    //
    protected $table        = 'jobs';
    protected $guarded      = [];
    protected $connection   = 'mazii';

    public function user()
    {
        return $this->belongsTo(UserMazii::class, 'user_id', 'userId');
    }
}

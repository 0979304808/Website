<?php

namespace App\Models\Codes;

use App\Models\Orders\Order;
use App\Models\Projects\Project;
use Illuminate\Database\Eloquent\Model;

class Code extends Model
{

    protected $table = 'codes';
    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Relationship
     */
    public function projects(){
        return $this->belongsToMany(Project::class);
    }

    public function order(){
        return $this->hasOne(Order::class);
    }

}

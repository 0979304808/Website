<?php

namespace App\Models\Orders;

use App\Models\Codes\Code;
use App\Models\Projects\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sort', function(Builder $builder){
            return $builder->latest();
        });
    }

    /**
     * Relationships
     */
    public function code(){
        return $this->belongsTo(Code::class);
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

}

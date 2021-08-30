<?php

namespace App\Models\Orders;

use App\Models\Codes\Code;
use App\Models\Projects\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    const _finish = true;
    const _unfinish = false;

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

<?php

namespace App\Models\Socials;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $connection = 'mazii';
    protected $table = 'language';
    protected $guarded = [];

    /**
     * Relationship
     */
//    public function accounts(){
//        return $this->hasMany(Account::class)->select('userId', 'username', 'email', 'language_id');
//    }
//
//    public function posts(){
//        return $this->hasMany(Post::class);
//    }

}

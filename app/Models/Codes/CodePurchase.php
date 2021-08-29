<?php

namespace App\Models\Codes;

use Illuminate\Database\Eloquent\Model;
use App\Models\Admins\Admin;
class CodePurchase extends Model
{
    protected $table = 'code_purchase';

    protected $guarded = [];

    public function admin(){
        return $this->belongsTo(Admin::class);
    }

}

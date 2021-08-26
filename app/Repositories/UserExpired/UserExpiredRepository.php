<?php

namespace App\Repositories\UserExpired;

use App\Core\Repositories\BaseRepository;
use App\Models\Users\UserExpiredNote;
use App\Repositories\UserExpired\Contract\UserExpiredRepositoryInterface;
use App\Core\Traits\ApiResponser;
use App\Core\Traits\Authorization;
use App\Models\Users\UserMazii;

class UserExpiredRepository extends BaseRepository implements UserExpiredRepositoryInterface{
    use ApiResponser;
    use Authorization;
    protected $model;

    public function __construct(UserExpiredNote $userexpired)
    {
        parent::__construct($userexpired);
        $this->model = $userexpired;
    }

    public function updateOrCreateNote($id, $note){
        if(!UserMazii::where('userId',$id)->exists()){
            $this->error('User ID not found !',404);
        }
        $update = UserExpiredNote::updateOrCreate([
            'user_id'   =>  $id
        ],[
            'admin_id'  => $this->guard()->user()->id,
            'note'      => $note
        ]);
        if($update){
            return true;
        }
        return false; 
    }

}
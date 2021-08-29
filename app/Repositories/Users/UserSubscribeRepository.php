<?php

namespace App\Repositories\Users;

use App\Core\Repositories\BaseRepository;
use App\Repositories\Users\Contract\UserSubscribeRepositoryInterface;
use App\Models\Users\UserSubscribe;
class UserSubscribeRepository extends BaseRepository implements UserSubscribeRepositoryInterface
{

    protected $model;

    public function __construct(UserSubscribe $usersubscribe)
    {
        parent::__construct($usersubscribe);
        $this->model = $usersubscribe;
    }

    public function WhereHasUser($search){
        return $this->model->with('user')->whereHas('user',function($q) use ($search){
            $q->where('username','like',$search);
            $q->orWhere('email','like', $search);
        })->orWhere('package_name','like',$search)->orWhere('email','like',$search);
    }

    public function WithUser(){
        return $this->model->with('user');
    }

}
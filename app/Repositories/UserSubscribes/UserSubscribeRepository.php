<?php

namespace App\Repositories\UserSubscribes;

use App\Core\Repositories\BaseRepository;
use App\Models\Users\UserSubscribe;
use App\Repositories\UserSubscribes\Contract\UserSubscribeRepositoryInterface;

class UserSubscribeRepository extends BaseRepository implements UserSubscribeRepositoryInterface{
    protected $model;

    public function __construct(UserSubscribe $usersubscribe)
    {
        parent::__construct($usersubscribe);
        $this->model = $usersubscribe;
    }

  
}
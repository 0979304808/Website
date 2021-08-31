<?php

namespace App\Repositories\UserMazii;

use App\Core\Repositories\BaseRepository;
use App\Models\Users\UserMazii;
use App\Repositories\UserMazii\Contract\UserMaziiRepositoryInterface;

class UserMaziiRepository extends BaseRepository implements UserMaziiRepositoryInterface
{

    protected $model;

    public function __construct(UserMazii $UserMazii)
    {
        parent::__construct($UserMazii);
        $this->model = $UserMazii;
    }

    public function WithAll()
    {
        return $this->model->with(['language','profile']);
    }
}
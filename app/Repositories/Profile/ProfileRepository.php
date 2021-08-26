<?php

namespace App\Repositories\Profile;

use App\Core\Repositories\BaseRepository;
use App\Models\Socials\Profile;
use App\Repositories\Profile\Contract\ProfileRepositoryInterface;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface {

    protected $model;

    public function __construct(Profile $profile)
    {
        parent::__construct($profile);
        $this->model = $profile;
    }

    public function uploadImage($file)
    {
        return $this->uploadFTPMazii($file);
    }

}
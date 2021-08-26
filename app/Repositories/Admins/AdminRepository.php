<?php

namespace App\Repositories\Admins;

use App\Core\Repositories\BaseRepository;
use App\Repositories\Admins\Contract\AdminRepositoryInterface;
use App\Admin;

class AdminRepository extends BaseRepository implements AdminRepositoryInterface
{

    protected $model;

    public function __construct(Admin $admin)
    {
        parent::__construct($admin);
        $this->model = $admin;
    }

    public function updateImage($file)
    {
        $filename = 'Thumb_image_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $this->saveImage($file, $filename);
        return $this->model->update([
            'image' => $path
        ]);
    }


}
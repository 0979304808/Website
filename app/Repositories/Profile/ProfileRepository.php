<?php

namespace App\Repositories\Profile;

use App\Core\Repositories\BaseRepository;
use App\Core\Traits\UploadTable;
use App\Models\Socials\Profile;
use App\Repositories\Profile\Contract\ProfileRepositoryInterface;

class ProfileRepository extends BaseRepository implements ProfileRepositoryInterface
{
    use UploadTable;
    protected $model;

    public function __construct(Profile $profile)
    {
        parent::__construct($profile);
        $this->model = $profile;
    }

//    public function uploadImage($file)
//    {
//        return $this->uploadFTPMazii($file);
//    }

    public function createOrUpdate(array $attribute, $id = null)
    {
        if ($attribute['image']) {
            $file = $attribute['image'];
            $filename = 'Thumb_image_' . time() . '.' . $file->getClientOriginalExtension();
            $attribute['image'] = $this->saveImage($file, $filename);
        }
        if ($id != null ){
            $profile = $this->model->find($id);
            if ($profile){
                return $profile->update($attribute);
            }
        }
        return $this->model->create($attribute);
    }

}
<?php

namespace App\Repositories\Jlpt;

use App\Core\Repositories\BaseRepository;
use App\Models\Socials\JLPT;
use App\Repositories\Jlpt\Contract\JlptRepositoryInterface;
use App\Core\Traits\ApiResponser;
use App\Core\Traits\Authorization;

class JlptRepository extends BaseRepository implements JlptRepositoryInterface
{
    use ApiResponser;
    use Authorization;
    protected $model;

    public function __construct(JLPT $jlpt)
    {
        parent::__construct($jlpt);
        $this->model = $jlpt;
    }

    public function WithAll()
    {
        return $this->model->with('admin');
    }

    public function search($search)
    {
        return $this->model->where('id', $search)->orWhere('title', 'like', '%' . $search . '%')->with('admin');
    }

    public function createOrUpdate(array $attribute)
    {
        if ($attribute['image']) {
            $file = $attribute['image'];
            $filename = 'Thumb_image_' . time() . '.' . $file->getClientOriginalExtension();
            $attribute['image'] = $this->saveImage($file, $filename);
        }
        if (request('id')) {
            $model = $this->model->find(request('id'));
            if ($model) {
                $this->Unlink($model->image);
                return $model->update($attribute);
            }
        } else {
            return $this->model->create($attribute);
        }
    }

    public function deleteJplt($id)
    {
        $jplt = $this->model->find($id);
        if ($jplt){
            $this->Unlink($jplt->image);
            $jplt->delete();
        }
    }
}
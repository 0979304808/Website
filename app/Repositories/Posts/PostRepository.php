<?php

namespace App\Repositories\Posts;

use App\Core\Repositories\BaseRepository;
use App\Core\Traits\UploadTable;
use App\Post;
use App\Repositories\Posts\Contract\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface
{
    use UploadTable;
    protected $model;

    public function __construct(Post $post)
    {
        parent::__construct($post);
        $this->model = $post;
    }

    public function WithAll()
    {
        return $this->model->with(['categories', 'tags', 'author'])->paginate();
    }

    public function createOrUpdate(array $attribute)
    {
        if ($attribute['img']){
            $file = $attribute['img'];
            $filename = 'Thumb_image_' . time() . '.' . $file->getClientOriginalExtension();
            $attribute['img'] = $this->saveImage($file, $filename);
        }
        if (request('id')) {
            $model = $this->model->find(request('id'));
            if ($model) {
                $post = $model->update($attribute);
            }
        } else {
            $post = $this->model->create($attribute);
        }
        return $post;

    }

}
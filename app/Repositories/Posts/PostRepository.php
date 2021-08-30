<?php

namespace App\Repositories\Posts;

use App\Core\Repositories\BaseRepository;
use App\Core\Traits\UploadTable;
use App\Models\Posts\Post;
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
        if ($attribute['img']) {
            $file = $attribute['img'];
            $filename = 'Thumb_image_' . time() . '.' . $file->getClientOriginalExtension();
            $attribute['img'] = $this->saveImage($file, $filename);
        }
        if (request('id')) {
            $model = $this->model->find(request('id'));
            if ($model) {
                $this->Unlink($model->img);
                $post = $model->update($attribute);
            }
        } else {
            $post = $this->model->create($attribute);
        }
        return $post;

    }

    public function WhereHasCategory($id)
    {
        return $this->model->whereHas('categories', function ($query) use ($id) {
            $query->where('category_id', $id);
        })->with(['categories', 'tags', 'author'])->paginate();
    }

    public function WhereHasTag($id)
    {
        return $this->model->whereHas('tags', function ($query) use ($id) {
            $query->where('tag_id', $id);
        })->with(['categories', 'tags', 'author'])->paginate();
    }

    public function WhereHasCategoryTag($category, $tag)
    {
        return $this->model->whereHas('tags', function ($query) use ($tag) {
            $query->where('tag_id', $tag);
        })->whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category);
        })->with(['categories', 'tags', 'author'])->paginate();
    }

    public function Search($search)
    {
        return $this->model->where('title', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%')->with(['categories', 'tags', 'author'])->paginate();
    }


}
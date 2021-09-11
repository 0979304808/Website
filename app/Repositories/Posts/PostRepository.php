<?php

namespace App\Repositories\Posts;

use App\Core\Repositories\BaseRepository;
use App\Core\Traits\UploadTable;
use App\Models\Socials\Post;
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

    // Status = 1 chỉ lấy những bài viết đã được duyệt
    public function WithAll()
    {
        return $this->model->where('status','1')->with(['category', 'comments', 'user']);
    }

    public function whereAll($language, $account, $category)
    {
        $posts = $this->model->with(['category', 'comments', 'user']);
        if ($language !== 'all') {
            $posts = $posts->language($language);
        }
        if ($account !== 'all') {
            $posts = $posts->account($account);
        }
        if ($category !== 'all') {
            $posts = $posts->category($category);
        }
        return $posts;
    }

    // Create or Update
    public function createOrUpdatePost(array $attribute)
    {
        if (isset($attribute['img'])) {
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

    // Where language and status
    public function whereLangStatus($lang, $status)
    {
        $post = $this->model->with(['category', 'comments', 'user']);
        if ($lang != null) {
            $post = $post->language($lang);
        }
        if ($status != null) {
            $post = $post->status($status);
        }
        return $post;
    }

    public function wherePin()
    {
        return $this->model->pinTop()->with(['category', 'comments', 'user']);
    }

    public function whereChoice()
    {
        return $this->model->choiceTop()->with(['category', 'comments', 'user']);
    }

    public function accountHasPosts(array $id)
    {
        return $this->model->user($id)->limit(30)->get();
    }

    // List post trừ đi bài post đang xem.
    public function whereListDetail($id)
    {
        return $this->model->hasId($id)->get();
    }
//
//    public function WhereHasCategory($id)
//    {
//        return $this->model->whereHas('categories', function ($query) use ($id) {
//            $query->where('category_id', $id);
//        })->with(['categories', 'tags', 'author'])->paginate();
//    }
//
//    public function WhereHasTag($id)
//    {
//        return $this->model->whereHas('tags', function ($query) use ($id) {
//            $query->where('tag_id', $id);
//        })->with(['categories', 'tags', 'author'])->paginate();
//    }
//
//    public function WhereHasCategoryTag($category, $tag)
//    {
//        return $this->model->whereHas('tags', function ($query) use ($tag) {
//            $query->where('tag_id', $tag);
//        })->whereHas('categories', function ($query) use ($category) {
//            $query->where('category_id', $category);
//        })->with(['categories', 'tags', 'author'])->paginate();
//    }
//
//    public function Search($search)
//    {
//        return $this->model->where('title', 'like', '%' . $search . '%')->orWhere('description', 'like', '%' . $search . '%')->with(['categories', 'tags', 'author'])->paginate();
//    }


}

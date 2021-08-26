<?php

namespace App\Repositories\Posts;

use App\Core\Repositories\BaseRepository;
use App\Models\Socials\Post;
use App\Repositories\Posts\Contract\PostRepositoryInterface;

class PostRepository extends BaseRepository implements PostRepositoryInterface {

    protected $model;

    public function __construct(Post $post)
    {
        parent::__construct($post);
        $this->model = $post;
    }

    public function accountHasPosts(array $id)
    {
        return $this->model->whereIn('user_id', $id)->limit(30)->get();
    }

    public function setTotal()
    {
        $this->total_comment = $this->getTotal();
        return $this->save();
    }

    public function getTotal()
    {
        $post = $this->model->withCount(['comments', 'childComments'])->first();
        return $post->comments_count + $post->child_comments_count;
    }
}
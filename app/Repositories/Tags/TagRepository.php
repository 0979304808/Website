<?php

namespace App\Repositories\Tags;

use App\Core\Repositories\BaseRepository;
use App\Repositories\Tags\Contract\TagRepositoryInterface;
use App\Tag;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{

    protected $model;

    public function __construct(Tag $tag)
    {
        parent::__construct($tag);
        $this->model = $tag;
    }

}
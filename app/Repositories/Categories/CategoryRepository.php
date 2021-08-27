<?php

namespace App\Repositories\Categories;

use App\Category;
use App\Core\Repositories\BaseRepository;
use App\Repositories\Categories\Contract\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface {

    protected $model;

    public function __construct(Category $category)
    {
        parent::__construct($category);
        $this->model = $category;
    }
}
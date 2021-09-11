<?php

namespace App\Repositories\Posts\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface PostRepositoryInterface extends BaseRepositoryInterface
{
    public function WithAll();

    public function whereAll($language, $account, $category);

    public function createOrUpdatePost(array $attribute);

    public function whereLangStatus($lang, $status);

    public function wherePin();

    public function whereChoice();

    public function accountHasPosts(array $id);

    public function whereListDetail($id);
//
//    public function WhereHasCategory($id);
//
//    public function WhereHasTag($id);
//
//    public function WhereHasCategoryTag($category, $tag);
}

<?php

namespace App\Repositories\Languages;

use App\Core\Repositories\BaseRepository;
use App\Http\Resources\Socials\PostResource;
use App\Models\Socials\Language;
use App\Repositories\Languages\Contract\LanguageRepositoryInterface;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface {

    protected $model;

    public function __construct(Language $language)
    {
        parent::__construct($language);
        $this->model = $language;
    }

    public function langHasPosts(string $lang)
    {
        $language = $this->model->whereShort($lang)->first();

        return $language->posts()->paginate();
    }

    public function langHasAccounts(string $lang)
    {
        $language = $this->model->whereShort($lang)->first();
        return $language->accounts()->whereVirtual(true)->get()->toArray();
    }
 
}
<?php

namespace App\Repositories\Languages;

use App\Core\Repositories\BaseRepository;
use App\Core\Traits\ApiResponser;
use App\Core\Traits\Authorization;
use App\Models\Socials\Language;
use App\Repositories\Languages\Contract\LanguageRepositoryInterface;

class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface
{
    use ApiResponser;
    use Authorization;
    protected $model;

    public function __construct(Language $language)
    {
        parent::__construct($language);
        $this->model = $language;
    }

}
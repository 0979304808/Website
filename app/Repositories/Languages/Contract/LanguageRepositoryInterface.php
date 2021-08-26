<?php

namespace App\Repositories\Languages\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface LanguageRepositoryInterface extends BaseRepositoryInterface {
    
    public function langHasPosts(string $lang);
    public function langHasAccounts(string $lang);
}
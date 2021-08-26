<?php

namespace App\Repositories\Accounts;

use App\Core\Repositories\BaseRepository;
use App\Models\Codes\Code;
use App\Repositories\Codes\Contract\CodeRepositoryInterface;

class CodeRepository extends BaseRepository implements CodeRepositoryInterface {

    protected $model;

    public function __construct(Code $code)
    {
        parent::__construct($code);
        $this->model = $code;
    }

    /**
     * @param int $project_id
     * @param int $price
     * @param int $expired 
     */   
    public function findCode($code)
    {
        return $this->model->whereCode(strtoupper(str_replace('-', '', $code)))->firstOrFail();
    }
 
}
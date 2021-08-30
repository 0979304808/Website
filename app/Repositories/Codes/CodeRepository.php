<?php

namespace App\Repositories\Codes;

use App\Models\Codes\Code;
use App\Core\Repositories\BaseRepository;
use App\Repositories\Codes\Contract\CodeRepositoryInterface;

class CodeRepository extends BaseRepository implements CodeRepositoryInterface
{

    protected $model;

    public function __construct(Code $code)
    {
        parent::__construct($code);
        $this->model = $code;
    }


    public function withAll()
    {
        return $this->model->with('order')->paginate();
    }

    public function WhereStatusSort($status, $sort)
    {
        if ($sort == 'old'){
            $sort = 'desc';
        }
        if ($sort == 'new'){
            $sort = 'asc';
        }
        return $this->model->where('status', $status)->orderBy('id', $sort);
    }

    public function search($search)
    {
        return $this->model->where('code',$search)->paginate();
    }

}
<?php

namespace App\Repositories\Serial;

use App\Core\Repositories\BaseRepository;
use App\Repositories\Serial\Contract\SerialRepositoryInterface;
use App\Core\Traits\ApiResponser;
use App\Core\Traits\Authorization;
use App\Models\Serial\Serial;

class SerialRepository extends BaseRepository implements SerialRepositoryInterface
{
    use ApiResponser;
    use Authorization;
    protected $model;

    public function __construct(Serial $serial)
    {
        parent::__construct($serial);
        $this->model = $serial;
    }
}
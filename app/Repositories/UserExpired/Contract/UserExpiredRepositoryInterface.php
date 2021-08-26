<?php

namespace App\Repositories\UserExpired\Contract;

use App\Core\Repositories\Contract\BaseRepositoryInterface;

interface UserExpiredRepositoryInterface extends BaseRepositoryInterface {
    public function updateOrCreateNote($id, $note);
}
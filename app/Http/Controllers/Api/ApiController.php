<?php

namespace App\Http\Controllers\Api;

use App\Core\Traits\ApiResponser;
use App\Core\Traits\Authorization;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    use ApiResponser, Authorization;
}

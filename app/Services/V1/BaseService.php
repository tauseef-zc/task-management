<?php

namespace App\Services\V1;

use App\Services\V1\Interfaces\ServiceInterface;
use App\Traits\ServicePayloadTrait;

class BaseService implements ServiceInterface
{
    use ServicePayloadTrait;

}

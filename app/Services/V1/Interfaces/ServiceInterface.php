<?php

namespace App\Services\V1\Interfaces;

use Illuminate\Http\Response;

interface ServiceInterface
{
    /**
     * @param array $data
     * @param int $code
     * @return array
     */
    public function payload(array $data, int $code = Response::HTTP_OK): array;

    /**
     * @param string $message
     * @param int $code
     * @return array
     */
    public function error(string $message, int $code = Response::HTTP_BAD_REQUEST): array;

}
<?php

namespace App\Api\Controllers;

use App\Utils\EnumUtils;

class EnumController extends ApiController
{
    /**
     * @OA\Get(
     *     path="/enums",
     *     tags={"enums"},
     *     operationId="getEnums",
     *     summary="Liste des enums",
     *     description="Liste des enums",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     * )
     *
     * @throws \ReflectionException
     *
     * @return array
     */
    public function index()
    {
        return EnumUtils::all();
    }
}

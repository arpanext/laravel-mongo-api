<?php

namespace Arpanext\Storage\Jsons\App\Http\Controllers\Api\Storage\Jsons\Databases\Collections;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use MongoDB\BSON\ObjectId;
class UpdateManyController extends Controller
{
    /**
     * @OA\Patch(
     *     path="/api/v1/storage/jsons/databases/{databaseName}/collections/{collectionName}/updateMany",
     *     tags={"Collections"},
     *     description="",
     *     @OA\Parameter(
     *         name="databaseName",
     *         in="path",
     *         description="database",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="string",
     *             example="database",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="collectionName",
     *         in="path",
     *         description="collection",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="string",
     *             example="collection",
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="filter",
     *         in="query",
     *         description="filter",
     *         required=true,
     *         @OA\Schema(
     *             type="string",
     *             format="string",
     *             example="{ ""$or"": [ { ""name"": ""Leanne Graham"" }, { ""name"": ""Ervin Howell"" } ] }",
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Document",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *                 type="object",
     *                 example="{""$set"": {""name"": ""John Doe""}}"
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *         @OA\MediaType(
     *             mediaType="application/vnd.api+json",
     *             @OA\Schema(
     *                 type="object",
     *                 example=
"{
  ""matchedCount"": 2,
  ""modifiedCount"": 2,
  ""isAcknowledged"": true
}"
     *             ),
     *         ),
     *     ),
     * )
     */

    /**
     * Handle the incoming request.
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request, string $databaseName, string $collectionName): JsonResponse
    {
        $collection = app()->Mongo->getClient()->{$databaseName}->{$collectionName};

        $filter = json_decode($request->filter);

        ! isset($filter->_id->{'$oid'}) ?: $filter->_id = new ObjectId($filter->_id->{'$oid'});

        $updateResult = $collection->updateMany($filter, json_decode($request->getContent()));

        return response()->json([
            'matchedCount' => $updateResult->getMatchedCount(),
            'modifiedCount' => $updateResult->getModifiedCount(),
            'isAcknowledged' => $updateResult->isAcknowledged(),
        ], 200);
    }
}

<?php
class ArkController
{
    /**
     * @OA\Post(
     *     path="/ark/create",
     *     tags={"ark"},
     *     summary="Create a new Ark machine",
     *     operationId="insertArk",
     * @OA\Parameter(
     *         name="token",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     * @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="ark_name",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="attack",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="skill",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="hitpoint",
     *                     type="string",
     *                 ),
     *                 example={"ark_name": "Bambang19.2", "attack": "510", "skill": "Sleepburst", "hitpoint": "1400"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="401", description="Invalid credential") 
     * )
     */
    public function insertArk()
    { }


    /**
     * @OA\Put(
     *     path="/ark/{arkId}/uploadBanner",
     *     description="",
     *     tags={"ark"},
     *     summary="Upload battle banner for Ark machine",
     *     operationId="uploadFile",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     description="Additional data to pass to server",
     *                     property="additionalMetadata",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     description="file to upload",
     *                     property="file",
     *                     type="string",
     *                     format="file",
     *                 ),
     *                 required={"file"}
     *             )
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="ID of pet to update",
     *         in="path",
     *         name="petId",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="successful operation",
     *         @OA\Schema(ref="#/components/schemas/ApiResponse")
     *     ),
     * )
     * */
    public function uploadBanner()
    {

    }

    /**
     * @OA\Get(
     *     path="/ark/upgrade/{arkId}",
     *     tags={"ark"},
     *     summary="Upgrade your Ark machine",
     *     description="This can only be done by the logged in user. <br> Upgrade can only be done once for every Ark machine.",
     *     operationId="upgradeArk",
     * @OA\Parameter(
     *         name="token",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="401", description="Invalid credential") 
     * )
     */
    public function upgradeArk()
    { }

}

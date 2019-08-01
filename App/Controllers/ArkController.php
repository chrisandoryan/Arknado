<?php

namespace App\Controllers;

require_once __DIR__ . '/../Helpers/Database.php';
require_once __DIR__ . '/../Helpers/JWT.php';

use Database;
use JWT;

class ArkController
{

    private $conn;
    private $jwt;

    function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();

        $this->jwt = new JWT();
    }

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
    public function insertArk($raw)
    {
        $data = json_decode($raw, true);

        $user = $this->jwt->decode($data['token']);
        $userid = $user['userid'];

        $ark_name = $data['ark_name'];
        $attack = $data['attack'];
        $hitpoint = $data['hitpoint'];
        $skill = $data['skill'];

        $query = "INSERT INTO arks VALUES (DEFAULT, $userid, '$ark_name', $attack, $hitpoint, '$skill');";

        if ($this->conn->query($query) === TRUE) {
            $response = [
                "status" => "success",
                "message" => "OK",
            ];
        } else {
            $response = [
                "status" => "failed",
                "message" => "Failed to create new Ark machine",
                "trace" => $this->conn->error
            ];
        }

        return $response;
    }


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
    public function uploadBanner($id, $files)
    { 
        $arkid = $id;
        $banner = $files['arkbanner'];

        $banner_name = $banner['name'];
        $banner_tmploc = $banner['tmp_name'];

        if (move_uploaded_file($banner_tmploc, __DIR__ . "/../../public/images/$banner_name")) {
            $query = "UPDATE arks SET banner_name = '$banner_name' WHERE id = $arkid;";
            if ($this->conn->query($query) === TRUE) {
                $response = [
                    "status" => "success",
                    "message" => "OK",
                    "banner_name" => $banner_name
                ];
            }
            else {
                $response = [
                    "status" => "failed",
                    "message" => "Failed to update Ark banner path",
                    "trace" => $this->conn->error
                ];
            }
        }
        else {
            $response = [
                "status" => "failed",
                "message" => "Failed to upload Ark banner",
            ];
        }

        return $response;
        
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
    public function upgradeArk($id, $raw)
    {
        $arkid = $id;

        $user = $this->jwt->decode($raw['token']);
        $userid = $user['userid'];

        $query = "SELECT * FROM arks WHERE id = $arkid;";

        $result = $this->conn->query($query);
        if ($result->num_rows > 0) {
            $ark = $result->fetch_assoc();

            $upgrade_hp = random_int(500, 1000);
            $nhp = $ark['hitpoint'] + $upgrade_hp;

            $upgrade_atk = random_int(500, 1000);
            $natk = $ark['attack'] + $upgrade_atk;

            $query = "UPDATE arks SET hitpoint = $nhp, attack = $natk WHERE id = $arkid;";

            if ($this->conn->query($query) === TRUE) {
                $response = [
                    "status" => "success",
                    "message" => "OK",
                    "result" => [
                        "up_hitpoint" => $upgrade_hp,
                        "up_attack" => $upgrade_atk
                    ],
                ];
            } else {
                $response = [
                    "status" => "failed",
                    "message" => "Failed to upgrade Ark machine",
                ];
            }
        }
        else {
            $response = [
                "status" => "failed",
                "message" => "Ark machine not found"
            ];
        }

        return $response;
    }

    public function getArks($raw)
    {

        $user = $this->jwt->decode($raw['token']);
        $userid = $user['userid'];

        $query = "SELECT * FROM arks WHERE userid = $userid";

        $result = $this->conn->query($query);

        if ($result->num_rows > 0) {
            $arks = $result->fetch_all(MYSQLI_ASSOC);
            $response = [
                "status" => "success",
                "message" => "OK",
                "data" => $arks
            ];
        } else {
            $response = [
                "status" => "failed",
                "message" => "Failed while fetching Ark machines",
            ];
        }

        return $response;
    }
}

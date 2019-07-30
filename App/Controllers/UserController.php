<?php
class UserController
{
    /**
     * @OA\Post(
     *     path="/user/login",
     *     tags={"user"},
     *     description="Returns a JWT Token for authentication", 
     *     summary="Password-based login endpoint",
     *     operationId="login",
     * @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                 ),
     *                 example={"email": "train3e@binus.ac.id", "password": "192yangterbaik"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="401", description="Invalid credential") 
     * )
     */
    public function login()
    { }

    public function logout()
    { }

    /**
     * @OA\POST(
     *     path="/user/register",
     *     tags={"user"},
     *     summary="Register new account",
     *     operationId="register",
     * * @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string",
     *                 ),
     *                  @OA\Property(
     *                     property="email",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                 ),
     *                 example={"name": "Trainee Terbayk","email": "train3e@binus.ac.id", "password": "192yangterbaik"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Missing required data"
     *     )
     * )
     */
    public function register()
    { }

    /**
     * @OA\Post(
     *     path="/user/check",
     *     tags={"user"},
     *     summary="Check token validity",
     *     operationId="checkToken",
     * @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="token",
     *                     type="string",
     *                 ),
     *                 example={"token": "abcdefghijkl"}
     *             )
     *         )
     *     ),
     * @OA\Response(response="200", description="OK"),
     * @OA\Response(response="400", description="Invalid token")
     * )
     */
    public function checkToken()
    { }

    /**
     * @OA\Get(
     *     path="/user/{username}",
     *     tags={"user"},
     *     summary="Get detailed user information",
     *     description="This can only be done by the logged in user.",
     *     operationId="getUser",
     *     @OA\Parameter(
     *         name="token",
     *         in="header",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid data supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    public function getUser()
    { }

    /**
     * @OA\Put(
     *     path="/user/{username}",
     *     tags={"user"},
     *     summary="Update user information",
     *     description="This can only be done by the logged in user.",
     *     operationId="updateUser",
     *     @OA\Parameter(
     *         name="username",
     *         in="path",
     *         description="name to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="token",
     *         in="header",
     *         description="authentication token",
     *         required=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid argument"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OA\RequestBody(
     *         description="Updated user information",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="username",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string",
     *                 ),
     *                 example={"username": "Bambang19.2_Jr.", "email": "192jadiasisten@binus.edu", "password": "mungkinkah?"}
     *             )
     *         )
     *     )
     * )
     */
    public function updateUser()
    { }
}

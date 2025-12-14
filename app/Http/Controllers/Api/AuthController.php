<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     * path="/api/auth/register",
     * tags={"Authentication"},
     * summary="Register",
     * description="Mendaftarkan akun pelanggan baru",
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * required={"first_name", "last_name", "email", "phone_number", "password"},
     * @OA\Property(property="first_name", type="string", example="Budi"),
     * @OA\Property(property="middle_name", type="string", example="Santoso", description="Opsional"),
     * @OA\Property(property="last_name", type="string", example="Wibowo"),
     * @OA\Property(property="email", type="string", format="email", example="saputra@gmail.com"),
     * @OA\Property(property="phone_number", type="string", example="08123456789"),
     * @OA\Property(property="password", type="string", format="password", example="password123", description="Minimal 8 karakter"),
     * )
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Berhasil Register",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="User successfully registered"),
     * @OA\Property(property="user", type="object"),
     * )
     * ),
     * @OA\Response(response=400, description="Validasi Gagal (Email sudah ada / Password kurang)")
     * )
    */

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'   => 'required|string|max:255',
            'middle_name'  => 'nullable|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|string|max:20',
            'password'     => 'required|string|min:5',
            ]);

    if ($validator->fails()) {
         return response()->json($validator->errors(), 400);
    }

        $user = User::create([
            'first_name'   => $request->first_name,
            'middle_name'  => $request->middle_name,
            'last_name'    => $request->last_name,
            'email'        => $request->email,
            'phone_number' => $request->phone_number,
            'password'     => Hash::make($request->password),
            'role'         => 'customer',
            'status'       => 1,
            'notice'       => null,
        ]);

        return response()->json([
            'message' => 'Berhasil registrasi',
            'user' => $user
        ], 201);
    }

    /**
     * @OA\Post(
     * path="/api/auth/login",
     * tags={"Authentication"},
     * summary="Login",
     * description="Masukkan email dan password untuk mendapatkan token",
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * @OA\Property(property="email", type="string", format="email", example="contoh@gmail.com"),
     * @OA\Property(property="password", type="string", format="password", example="password123"),
     * )
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Berhasil Login",
     * @OA\JsonContent(
     * @OA\Property(property="access_token", type="string"),
     * @OA\Property(property="token_type", type="string", example="bearer"),
     * )
     * ),
     * @OA\Response(response=401, description="Unauthorized")
     * )
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required|string|min:5',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth('api')->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }
    
    /**
     * @OA\Post(
     * path="/api/auth/logout",
     * tags={"Authentication"},
     * summary="Logout",
     * description="Endpoint ini membutuhkan Token JWT",
     * security={{"bearerAuth":{}}}, 
     * @OA\Response(
     * response=200,
     * description="Sukses Logout",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="data", type="array", @OA\Items(type="object")),
     * )
     * ),
     * @OA\Response(response=401, description="Token Salah / Tidak Ada")
     * )
     */

    public function logout(){
        auth('api')->logout();

        return response()->json(['message' => 'Berhasil Logout']);
    }

    /**
     * @OA\Post(
     * path="/api/auth/refresh",
     * tags={"Authentication"},
     * summary="Refresh Token",
     * description="Endpoint ini membutuhkan Token JWT",
     * security={{"bearerAuth":{}}}, 
     * @OA\Response(
     * response=200,
     * description="Sukses reset token",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="data", type="array", @OA\Items(type="object")),
     * )
     * ),
     * @OA\Response(response=401, description="Token Salah / Tidak Ada")
     * )
     */

    public function refresh(){
        $newToken = JWTAuth::parseToken()->refresh();

        return $this->createNewToken($newToken);
    }

    /**
     * @OA\Get(
     * path="/api/auth/user-profile",
     * tags={"Authentication"},
     * summary="Informasi Data",
     * description="Endpoint ini membutuhkan Token JWT",
     * security={{"bearerAuth":{}}}, 
     * @OA\Response(
     * response=200,
     * description="Sukses ambil data",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="data", type="array", @OA\Items(type="object")),
     * )
     * ),
     * @OA\Response(response=401, description="Token Salah / Tidak Ada")
     * )
     */

    public function userProfile(){
        return response()->json(auth('api')->user());
    }

    protected function createNewToken($token)
    {
    $ttl = config('jwt.ttl'); 

    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => $ttl * 60,
        'user' => auth('api')->user()
    ]);
    }
    }

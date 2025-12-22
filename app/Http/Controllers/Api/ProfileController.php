<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/profile",
     * tags={"Profile Management"},
     * summary="Lihat Data Diri Sendiri",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Data profile user",
     * @OA\JsonContent()
     * )
     * )
     */

    public function index()
    {
        $profile = Auth::user();

        return response()->json([
            'status' => 'Sukses',
            'data' => $profile
        ]);
    }


    /**
     * @OA\Post(
     * path="/api/profile",
     * tags={"Profile Management"},
     * summary="Update Biodata & Foto Profil",
     * description="Update data diri user",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * required={"first_name", "last_name", "email"},
     * @OA\Property(property="first_name", type="string", example="John"),
     * @OA\Property(property="middle_name", type="string", example="D.", description="Opsional"),
     * @OA\Property(property="last_name", type="string", example="Doe"),
     * @OA\Property(property="email", type="string", format="email", example="john@example.com"),
     * @OA\Property(property="phone_number", type="string", example="08123456789"),
     * @OA\Property(property="address", type="string", example="Jl. Merdeka No. 1, Jakarta"),
     * @OA\Property(
     * property="profile_photo", 
     * type="string", 
     * format="binary", 
     * description="File foto profil (jpg, png, jpeg). Max 2MB."
     * )
     * )
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Profile berhasil diupdate",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="sukses"),
     * @OA\Property(property="message", type="string", example="Berhasil ubah foto profil"),
     * @OA\Property(property="data", type="object")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Validasi Gagal",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="The email has already been taken."),
     * @OA\Property(property="errors", type="object")
     * )
     * )
     * )
     */

    public function update(UpdateProfileRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::find(Auth::id());

        if($request->hasFile('profile_photo')) {

            if($user->profile_picture && Storage::exists('public/profile-picture/' . $user->profile_picture)) {
                Storage::delete('public/profile-picture/' . $user->profile_picture);
            }

            $file = $request->file('profile_photo');
            $filename = time() . '-' . $file->getClientOriginalName();
            $file->storeAs('public/profile-picture/' . $filename);

            $validatedData['profile_picture'] = $filename;

        }

        $user->update($validatedData);

        return response()->json([
            'status' => 'sukses',
            'message' => 'Berhasil edit profil',
            'data' => $user
        ]);
    }


    /**
     * @OA\Put(
     * path="/api/change-password",
     * tags={"Profile Management"},
     * summary="Ganti Password Akun",
     * description="Form ganti password (x-www-form-urlencoded)",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="application/x-www-form-urlencoded",
     * @OA\Schema(
     * required={"current_password", "new_password", "new_password_confirmation"},
     * @OA\Property(
     * property="current_password", 
     * type="string", 
     * format="password", 
     * example="password123",
     * description="Password saat ini"
     * ),
     * @OA\Property(
     * property="new_password", 
     * type="string", 
     * format="password", 
     * example="newpassword123",
     * description="Password baru (min 8 karakter)"
     * ),
     * @OA\Property(
     * property="new_password_confirmation", 
     * type="string", 
     * format="password", 
     * example="newpassword123",
     * description="Ulangi password baru"
     * )
     * )
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Password berhasil diganti",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="sukses"),
     * @OA\Property(property="message", type="string", example="Password berhasil diganti")
     * )
     * ),
     * @OA\Response(
     * response=400,
     * description="Password lama salah",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="error"),
     * @OA\Property(property="message", type="string", example="Password lama salah")
     * )
     * ),
     * @OA\Response(response=422, description="Validasi Error")
     * )
     */

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:5|confirmed',
        ]);

        if($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find(Auth::id());

        if(!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Password lama yang Anda masukkan salah.'
            ], 400);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status' => 'sukses',
            'message' => 'Password berhasil diganti. Silakan login ulang jika diperlukan.'
        ]);
    }
}

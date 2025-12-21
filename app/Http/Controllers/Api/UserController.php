<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/users",
     * operationId="getUsersList",
     * tags={"User Management"},
     * summary="Ambil daftar semua user",
     * description="List semua user yang terdaftar",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Berhasil mengambil data",
     * @OA\JsonContent()
     * ),
     * @OA\Response(response=401, description="Unauthenticated"),
     * @OA\Response(response=403, description="Forbidden")
     * )
     */

    public function index()
    {
        $currentUser = Auth::user();

        if($currentUser->role !== 'global_admin' && $currentUser->role !== 'admin') {
            return response()->json([
                'sukses' => false,
                'pesan' => 'Forbidden: Hanya admin yang dapat mengakses'
            ], 403);
        }

        $users = User::all();

        return response()->json([
            'status' => 'Sukses',
            'data'  => $users
        ], 200);
    }


    /**
     * @OA\Get(
     * path="/api/users/{id}",
     * operationId="getUserById",
     * tags={"User Management"},
     * summary="Ambil detail user",
     * description="Melihat detail satu user",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * description="User ID",
     * required=true,
     * in="path",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Detail User ditemukan",
     * @OA\JsonContent()
     * ),
     * @OA\Response(response=404, description="User tidak ditemukan"),
     * @OA\Response(response=403, description="Unauthorized Access")
     * )
     */

    public function show($id){
        $userTarget = User::find($id);

        if(!$userTarget)
            return response()->json([
                'sukses' => false,
                'pesan' => 'User tidak ditemukan'
            ], 404);

        $currentUser = Auth::user();

        if($currentUser->role == 'global_admin' || $currentUser->id == $userTarget->id) {
            return response()->json([
                'sukses' => true,
                'data' => $userTarget
            ], 200);
        }

        return response()->json([
            'sukses' => false,
            'pesan' => 'Forbidden: Anda tidak dapat melihat data orang lain'
        ], 403);
    }


    /**
     * @OA\Delete(
     * path="/api/users/{id}",
     * operationId="deleteUser",
     * tags={"User Management"},
     * summary="Hapus User",
     * description="Hapus user permanen dari sistem",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * description="User ID yang akan dihapus",
     * required=true,
     * in="path",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="User berhasil dihapus",
     * @OA\JsonContent()
     * ),
     * @OA\Response(response=404, description="User tidak ditemukan"),
     * @OA\Response(response=403, description="Forbidden")
     * )
     */

    public function destroy($id)
    {
        $userTarget = User::find($id);

        if(!$userTarget)
            return response()->json([
                'sukses' => false,
                'pesan' => 'User tidak ditemukan'
            ], 404);

        $currentUser = Auth::user();

        $userTarget->delete();

        if($currentUser->role == 'global_admin') {
            return response()->json([
                'sukses' => true,
                'pesan' => 'User berhasil dihapus'
            ], 200);
        }

        return response()->json([
            'sukses' => false,
            'pesan' => 'Forbidden: Anda tidak berhak menghapus akun'
        ], 403);
    }
}

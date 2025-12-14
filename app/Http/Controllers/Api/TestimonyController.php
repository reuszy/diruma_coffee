<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimony;
use Illuminate\Support\Facades\Validator;

class TestimonyController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/testimony",
     * tags={"Testimoni"},
     * summary="Ambil Semua Data Testimoni",
     * @OA\Response(
     * response=200,
     * description="Sukses ambil data",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="success"),
     * @OA\Property(property="data", type="array", @OA\Items(type="object")),
     * )
     * ),
     * @OA\Response(response=401, description="Tidak Ada")
     * )
     */

    public function index()
    {
        $testimonies = Testimony::all();

        return response()->json([
            'Pesan'   => 'Sukses',
            'data'      => $testimonies,
        ]);
    }

    /**
    * @OA\Get(
    * path="/api/testimony/{id}",
    * tags={"Testimoni"},
    * summary="Lihat Detail Satu Testimoni",
    * @OA\Parameter(
    * name="id",
    * in="path",
    * description="ID Testimoni",
    * required=true,
    * @OA\Schema(type="integer")
    * ),
    * @OA\Response(
    * response=200,
    * description="Detail Ditemukan",
    * @OA\JsonContent(
    * @OA\Property(property="Status", type="string", example="Sukses"),
    * @OA\Property(property="data", type="object"),
    * )
    * ),
    * @OA\Response(response=404, description="Testimoni Tidak Ditemukan")
    * )
    */


    public function show($id)
    {
        $testimony = Testimony::find($id);

        if(!$testimony) return response()->json(['Pesan' => 'Tidak ada testimoni'], 404);
        return response()->json([
            'Status' => 'Sukses',
            'data' => $testimony,
        ]);
    }

    /**
    * @OA\Post(
    * path="/api/testimony",
    * tags={"Testimoni"},
    * summary="Tambah Testimoni Baru",
    * security={{"bearerAuth":{}}},
    * @OA\RequestBody(
    * required=true,
    * @OA\MediaType(
    * mediaType="multipart/form-data",
    * @OA\Schema(
    * @OA\Property(property="name", type="string", example="Budi Santoso"),
    * @OA\Property(property="content", type="string", example="Makanannya sangat enak dan higienis!")
    * )
    * )
    * ),
    * @OA\Response(
    * response=201,
    * description="Berhasil dibuat",
    * @OA\JsonContent(
    * @OA\Property(property="Status", type="string", example="Sukses"),
    * @OA\Property(property="Pesan", type="string", example="Testimoni berhasil ditambahkan"),
    * @OA\Property(property="data", type="object"),
    * )
    * ),
    * @OA\Response(response=403, description="Forbidden (Bukan Admin)"),
    * @OA\Response(response=400, description="Validasi Gagal")
    * )
    */

    public function store(Request $request)
    {
        $user = auth('api')->user();
        if(!$user || $user->role !== 'global_admin' && $user->role !== 'admin'){
            return response()->json(['Pesan' => 'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:100',
            'content'   => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $testimony = Testimony::create([
            'name'      => $request->name,
            'content'   => $request->content,
        ]);

        return response()->json([
            'Status'    => 'Sukses',
            'Pesan' => 'Testimoni berhasil ditambahkan',
            'data' => $testimony,
        ], 201);
    }

    /**
    * @OA\Put(
    * path="/api/testimony/{id}",
    * tags={"Testimoni"},
    * summary="Update Testimoni",
    * security={{"bearerAuth":{}}},
    * @OA\Parameter(
    * name="id",
    * in="path",
    * required=true,
    * @OA\Schema(type="integer")
    * ),
    * @OA\RequestBody(
    * required=true,
    * @OA\MediaType(
    * mediaType="application/x-www-form-urlencoded",
    * @OA\Schema(
    * @OA\Property(property="name", type="string", example="Saputra"),
    * @OA\Property(property="content", type="string", example="makanannya enak enak")
    * )
    * )
    * ),
    * @OA\Response(response=200, description="Berhasil Update"),
    * @OA\Response(response=404, description="Tidak ditemukan"),
    * @OA\Response(response=403, description="Dilarang")
    * )
    */

    public function update(Request $request, $id)
    {
        $user = auth('api')->user();
        if(!$user || $user->role !== 'global_admin' && $user->role !== 'admin'){
            return response()->json(['Pesan' => 'Forbidden'], 403);
        }

        $testimony = Testimony::find($id);
            if(!$testimony) return response()->json(['Pesan' => 'Tidak ada Testimoni'], 404);

        $validator = Validator::make($request->all(), [
            'name'      => 'required|string|max:100',
            'content'   => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $testimony->update([
            'name'      => $request->name,
            'content'   => $request->content,
        ]);

        return response()->json([
            'Status' => 'Sukses',
            'Pesan' => 'Testimoni berhasil di Update',
            'data' => $testimony,
        ]);
    }

    /**
    * @OA\Delete(
    * path="/api/testimony/{id}",
    * tags={"Testimoni"},
    * summary="Hapus Testimoni",
    * security={{"bearerAuth":{}}},
    * @OA\Parameter(
    * name="id",
    * in="path",
    * required=true,
    * @OA\Schema(type="integer")
    * ),
    * @OA\Response(response=200, description="Berhasil Dihapus"),
    * @OA\Response(response=404, description="Tidak ditemukan"),
    * @OA\Response(response=403, description="Forbidden")
    * )
    */

    public function destroy($id)
    {
        $user = auth('api')->user();
        if(!$user || $user->role !== 'global_admin' && $user->role !== 'admin'){
            return response()->json(['Pesan' => 'Forbidden'], 403);
        }

        $testimony = Testimony::find($id);
            if(!$testimony) return response()->json(['Pesan' => 'Tidak ada Testimoni'], 404);

        $testimony->delete();

        return response()->json([
            'Status' => 'Sukses',
            'message' => 'Testimoni berhasil dihapus',
        ]);
    }
}

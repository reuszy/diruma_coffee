<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/categories",
     * tags={"Kategori"},
     * summary="Ambil Semua Data Kategori",
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
        $categories = Category::all();
        
        return response()->json([
            'status' => 'success',
            'data' => $categories
        ]);
    }

    /**
    * @OA\Get(
    * path="/api/categories/{id}",
    * tags={"Kategori"},
    * summary="Lihat Detail Satu Kategori",
    * @OA\Parameter(
    * name="id",
    * in="path",
    * description="ID Kategori",
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
    * @OA\Response(response=404, description="Kategori Tidak Ditemukan")
    * )
    */

    public function show($id)
    {
        $category = Category::find($id);

        if(!$category) return response()->json(['message' => 'Tidak ada kategori'], 404);
        return response()->json([
            'status' => 'success',
            'data' => $category,
        ]);
    }

    /**
    * @OA\Post(
    * path="/api/categories",
    * tags={"Kategori"},
    * summary="Tambah Kategori",
    * security={{"bearerAuth":{}}},
    * @OA\RequestBody(
    * required=true,
    * @OA\MediaType(
    * mediaType="multipart/form-data",
    * @OA\Schema(
    * @OA\Property(property="name", type="string", example=""),
    * )
    * )
    * ),
    * @OA\Response(
    * response=201,
    * description="Kategori Berhasil dibuat",
    * @OA\JsonContent(
    * @OA\Property(property="Status", type="string", example="Sukses"),
    * @OA\Property(property="Pesan", type="string", example="Kategori berhasil ditambahkan"),
    * @OA\Property(property="data", type="object"),
    * )
    * ),
    * @OA\Response(response=403, description="Forbidden"),
    * @OA\Response(response=400, description="Validasi Gagal")
    * )
    */

    public function store(Request $request)
    {
        $user = auth('api')->user();
        if ($user->role !== 'global_admin' && $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255|unique:categories,name',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $category = Category::create([
            'name'  => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category created successfully',
            'data' => $category
        ], 201);
    }

    /**
    * @OA\Put(
    * path="/api/categories/{id}",
    * tags={"Kategori"},
    * summary="Update Kategori",
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
    * @OA\Property(property="name", type="string", example=" "),
    * )
    * )
    * ),
    * @OA\Response(response=200, description="Berhasil Update"),
    * @OA\Response(response=404, description="Tidak ditemukan"),
    * @OA\Response(response=403, description="Forbidden")
    * )
    */

    public function update(Request $request, $id)
    {
        $user = auth('api')->user();
        if ($user->role !== 'global_admin' && $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'Category not found'], 404);

        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }

    /**
    * @OA\Delete(
    * path="/api/categories/{id}",
    * tags={"Kategori"},
    * summary="Hapus Kategori",
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
        if ($user->role !== 'global_admin' && $user->role !== 'admin') {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $category = Category::find($id);
        if (!$category) return response()->json(['message' => 'Category not found'], 404);

        $category->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Category deleted successfully'
        ]);
    }
}

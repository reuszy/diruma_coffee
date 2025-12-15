<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{

    /**
     * @OA\Get(
     * path="/api/menus",
     * tags={"Menu"},
     * summary="Ambil Semua Data Menu",
     * description="Endpoint ini membutuhkan Token JWT",
     * @OA\Response(
     * response=200,
     * description="Sukses ambil data",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="Sukses"),
     * @OA\Property(property="data", type="array", @OA\Items(type="object")),
     * )
     * ),
     * @OA\Response(response=401, description="Token Salah / Tidak Ada")
     * )
     */

    public function index(){
        $menus = Menu::all(); 

        return response()->json([
            'status' => 'Sukses',
            'data' => $menus
        ]);
    }

    /**
    * @OA\Get(
    * path="/api/menus/{id}",
    * tags={"Menu"},
    * summary="Lihat Detail Satu Menu",
    * @OA\Parameter(
    * name="id",
    * in="path",
    * description="ID Menu",
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
    * @OA\Response(response=404, description="Menu Tidak Ditemukan")
    * )
    */

    public function show($id){
        $menu = Menu::find($id);

        if(!$menu) return response()->json(['pesan' => 'Menu tidak ditemukan', 404]);
        return response()->json([
            'status' => 'Sukses',
            'data' => $menu,
        ]);
    }

    /**
     * @OA\Post(
     * path="/api/menus",
     * tags={"Menu"},
     * summary="Tambah Menu Baru",
     * description="Menambahkan data menu",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * required={"name", "price", "category_id"},
     * @OA\Property(property="name", type="string", example=""),
     * @OA\Property(property="description", type="string", example=""),
     * @OA\Property(property="price", type="number", format="float", example=25000),
     * @OA\Property(property="category_id", type="integer", example=1, description=""),
     * @OA\Property(property="image", type="string", format="binary", description="max 2MB")
     * )
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Created",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="Sukses"),
     * @OA\Property(property="pesan", type="string", example="Menu berhasil Ditambahkan"),
     * @OA\Property(property="data", type="object")
     * )
     * ),
     * @OA\Response(
     * response=400,
     * description="Bad Request (Validasi Gagal)",
     * @OA\JsonContent(
     * @OA\Property(
     * property="name",
     * type="array",
     * @OA\Items(type="string", example="The name field is required.")
     * )
     * )
     * ),
     * @OA\Response(
     * response=403,
     * description="Forbidden (Bukan Admin)",
     * @OA\JsonContent(
     * @OA\Property(property="pesan", type="string", example="Dilarang, hanya admin yang dapat mengakses halaman ini")
     * )
     * )
     * )
     */

    public function store(Request $request){
        $user = auth('api')->user();
        if($user->role !== 'global_admin' && $user->role !== 'admin'){
            return response()->json(['pesan'   => 'Dilarang, hanya admin yang dapat mengakses halaman ini'], 403);
        }

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id'    => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        $menu = Menu::create([
            'name'        => $request->name,
            'description' => $request->description,
            'price'       => $request->price,
            'category_id'    => $request->category_id,
            'image'       => $imagePath,
            'is_available'=> true,       
        ]);

        return response()->json([
            'status' => 'Sukses',
            'pesan' => 'Menu berhasil Ditambahkan',
            'data' => $menu
        ], 201);
    }

    /**
     * @OA\Post(
     * path="/api/menus/{id}",
     * tags={"Menu"},
     * summary="Update Menu",
     * description="Mengupdate data menu. Gunakan method POST dengan _method=PUT untuk support upload file.",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="ID Menu",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(
     * mediaType="multipart/form-data",
     * @OA\Schema(
     * required={"name", "price", "category_id", "_method"},
     * @OA\Property(property="_method", type="string", example="PUT", description="Wajib diisi PUT"),
     * @OA\Property(property="name", type="string", example=""),
     * @OA\Property(property="description", type="string", example=""),
     * @OA\Property(property="price", type="number", format="float", example=25000),
     * @OA\Property(property="category_id", type="integer", example=1),
     * @OA\Property(property="image", type="string", format="binary", description="Upload gambar baru jika ingin ganti")
     * )
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Success",
     * @OA\JsonContent(
     * @OA\Property(property="status", type="string", example="sukses"),
     * @OA\Property(property="pesan", type="string", example="Menu berhasil di update"),
     * @OA\Property(property="data", type="object")
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Not Found",
     * @OA\JsonContent(
     * @OA\Property(property="pesan", type="string", example="Tidak ada Menu")
     * )
     * ),
     * @OA\Response(
     * response=403,
     * description="Forbidden",
     * @OA\JsonContent(
     * @OA\Property(property="pesan", type="string", example="Dilarang, hanya admin yang dapat mengakses halaman ini")
     * )
     * )
     * )
     */

    public function update(Request $request, $id)
    {
        $user = auth('api')->user();
        if($user->role !== 'global_admin' && $user->role !== 'admin'){
            return response()->json(['pesan' => 'Dilarang, hanya admin yang dapat mengakses halaman ini'], 403);
        }

        $menu = Menu::find($id);
            if(!$menu) return response()->json(['pesan' => 'Tidak ada Menu', 404]);

        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 400);
        }

        $imagePath = $menu->image; 

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menus', 'public');
        }

        $menu->update([
            'name'          => $request->name,
            'description'   => $request->description,
            'price'         => $request->price,
            'category_id'   => $request->category_id,
            'image'         => $imagePath,
        ]);

        return response()->json([
            'status'    => 'sukses',
            'pesan'     => 'Menu berhasil di update',
            'data'      => $menu,
        ]);
    }

    /**
    * @OA\Delete(
    * path="/api/menus/{id}",
    * tags={"Menu"},
    * summary="Hapus Menu",
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
            return response()->json(['Pesan' => 'Dilarang'], 403);
        }

        $menu = Menu::find($id);
            if(!$menu) return response()->json(['pesan' => 'Tidak ada Menu'], 404);

        $menu->delete();

        return response()->json([
            'status' => 'Sukses',
            'pesan' => 'Menu berhasil dihapus',
        ]);
    }

}

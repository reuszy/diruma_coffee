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
     * security={{"bearerAuth":{}}}, 
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

}

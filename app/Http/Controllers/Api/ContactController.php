<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RestaurantAddress;
use App\Models\RestaurantPhoneNumber;
use App\Models\RestaurantWorkingHour;
use App\Models\SocialMediaHandle;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/contact",
     * tags={"Kontak"},
     * summary="Ambil Semua Data Kontak & Sosmed",
     * @OA\Response(response=200, description="Sukses"),
     * )
     */
    public function index()
    {
        $site_name = config('site.name');
        $socmed    = SocialMediaHandle::all();
        $address   = RestaurantAddress::first();
        $phone     = RestaurantPhoneNumber::first();
        $hour      = RestaurantWorkingHour::first();
        
        return response()->json([
            'status' => 'success',
            'data'   => [
                'name'         => $site_name,
                'address'      => $address,
                'phone'        => $phone,
                'working_hour' => $hour,
                'social_media' => $socmed,
            ]
        ]);
    }

    /**
     * @OA\Post(
     * path="/api/contact/update-info",
     * tags={"Kontak"},
     * summary="Update Info Dasar (Alamat, Telp, Jam Buka) - Admin Only",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(mediaType="multipart/form-data",
     * @OA\Schema(
     * @OA\Property(property="address", type="string"),
     * @OA\Property(property="phone", type="string"),
     * @OA\Property(property="working_hour", type="string"),
     * )
     * )
     * ),
     * @OA\Response(response=200, description="Berhasil Update"),
     * @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function update(Request $request)
    {
        $user = auth('api')->user();
        if (!$user || ($user->role !== 'global_admin' && $user->role !== 'admin')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'address'      => 'nullable|string|max:500',
            'phone'        => 'nullable|string|max:20',
            'working_hour' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->has('address')) {
            RestaurantAddress::updateOrCreate(
                ['id' => 1],
                ['address' => $request->address]
            );
        }

        if ($request->has('phone')) {
            // Cek apakah ada record pertama
            $phoneObj = RestaurantPhoneNumber::first();
            if ($phoneObj) {
                $phoneObj->update(['phone_number' => $request->phone]);
            } else {
                RestaurantPhoneNumber::create(['phone_number' => $request->phone]);
            }
        }

        if ($request->has('working_hour')) {
            $hourObj = RestaurantWorkingHour::first();
            if ($hourObj) {
                $hourObj->update(['working_hours' => $request->working_hour]);
            } else {
                RestaurantWorkingHour::create(['working_hours' => $request->working_hour]);
            }
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Contact information updated successfully',
        ]);
    }

    /**
     * @OA\Post(
     * path="/api/contact/social-media",
     * tags={"Kontak"},
     * summary="Tambah Sosial Media Baru (Admin Only)",
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\MediaType(mediaType="multipart/form-data",
     * @OA\Schema(
     * @OA\Property(property="handle", type="string", example=" "),
     * @OA\Property(property="social_media", type="string", example=" "),
     * )
     * )
     * ),
     * @OA\Response(response=201, description="Berhasil Ditambah")
     * )
     */
    public function storeSocialMedia(Request $request)
    {
        $user = auth('api')->user();
        if (!$user || ($user->role !== 'global_admin' && $user->role !== 'admin')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $validator = Validator::make($request->all(), [
            'handle' => 'required|string|max:50',
            'social_media'     => 'required|max:255',
        ]);

        if ($validator->fails()) return response()->json($validator->errors(), 400);

        $socmed = SocialMediaHandle::create([
            'handle'        => $request->handle,
            'social_media'  => $request->social_media,
        ]);

        return response()->json(['status' => 'success', 'data' => $socmed], 201);
    }

    /**
     * @OA\Delete(
     * path="/api/contact/social-media/{id}",
     * tags={"Kontak"},
     * summary="Hapus Sosial Media (Admin Only)",
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Berhasil Dihapus")
     * )
     */
    public function destroySocialMedia($id)
    {
        $user = auth('api')->user();
        if (!$user || ($user->role !== 'global_admin' && $user->role !== 'admin')) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $socmed = SocialMediaHandle::find($id);
        if (!$socmed) return response()->json(['message' => 'Social Media not found'], 404);

        $socmed->delete();

        return response()->json(['status' => 'success', 'message' => 'Deleted successfully']);
    }
}
<?php

namespace App\Http\Controllers\API;

use App\BoardingHouseImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseFormatter;

class BoardingHouseImageController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);

        if($id)
        {
            $image = BoardingHouseImage::find($id);

            if($image)
            {
                return ResponseFormatter::success($image, 'Data gambar kos berhasil diambil');
            }
            else
            {
                return ResponseFormatter::error(null, 'data gambar kos tidak ada', 404);
            }
        }

        $image = BoardingHouseImage::query();

        return ResponseFormatter::success($image->paginate($limit), 'Data gambar kos berhasil diambil');
    }

    public function store(Request $request, $boarding_house_id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if($validator->fails())
        {
            return ResponseFormatter::error($validator->errors(), 'Gagal');
        }

        $image = new BoardingHouseImage();
        $image->boarding_house_id = $boarding_house_id;

        if($request->file('image'))
        {
            $file = $request->file('image')->store('houseimage', 'public');
            $image->image = $file;
        }

        $image->save();

        return ResponseFormatter::success($image, 'Data gambar kos berhasil diambil');
    }

    public function update(Request $request, $boardinghouseimage_id)
    {
        $image = BoardingHouseImage::find($boardinghouseimage_id);

        if($request->file('image'))
        {
            $file = $request->file('image')->store('houseimage', 'public');
            $image->image = $file;
        }

        $data = [
            'image' => $file
        ];

        $image->update($data);

        return ResponseFormatter::success($image, 'Data gambar behasil diubah');
    }

    public function destroy($boardinghouseimage_id)
    {
        $boardinghouseimage = BoardingHouseImage::find($boardinghouseimage_id);

        $boardinghouseimage->delete();

        return ResponseFormatter::success('data berhasil dihapus');
    }
}

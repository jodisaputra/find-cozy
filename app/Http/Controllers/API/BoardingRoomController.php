<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\BoardingRoom;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseFormatter;

class BoardingRoomController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);

        if($id)
        {
            $room = BoardingRoom::find($id);

            if($room)
            {
                return ResponseFormatter::success($room, 'Data kamar kos berhasil diambil');
            }
            else
            {
                return ResponseFormatter::error(null, 'Data kamar kos tidak ada', 404);
            }
        }

        $room = BoardingRoom::query();

        return ResponseFormatter::success($room->paginate($limit), 'Data kamar kos berhasil diambil');
    }

    public function store(Request $request, $boarding_house_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'status' => 'required',
            'price' => 'numeric|required'
        ]);

        if($validator->fails())
        {
           return ResponseFormatter::error($validator->errors(), 442);
        }

        $boardingroom = new BoardingRoom();
        $boardingroom->name = $request->name;
        $boardingroom->status = $request->status;
        $boardingroom->price = $request->price;
        $boardingroom->boarding_house_id = $boarding_house_id;

        $boardingroom->save();

        return ResponseFormatter::success($boardingroom, 'Data kamar kos berhasil disimpan');
    }

    public function update(Request $request, $boardingroom_id)
    {
        $boardingroom = BoardingRoom::find($boardingroom_id);

        $data = $request->all();

        $boardingroom->update($data);

        return ResponseFormatter::success($boardingroom, 'Data kamar kos berhasil diubah');
    }

    public function destroy($boardingroom_id)
    {
        $boardingroom = BoardingRoom::find($boardingroom_id);

        $boardingroom->delete();

        return ResponseFormatter::success('Data kamar kos berhasil dihapus');
    }
}

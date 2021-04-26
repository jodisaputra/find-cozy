<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BoardingRoomCollection;
use Illuminate\Http\Request;
use App\BoardingRoom;
use Illuminate\Support\Facades\Validator;

class BoardingRoomController extends Controller
{
    public function index($boarding_house_id)
    {
        return new BoardingRoomCollection(BoardingRoom::where('boarding_house_id', $boarding_house_id)->get());
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
            return response(['errors' => $validator->errors()], 422);
        }

        $boardingroom = new BoardingRoom();
        $boardingroom->name = $request->name;
        $boardingroom->status = $request->status;
        $boardingroom->price = $request->price;
        $boardingroom->boarding_house_id = $boarding_house_id;

        $boardingroom->save();

        return $boardingroom;
    }

    public function update(Request $request, $boardingroom_id)
    {
        $boardingroom = BoardingRoom::find($boardingroom_id);

        $data = $request->all();

        $boardingroom->update($data);

        return $boardingroom;
    }

    public function destroy($boardingroom_id)
    {
        $boardingroom = BoardingRoom::find($boardingroom_id);

        $boardingroom->delete();

        return response(['message' => 'success']);
    }
}

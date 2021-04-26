<?php

namespace App\Http\Controllers\API;

use App\BoardingHouse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BoardingHouseCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class BoardingHouseController extends Controller
{
    //get data boarding house for admin kost
    public function index()
    {
        return new BoardingHouseCollection(BoardingHouse::where('user_id', Auth::user()->id)->paginate(10));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'map_url' => 'string|max:255',
            'city' => 'required|string|max:255'
        ]);

        if($validator->fails())
        {
            return response(['errors' => $validator->errors()], 422);
        }

        $boardinghouse = new BoardingHouse();
        $boardinghouse->name = $request->name;
        $boardinghouse->address = $request->address;
        $boardinghouse->map_url = $request->map_url;
        $boardinghouse->user_id = Auth::user()->id;
        $boardinghouse->city = $request->city;

        $boardinghouse->save();

        return $boardinghouse;
    }

    public function update(Request $request, $boardinghouse_id)
    {
        $boardinghouse = BoardingHouse::find($boardinghouse_id);

        $data = $request->all();

        $boardinghouse->update($data);

        return $boardinghouse;
    }

    public function destroy($boardinghouse_id)
    {
        $boardinghouse = BoardingHouse::find($boardinghouse_id);

        $boardinghouse->delete();

        return response(['message' => 'success']);
    }
}

<?php

namespace App\Http\Controllers\API;

use App\BoardingHouse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class BoardingHouseController extends Controller
{
    //get data boarding house for user kost
    public function index(Request $request)
    {
        $id = $request->input('id');
        $limit = $request->input('limit', 6);

        if($id)
        {
            $boardinghouse = BoardingHouse::find($id);

            if($boardinghouse)
            {
                return ResponseFormatter::success($boardinghouse, 'Data kos berhasil diambil');
            }
            else
            {
                return ResponseFormatter::error(null, 'data kos tidak ada', 404);
            }
        }

        $boardinghouse = BoardingHouse::query();

        return ResponseFormatter::success($boardinghouse->paginate($limit), 'Data kos berhasil diambil');
    }

    // get data untuk admin
    public function getAdmin()
    {
        $boardinghouse = BoardingHouse::where('user_id', Auth::user()->id);

        return ResponseFormatter::success($boardinghouse, 'data kos berhasil diambil');
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
           return ResponseFormatter::error($validator->errors(), 422);
        }

        $boardinghouse = new BoardingHouse();
        $boardinghouse->name = $request->name;
        $boardinghouse->address = $request->address;
        $boardinghouse->map_url = $request->map_url;
        $boardinghouse->user_id = Auth::user()->id;
        $boardinghouse->city = $request->city;

        $boardinghouse->save();

        return ResponseFormatter::success($boardinghouse, 'Data kos berhasil disimpan');
    }

    public function update(Request $request, $boardinghouse_id)
    {
        $boardinghouse = BoardingHouse::find($boardinghouse_id);

        $data = $request->all();

        $boardinghouse->update($data);

        return ResponseFormatter::success($boardinghouse, 'Data kos berhasil disimpan');
    }

    public function destroy($boardinghouse_id)
    {
        $boardinghouse = BoardingHouse::find($boardinghouse_id);

        $boardinghouse->delete();

        return ResponseFormatter::success(null, 'Data kos berhasil dihapus');
    }
}

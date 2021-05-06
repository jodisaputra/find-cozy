<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Favorite;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;

class FavoritesController extends Controller
{
    public function index()
    {
        $favorites = Favorite::where('user_id', Auth::user()->id);

        return ResponseFormatter::success($favorites, 'Data favorites berhasil diambil');
    }

    public function store(Request $request, $boarding_house_id)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'boarding_house_id' => 'required',
        ]);

        if($validator->fails())
        {
           return ResponseFormatter::error($validator->errors(), 442);
        }

        $favorite = new Favorite();
        $favorite->user_id = $request->user_id;
        $favorite->boarding_house_id = $boarding_house_id;

        $favorite->save();

        return ResponseFormatter::success($favorite, 'Data Favorite berhasil disimpan');
    }

    public function destroy($favorite_id)
    {
        $favorite = Favorite::find($favorite_id);

        $favorite->delete();

        return ResponseFormatter::success('Data favorite berhasil dihapus');
    }
}

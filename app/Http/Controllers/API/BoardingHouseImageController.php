<?php

namespace App\Http\Controllers\API;

use App\BoardingHouseImage;
use App\Http\Controllers\Controller;
use App\Http\Resources\BoardingHouseImageCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BoardingHouseImageController extends Controller
{
    public function index($boarding_house_id)
    {
        return new BoardingHouseImageCollection(BoardingHouseImage::where('boarding_house_id', $boarding_house_id)->get());
    }

    public function store(Request $request, $boarding_house_id)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if($validator->fails())
        {
            return response(['errors' => $validator->errors()], 422);
        }

        $boardinghouseimage = new BoardingHouseImage();
        $boardinghouseimage->boarding_house_id = $boarding_house_id;

        if($request->file('image'))
        {
            $file = $request->file('image')->store('houseimage', 'public');
            $boardinghouseimage->image = $file;
        }

        $boardinghouseimage->save();

        return $boardinghouseimage;
    }

    public function update(Request $request, $boardinghouseimage_id)
    {
        $boardinghouseimage = BoardingHouseImage::find($boardinghouseimage_id);

        if($request->file('image'))
        {
            $file = $request->file('image')->store('houseimage', 'public');
            $boardinghouseimage->image = $file;
        }

        $data = [
            'image' => $file
        ];

        $boardinghouseimage->update($data);

        return $boardinghouseimage;
    }

    public function destroy($boardinghouseimage_id)
    {
        $boardinghouseimage = BoardingHouseImage::find($boardinghouseimage_id);

        $boardinghouseimage->delete();

        return response(['message' => 'success']);
    }
}

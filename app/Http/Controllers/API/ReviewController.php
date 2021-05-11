<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Review;
use App\Helpers\ResponseFormatter;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->input('id');
        $boardinghouseid = $request->input('boardinghouseid');
        $limit = $request->input('limit', 6);

        if($id)
        {
            $review = Review::find($id);

            if($review)
            {
                return ResponseFormatter::success($review, 'Data review berhasil diambil');
            }
            else
            {
                return ResponseFormatter::error(null, 'Data review tidak ada', 404);
            }
        }

        if($boardinghouseid)
        {
            $review = Review::where('boarding_house_id', $boardinghouseid);

            if($boardinghouseid)
            {
                return ResponseFormatter::success($review, 'Data review berhasil diambliawaawpooo;l.');
            }
        }

        $review = Review::query();

        return ResponseFormatter::success($review->paginate($limit), 'Data Review berhasil diambil');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'boarding_house_id' => 'required',
            'rate' => 'required',
            'comment' => 'string',
        ]);

        if($validator->fails())
        {
           return ResponseFormatter::error($validator->errors(), 422);
        }

        $review = new Review();
        $review->boarding_house_id = $request->boarding_house_id;
        $review->rate = $request->rate;
        $review->comment = $request->comment;
        $review->created_by = Auth::user()->id;

        $review->save();

        return ResponseFormatter::success($review, 'Data review berhasil disimpan');
    }

    public function destroy($review_id)
    {
        $review = Review::find($review_id);

        $review->delete();

        return ResponseFormatter::success(null, 'Data review berhasil dihapus');
    }
}

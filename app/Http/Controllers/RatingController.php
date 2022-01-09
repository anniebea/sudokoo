<?php

namespace App\Http\Controllers;

use App\Models\DifficultyRating;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    /**
     * Store a newly created resource in storage or update existing one.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->rating != '-1') {
            //check if user has already made a rating on this grid, otherwise update rating
            Rating::updateOrCreate(
                [
                    'sudoku_grid_id' => $request->grid,
                    'user_id' => $request->user,
                ],
                [
                    'is_positive' => $request->rating
                ],
            );
        }

        if($request->difficultyRating != '-1') {
            app(DifficultyRatingController::class)->store($request);
        }

        return redirect()->route('sudoku.show', ['id' => $request->grid]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function show($id)
    {
        $ratings = Rating::where('sudoku_grid_id', '=', $id)
            ->get(['is_positive', 'user_id'])
            ->map(function ($item) {
                return [
                    $item->user_id,
                    $item->is_positive,
                ];
            });

        if (count($ratings) == 0) {
            $avgRating = 'N/A';
            $userRating = 'N/A';
        }
        else if (count($ratings) == 1) {
            $avgRating = number_format($ratings[0][1]*100,2) . '%';
            $userRating = 'N/A';

            if ($ratings[0][0] == Auth::id())
                $userRating = $ratings[0][1];
        }
        else {
            $userRating = 'N/A';
            $numerator = 0;

            for($i = 0; $i < count($ratings); $i++) {
                $numerator = $numerator + $ratings[$i][1];

                if ($ratings[$i][0] == Auth::id())
                    $userRating = $ratings[$i][1];
            }
            $avgRating = number_format($numerator / count($ratings) *100, 2) . '%';
        }

        return [
            $avgRating,
            $userRating,
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($request->rating != '-1') {
            //check if user has already made a rating on this grid, otherwise update rating
            Rating::updateOrCreate(
                [
                    'sudoku_grid_id' => $id,
                    'user_id' => $request->user,
                ],
                [
                    'is_positive' => $request->rating
                ],
            );
        }

        if($request->difficultyRating != '-1') {
            app(DifficultyRatingController::class)->store($request);
        }

        return redirect()->route('sudoku.show', ['id' => $request->grid]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\DifficultyRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DifficultyRatingController extends Controller
{
    /**
     * Store a newly created resource in storage or update existing one.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->difficultyRating > '0') {
            //check if user has already made a rating on this grid, otherwise update rating
            DifficultyRating::updateOrCreate(
                [
                    'sudoku_grid_id' => $request->grid,
                    'user_id' => $request->user,
                ],
                [
                    'rating' => $request->difficultyRating
                ],
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $grid
     * @return array
     */
    public function show($grid)
    {
        $ratings = DB::table('difficulty_ratings')->where('sudoku_grid_id', '=', $grid->id)
            ->get(['rating', 'user_id'])
            ->map(function ($item) {
                return [
                    $item->user_id,
                    $item->rating,
                ];
            });

        if (count($ratings) == 0) {
            $avgRating = 'N/A';
            $userRating = 'N/A';
            $authorRating = 'N/A';
        }
        else if (count($ratings) == 1) {
            $avgRating = number_format($ratings[0][1]);
            $userRating = 'N/A';
            $authorRating = 'N/A';

            if ($ratings[0][0] == Auth::id())
                $userRating = $ratings[0][1];

            if ($ratings[0][0] == $grid->user_id)
                $authorRating = $ratings[0][1];
        }
        else {
            $userRating = 'N/A';
            $authorRating = 'N/A';
            $numerator = 0;

            for($i = 0; $i < count($ratings); $i++) {
                $numerator = $numerator + $ratings[$i][1];

                if ($ratings[$i][0] == Auth::id())
                    $userRating = $ratings[$i][1];

                if ($ratings[$i][0] == $grid->user_id)
                    $authorRating = $ratings[$i][1];
            }
            $avgRating = $numerator / count($ratings);
        }

        return [
            $avgRating,
            $userRating,
            $authorRating,
        ];
    }
}

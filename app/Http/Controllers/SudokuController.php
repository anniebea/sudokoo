<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\SudokuGrid;
use App\Models\SudokuGridContents;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SudokuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grids = SudokuGrid::with('user')
            ->orderByDesc('created_at')
            ->get();

        return view('sudoku.sudokuList', [
            'grids' => $grids,
//            'rating' => $rating,
//            'difficultyRating' => $difficultyRating
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sudoku.sudokuEdit', ['user' => Auth::user()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //only name validation is necessary, as the grid itself was deemed 'correct' pre-submission
        $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'title' => ['required', 'max:64']
        ]);

        $gridID = DB::table('sudoku_grids')->insertGetId([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'created_at' => Carbon::now()->toDateTimeString(),
        ]);

        $requests = $request->except([
            'title',
            'user_id',
            'created_at',
            'updated_at',
            'deleted_at',
            '_token'
        ]);

        foreach ($requests as $key => $value) {
            if ($value != '') {
                DB::table('sudoku_grid_contents')->insert([
                    'cell_num' => $key,
                    'cell_content' => $value,
                    'sudoku_grid_id' => $gridID
                ]);
            }
        };

        return redirect()->route('sudoku.list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $grid = SudokuGrid::with('contents')
            ->where('id', '=', $id)
            ->first();

        $contents = SudokuGridContents::where('sudoku_grid_id', '=', $grid->id)
            ->get(['cell_num','cell_content'])
            ->map(function ($item) {
                return [
                    $item->cell_num,
                    $item->cell_content,
                ];
            });

        $ratings = app(RatingController::class)->show($grid->id);
        $difficultyRatings = app(DifficultyRatingController::class)->show($grid);


        return view('sudoku.sudokuSolve', [
            'grid' => $grid,
            'contents' => $contents,
            'user' => Auth::user(),
            'avgRating' => $ratings[0],
            'userRating' => $ratings[1],
            'avgDifficultyRating' => $difficultyRatings[0],
            'userDifficultyRating' => $difficultyRatings[1],
            'authorDifficultyRating' => $difficultyRatings[2],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

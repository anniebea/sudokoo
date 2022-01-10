<?php

namespace App\Http\Controllers;

use App\Models\GridRule;
use App\Models\Rating;
use App\Models\Rule;
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
            ->whereNull('deleted_at')
            ->orderByDesc('created_at')
            ->get();

        for ($i = 0; $i < count($grids); $i++) {
            $ratingArray = app(RatingController::class)->show($grids[$i]->id);
            $grids[$i]->ratingArray = $ratingArray;
        }

        for ($i = 0; $i < count($grids); $i++) {
            $ratingArray = app(DifficultyRatingController::class)->show($grids[$i]);
            $grids[$i]->difficultyRatingArray = $ratingArray;
        }

        return view('sudoku.sudokuList', [
            'grids' => $grids,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rules = Rule::all();

        return view('sudoku.sudokuCreate', [
            'user' => Auth::user(),
            'rules' => $rules
        ]);
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
            'title' => ['required', 'max:64'],
            'custom_rules' => ['max:512']
        ]);

        $gridID = DB::table('sudoku_grids')->insertGetId([
            'title' => $request->title,
            'user_id' => $request->user_id,
            'created_at' => Carbon::now()->toDateTimeString(),
            'custom_rules' => $request->customRules,
        ]);

        $ruleIDs = str_split($request->rules);
        foreach ($ruleIDs as $ruleID) {
            if($ruleID != '0') {
                $gridRule = new GridRule();
                $gridRule->sudoku_grid_id = $gridID;
                $gridRule->rule_id = $ruleID;
                $gridRule->save();
            }
        }

        $requests = $request->except([
            'title',
            'user_id',
            'created_at',
            'updated_at',
            'deleted_at',
            'rules',
            'customRules',
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
        }

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

        $rules = Rule::all();
        $gridRules = GridRule::where('sudoku_grid_id', '=', $grid->id)->get('rule_id');
        $gridRuleArray = [];
        for ($i = 0; $i < count($gridRules); $i++) {
            $gridRuleArray[] = $gridRules[$i]->rule_id;
            break;
        }

        $ratings = app(RatingController::class)->show($grid->id);
        $difficultyRatings = app(DifficultyRatingController::class)->show($grid);
        $comments = app(CommentController::class)->show($grid);

        return view('sudoku.sudokuSolve', [
            'grid' => $grid,
            'contents' => $contents,
            'user' => Auth::user(),
            'rules' => $rules,
            'gridRules' => $gridRuleArray,
            'avgRating' => $ratings[0],
            'userRating' => $ratings[1],
            'avgDifficultyRating' => $difficultyRatings[0],
            'userDifficultyRating' => $difficultyRatings[1],
            'authorDifficultyRating' => $difficultyRatings[2],
            'comments' => $comments,
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
        $grid = SudokuGrid::with('contents')
            ->where('id', '=', $id)
            ->first();

        if(Auth::id() != $grid->user_id) {
            abort(403);
        }

        $contents = SudokuGridContents::where('sudoku_grid_id', '=', $grid->id)
            ->get(['cell_num','cell_content'])
            ->map(function ($item) {
                return [
                    $item->cell_num,
                    $item->cell_content,
                ];
            });

        $rules = Rule::all();
        $gridRules = GridRule::where('sudoku_grid_id', '=', $grid->id)->get('rule_id');
        $gridRuleArray = [];
        for ($i = 0; $i < count($gridRules); $i++) {
            $gridRuleArray[] = $gridRules[$i]->rule_id;
            break;
        }

        return view('sudoku.sudokuEdit', [
            'grid' => $grid,
            'contents' => $contents,
            'user' => Auth::user(),
            'rules' => $rules,
            'gridRules' => $gridRuleArray,
        ]);
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
        //only name validation is necessary, as the grid itself was deemed 'correct' pre-submission
        $request->validate([
            'title' => ['required', 'max:64'],
            'custom_rules' => ['max:512']
        ]);

        //get all associated grid_rules
        $gridRules = GridRule::where('sudoku_grid_id', '=', $id);

        //if a rule is not in $request->rules, delete it;
        $ruleIDs = str_split($request->rules);
        foreach ($gridRules as $gridRule) {
            if (!in_array($gridRule->rule_id, $ruleIDs)) {
                $gridRule->delete();
            }
        }

        //if a rule is in $request, but is not stored in DB, add it
        foreach ($ruleIDs as $ruleID) {
            if($ruleID != '0') {
                GridRule::firstOrCreate([
                    'sudoku_grid_id' => $id,
                    'rule_id' => $ruleID
                ]);
            }
        }

        $grid = SudokuGrid::where('id', '=', $id)->first();
        $grid->title = $request->title;
        $grid->updated_at = Carbon::now()->toDateTimeString();
        $grid->custom_rules = $request->customRules;
        $grid->save();

        $requests = $request->except([
            'title',
            'user_id',
            'created_at',
            'updated_at',
            'deleted_at',
            'rules',
            'customRules',
            '_token'
        ]);

        SudokuGridContents::where('sudoku_grid_id', '=', $id)->delete();

        //get only those cells which have values stored
        $notNullValues = array_filter($requests, function($arr) {
            return $arr != '';
        });

        foreach ($notNullValues as $key => $value) {
            SudokuGridContents::firstOrCreate([
                'sudoku_grid_id' => $id,
                'cell_num' => $key
            ], [
                'cell_content' => $value,
            ]);
        }

        return redirect()->route('sudoku.show', ['id' => $id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $grid = SudokuGrid::where('id', '=', $id)->first();
        if($grid->user_id != Auth::id()) {
            abort(403);
        }

        SudokuGridContents::where('sudoku_grid_id', '=', $id)->delete();

        GridRule::where('sudoku_grid_id', '=', $id)->delete();

        $grid->update(['deleted_at' => Carbon::now()->toDateTimeString()]);

        return redirect()->route('sudoku.list');
    }
}

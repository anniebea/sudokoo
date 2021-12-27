<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user' => ['required', 'exists:users,id'],
            'grid' => ['required', 'exists:sudoku_grids,id'],
            'comment' => ['required',  'string', 'max:512']
        ]);

        $comment = new Comment();
        $comment->user_id = $request->user;
        $comment->sudoku_grid_id = $request->grid;
        $comment->content = $request->comment;
        $comment->save();

        return redirect()->route('sudoku.show', ['id' => $comment->sudokuGrid->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  $grid
     * @return \Illuminate\Http\Response
     */
    public function show($grid)
    {
        return Comment::where('sudoku_grid_id', '=', $grid->id)
            ->whereNull('deleted_at')
            ->orderByDesc('created_at')
            ->get();
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
        $request->validate([
            'user' => ['required', 'exists:users,id'],
            'grid' => ['required', 'exists:sudoku_grids,id'],
            'commentUpdate' => ['required',  'string', 'max:512']
        ]);

        $comment = Comment::find($id);
        $comment->content = $request->commentUpdate;
        $comment->save();

        return redirect()->route('sudoku.show', ['id' => $comment->sudokuGrid->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::find($id);
        $grid = $comment->sudokuGrid->id;
        $comment->deleted_at = Carbon::now()->toDateTimeString();
        $comment->save();

        return redirect()->route('sudoku.show', ['id' => $grid]);
    }
}

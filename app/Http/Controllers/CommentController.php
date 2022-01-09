<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Rules\Author;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommentController extends Controller
{
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user' => ['required', 'exists:users,id', new Author],
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
        $request = new Request(['id' => $comment->user_id]);
        $request->validate([
            'id' => ['exists:users,id', new Author]
        ]);

        $comment->deleted_at = Carbon::now()->toDateTimeString();
        $comment->save();

        return redirect()->route('sudoku.show', ['id' => $comment->sudokuGrid->id]);
    }

    /**
     * Add comment to reviewable comment list
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function report($id) {
        $comment = Comment::find($id);
        $comment->is_reviewed = '0';
        $comment->save();

        return redirect()->route('sudoku.show', ['id' => $comment->sudokuGrid->id]);
    }

    /**
     * Remove comment from reviewable comment list.
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeReport($id) {
        $comment = Comment::find($id);
        if($comment->is_reviewed == '0') {
            $comment->is_reviewed = '1';
            $comment->save();
        }

        return redirect()->route('report.index');
    }

    /**
     * Display a listing of reported comments.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function reportIndex() {
        $reported = Comment::where('is_reviewed', '=', '0')
            ->whereNull('deleted_at')
            ->get();
        $previouslyReported = Comment::where('is_reviewed', '=', '1')
            ->whereNull('deleted_at')
            ->get();

        return view('admin.reportedComments', [
            'reported' => $reported,
            'prevReported' => $previouslyReported,
        ]);
    }
}

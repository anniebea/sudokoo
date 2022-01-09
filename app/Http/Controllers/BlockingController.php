<?php

namespace App\Http\Controllers;

use App\Models\Blocking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlockingController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $user = User::where('id','=', $id)
            ->first();

        return view('admin.blockForm', ['user' => $user]);
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
            'date_to' => ['nullable', 'date', 'after_or_equal:' . Carbon::now()->toDateString()],
            'user_id' => ['required', 'exists:users,id'],
        ]);

        DB::table('blockings')
            ->insert([
                'date_to' => $request->date_to,
                'date_from' => Carbon::now()->toDateString(),
                'user_id' => $request->user_id,
                'created_at' => Carbon::now()->toDateTimeString(),
            ]);

        DB::table('users')
            ->where('id','=', $request->user_id)
            ->update([
            'is_blocked' => '1'
        ]);

        return redirect()->route('user.list');
    }

    public function showBlocked()
    {
        return view('blockScreen');
    }
}

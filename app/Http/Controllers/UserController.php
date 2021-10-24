<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('role')->get();

        return view('profiles.profileList', ['users' => $users]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with('role')
            ->where('users.id', $id)
            ->first();

        return view('profiles.profile', ['user' => $user, 'login' => Auth::id()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->getUser($id);
        return view('profiles.profileEdit', ['user' => $user]);
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
        $user = $this->getUser($id);
        $username = $user->name;

        if($request->name != $username) //if no changes have been made to the username, then there is no need to validate it
        {
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:users'],
                'date_of_birth' => ['required', 'date', 'before_or_equal:' . Carbon::now()->subYears(16)->toDateString()],
            ]);
        }
        else
        {
            $request->validate([
                'date_of_birth' => ['required', 'date', 'before_or_equal:' . Carbon::now()->subYears(16)->toDateString()],
            ]);
        }

        DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'date_of_birth' => $request->dob,
            ]);

        return redirect()->route('user.show', ['id' => $id]);
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

    /**
     * Get a specific user
    */
    protected function getUser($id)
    {
        return DB::table('users')
            ->where('id','=',$id)
            ->first();
    }
}

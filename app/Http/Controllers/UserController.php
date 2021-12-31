<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\SudokuGrid;
use App\Models\User;
use Carbon\Carbon;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        Users - users who have never been blocked
        $users = User::with('role')->whereNull('is_blocked')->get();
//        Warned - users wh have been temporarily blocked before
        $warned = User::with('role')->where('is_blocked', '=', '0')->get();

//        Blocked - users who are currently temporarily blocked
        $blocked = DB::table('users')
            ->join('blockings','users.id','=', 'blockings.user_id')
            ->join('roles', 'users.role_id','=','roles.id')
            ->where('date_to', '>', date('Y-m-d'))
            ->select('users.*','roles.name as role', 'blockings.date_from', 'blockings.date_to')
            ->get();

//        Permanent - users who are blocked permanently
        $permanent = DB::table('users')
            ->join('blockings','users.id','=', 'blockings.user_id')
            ->join('roles', 'users.role_id','=','roles.id')
            ->whereNull('blockings.date_to')
            ->select('users.*','roles.name as role', 'blockings.date_from')
            ->get();

        return view('profiles.profileList', [
            'users' => $users,
            'warned' => $warned,
            'blockedUsers' => $blocked,
            'permanentlyBlocked' => $permanent,
        ]);
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
        $user = $this->getUser($id);

        $puzzles = SudokuGrid::where('user_id', '=', $id)
            ->orderByDesc('created_at')
            ->get();

        for ($i = 0; $i < count($puzzles); $i++) {
            $ratingArray = app(RatingController::class)->show($puzzles[$i]->id);
            $puzzles[$i]->ratingArray = $ratingArray;
        }

        for ($i = 0; $i < count($puzzles); $i++) {
            $ratingArray = app(DifficultyRatingController::class)->show($puzzles[$i]);
            $puzzles[$i]->difficultyRatingArray = $ratingArray;
        }

        return view('profiles.profile', [
            'user' => $user,
            'login' => Auth::id(),
            'puzzles' => $puzzles,
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
        $request->validate([
            'name' => ['sometimes', 'string', 'max:32', 'unique:users,name,' . $id],
            'email' => ['sometimes', 'string', 'email', 'max:64', 'unique:users,email,' . $id],
        ]);

        DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'email' => $request->email,
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
     * Get a specific user and their role.
    */
    protected function getUser($id)
    {
        return User::with('role')
            ->where('id','=',$id)
            ->first();
    }

    /**
     * Show the form for editing the role of a specific user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editRole($id)
    {
        $user = $this->getUser($id);
        $roles = Role::all();

        return view('admin.roleForm', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the role of a specific user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateRole(Request $request)
    {
        $request->validate([
            'role' => ['required', 'numeric', 'exists:roles,id'],
        ]);

        DB::table('users')
            ->where('id', $request->user_id)
            ->update([
                'role_id' => $request->role,
            ]);

        return redirect()->route('user.list');
    }

    /**
     * Show the form for changing the password of a specific user.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function editPassword($id)
    {
        $user = $this->getUser($id);

        return view('profiles.passwordChange', ['user' => $user]);
    }

    /**
     * Update the password of a specific user.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'oldPassword' => ['required', 'string', 'password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'password' => Hash::make($request['password']),
            ]);
        echo(Auth::user()->name . '--' . Auth::user()->email);

        return redirect()->route('user.show', ['id' => $id]);
    }
}

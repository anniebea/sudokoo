<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
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
        $user = $this->getUser($id);

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
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:users'],
        ]);

        DB::table('users')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
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
            'role' => ['required', 'exists:roles,id'],
        ]);

        DB::table('users')
            ->where('id', $request->user_id)
            ->update([
                'role_id' => $request->role,
            ]);

        return redirect()->route('user.list');
    }
}

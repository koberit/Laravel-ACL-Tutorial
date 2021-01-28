<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Junges\ACL\Http\Models\Group;
use Junges\ACL\Http\Models\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
        $groups = Group::all();
        return view('users.create',compact('permissions', 'groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
           'name' => ['required', 'string', 'max:255'],
           'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
           'password' => ['required', 'string', 'min:8','confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])

        ]);

        if(isset($request['permissions'])) {
            $user->syncPermissions($request['permissions']);
        }

        if(isset($request['groups'])) {
            $user->syncGroups($request['groups']);
        }

        return redirect('users')->with('success','User erfolgreich angelegt!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        $permissions = Permission::all();

        $groups = Group::all();

        return view('users.edit',compact('user','permissions', 'groups'));
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
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::findOrFail($id);

        if($user->email != $data['email'] && $user->name != $data['name']){
            User::whereId($id)->update([
               'name' => $data['name'],
               'email' => $data['email'],
            ]);
        }elseif($user->email != $data['email']){
            User::whereId($id)->update([
                'email' => $data['email'],
            ]);
        }elseif($user->name != $data['name']){
            User::whereId($id)->update([
                'name' => $data['name'],
            ]);
        }

        if(!isset($request['permissions'])){
            $user->revokeAllPermissions();
        }else{
            $user->syncPermissions($request['permissions']);
        }

        if(!isset($request['groups'])){
            $user->revokeAllGroups();
        }else{
            $user->syncGroups($request['groups']);
        }

        return redirect('users')->with('success', 'User erfolgreich eiditiert!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->revokeAllPermissions();

        $user->revokeAllGroups();

        $user->delete();

        return redirect('users')->with('success', 'User erfolgreich gelöscht!');
    }
}

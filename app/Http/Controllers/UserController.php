<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $roleId = $request->input('role_id');
        if($roleId) {
            $users = User::with('roles')->whereHas('roles', function ($item) use($request) {
            $item->where('id', $request->role_id);
        })->get();
        } else {
            $users = User::with('roles')->get();
        }
        return response()->json(['data', $users], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $user = User::with('roles')->find($id);
        return response()->json(['data', $user], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'roles' => 'required|array'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $userData = $request->only([
            'name',
            'email',
            'password'
        ]);

        $user = User::query()->create($userData);
        $roles = $request->get('roles');
        $user->assignRole($roles);
        return response()->json(['data' => $user], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $updateUser = User::query()->find($id);
        $updateUser->name =$request->get('name');
        $updateUser->email =$request->get('email');
        $roles = $request->get('roles');
        $updateUser->syncRoles($roles);
        $updateUser->save();
        return $updateUser;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        User::query()->find($id)->delete();
        return [];
    }

}

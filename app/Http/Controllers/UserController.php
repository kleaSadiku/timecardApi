<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $users = User::with('roles');
        if($roleId = $request->get('role_id')) {
            $users = $users->whereHas('roles', function ($item) use ($request) {
                $item->where('id', $request->role_id);
            });
        }
        return response()->json(['data', $users->paginate()], 200);
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

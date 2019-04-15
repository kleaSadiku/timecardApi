<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index() {
       $roles = Role::query()->get();
        return response()->json(['data', $roles], 200);
    }
}

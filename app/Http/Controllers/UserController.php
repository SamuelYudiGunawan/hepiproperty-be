<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getPaginate(Request $request)
    {
        $users = User::paginate(10);
        return response()->json([
            'message' => 'success',
            'status' => 'success',
            'data' => $users
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => 'string|unique:users',
            'password' => 'string',
            'role' => 'string'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ], 400);
        }
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message' => 'User not found',
                'status' => 'error'
            ], 400);
        }
        $password = Hash::make($request->password);
        $request->merge(['password' => $password]);
        $user->update($request->all());
        if($request->role){
            $user->syncRoles($request->role);
        }
        return response()->json([
            'message' => 'User updated successfully',
            'status' => 'success'
        ], 200);
    }

    public function delete (Request $request, $id)
    {
        $user = User::find($id);
        if(!$user){
            return response()->json([
                'message' => 'User not found',
                'status' => 'error'
            ], 400);
        }
        $user->delete();
        return response()->json([
            'message' => 'User deleted successfully',
            'status' => 'success'
        ], 200);
    }

    public function filter (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'string|required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
                'status' => 'error'
            ], 400);
        }

        $role = User::role($request->role_name)->paginate(10);
        if ($role->count() == 0) {
            return response()->json([
                'message' => 'data not found',
                'status' => 'error'
            ], 400);
        }
        return response()->json([
            'message' => 'data found',
            'status' => 'success',
            'data' => $role
        ], 200);
    }
}

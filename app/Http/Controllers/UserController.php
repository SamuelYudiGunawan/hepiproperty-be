<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

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

    public function profileUpdate(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => 'string|unique:users',
            'phone_number' => 'string',
            'old_password' => 'current_password|required_with:new_password',
            'new_password' => 'string|confirmed',
            'new password_confirmation' => 'string',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ],
        [
            'new_password.confirmed' => 'confirmed password not match',
            'required_with' => 'Password required',
            'old_password.current_password' => 'Old password not match'
        ]
    );
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->messages(),
                'status' => 'error'
            ], 400);
        }
        $user = User::find(Auth::user()->id);
        if(!$user){
            return response()->json([
                'message' => 'User not found',
                'status' => 'error'
            ], 400);
        }

        if($request->email){
            $request->merge(['email' => $request->email]);
        }

        if($request->name){
            $request->merge(['name' => $request->name]);
        }

        if($request->phone_number){
            $request->merge(['phone_number' => $request->phone_number]);
        }

        if($request->hasFile('profile_image')){
            $image = Storage::disk('public')->put('profile', $request->file('profile_image'));
            $request->merge(['image_url' => $image]);
        }

        if($request->old_password){
            $password = Hash::make($request->password);
            $request->merge(['password' => $password]);
        }

        try {
            $user->update($request->except(['new_password', 'old_password', 'new_password_confirmation', 'profile_image']));
            return response()->json([
                'message' => 'User updated successfully',
                'status' => 'success'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'status' => 'error'
            ], 502);
        }
    }
}

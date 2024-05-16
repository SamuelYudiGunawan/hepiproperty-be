<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;

class UserController extends Controller
{
    public function getPaginate(Request $request)
    {
        $users = User::with('roles')->paginate(10, ['id','name', 'email']);
        return response()->json([
            'message' => 'success',
            'status' => 'success',
            'data' => $users
        ], 200);
    }

    public function detailById(Request $request, $id)
    {
        $user = User::with('roles')->find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'status' => 'error'
            ], 400);
        }
        $property = Property::where('agent_id', $id)->get();
        // if($property->isEmpty()){
        //     return response()->json([
        //         'message' => 'User found',
        //         'status' => 'success',
        //         'data' => $user,
        //         'listing' => 0,
        //         'dijual' => 0,
        //         'disewa' => 0
        //     ], 200);
        // }
        $grouped = array_reduce(
            $property->toArray(),
            function ($carry, $item) {
                $carry[$item['status']][] = $item;
                return $carry;
            },
            []
        );

        $property_count = count($property);
        if(!array_key_exists('dijual', $grouped)){
            $dijual = 0;
        } else {
            $dijual = count($grouped['dijual']);
        }
        if(!array_key_exists('disewakan', $grouped)){
            $disewa = 0;
        } else {
            $disewa = count($grouped['disewakan']);
        }
        if(!$user){
            return response()->json([
                'message' => 'User not found',
                'status' => 'error'
            ], 400);
        }
        return response()->json([
            'message' => 'User found',
            'status' => 'success',
            'data' => $user,
            'listing' => $property_count,
            'dijual' => $dijual,
            'disewa' => $disewa
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string',
            'email' => 'string',
            'password' => 'string',
            'role' => 'string',
            'phone_number' => 'string',
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
        if($request->name){
            $request->merge(['name' => $request->name]);
        }
        if($request->email){
            $request->merge(['email' => $request->email]);
        }
        if($request->password){
            $password = Hash::make($request->password);
            $request->merge(['password' => $password]);
        }
        if($request->phone_number){
            $request->merge(['phone_number' => $request->phone_number]);
        }
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

    public function selfProfileUpdate(Request $request){
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

    public function selfProfileDetail(Request $request) {
        $user = User::with('roles')->find(Auth::user()->id);
        $property = Property::where('agent_id', $user->id)->get();
        if(!$property){
            return response()->json([
                'message' => 'User found',
                'status' => 'success',
                'data' => $user,
                'listing' => 0,
                'dijual' => 0,
                'disewa' => 0
            ], 200);
        }
        $grouped = array_reduce(
            $property->toArray(),
            function ($carry, $item) {
                $carry[$item['status']][] = $item;
                return $carry;
            },
            []
        );
        $property_count = count($property);
        $dijual = count($grouped['dijual']);
        $disewa = count($grouped['disewakan']);
        if(!$user){
            return response()->json([
                'message' => 'User not found',
                'status' => 'error'
            ], 400);
        }
        return response()->json([
            'message' => 'User found',
            'status' => 'success',
            'data' => $user,
            'listing' => $property_count,
            'dijual' => $dijual,
            'disewa' => $disewa
        ], 200);
    }
}

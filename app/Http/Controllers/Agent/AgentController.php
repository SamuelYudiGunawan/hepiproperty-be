<?php

namespace App\Http\Controllers\Agent;

use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AgentController extends Controller
{
    public function list ()
    {
        $agents = User::whereHas('roles', function($q){
            $q->where('name', 'agent');
        })->paginate(10, ['id', 'name', 'image_url', 'phone_number', 'email']);  
        return response()->json([   
            'message' => 'success',
            'status' => 'success',
            'data' => $agents
        ], 200);
    }

    public function detail($id){
        $user = User::with('roles')->find($id);
        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'status' => 'error'
            ], 400);
        }
        $property = Property::where('agent_id', $id)->get();
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

    public function agentProperty($id){
        $property = Property::where('agent_id', $id)->with('images')->paginate(10, ['id','slug','judul','tipe_properti','harga','luas_tanah','kamar_mandi','kamar_tidur','agent_id', 'created_at', 'area']);
        return response()->json([
            'message' => 'success',
            'status' => 'success',
            'data' => $property
        ], 200);
    }
}

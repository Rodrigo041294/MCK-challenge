<?php

namespace App\Http\Controllers;

use App\Models\state;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StateController extends Controller
{
    public function index()
    {
        $states = [];
        try {
            $response = Http::get(env('INEGI_URL', 'https://gaia.inegi.org.mx/wscatgeo/mgee'));
            if ($response->successful()) {
                $data = $response->json();
                $states = $data['datos'];
                return view('welcome', compact('states'));
            } else {
                return response()->json([
                    'message' => 'Error al obtener los estados'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getInfo($id){
        $state = [];
        try {
            $response = Http::get('https://gaia.inegi.org.mx/wscatgeo/mgee/'.$id);
            if ($response->successful()) {
                $data = $response->json();
                $state = $data['datos'];
                return response()->json([
                    'message' => 'Estados obtenidos correctamente',
                    'data' => $state
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Error al obtener los estados'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

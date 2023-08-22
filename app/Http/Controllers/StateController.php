<?php

namespace App\Http\Controllers;

use App\Models\state;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StateController extends Controller
{
    public function index()
    {
        $states = state::where('active', true)->get();
        return view('welcome', compact('states'));
    }

    public function sincronizarDatosINEGI() {
        $states = [];
        try {
            $response = Http::get(env('INEGI_URL', 'https://gaia.inegi.org.mx/wscatgeo/mgee'));
            if ($response->successful()) {
                $data = $response->json();
                $states = $data['datos'];
                // set active false to all states and save new data
                state::where('active', true)->update(['active' => false]);
                foreach ($states as $state) {
                    state::create([
                        'cvegeo' => $state['cvegeo'],
                        'cve_agee' => $state['cve_agee'],
                        'nom_agee' => $state['nom_agee'],
                        'nom_abrev' => $state['nom_abrev'],
                        'pob' => $state['pob'],
                        'pob_fem' => $state['pob_fem'],
                        'pob_mas' => $state['pob_mas'],
                        'viv' => $state['viv'],
                        'active' => true
                    ]);
                }
                return response()->json([
                    'status' => 'success',
                    'data' => $states
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al obtener los estados'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
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
                    'status' => 'success',
                    'data' => $state
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error al obtener la información del estado'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cupon;
use App\Models\Plato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CuponController extends Controller
{
    //

    public function addCupon(Request $request){

        $nombre = $request->input('nombre');
        $descripcion = $request->input('descripcion');
        $caducidad = $request->input('caducidad');
        $porcentaje = $request->input('porcentaje');

        return Cupon::addCupon($nombre, $descripcion, $caducidad, $porcentaje);

    }

    public function removeCupon($cuponId){

        return Cupon::removeCupon($cuponId);

    }

    public function activarCupon($cuponId){

        return Cupon::activarCupon($cuponId);

    }

    public function index(){

        if(Auth::user()){

            if(Auth::user()->currentTeam->name == 'Admin'){
                $allCupones = Cupon::with('platos')->get();
            }else{
                $allCupones = Cupon::with('platos')->where('activo', '=', true)->where('caducidad', '>=', date('Y-m-d'))->get();
            }

            return view('templates/cupones', ['allCupones' => $allCupones]);

        }

        $platos = Plato::with('ingredientes')->take(4)->orderBy('created_at', 'desc')->get();

        return view('templates/index', ['error' => 'Debes iniciar sesión para ver esta página', 'platos' => $platos]);

    }

    public function editCupon($cuponId){

        if(Auth::user()){

            $user = Auth::user();

            if($user->currentTeam->name == 'Admin'){

                $cupon = Cupon::find($cuponId);

                if(isset($cupon)){

                    $allPlatos = DB::table('platos')->get();

                    return view('templates/cupones_edit', ['cupon' => $cupon, 'allPlatos' => $allPlatos]);

                }

            }

            $platos = Plato::with('ingredientes')->take(4)->orderBy('created_at', 'desc')->get();

            return view('templates/index', ['error' => 'Debes iniciar sesión para ver esta página', 'platos' => $platos]);

        }

        $platos = Plato::with('ingredientes')->take(4)->orderBy('created_at', 'desc')->get();

        return view('templates/index', ['error' => 'Debes iniciar sesión para ver esta página', 'platos' => $platos]);

    }

    public function editCuponPost($idCupon, Request $request){

        if(Auth::user()){

            $user = Auth::user();

            if($user->currentTeam->name == 'Admin'){

                $nombre = $request->input('nombre');
                $descripcion = $request->input('descripcion');
                $caducidadDate = $request->input('caducidad');
                $porcentaje = $request->input('porcentaje');
                $platos = $request->input('platos', []);

                return Cupon::editCupon($idCupon, $nombre, $descripcion, $caducidadDate, $porcentaje, $platos);

            }

            $platos = Plato::with('ingredientes')->take(4)->orderBy('created_at', 'desc')->get();

            return view('templates/index', ['error' => 'Debes iniciar sesión para ver esta página', 'platos' => $platos]);

        }

        $platos = Plato::with('ingredientes')->take(4)->orderBy('created_at', 'desc')->get();

        return view('templates/index', ['error' => 'Debes iniciar sesión para ver esta página', 'platos' => $platos]);

    }
}

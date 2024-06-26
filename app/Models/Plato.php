<?php

namespace App\Models;

use App\Models\User;
use App\Models\Cupon;
use App\Models\Pedido;
use App\Models\Ingrediente;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Plato extends Model
{
    use HasFactory;

    protected $table = 'platos';

    public function favoritos(){
        return $this->belongsToMany(User::class, 'favoritos', 'platoId', 'userId');
    }

    public function cupones(){
        return $this->belongsToMany(Cupon::class, 'cupon_platos', 'platoId', 'cuponId');
    }

    public function ingredientes(){
        return $this->belongsToMany(Ingrediente::class, 'plato_ingredientes', 'platoid', 'ingredienteId');
    }

    public function pedidos(){
        return $this->belongsToMany(Pedido::class, 'plato_pedidos', 'platoId', 'pedidoId');
    }

    public static function addPlato($nombre, $ruta, $ingredientes, $precio){
        $plato = new Plato();
        $allPlatos = Plato::all();
        $existe = false;

        foreach ($allPlatos as $platoDB){

            if(strtoupper($platoDB->nombre) == strtoupper($nombre)){
                $existe = true;
                $plato = $platoDB;
            }

        }

        $plato->nombre = $nombre;
        $plato->rutaImagen = $ruta;
        $plato->precio = $precio;
        $plato->save();

        $plato->ingredientes()->detach();


        foreach($ingredientes as $ingrediente){

            $añadeIngredientes = [];
            $ingredienteNew = Ingrediente::find($ingrediente);

            if(isset($ingredienteNew) && $ingredienteNew != null){

                $ingredienteLast = $ingredienteNew->id;

            }else{

                $ingredienteLast = Ingrediente::addIngrediente($ingrediente);

            }

            $añadeIngredientes[] = $ingredienteLast;

            $plato->ingredientes()->attach($ingredienteLast->id);

        }

        return $plato;
    }

    public static function updatePlato($platoId, $newNombre, $newRuta, $precio, $ingredientes){

        $plato = Plato::find($platoId);

        if(isset($plato)){

            $plato->nombre = $newNombre;
            $plato->precio = $precio;

            if($newRuta != null){
                unlink(public_path('img/' . $plato->rutaImagen));
                $plato->rutaImagen = $newRuta;
            }

            $plato->ingredientes()->detach();

            foreach ($ingredientes as $ingrediente){

                $ingredienteExist = Ingrediente::find($ingrediente);

                if(isset($ingredienteExist) && $ingredienteExist != null){

                    $ingredienteLast = $ingrediente->id;

                }else{

                    $ingredienteLast = Ingrediente::addIngrediente($ingrediente);

                }
                $plato->ingredientes()->attach($ingredienteLast->id);

            }

            $plato->save();

            return redirect('/admin_gestion_platos');

        }

        return view('templates/platos_edit', [ 'idPlato' => $platoId, 'error' => 'No se ha localizado el plato con ID ' . $platoId ]);

    }

    public static function removePlato($platoId){

        $plato = Plato::find($platoId);

        if(isset($plato)){

            unlink(public_path('img/' . $plato->rutaImagen));

            $plato->delete();
            return redirect('/admin_gestion_platos');

        }

        return redirect('/admin_gestion_platos');

    }

}

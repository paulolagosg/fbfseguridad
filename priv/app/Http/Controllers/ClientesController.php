<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Estados;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ClientesController extends Controller
{
    public function lista(){

        $clientes = Clientes::join('estados','estados.esta_ncod','=','clie_nestado')
                    ->select(DB::raw("concat(clie_nrut,'-',clie_tdv) as rut"),'clie_trazon_social','clie_tejecutivo',DB::raw("case when clie_nfono_fijo is null and clie_nfono_movil is not null then clie_nfono_movil when clie_nfono_fijo is not null and clie_nfono_movil is null then clie_nfono_fijo when clie_nfono_fijo is not null and clie_nfono_movil is not null then concat(clie_nfono_fijo,' - ',clie_nfono_movil) end as fono"),'clie_tcorreo','esta_tnombre','clie_ncod','clie_nestado')
                    ->orderBy('clie_trazon_social')
                    ->get();

        return view('administracion.clientes.lista', compact('clientes'));
    }


    public function crear(){
        $estados = Estados::orderBy('esta_tnombre')->get();
        return view('administracion.clientes.crear',compact('estados'));
    }

    public function agregar(Request $request){
        //dd($request);

        $this->validate($request,[
            'clie_nrut' => 'required|valida_rut|unique:clientes'
            ,'clie_trazon_social' => 'required|min:5'
            ,'clie_tejecutivo' => 'required|min:5'
            // ,'clie_nfono_fijo' => 'required|min:9|int'
            // ,'clie_nfono_movil' => 'required|min:9|int'
            ,'clie_tcorreo' => 'required|min:5|email'
            ,'clie_tdireccion' => 'required|min:5'
            ,'clie_nestado' => 'required'
        ]);

        if($request->clie_nfono_fijo == "" && $request->clie_nfono_movil == ""){
            return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Debe ingresar al menos un teléfono de contacto']);
        }
        else{
           if(
                ($request->clie_nfono_fijo != "" && (strlen($request->clie_nfono_fijo) <> 9 || !is_numeric($request->clie_nfono_fijo)))
                ||
                ($request->clie_nfono_movil != "" && (strlen($request->clie_nfono_movil) <> 9 || !is_numeric($request->clie_nfono_movil)))
            ){
                return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Teléfono(s) de contacto debe ser numérico y de 9 digitos']);
            }
        }


        $explode = explode("-",$request->clie_nrut);
        $pers_nrut = $explode[0];
        $pers_tdv = $explode[1];

        $cliente = new Clientes();
        $cliente->clie_nrut = $pers_nrut;
        $cliente->clie_tdv = $pers_tdv;
        $cliente->clie_trazon_social = $request->clie_trazon_social;
        $cliente->clie_tejecutivo = $request->clie_tejecutivo;
        $cliente->clie_nfono_fijo = $request->clie_nfono_fijo;
        $cliente->clie_nfono_movil = $request->clie_nfono_movil;
        $cliente->clie_tcorreo = $request->clie_tcorreo;
        $cliente->clie_tdireccion = $request->clie_tdireccion;
        $cliente->clie_nestado = $request->clie_nestado;

        if($cliente->save()){
            $request->session()->flash('status', 'Registro creado');
            return redirect()->route('clientes.lista');
        }
        else{
            return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Ocurrió un error al intentar modificar, favor intente nuevamente']);
        }
    } 

    public function editar($id){

        try{
            $datos = Clientes::where('clie_ncod', '=', $id)
                            ->firstOrFail();
        }
        catch(ModelNotFoundException $e){
            abort(404, __('Sorry, the page you are looking for is not available.'));    
        }



        $estados = Estados::orderBy('esta_tnombre')->get();
        $clientes = Clientes::join('estados','estados.esta_ncod','=','clie_nestado')
                    ->select(DB::raw("concat(clie_nrut,'-',clie_tdv) as rut"),'clie_trazon_social','clie_tejecutivo','clie_nfono_movil','clie_nfono_fijo','clie_tcorreo','esta_tnombre','clie_tdireccion','clie_nestado','clie_ncod')
                    ->where('clie_ncod','=',$id)
                    ->orderBy('clie_trazon_social')
                    ->get();

        return view('administracion.clientes.editar',compact('estados','clientes'));
    }

    public function modificar(Request $request){
        //dd($request);

        $this->validate($request,[
            'clie_nrut' => 'required|valida_rut'
            ,'clie_trazon_social' => 'required|min:5'
            ,'clie_tejecutivo' => 'required|min:5'
            // ,'clie_nfono_fijo' => 'required|min:9|int'
            // ,'clie_nfono_movil' => 'required|min:9|int'
            ,'clie_tcorreo' => 'required|min:5|email'
            ,'clie_tdireccion' => 'required|min:5'
            ,'clie_nestado' => 'required'
        ]);

        if($request->clie_nfono_fijo == "" && $request->clie_nfono_movil == ""){
            return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Debe ingresar al menos un teléfono de contacto']);
        }
        else{
            if(
                (strlen($request->clie_nfono_fijo) <> 9 || !is_numeric($request->clie_nfono_fijo))
                ||
                (strlen($request->clie_nfono_movil) <> 9 || !is_numeric($request->clie_nfono_movil))
            ){
                return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Teléfono(s) de contacto debe ser numérico y de 9 digitos']);
            }
        }


        $explode = explode("-",$request->clie_nrut);
        $pers_nrut = $explode[0];
        $pers_tdv = $explode[1];


        $sqlUpdate = DB::table('clientes')
              ->where('clie_ncod', $request->clie_ncod)
              ->update(['clie_trazon_social' => $request->clie_trazon_social,
                        'clie_tejecutivo' => $request->clie_tejecutivo,
                        'clie_nfono_fijo' =>$request->clie_nfono_fijo,
                        'clie_nfono_movil' => $request->clie_nfono_movil,
                        'clie_tcorreo' => $request->clie_tcorreo,
                        'clie_tdireccion' => $request->clie_tdireccion,
                        'clie_nestado' => $request->clie_nestado]);

        $request->session()->flash('status', 'Registro modificado');
        return redirect()->route('clientes.lista');
   }

    public function eliminar($id,$estado){
        try{
            $datos = Clientes::where('clie_ncod', '=', $id)
                            ->firstOrFail();
        }
        catch(ModelNotFoundException $e){
            abort(404, __('Sorry, the page you are looking for is not available.'));    
        }

        $sqlUpdate = DB::table('clientes')
              ->where('clie_ncod', $id)
              ->update(['clie_nestado' => $estado]);

        Session::flash('status', 'Registro modificado');
        return redirect()->route('clientes.lista');

    } 

    public function datos(Request $request,$id){
        $clientes = Clientes::join('estados','estados.esta_ncod','=','clie_nestado')
                    ->select(DB::raw("concat(clie_nrut,'-',clie_tdv) as rut"),'clie_trazon_social','clie_tejecutivo','clie_nfono_movil','clie_nfono_fijo','clie_tcorreo','esta_tnombre','clie_tdireccion','clie_nestado','clie_ncod',DB::raw("case when clie_nfono_fijo is null and clie_nfono_movil is not null then clie_nfono_movil when clie_nfono_fijo is not null and clie_nfono_movil is null then clie_nfono_fijo when clie_nfono_fijo is not null and clie_nfono_movil is not null then concat(clie_nfono_fijo,' - ',clie_nfono_movil) end as fono"))
                    ->where('clie_ncod','=',$id)
                    ->orderBy('clie_trazon_social')
                    ->get();
        $clie_rut = "";
        $clie_tejecutivo = "";
        $clie_fonos = "";
        $clie_tcorreo = "";
        $clie_tdireccion = "";

        foreach($clientes as $c){
            $clie_rut = $c->rut;
            $clie_tejecutivo = $c->clie_tejecutivo;
            $clie_fonos = $c->fono;
            $clie_tcorreo = $c->clie_tcorreo;
            $clie_tdireccion = $c->clie_tdireccion;
        }

        $datos = array(
            'rut' => $clie_rut,
            'ejecutivo' => $clie_tejecutivo,
            'fonos' => $clie_fonos,
            'correo' => $clie_tcorreo,
            'direccion' => $clie_tdireccion
        );
        return json_encode($datos);
    }

}

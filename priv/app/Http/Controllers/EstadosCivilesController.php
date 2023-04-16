<?php

namespace App\Http\Controllers;

use App\Models\EstadosCiviles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EstadosCivilesController extends Controller
{
    public function lista(){
        
        if(Auth::user()->tius_ncod > 1){
            $estados = EstadosCiviles::select('eciv_ncod','eciv_tnombre',DB::raw("case when eciv_nestado = 0 then 'Inactivo' else 'Activo' end as estadotxt"))
                ->orderBy('eciv_tnombre')
                ->get();
            
            return view('administracion.estados_civiles.lista', compact('estados'));
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

    public function crear(){
        
        if(Auth::user()->tius_ncod > 1){
            return view('administracion.estados_civiles.crear');
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

    public function agregar(Request $request){
        
        //dd($request);
        if(Auth::user()->tius_ncod > 1){
            $this->validate($request,[
                'eciv_tnombre' => 'required|min:3'
                ,'eciv_nestado' => 'required'
            ]);


            $ecivil = new EstadosCiviles();
            $ecivil->eciv_tnombre = $request->eciv_tnombre;
            $ecivil->eciv_nestado = $request->eciv_nestado;

            if($ecivil->save()){
                $request->session()->flash('status', 'Registro creado');
                return redirect()->route('estados_civiles.lista');
            }
            else{
                return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Ocurrió un error al intentar agregar, favor intente nuevamente']);
            }
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }


    public function editar($id){

        if(Auth::user()->tius_ncod > 1){
            try{
                $datos = EstadosCiviles::where('eciv_ncod', '=', $id)
                                ->firstOrFail();
            }
            catch(ModelNotFoundException $e){
                abort(404, __('Sorry, the page you are looking for is not available.'));    
            }

            $estados = EstadosCiviles::where('eciv_ncod','=',$id)->get();

            return view('administracion.estados_civiles.editar', compact('estados'));
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }

    }

    public function modificar(Request $request){
        
       // dd($request);
        if(Auth::user()->tius_ncod > 1){
            $this->validate($request,[
                'eciv_tnombre' => 'required|min:3'
                ,'eciv_nestado' => 'required'
            ]);


            $sqlUpdate = DB::table('estados_civiles')
                  ->where('eciv_ncod', $request->eciv_ncod)
                  ->update(['eciv_tnombre' => $request->eciv_tnombre,
                            'eciv_nestado' =>$request->eciv_nestado
                            ]);

            $request->session()->flash('status', 'Registro modificado');
            return redirect()->route('estados_civiles.lista');
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

    public function eliminar($id){

        if(Auth::user()->tius_ncod > 1){
            try {
                $estados = EstadosCiviles::where('eciv_ncod', '=', $id)
                                ->firstOrFail();
            } catch (ModelNotFoundException $ex) {
                return back()->with('error','No existe la jornada seleccionada para eliminar');
            }

            //verificar que la jornada no este siendo utilizada en una OC
            $nExiste = DB::table('personas')
                        ->select(db::raw("count(1) as total"))
                        ->where('eciv_ncod',$id)
                        ->count();
            //$nExiste2 = intval($nExiste['0']->total);

            if($nExiste > 0){
                return redirect()->route('estados_civiles.lista')->withErrors(['Error'=>'El estado civil seleccionado está siendo utilizado por una personas, no puede eliminarse.']);
            }

            $deleted = DB::table('estados_civiles')->where('eciv_ncod',$id)->delete();

            if($deleted > 0){
                Session::flash('status', 'Registro eliminado');
                return redirect()->route('estados_civiles.lista');
            }
            else{
                return redirect()->route('estados_civiles.lista')->withErrors(['Error'=>'Ocurrió un error en la eliminación del registro, favor intentar nuevamente.']);
            }
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }
}

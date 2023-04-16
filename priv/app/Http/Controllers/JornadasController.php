<?php

namespace App\Http\Controllers;

use App\Models\Jornadas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class JornadasController extends Controller
{
    

    public function lista(){

        if(Auth::user()->tius_ncod > 1){
            $jornadas = Jornadas::select('jorn_ncod','jorn_tnombre',DB::raw("case when jorn_nestado = 0 then 'Inactivo' else 'Activo' end as estadotxt"))
                ->orderBy('jorn_tnombre')
                ->get();
            
            return view('administracion.jornadas.lista', compact('jornadas'));
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }

    }

    public function crear(){
        if(Auth::user()->tius_ncod > 1){
            return view('administracion.jornadas.crear');
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

    public function agregar(Request $request){
        
        //dd($request);
        if(Auth::user()->tius_ncod > 1){
            $this->validate($request,[
                'jorn_tnombre' => 'required|min:3'
                ,'jorn_nestado' => 'required'
            ]);


            $jornada = new Jornadas();
            $jornada->jorn_tnombre = $request->jorn_tnombre;
            $jornada->jorn_nestado = $request->jorn_nestado;

            if($jornada->save()){
                $request->session()->flash('status', 'Registro creado');
                return redirect()->route('jornadas.lista');
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
                $datos = Jornadas::where('jorn_ncod', '=', $id)
                                ->firstOrFail();
            }
            catch(ModelNotFoundException $e){
                abort(404, __('Sorry, the page you are looking for is not available.'));    
            }

            $jornada = Jornadas::where('jorn_ncod','=',$id)->get();

            return view('administracion.jornadas.editar', compact('jornada'));
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }

    }

    public function modificar(Request $request){
        
       // dd($request);
        if(Auth::user()->tius_ncod > 1){
            $this->validate($request,[
                'jorn_tnombre' => 'required|min:3'
                ,'jorn_nestado' => 'required'
            ]);


            $sqlUpdate = DB::table('jornadas')
                  ->where('jorn_ncod', $request->jorn_ncod)
                  ->update(['jorn_tnombre' => $request->jorn_tnombre,
                            'jorn_nestado' =>$request->jorn_nestado
                            ]);

            $request->session()->flash('status', 'Registro modificado');
            return redirect()->route('jornadas.lista');
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

    public function eliminar($id){

        if(Auth::user()->tius_ncod > 1){
            try {
                $jornada = Jornadas::where('jorn_ncod', '=', $id)
                                ->firstOrFail();
            } catch (ModelNotFoundException $ex) {
                return back()->with('error','No existe la jornada seleccionada para eliminar');
            }

            //verificar que la jornada no este siendo utilizada en una OC
            $nExiste = DB::table('ordenes')
                        ->select(db::raw("count(1) as total"))
                        ->where('jorn_ncod',$id)
                        ->count();
            //$nExiste2 = intval($nExiste['0']->total);

            if($nExiste > 0){
                return redirect()->route('jornadas.lista')->withErrors(['Error'=>'La jornada seleccionada está siendo utilizada en una orden de trabajo, no puede eliminarse.']);
            }

            $deleted = DB::table('jornadas')->where('jorn_ncod',$id)->delete();

            if($deleted > 0){
                Session::flash('status', 'Registro eliminado');
                return redirect()->route('jornadas.lista');
            }
            else{
                return redirect()->route('jornadas.lista')->withErrors(['Error'=>'Ocurrió un error en la eliminación del registro, favor intentar nuevamente.']);
            }
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }


}

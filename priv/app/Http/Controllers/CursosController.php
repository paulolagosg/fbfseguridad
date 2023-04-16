<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CursosController extends Controller
{
    public function lista(){
            
        if(Auth::user()->tius_ncod > 1){
            $datos = Cursos::select('curs_ncod','curs_tnombre',DB::raw("case when curs_nestado = 1 then 'Activo' else 'Inactivo' end as estadotxt"),'curs_nestado')
                ->get();

            return view('administracion.cursos.lista',compact('datos'));
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }

    }

    public function crear(){
          
        if(Auth::user()->tius_ncod > 1){    
            return view('administracion.cursos.crear');
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

    public function agregar(Request $request){

        if(Auth::user()->tius_ncod > 1){
            $this->validate($request,[
                'curs_tnombre' => 'required'
                ,'curs_nestado' => 'required'
            ]);


            $curso = new Cursos();
            $curso->curs_tnombre = $request->curs_tnombre;
            $curso->curs_nestado = $request->curs_nestado;


            if($curso->save()){
                $request->session()->flash('status', 'Registro creado');
                return redirect()->route('cursos.lista');
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
                $datos = Cursos::where('curs_ncod', '=', $id)
                                ->firstOrFail();
            }
            catch(ModelNotFoundException $e){
              abort(404, __('Sorry, the page you are looking for is not available.'));    
            }


            $curso = Cursos::select('curs_ncod','curs_tnombre','curs_nestado')
                        ->where('curs_ncod','=',$id)
                        ->get();

            return view('administracion.cursos.editar',compact('curso'));
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

    public function modificar(Request $request){
 
        if(Auth::user()->tius_ncod > 1){       
            $this->validate($request,[
                'curs_tnombre' => 'required'
                ,'curs_nestado' => 'required'
            ]);


            DB::beginTransaction();

            try {

                $fExpira = explode("/",$request->cupe_fexpira);

                 $sqlUpdate = DB::table('cursos')
                  ->where('curs_ncod', $request->curs_ncod)
                  ->update(['curs_tnombre' => $request->curs_tnombre,
                            'curs_nestado' => $request->curs_nestado]);

                DB::commit();
                $request->session()->flash('status', 'Registro modificado');
                return redirect()->route('cursos.lista');

            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withInput($request->input())->withErrors(['Error'=>'Ocurrió un error al intentar modificar el registro, favor intente nuevamente']);
            }
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

    public function eliminar($id){
        
        if(Auth::user()->tius_ncod > 1){
            try {
                $cp = Cursos::where('curs_ncod', '=', $id)
                                ->firstOrFail();
            } catch (ModelNotFoundException $ex) {
                return back()->with('error','No existe el curso para eliminar');
            }

            //verificar que la jornada no este siendo utilizada en una OC
            $nExiste = DB::table('cursos_personas')
                        ->select(db::raw("count(1) as total"))
                        ->where('curs_ncod',$id)
                        ->count();
            //$nExiste2 = intval($nExiste['0']->total);

            if($nExiste > 0){
                return redirect()->route('cursos.lista')->withErrors(['Error'=>'El Curso no puede eliminarse, está asociado a un guardia.']);
            }

            $deleted = DB::table('cursos')->where('curs_ncod',$id)->delete();

            if($deleted > 0){
                Session::flash('status', 'Registro eliminado');
                return redirect()->route('cursos.lista');
            }
            else{
                return redirect()->route('cursos.lista')->withErrors(['Error'=>'Ocurrió un error en la eliminación del registro, favor intentar nuevamente.']);
            }
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

}

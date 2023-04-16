<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\CursosPersonas;
use App\Models\Personas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CursosPersonasController extends Controller
{
    
    public function lista(){
        $datos = CursosPersonas::join('personas','personas.pers_nrut','cursos_personas.pers_nrut')
            ->join('cursos','cursos.curs_ncod','=','cursos_personas.curs_ncod')
            ->where('cupe_nestado','=',1)
            ->select(DB::raw("concat(personas.pers_nrut,'-',personas.pers_tdv) as rut"), DB::raw("concat(personas.pers_tnombres,' ',personas.pers_tpaterno,' ',coalesce(personas.pers_tmaterno,'')) as nombre"),'cursos.curs_tnombre',DB::raw("date_format(cupe_fexpira,'%d/%m/%Y') as cupe_fexpira"),'cupe_ncod')
            ->get();

        return view('administracion.cursos_personas.lista',compact('datos'));

    }

    public function crear(){
        $personas = Personas::join('estados_civiles','estados_civiles.eciv_ncod','=','personas.eciv_ncod')
                    ->join('estados','personas.pers_nestado','=','estados.esta_ncod')
                    ->where('pers_bguardia','=',1)
                    ->where('pers_nestado','=',1)
                    ->select('pers_nrut', DB::raw("concat(pers_tnombres,' ',pers_tpaterno,' ',coalesce(pers_tmaterno,'')) as nombres"))
                    ->get();
        $cursos = Cursos::where('curs_nestado','=',1)->get();

        return view('administracion.cursos_personas.crear',compact('personas','cursos'));
    }

    public function agregar(Request $request){

        $this->validate($request,[
            'pers_nrut' => 'required'
            ,'curs_ncod' => 'required'
            ,'cupe_fexpira' => 'required|date_format:d/m/Y'
        ]);

        $fExpira = explode("/",$request->cupe_fexpira);

        $cursoPersona = new CursosPersonas();
        $cursoPersona->curs_ncod = $request->curs_ncod;
        $cursoPersona->pers_nrut = $request->pers_nrut;
        $cursoPersona->cupe_fexpira = $fExpira[2]."-".$fExpira[1]."-".$fExpira[0];
        $cursoPersona->cupe_nestado = 1;


        if($cursoPersona->save()){
            $request->session()->flash('status', 'Registro creado');
            return redirect()->route('cursos_personas.lista');
        }
        else{
            return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Ocurrió un error al intentar agregar, favor intente nuevamente']);
        }
    }

    public function editar($id){

        try{
            $datos = CursosPersonas::where('cupe_ncod', '=', $id)
                            ->firstOrFail();
        }
        catch(ModelNotFoundException $e){
          abort(404, __('Sorry, the page you are looking for is not available.'));    
        }


        $cursos_personas = CursosPersonas::join('personas','personas.pers_nrut','=','cursos_personas.pers_nrut')
                    ->where('cupe_ncod', '=', $id)
                    ->select('personas.pers_nrut', DB::raw("concat(pers_tnombres,' ',pers_tpaterno,' ',coalesce(pers_tmaterno,'')) as nombres"),'cupe_ncod',DB::raw("date_format(cupe_fexpira,'%d/%m/%Y') as cupe_fexpira"),'curs_ncod','cupe_ncod')
                    ->get();
        $cursos = Cursos::where('curs_nestado','=',1)->get();

        return view('administracion.cursos_personas.editar',compact('cursos','cursos_personas'));
    }

    public function modificar(Request $request){
        $this->validate($request,[
            'pers_nrut' => 'required'
            ,'curs_ncod' => 'required'
            ,'cupe_fexpira' => 'required|date_format:d/m/Y'
        ]);


        DB::beginTransaction();

        try {

            $fExpira = explode("/",$request->cupe_fexpira);

             $sqlUpdate = DB::table('cursos_personas')
              ->where('cupe_ncod', $request->cupe_ncod)
              ->update(['curs_ncod' => $request->curs_ncod,
                        'cupe_fexpira' => $fExpira[2]."-".$fExpira[1]."-".$fExpira[0]]);

            DB::commit();
            $request->session()->flash('status', 'Registro modificado');
            return redirect()->route('cursos_personas.lista');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput($request->input())->withErrors(['Error'=>'Ocurrió un error al intentar modificar el registro, favor intente nuevamente']);
        }

    }

    public function eliminar($id){
        try {
            $cp = CursosPersonas::where('cupe_ncod', '=', $id)
                            ->firstOrFail();
        } catch (ModelNotFoundException $ex) {
            return back()->with('error','No existe el curso para eliminar');
        }


        $deleted = DB::table('cursos_personas')->where('cupe_ncod',$id)->delete();

        if($deleted > 0){
            Session::flash('status', 'Registro eliminado');
            return redirect()->route('cursos_personas.lista');
        }
        else{
            return redirect()->route('cursos_personas.lista')->withErrors(['Error'=>'Ocurrió un error en la eliminación del registro, favor intentar nuevamente.']);
        }
    }


}

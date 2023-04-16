<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use App\Models\CursosPersonas;
use App\Models\Estados;
use App\Models\EstadosCiviles;
use App\Models\Personas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PersonasController extends Controller
{
    public function lista(){
        $personas = Personas::join('estados_civiles','estados_civiles.eciv_ncod','=','personas.eciv_ncod')
                    ->join('estados','personas.pers_nestado','=','estados.esta_ncod')
                    ->where('pers_bguardia','=',1)
                    ->select(DB::raw("concat(pers_nrut,'-',pers_tdv) as rut"), DB::raw("concat(pers_tnombres,' ',pers_tpaterno,' ',coalesce(pers_tmaterno,'')) as nombre"),DB::raw("case when pers_nfono_fijo is null and pers_nfono_movil is not null then pers_nfono_movil when pers_nfono_fijo is not null and pers_nfono_movil is null then pers_nfono_fijo when pers_nfono_fijo is not null and pers_nfono_movil is not null then concat(pers_nfono_fijo,' - ',pers_nfono_movil) end as fono"),'pers_tcorreo','esta_tnombre','pers_ncod','pers_nestado','personas.pers_nrut')
                    ->get();

        $cursos = CursosPersonas::join('personas','personas.pers_nrut','cursos_personas.pers_nrut')
            ->join('cursos','cursos.curs_ncod','=','cursos_personas.curs_ncod')
            ->where('cupe_nestado','=',1)
            ->select('personas.pers_nrut','cursos.curs_tnombre',DB::raw("date_format(cupe_fexpira,'%d/%m/%Y') as cupe_fexpira"),'cupe_ncod')
            ->get();

        return view ('administracion.personas.lista',compact('personas','cursos'));
    }

    public function crear(){

        $estados = Estados::orderBy('esta_tnombre')->get();
        $cursos = Cursos::where('curs_nestado','=',1)->orderBy('curs_tnombre')->get();
        $estados_civiles = EstadosCiviles::where('eciv_nestado','=',1)
                    ->orderBy('eciv_ncod')
                    ->get();

        return view('administracion.personas.crear', compact('estados','estados_civiles','cursos'));
    }


    public function agregar(Request $request){
        //dd($request);

        $this->validate($request,[
            'pers_nrut' => 'required|valida_rut|unique:personas'
            ,'pers_tnombres' => 'required|min:3'
            ,'pers_tpaterno' => 'required|min:3'
            ,'pers_tcorreo' => 'required|min:5|email'
            ,'pers_tdireccion' => 'required|min:5'
            ,'pers_nestado' => 'required'
            ,'pers_fnacimiento' => 'required|date_format:d/m/Y'
            ,'eciv_ncod' => 'required'
        ]);


        

        if($request->pers_nfono_fijo == "" && $request->pers_nfono_movil == ""){
            return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Debe ingresar al menos un teléfono de contacto']);
        }
        else{
           if(
                ($request->pers_nfono_fijo != "" && (strlen($request->pers_nfono_fijo) <> 9 || !is_numeric($request->pers_nfono_fijo)))
                ||
                ($request->pers_nfono_movil != "" && (strlen($request->pers_nfono_movil) <> 9 || !is_numeric($request->pers_nfono_movil)))
            ){
                return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Teléfono(s) de contacto debe ser numérico y de 9 digitos']);
            }
        }


        $explode = explode("-",$request->pers_nrut);
        $pers_nrut = $explode[0];
        $pers_tdv = $explode[1];

        $fNacimiento = explode("/",$request->pers_fnacimiento);


        DB::beginTransaction();

        try {
            $persona = new Personas();
            $persona->pers_nrut = $pers_nrut;
            $persona->pers_tdv = $pers_tdv;
            $persona->pers_tnombres = $request->pers_tnombres;
            $persona->pers_tpaterno = $request->pers_tpaterno;
            $persona->pers_tmaterno = $request->pers_tmaterno;
            $persona->pers_nfono_fijo = $request->pers_nfono_fijo;
            $persona->pers_nfono_movil = $request->pers_nfono_movil;
            $persona->pers_tcorreo = $request->pers_tcorreo;
            $persona->pers_tdireccion = $request->pers_tdireccion;
            $persona->pers_fnacimiento = $fNacimiento[2]."-".$fNacimiento[1]."-".$fNacimiento[0];
            $persona->pers_nestado = $request->pers_nestado;
            $persona->pers_bguardia = 1;
            $persona->eciv_ncod = $request->eciv_ncod;

            $persona->save();

            
            DB::commit();
            return Redirect::back()->with('message','Registro agregado!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput($request->input())->withErrors(['Error'=>'Ocurrió un error al intentar agregar el registro, favor intente nuevamente']);
        }


    }

    public function editar($id){

        try{
            $datos = Personas::where('pers_ncod', '=', $id)
                            ->firstOrFail();
        }
        catch(ModelNotFoundException $e){
            abort(404, __('Sorry, the page you are looking for is not available.'));    
        }

        $estados = Estados::orderBy('esta_tnombre')->get();
        
        $estados_civiles = EstadosCiviles::where('eciv_nestado','=',1)
                    ->orderBy('eciv_ncod')
                    ->get();

        $cursos = Cursos::where('curs_nestado','=',1)->orderBy('curs_tnombre')
                ->get();
        
        $cursos_guardias = CursosPersonas::join('personas','cursos_personas.pers_nrut','=','personas.pers_nrut')
                        ->join('cursos','cursos.curs_ncod','=','cursos_personas.curs_ncod')
                        ->where('pers_ncod', '=', $id)
                        ->select('cursos.curs_ncod',DB::raw("date_format(cupe_fexpira,'%d/%m/%Y') as cupe_fexpira"),'cursos.curs_tnombre')
                        ->get();

        $datos_persona = Personas::where('pers_ncod','=',$id)
                    ->select(DB::raw("concat(personas.pers_nrut,'-',pers_tdv) as rut"), 'pers_tnombres','pers_tpaterno','pers_tmaterno','pers_nfono_movil','pers_nfono_fijo','pers_tcorreo','pers_ncod','pers_nestado','pers_tdireccion',DB::raw("date_format(pers_fnacimiento,'%d/%m/%Y') as pers_fnacimiento"),'eciv_ncod','pers_nrut')
                    ->get();

        return view('administracion.personas.editar', compact('estados','estados_civiles','datos_persona','cursos','cursos_guardias'));
    }

    public function modificar(Request $request){        
        $this->validate($request,[
            'pers_tnombres' => 'required|min:3'
            ,'pers_tpaterno' => 'required|min:3'
            ,'pers_tcorreo' => 'required|min:5|email'
            ,'pers_tdireccion' => 'required|min:5'
            ,'pers_nestado' => 'required'
            ,'pers_fnacimiento' => 'required|date_format:d/m/Y'
            ,'eciv_ncod' => 'required'
        ]);

        if($request->pers_nfono_fijo == "" && $request->pers_nfono_movil == ""){
            return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Debe ingresar al menos un teléfono de contacto']);
        }
        else{
           if(
                ($request->pers_nfono_fijo != "" && (strlen($request->pers_nfono_fijo) <> 9 || !is_numeric($request->pers_nfono_fijo)))
                ||
                ($request->pers_nfono_movil != "" && (strlen($request->pers_nfono_movil) <> 9 || !is_numeric($request->pers_nfono_movil)))
            ){
                return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Teléfono(s) de contacto debe ser numérico y de 9 digitos']);
            }
        }


        $explode = explode("-",$request->pers_nrut);
        $pers_nrut = $explode[0];
        $pers_tdv = $explode[1];

        $fNacimiento = explode("/",$request->pers_fnacimiento);

       
        DB::beginTransaction();

        try {
             $sqlUpdate = DB::table('personas')
              ->where('pers_ncod', $request->pers_ncod)
              ->update(['pers_tnombres' => $request->pers_tnombres,
                        'pers_tpaterno' => $request->pers_tpaterno,
                        'pers_tmaterno' => $request->pers_tmaterno,
                        'pers_nfono_fijo' =>$request->pers_nfono_fijo,
                        'pers_nfono_movil' => $request->pers_nfono_movil,
                        'pers_tcorreo' => $request->pers_tcorreo,
                        'pers_tdireccion' => $request->pers_tdireccion,
                        'pers_fnacimiento' => $fNacimiento[2]."-".$fNacimiento[1]."-".$fNacimiento[0],
                        'pers_nestado' => $request->pers_nestado,
                        'eciv_ncod' => $request->eciv_ncod]);

            DB::commit();

            $request->session()->flash('status', 'Registro creado');
            return redirect()->route('personas.lista');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput($request->input())->withErrors(['Error'=>'Ocurrió un error al intentar modificar el registro, favor intente nuevamente']);
        }





        $request->session()->flash('status', 'Registro modificado');
        return redirect()->route('personas.lista');
    }

    public function eliminar($id,$estado){
        try{
            $datos = Personas::where('pers_ncod', '=', $id)
                            ->firstOrFail();
        }
        catch(ModelNotFoundException $e){
            abort(404, __('Sorry, the page you are looking for is not available.'));    
        }

        $sqlUpdate = DB::table('personas')
              ->where('pers_ncod', $id)
              ->update(['pers_nestado' => $estado]);

        Session::flash('status', 'Registro modificado');
        return redirect()->route('personas.lista');

    }
}

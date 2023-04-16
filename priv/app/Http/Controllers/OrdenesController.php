<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Estados;
use App\Models\EstadosOrdenes;
use App\Models\Jornadas;
use App\Models\Ordenes;
use App\Models\Personas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class OrdenesController extends Controller
{

    public function lista(){
        
        $nTipoUsuario = Auth::user()->tius_ncod;

        $estados = EstadosOrdenes::join('tipos_usuarios_estados','estados_ordenes.esor_ncod','=','tipos_usuarios_estados.esor_ncod')
            ->where('tipos_usuarios_estados.tius_ncod','=',$nTipoUsuario)
            ->orderBy('esor_tnombre')->get();


        $ordenes = DB::table('ordenes')
        ->join('clientes','ordenes.pers_nrut_cliente','=','clientes.clie_nrut')
        ->join('estados_ordenes','ordenes.orde_nestado','=','estados_ordenes.esor_ncod')
        ->join('jornadas','ordenes.jorn_ncod','=','jornadas.jorn_ncod')
        ->select('ordenes.orde_ncod','clientes.clie_trazon_social','clientes.clie_nrut',db::raw("date_format(ordenes.orde_finicio,'%d/%m/%Y') as orde_finicio"),db::raw("date_format(ordenes.orde_ftermino,'%d/%m/%Y') as orde_ftermino"),db::raw("jornadas.jorn_tnombre as jornada"),db::raw("estados_ordenes.esor_tnombre as estado"),'esor_npermite_factura','esor_npermite_editar','orde_nestado','orde_nfactura')
        ->orderBy('ordenes.orde_ncod','DESC')
        ->get();


        return view('ordenes.lista',compact('ordenes','estados'));
    }

    public function lista_estado($id){

        $nTipoUsuario = Auth::user()->tius_ncod;
        
        $estados = EstadosOrdenes::orderBy('esor_tnombre')->get();

        if($id < 100){
            $ordenes = DB::table('ordenes')
            ->join('clientes','ordenes.pers_nrut_cliente','=','clientes.clie_nrut')
            ->join('estados_ordenes','ordenes.orde_nestado','=','estados_ordenes.esor_ncod')
            ->join('jornadas','ordenes.jorn_ncod','=','jornadas.jorn_ncod')
            ->where('estados_ordenes.esor_ncod','=',$id)
            ->select('ordenes.orde_ncod','clientes.clie_trazon_social','clientes.clie_nrut',db::raw("date_format(ordenes.orde_finicio,'%d/%m/%Y') as orde_finicio"),db::raw("date_format(ordenes.orde_ftermino,'%d/%m/%Y') as orde_ftermino"),db::raw("jornadas.jorn_tnombre as jornada"),db::raw("estados_ordenes.esor_tnombre as estado"),'esor_npermite_factura','esor_npermite_editar','orde_nestado','orde_nfactura')
            ->orderBy('ordenes.orde_ncod','DESC')
            ->get();
        }
        else{
            $ordenes = DB::table('ordenes')
            ->join('clientes','ordenes.pers_nrut_cliente','=','clientes.clie_nrut')
            ->join('estados_ordenes','ordenes.orde_nestado','=','estados_ordenes.esor_ncod')
            ->join('jornadas','ordenes.jorn_ncod','=','jornadas.jorn_ncod')
            ->whereRaw('(DATEDIFF(now(),orde_ftermino) > 3) and ((orde_nfactura = 0 or orde_nfactura is null))')
            ->select('ordenes.orde_ncod','clientes.clie_trazon_social','clientes.clie_nrut',db::raw("date_format(ordenes.orde_finicio,'%d/%m/%Y') as orde_finicio"),db::raw("date_format(ordenes.orde_ftermino,'%d/%m/%Y') as orde_ftermino"),db::raw("jornadas.jorn_tnombre as jornada"),db::raw("estados_ordenes.esor_tnombre as estado"),'esor_npermite_factura','esor_npermite_editar','orde_nestado','orde_nfactura')
            ->orderBy('ordenes.orde_ncod','DESC')
            ->get();
        }

        return view('ordenes.lista_estado',compact('ordenes','estados'));
    }

    public function crear(){

        $nTipoUsuario = Auth::user()->tius_ncod;

        $estados = EstadosOrdenes::join('tipos_usuarios_estados','estados_ordenes.esor_ncod','=','tipos_usuarios_estados.esor_ncod')
            ->where('tipos_usuarios_estados.tius_ncod','=',$nTipoUsuario)
            ->orderBy('esor_tnombre')
            ->get();

        $jornadas = Jornadas::where('jorn_nestado','=',1)->orderBy('jorn_tnombre')->get();
        $clientes = Clientes::where('clie_nestado','=',1)->orderBy('clie_trazon_social')->get();
        $personas = Personas::join('estados_civiles','estados_civiles.eciv_ncod','=','personas.eciv_ncod')
                    ->join('estados','personas.pers_nestado','=','estados.esta_ncod')
                    ->where('pers_bguardia','=',1)
                    ->where('pers_nestado','=',1)
                    ->select('pers_nrut', DB::raw("concat(pers_tnombres,' ',pers_tpaterno,' ',coalesce(pers_tmaterno,'')) as nombres"),DB::raw("case when pers_nfono_fijo is null and pers_nfono_movil is not null then pers_nfono_movil when pers_nfono_fijo is not null and pers_nfono_movil is null then pers_nfono_fijo when pers_nfono_fijo is not null and pers_nfono_movil is not null then concat(pers_nfono_fijo,' - ',pers_nfono_movil) end as fono"),'pers_tcorreo','esta_tnombre','pers_ncod','pers_nestado')
                    ->get();

        return view('ordenes.crear',compact('estados','jornadas','clientes','personas'));
    }

    public function agregar(Request $request){

        $nTipoUsuario = Auth::user()->tius_ncod;

        $this->validate($request,[
            'clie_ncod' => 'required'
            ,'clie_nrut' => 'required'
            ,'orde_finicio' => 'required|date_format:d/m/Y'
            ,'orde_ftermino' => 'required|date_format:d/m/Y|after_or_equal:orde_finicio'
            ,'orde_ndias' => 'required'
            ,'orde_nvalor_dia' => 'required'
            ,'orde_total_sin_iva' => 'required'
            ,'orde_total_con_iva' => 'required'
            ,'pers_nrut_guardia' => 'required'
            ,'jorn_ncod' => 'required'
        ]);
        $rut = explode("-",$request->clie_nrut);

        $fInicio = explode("/",$request->orde_finicio);
        $fTermino = explode("/",$request->orde_ftermino);

        $orden = new Ordenes();
        $orden->pers_nrut_cliente = $rut[0];
        $orden->orde_finicio = $fInicio[2]."-".$fInicio[1]."-".$fInicio[0];
        $orden->orde_ftermino = $fTermino[2]."-".$fTermino[1]."-".$fTermino[0];
        $orden->orde_ndias = $request->orde_ndias;
        $orden->orde_nvalor_dia = $request->orde_nvalor_dia;
        $orden->orde_total_sin_iva = $request->orde_total_sin_iva;
        $orden->orde_total_con_iva = $request->orde_total_con_iva;
        $orden->orde_nfactura = 0;
        $orden->orde_oc_cliente = $request->orde_oc_cliente;
        $orden->orde_nestado = 1;
        $orden->orde_tcomentario = $request->orde_tcomentario;
        $orden->jorn_ncod = $request->jorn_ncod;
        $orden->pers_nrut_guardia = $request->pers_nrut_guardia;

        if($orden->save()){
            $request->session()->flash('status', 'Registro creado');
            return redirect()->route('ordenes.lista');
        }
        else{
            return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Ocurrió un error al intentar agregar, favor intente nuevamente']);
        }

    }

    public function editar($id){

        $nTipoUsuario = Auth::user()->tius_ncod;

        try{
            $datos = Ordenes::where('orde_ncod', '=', $id)
                            ->firstOrFail();
        }
        catch(ModelNotFoundException $e){
            abort(404, __('Sorry, the page you are looking for is not available.'));    
        }

        $estados = EstadosOrdenes::join('tipos_usuarios_estados','estados_ordenes.esor_ncod','=','tipos_usuarios_estados.esor_ncod')
            ->where('tipos_usuarios_estados.tius_ncod','=',$nTipoUsuario)
            ->orderBy('esor_tnombre')
            ->get();

        $jornadas = Jornadas::where('jorn_nestado','=',1)->orderBy('jorn_tnombre')->get();

        $clientes = Clientes::where('clie_nestado','=',1)->orderBy('clie_trazon_social')->get();

        $personas = Personas::where('pers_bguardia','=',1)
                    ->where('pers_nestado','=',1)
                    ->select('pers_nrut', DB::raw("concat(pers_tnombres,' ',pers_tpaterno,' ',coalesce(pers_tmaterno,'')) as nombres"),)
                    ->get();

        $ordenes = DB::table('ordenes')
            ->join('clientes','ordenes.pers_nrut_cliente','=','clientes.clie_nrut')
            ->join('estados_ordenes','ordenes.orde_nestado','=','estados_ordenes.esor_ncod')
            ->join('jornadas','ordenes.jorn_ncod','=','jornadas.jorn_ncod')
            ->select('ordenes.orde_ncod','clientes.clie_trazon_social',db::raw("concat(clientes.clie_nrut,'-',clientes.clie_tdv) as rut"),'ordenes.orde_finicio','ordenes.orde_ftermino',db::raw("jornadas.jorn_tnombre as jornada"),db::raw("estados_ordenes.esor_tnombre as estado"),'clie_ncod','clientes.clie_tejecutivo','clientes.clie_tdireccion','clientes.clie_tcorreo',db::raw("date_format(orde_finicio,'%d/%m/%Y') as orde_finicio"),db::raw("date_format(orde_ftermino,'%d/%m/%Y') as orde_ftermino"),'orde_ndias',db::raw("orde_nvalor_dia as orde_nvalor_dia"),db::raw("orde_total_sin_iva as orde_total_sin_iva"),db::raw("orde_total_con_iva as orde_total_con_iva"),'orde_oc_cliente','orde_nestado','pers_nrut_guardia','ordenes.jorn_ncod','orde_nfactura','esor_npermite_factura','esor_npermite_editar',DB::raw("case when clie_nfono_fijo is null and clie_nfono_movil is not null then clie_nfono_movil when clie_nfono_fijo is not null and clie_nfono_movil is null then clie_nfono_fijo when clie_nfono_fijo is not null and clie_nfono_movil is not null then concat(clie_nfono_fijo,' - ',clie_nfono_movil) end as fonos"),'orde_tcomentario')
            ->where('orde_ncod','=',$id)
            ->orderBy('ordenes.orde_ncod','DESC')
            ->get();

        $nFactura = $ordenes[0]->esor_npermite_factura;
        $nEditar = $ordenes[0]->esor_npermite_editar;

        if($nEditar == 1){
            return view('ordenes.editar',compact('estados','jornadas','clientes','personas','ordenes','nFactura','nEditar'));
        }
        else{
            return redirect()->route('ordenes.lista')->withErrors(['Error'=>'La Orden de Trabajo está en un estado donde no puede modificarse']);
            // Session::flash('status', 'La Orden de Trabajo está en un estado donde no puede modificarse');
            // return redirect()->route('ordenes.lista');
        }

    }

    public function modificar(Request $request){
        //dd($request);
        $nTipoUsuario = Auth::user()->tius_ncod;

        $this->validate($request,[
            'clie_ncod' => 'required'
            ,'clie_nrut' => 'required'
            ,'orde_finicio' => 'required|date_format:d/m/Y'
            ,'orde_ftermino' => 'required|date_format:d/m/Y|after_or_equal:orde_finicio'
            ,'orde_ndias' => 'required'
            ,'orde_nvalor_dia' => 'required'
            ,'orde_total_sin_iva' => 'required'
            ,'orde_total_con_iva' => 'required'
            ,'pers_nrut_guardia' => 'required'
            ,'jorn_ncod' => 'required'
            ,'esor_ncod' => 'required'
            //,'orde_nfactura' => 'required|numeric|gt:0'

        ]);
        $rut = explode("-",$request->clie_nrut);

        $fInicio = explode("/",$request->orde_finicio);
        $fTermino = explode("/",$request->orde_ftermino);

        $estados = EstadosOrdenes::where('esor_ncod','=',$request->esor_ncod)->get();

        $nPermiteFactura = $estados[0]->esor_npermite_factura;
        if($nPermiteFactura > 0 && ($request->orde_nfactura <= 0 || $request->orde_nfactura == "")){
            return Redirect::back()->withInput($request->input())->withErrors(['Error'=>'Ingrese un número de factura']);
        }

        $sqlUpdate = DB::table('ordenes')
              ->where('orde_ncod', $request->orde_ncod)
              ->update(['orde_finicio' => $fInicio[2]."-".$fInicio[1]."-".$fInicio[0],
                        'orde_ftermino' => $fTermino[2]."-".$fTermino[1]."-".$fTermino[0],
                        'orde_ndias' => $request->orde_ndias,
                        'orde_nvalor_dia' =>$request->orde_nvalor_dia,
                        'orde_total_sin_iva' => $request->orde_total_sin_iva,
                        'orde_total_con_iva' => $request->orde_total_con_iva,
                        'pers_nrut_guardia' => $request->pers_nrut_guardia,
                        'jorn_ncod' => $request->jorn_ncod,
                        'orde_nestado' => $request->esor_ncod,
                        'orde_tcomentario' => $request->orde_tcomentario,
                        'orde_nfactura' => $request->orde_nfactura,
                        'orde_oc_cliente' => $request->orde_oc_cliente]);

        $request->session()->flash('status', 'Registro modificado');
        return redirect()->route('ordenes.lista');

    }

    public function permite_modificar(Request $request,$id){

        $nTipoUsuario = Auth::user()->tius_ncod;

        $permite = EstadosOrdenes::where('esor_ncod','=',$id)->get();


        $datos = array(
            'permite' => $permite[0]->esor_npermite_factura
        );
        return json_encode($datos);
    }

    public function cambiar_estado($id,$estado){

        $nTipoUsuario = Auth::user()->tius_ncod;

        try{
            $datos = Ordenes::where('orde_ncod', '=', $id)
                            ->firstOrFail();
        }
        catch(ModelNotFoundException $e){
            abort(404, __('Sorry, the page you are looking for is not available.'));    
        }

        $nEstadoActual = $datos->orde_nestado;
        if($nEstadoActual <= $estado){

            $sqlUpdate = DB::table('ordenes')
                  ->where('orde_ncod', $id)
                  ->update(['orde_nestado' => $estado]);

            Session::flash('status', 'Registro modificado');
            return redirect()->route('ordenes.lista');
        }
        else{
            return redirect()->route('ordenes.lista')->withErrors(['Error'=>'La Orden de Trabajo no pueda cambiarse a un estado anterior.']);
        }
    }

    public function resumen(){

        $nTipoUsuario = Auth::user()->tius_ncod;

        $atrasadas = Ordenes::select(DB::raw("coalesce(sum(case when (
    (DATEDIFF(now(),orde_ftermino) > 1) and ((orde_nfactura = 0 or orde_nfactura is null)) 
    ) then 1 else 0 end),0) as atrasadas"))
                    ->get();

        $ordenes = EstadosOrdenes::leftJoin('ordenes','ordenes.orde_nestado','=','estados_ordenes.esor_ncod')
        ->groupBy('esor_ncod','esor_tnombre')
        ->orderBy('esor_ncod','asc')
        ->select(db::raw("count(ordenes.orde_ncod) as total"),'esor_ncod','esor_tnombre')
        ->get();


        return view('dashboard',compact('ordenes','atrasadas'));

    }

    public function estados($id){

        $nTipoUsuario = Auth::user()->tius_ncod;

        $ordenes = DB::table('ordenes')
        ->join('clientes','ordenes.pers_nrut_cliente','=','clientes.clie_nrut')
        ->join('estados_ordenes','ordenes.orde_nestado','=','estados_ordenes.esor_ncod')
        ->join('jornadas','ordenes.jorn_ncod','=','jornadas.jorn_ncod')
        ->select('ordenes.orde_ncod','clientes.clie_trazon_social','clientes.clie_nrut',db::raw("date_format(ordenes.orde_finicio,'%d/%m/%Y') as orde_finicio"),db::raw("date_format(ordenes.orde_ftermino,'%d/%m/%Y') as orde_ftermino"),db::raw("jornadas.jorn_tnombre as jornada"),db::raw("estados_ordenes.esor_tnombre as estado"),'esor_npermite_factura','esor_npermite_editar','orde_nestado','orde_nfactura')
        ->orderBy('ordenes.orde_ncod','DESC')
        ->get();


        return view('ordenes.lista',compact('ordenes','estados'));
    }

    public function ver($id){

        $nTipoUsuario = Auth::user()->tius_ncod;


        try{
            $datos = Ordenes::where('orde_ncod', '=', $id)
                            ->firstOrFail();
        }
        catch(ModelNotFoundException $e){
            abort(404, __('Sorry, the page you are looking for is not available.'));    
        }

        $estados = EstadosOrdenes::orderBy('esor_tnombre')->get();

        $jornadas = Jornadas::where('jorn_nestado','=',1)->orderBy('jorn_tnombre')->get();

        $clientes = Clientes::where('clie_nestado','=',1)->orderBy('clie_trazon_social')->get();

        $personas = Personas::where('pers_bguardia','=',1)
                    ->where('pers_nestado','=',1)
                    ->select('pers_nrut', DB::raw("concat(pers_tnombres,' ',pers_tpaterno,' ',coalesce(pers_tmaterno,'')) as nombres"),)
                    ->get();

        $ordenes = DB::table('ordenes')
            ->join('clientes','ordenes.pers_nrut_cliente','=','clientes.clie_nrut')
            ->join('estados_ordenes','ordenes.orde_nestado','=','estados_ordenes.esor_ncod')
            ->join('jornadas','ordenes.jorn_ncod','=','jornadas.jorn_ncod')
            ->leftJoin('personas','personas.pers_nrut','=','ordenes.pers_nrut_guardia')
            ->select('ordenes.orde_ncod','clientes.clie_trazon_social',db::raw("concat(clientes.clie_nrut,'-',clientes.clie_tdv) as rut"),'ordenes.orde_finicio','ordenes.orde_ftermino',db::raw("jornadas.jorn_tnombre as jornada"),db::raw("estados_ordenes.esor_tnombre as estado"),'clie_ncod','clientes.clie_tejecutivo','clientes.clie_tdireccion','clientes.clie_tcorreo',db::raw("date_format(orde_finicio,'%d/%m/%Y') as orde_finicio"),db::raw("date_format(orde_ftermino,'%d/%m/%Y') as orde_ftermino"),'orde_ndias',db::raw("orde_nvalor_dia as orde_nvalor_dia"),db::raw("orde_total_sin_iva as orde_total_sin_iva"),db::raw("orde_total_con_iva as orde_total_con_iva"),'orde_oc_cliente','orde_nestado','pers_nrut_guardia','ordenes.jorn_ncod','orde_nfactura','esor_npermite_factura','esor_npermite_editar',DB::raw("concat(pers_tnombres,' ',pers_tpaterno,' ',coalesce(pers_tmaterno,'')) as guardia"),DB::raw("case when clie_nfono_fijo is null and clie_nfono_movil is not null then clie_nfono_movil when clie_nfono_fijo is not null and clie_nfono_movil is null then clie_nfono_fijo when clie_nfono_fijo is not null and clie_nfono_movil is not null then concat(clie_nfono_fijo,' - ',clie_nfono_movil) end as fonos"),'orde_tcomentario')
            ->where('orde_ncod','=',$id)
            ->orderBy('ordenes.orde_ncod','DESC')
            ->get();


        return view('ordenes.ver',compact('estados','jornadas','clientes','personas','ordenes'));
 

    }

}

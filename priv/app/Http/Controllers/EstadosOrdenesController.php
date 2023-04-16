<?php

namespace App\Http\Controllers;

use App\Models\EstadosOrdenes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class EstadosOrdenesController extends Controller
{
    public function lista(){

        if(Auth::user()->tius_ncod > 1){
            $estados = EstadosOrdenes::select('esor_ncod','esor_tnombre',DB::raw("case when esor_nestado = 0 then 'Inactivo' else 'Activo' end as estadotxt"),DB::raw("case when esor_npermite_editar = 0 then 'No' else 'Si' end as editar"),DB::raw("case when esor_npermite_factura = 0 then 'No' else 'Si' end as factura"))
                ->orderBy('esor_tnombre')
                ->get();
            
            return view('administracion.estados.lista', compact('estados'));
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

    public function crear(){
        
        if(Auth::user()->tius_ncod > 1){
            return view('administracion.estados.crear');
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

    public function agregar(Request $request){
        
        //dd($request);
        if(Auth::user()->tius_ncod > 1){
            $this->validate($request,[
                'esor_tnombre' => 'required|min:3'
                ,'esor_nestado' => 'required'
                ,'esor_npermite_editar' => 'required'
                ,'esor_npermite_factura' => 'required'
            ]);


            $estadosO = new EstadosOrdenes();
            $estadosO->esor_tnombre = $request->esor_tnombre;
            $estadosO->esor_nestado = $request->esor_nestado;
            $estadosO->esor_npermite_editar = $request->esor_npermite_editar;
            $estadosO->esor_npermite_factura = $request->esor_npermite_factura;

            if($estadosO->save()){
                $request->session()->flash('status', 'Registro creado');
                return redirect()->route('estados.lista');
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
                $datos = EstadosOrdenes::where('esor_ncod', '=', $id)
                                ->firstOrFail();
            }
            catch(ModelNotFoundException $e){
                abort(404, __('Sorry, the page you are looking for is not available.'));    
            }

            $estados = EstadosOrdenes::where('esor_ncod','=',$id)->get();

            return view('administracion.estados.editar', compact('estados'));
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }

    }

    public function modificar(Request $request){
        
        //dd($request);
        if(Auth::user()->tius_ncod > 1){
            $this->validate($request,[
                'esor_tnombre' => 'required|min:3'
                ,'esor_nestado' => 'required'
                ,'esor_npermite_editar' => 'required'
                ,'esor_npermite_factura' => 'required'
            ]);


            $sqlUpdate = DB::table('estados_ordenes')
                  ->where('esor_ncod', $request->esor_ncod)
                  ->update(['esor_tnombre' => $request->esor_tnombre,
                            'esor_nestado' =>$request->esor_nestado,
                            'esor_npermite_editar' => $request->esor_npermite_editar,
                            'esor_npermite_factura' => $request->esor_npermite_factura
                        ]);

            $request->session()->flash('status', 'Registro modificado');
            return redirect()->route('estados.lista');
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }

    public function eliminar($id){

        if(Auth::user()->tius_ncod > 1){
            try {
                $estados = EstadosOrdenes::where('esor_ncod', '=', $id)
                                ->firstOrFail();
            } catch (ModelNotFoundException $ex) {
                return back()->with('error','No existe la jornada seleccionada para eliminar');
            }

            //verificar que la jornada no este siendo utilizada en una OC
            $nExiste = DB::table('ordenes')
                        ->select(db::raw("count(1) as total"))
                        ->where('esor_ncod',$id)
                        ->count();
            //$nExiste2 = intval($nExiste['0']->total);

            if($nExiste > 0){
                return redirect()->route('estados.lista')->withErrors(['Error'=>'El estado  seleccionado está siendo utilizado por una orden, no puede eliminarse.']);
            }

            $deleted = DB::table('estados_ordenes')->where('esor_ncod',$id)->delete();

            if($deleted > 0){
                Session::flash('status', 'Registro eliminado');
                return redirect()->route('estados.lista');
            }
            else{
                return redirect()->route('estados.lista')->withErrors(['Error'=>'Ocurrió un error en la eliminación del registro, favor intentar nuevamente.']);
            }
        }
        else{
            abort(401, __('Sorry, the page you are looking for is not available.'));  
        }
    }
}

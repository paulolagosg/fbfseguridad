<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\CursosPersonasController;
use App\Http\Controllers\EstadosCivilesController;
use App\Http\Controllers\EstadosOrdenesController;
use App\Http\Controllers\JornadasController;
use App\Http\Controllers\OrdenesController;
use App\Http\Controllers\PersonasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', [OrdenesController::class,'resumen'])->middleware(['auth'])->name('ordenes.resumen');



/** ordenes **/
route::get('/ordenes',[OrdenesController::class,'lista'])->middleware(['auth'])->name('ordenes.lista');
route::get('/ordenes/lista_estado/{id}',[OrdenesController::class,'lista_estado'])->middleware(['auth'])->name('ordenes.lista_estado');

route::get('/ordenes/crear',[OrdenesController::class,'crear'])->middleware(['auth'])->name('ordenes.crear');
route::post('/ordenes/agregar',[OrdenesController::class,'agregar'])->middleware(['auth'])->name('ordenes.agregar');
route::get('/ordenes/editar/{id}',[OrdenesController::class,'editar'])->middleware(['auth'])->name('ordenes.editar');
route::post('/ordenes/modificar',[OrdenesController::class,'modificar'])->middleware(['auth'])->name('ordenes.modificar');
route::post('/ordenes/permite_modificar/{id}',[OrdenesController::class,'permite_modificar'])->middleware(['auth'])->name('ordenes.permite_modificar');
route::get('/ordenes/cambiar_estado/{id}/{estado}',[OrdenesController::class,'cambiar_estado'])->middleware(['auth'])->name('ordenes.cambiar_estado');
route::get('ordenes/estado/{id}',[OrdenesController::class,'estados'])->middleware(['auth'])->name('ordenes.estados');
route::get('/ordenes/ver/{id}',[OrdenesController::class,'ver'])->middleware(['auth'])->name('ordenes.ver');


/* clientes    */
route::get('/clientes',[ClientesController::class,'lista'])->middleware(['auth'])->name('clientes.lista');
route::get('/clientes/crear',[ClientesController::class,'crear'])->middleware(['auth'])->name('clientes.crear');
route::post('/clientes/agregar',[ClientesController::class,'agregar'])->middleware(['auth'])->name('clientes.agregar');
route::get('/clientes/editar/{id}',[ClientesController::class,'editar'])->middleware(['auth'])->name('clientes.editar');
route::post('/clientes/modificar',[ClientesController::class,'modificar'])->middleware(['auth'])->name('clientes.modificar');
route::get('/clientes/eliminar/{id}/{estado}',[ClientesController::class,'eliminar'])->middleware(['auth'])->name('clientes.eliminar');
route::post('/clientes/datos/{id}',[ClientesController::class,'datos'])->middleware(['auth'])->name('clientes.datos');


/* personas */
route::get('/personas',[PersonasController::class,'lista'])->middleware(['auth'])->name('personas.lista');
route::get('/personas/crear',[PersonasController::class,'crear'])->middleware(['auth'])->name('personas.crear');
route::post('/personas/agregar',[PersonasController::class,'agregar'])->middleware(['auth'])->name('personas.agregar');
route::get('/personas/editar/{id}',[PersonasController::class,'editar'])->middleware(['auth'])->name('personas.editar');
route::post('/personas/modificar',[PersonasController::class,'modificar'])->middleware(['auth'])->name('personas.modificar');
route::get('/personas/eliminar/{id}/{estado}',[PersonasController::class,'eliminar'])->middleware(['auth'])->name('personas.eliminar');



/* jornadas */
route::get('/jornadas',[JornadasController::class,'lista'])->middleware(['auth'])->name('jornadas.lista');
route::get('/jornadas/crear',[JornadasController::class,'crear'])->middleware(['auth'])->name('jornadas.crear');
route::post('/jornadas/agregar',[JornadasController::class,'agregar'])->middleware(['auth'])->name('jornadas.agregar');
route::get('/jornadas/editar/{id}',[JornadasController::class,'editar'])->middleware(['auth'])->name('jornadas.editar');
route::post('/jornadas/modificar',[JornadasController::class,'modificar'])->middleware(['auth'])->name('jornadas.modificar');
route::get('/jornadas/eliminar/{id}',[JornadasController::class,'eliminar'])->middleware(['auth'])->name('jornadas.eliminar');

/* estados civiles */
route::get('/estados_civiles',[EstadosCivilesController::class,'lista'])->middleware(['auth'])->name('estados_civiles.lista');
route::get('/estados_civiles/crear',[EstadosCivilesController::class,'crear'])->middleware(['auth'])->name('estados_civiles.crear');
route::post('/estados_civiles/agregar',[EstadosCivilesController::class,'agregar'])->middleware(['auth'])->name('estados_civiles.agregar');
route::get('/estados_civiles/editar/{id}',[EstadosCivilesController::class,'editar'])->middleware(['auth'])->name('estados_civiles.editar');
route::post('/estados_civiles/modificar',[EstadosCivilesController::class,'modificar'])->middleware(['auth'])->name('estados_civiles.modificar');
route::get('/estados_civiles/eliminar/{id}',[EstadosCivilesController::class,'eliminar'])->middleware(['auth'])->name('estados_civiles.eliminar');

/* estados ordenes */
route::get('/estados',[EstadosOrdenesController::class,'lista'])->middleware(['auth'])->name('estados.lista');
route::get('/estados/crear',[EstadosOrdenesController::class,'crear'])->middleware(['auth'])->name('estados.crear');
route::post('/estados/agregar',[EstadosOrdenesController::class,'agregar'])->middleware(['auth'])->name('estados.agregar');
route::get('/estados/editar/{id}',[EstadosOrdenesController::class,'editar'])->middleware(['auth'])->name('estados.editar');
route::post('/estados/modificar',[EstadosOrdenesController::class,'modificar'])->middleware(['auth'])->name('estados.modificar');
route::get('/estados/eliminar/{id}',[EstadosOrdenesController::class,'eliminar'])->middleware(['auth'])->name('estados.eliminar');

/** cursos **/
route::get('/cursos',[CursosController::class,'lista'])->middleware(['auth'])->name('cursos.lista');
route::get('/cursos/crear/',[CursosController::class,'crear'])->middleware(['auth'])->name('cursos.crear');
route::post('/cursos/agregar',[CursosController::class,'agregar'])->middleware(['auth'])->name('cursos.agregar');
route::get('/cursos/editar/{id}',[CursosController::class,'editar'])->middleware(['auth'])->name('cursos.editar');
route::post('/cursos/modificar',[CursosController::class,'modificar'])->middleware(['auth'])->name('cursos.modificar');
route::get('/cursos/eliminar/{id}',[CursosController::class,'eliminar'])->middleware(['auth'])->name('cursos.eliminar');

/** cursos personas **/
route::get('/cursos_personas',[CursosPersonasController::class,'lista'])->middleware(['auth'])->name('cursos_personas.lista');
route::get('/cursos_personas/crear/',[CursosPersonasController::class,'crear'])->middleware(['auth'])->name('cursos_personas.crear');
route::post('/cursos_personas/agregar',[CursosPersonasController::class,'agregar'])->middleware(['auth'])->name('cursos_personas.agregar');
route::get('/cursos_personas/editar/{id}',[CursosPersonasController::class,'editar'])->middleware(['auth'])->name('cursos_personas.editar');
route::post('/cursos_personas/modificar',[CursosPersonasController::class,'modificar'])->middleware(['auth'])->name('cursos_personas.modificar');
route::get('/cursos_personas/eliminar/{id}',[CursosPersonasController::class,'eliminar'])->middleware(['auth'])->name('cursos_personas.eliminar');

/** cambiar password **/
//route::get('cambiar_clave','')

require __DIR__.'/auth.php';

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Orden de Trabajo > Ver
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />          
                    <div class="block p-6 rounded-lg shadow-lg bg-white">
                    @foreach($ordenes as $o)
                      <form id="fcrear" action="{{ route('ordenes.modificar')}}" method="POST">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Mandante </label>
                                <br>
                                <label class="font-bold">{{ $o->clie_trazon_social}}</label>
                                </select>
                            </div>
                            <div class="form-group mb-6">
                            <label class="form-label inline-block mb-2 text-gray-700">RUT</label>
                            <br>
                            <label class="font-bold">{{ $o->rut }}</label>
                          </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Ejecutivo</label>
                                <br>
                            <label class="font-bold">{{ $o->clie_tejecutivo }}</label>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Teléfono(s) Contacto</label>
                                <br>
                            <label class="font-bold">{{ $o->fonos }}</label>
                            </div>
                        </div> 
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group  mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Correo Electrónico</label>
                                <br>
                            <label class="font-bold">{{ $o->clie_tcorreo }}</label>
                            </div>
                            <div class="form-group form-check mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Dirección</label>
                                <br>
                            <label class="font-bold">{{ $o->clie_tdireccion }}</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Fecha de Inicio </label>
                                <br>
                            	<label class="font-bold">{{ $o->orde_finicio }}</label>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Fecha de Término </label>
                                <br>
                            	<label class="font-bold">{{ $o->orde_ftermino }}</label>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Total días</label>
                                <br>
                            	<label class="font-bold">{{ $o->orde_ndias }}</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Valor día (sin IVA)</label>
                                <br>
                            	<label class="font-bold">${{ number_format($o->orde_nvalor_dia, 0, ',', '.') }}</label>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Total sin IVA</label>
                                <br>
                            	<label class="font-bold">${{ number_format($o->orde_total_sin_iva, 0, ',', '.') }}</label>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Total con IVA</label>
                                <br>
                            	<label class="font-bold">${{ number_format($o->orde_total_con_iva, 0, ',', '.') }}</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Orden de Compra Mandante</label>
                                <br>
                            	<label class="font-bold">{{ $o->orde_oc_cliente }}</label>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Guardia </label>
                                <br>
                            	<label class="font-bold">{{ $o->guardia}}</label>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Jornada </label>
                                <br>
                            	<label class="font-bold">{{ $o->jornada }}</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Estado </label>
                                <br>
                            	<label class="font-bold">{{ $o->estado }}</label>
                            </div>
                            <div class="form-group mb-6" >
                                <label class="form-label inline-block mb-2 text-gray-700">Factura asociada </label>
                                <br>
                            	<label class="font-bold">{{ $o->orde_nfactura }}</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="form-group mb-12">
                                <label class="form-label inline-block mb-2 text-gray-700">Comentario Adicional </label>
                                <br>
                            	<label class="font-bold">{{ $o->orde_tcomentario }}</label>
                            </div>
                            
                        </div>
                        <p class="flex justify-end p-2">
                            <button type="button" onclick="window.location.href='{{ route('ordenes.lista') }}'" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                            </svg>
                            <span>&nbsp;Volver</span>
                            </button>
                        </p>
                      </form>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
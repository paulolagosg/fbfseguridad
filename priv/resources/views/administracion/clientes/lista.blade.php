<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Clientes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-auth-validation-errors class="mb-4" :errors="$errors" />   

            	<p class="flex justify-end p-2">
            		<button onclick="window.location.href='{{ route('clientes.crear')}}';" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
            			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
						 	<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
						 	<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
						</svg>
  						<span>&nbsp;Agregar Cliente</span>
  					</button>
            	</p>
                <div class="p-6 bg-white border-b border-gray-200">
                	<x-auth-session-status class="mb-4" :status="session('status')" />
                	<div class="table-responsive">
						<table id="orderTable" class="table table-striped table-bordered display" style="width:100%">
							<thead>
								<tr>
								<th class="text-center">RUT</th>
								<th class="text-center">Razón Social</th>
								<th class="text-center">Contacto</th>
								<th class="text-center">Teléfono</th>
								<th class="text-center">Correo Electrónico</th>
								<th class="text-center">Estado</th>
								<th class="text-center" >Acciones</th>
								</tr>
							</thead>
							<tbody>
								@foreach($clientes as $c)
								<tr>
									<td class="text-right" nowrap="nowrap">{{$c->rut}}</td>
									<td class="text-left">{{$c->clie_trazon_social}}</td>
									<td class="text-left">{{$c->clie_tejecutivo}}</td>
									<td class="text-right">{{$c->fono}}</td>
									<td class="text-left">{{$c->clie_tcorreo}}</td>
									<td class="text-left">{{$c->esta_tnombre}}</td>
									<td class="text-center"><a href="{{ route('clientes.editar',$c->clie_ncod)}}" title="Modificar"><i class="fa fa-edit"></i></a>&nbsp;
										@if($c->clie_nestado == 1)
										<a href="{{ route('clientes.eliminar',[$c->clie_ncod,2]) }}" title="Eliminar"><i class="fa fa-trash"></i></a>
										@else
										<a href="{{ route('clientes.eliminar',[$c->clie_ncod,1]) }}" title="Activar"><i class="fa fa-check-square"></i></a>
										@endif

									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
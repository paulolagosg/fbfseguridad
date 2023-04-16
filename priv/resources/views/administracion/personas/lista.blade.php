<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Guardias
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <x-auth-validation-errors class="mb-4" :errors="$errors" />   
            	<p class="flex justify-end p-2">
            		<button onclick="window.location.href='{{ route('personas.crear')}}';" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
            			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
						 	<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
						 	<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
						</svg>
  						<span>&nbsp;Agregar Guardia</span>
  					</button>
            	</p>
                <div class="p-6 bg-white border-b border-gray-200">
                	<x-auth-session-status class="mb-4" :status="session('status')" />
                	<div class="table-responsive">
						<table id="orderTable" class="table table-striped table-bordered display" style="width:100%">
							<thead>
								<tr>
								<th class="text-center">RUT</th>
								<th class="text-center">Nombre</th>
								<th class="text-center">Teléfono</th>
								<th class="text-center">Correo Electrónico</th>
								<th class="text-center">Cursos</th>
								<th class="text-center">Estado</th>
								<th class="text-center" >Acciones</th>
								</tr>
							</thead>
							<tbody>
								@foreach($personas as $p)
								<tr>
									<td class="text-right">{{$p->rut}}</td>
									<td class="text-left">{{$p->nombre}}</td>
									<td class="text-right">{{$p->fono}}</td>
									<td class="text-left">{{$p->pers_tcorreo}}</td>
									<td class="text-left">
										@foreach($cursos as $c)
											@if($c->pers_nrut == $p->pers_nrut)
											{{ $c->curs_tnombre }} - {{ $c->cupe_fexpira}}<br>
											@endif
										@endforeach
									</td>
									<td class="text-left">{{$p->esta_tnombre}}</td>
									<td class="text-center"><a href="{{ route('personas.editar',$p->pers_ncod)}}" title="Modificar"><i class="fa fa-edit"></i></a>&nbsp;
										@if($p->pers_nestado == 1)
										<a href="{{ route('personas.eliminar',[$p->pers_ncod,2]) }}" title="Eliminar"><i class="fa fa-trash"></i></a>
										@else
										<a href="{{ route('personas.eliminar',[$p->pers_ncod,1]) }}" title="Activar"><i class="fa fa-check-square"></i></a>
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
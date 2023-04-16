<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ordenes de Trabajo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            	<p class="flex justify-end p-2">
            		<button onclick="window.location.href='{{ route('ordenes.crear')}}';" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
            			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
						 	<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
						 	<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
						</svg>
  						<span>&nbsp;Nueva orden</span>
  					</button>
            	</p>
                <div class="p-6 bg-white border-b border-gray-200">
                <x-validation-errors class="mb-4" :errors="$errors" />   
                    <form id="fUsuarios" name="fUsuarios" action="" method="post">
						@csrf
	                	<x-auth-session-status class="mb-4" :status="session('status')" />
						<div class="table-responsive">
							<table id="orderTable" class="table table-striped table-bordered display" style="width:100%">
								<thead>
									<tr>
									<th>#</th>
									<th class="text-center">Cliente</th>
									<th class="text-center">Inicio</th>
									<th class="text-center">Término</th>
									<th class="text-center">Jornada</th>
									<th class="text-center" style="width: 60px;">Estado</th>
									<th class="text-center" style="width: 60px;">Factura asociada</th>
									<th class="text-center" style="width: 60px;">Acciones</th>
									</tr>
								</thead>
								<tbody>
								@foreach($ordenes as $dato)
									<tr>
										<td >{{ $dato->orde_ncod}}</td>
										<td>{{ $dato->clie_trazon_social}}</td>
										<td class="text-center" >{{ $dato->orde_finicio}}</td>
										<td class="text-center" >{{ $dato->orde_ftermino}}</td>
										<td>{{ $dato->jornada}}</td>
										<td nowrap="nowrap" style="width:20%">
										@if(Auth::user()->tius_ncod > 1)	
											@if($dato->esor_npermite_editar == 1)
												{{ $dato->estado}}
											@else
												<select class="form-select form-select-lg mb-3
				                                  appearance-none
				                                  block
				                                  w-full
				                                  px-4
				                                  py-2
				                                  text-md
				                                  font-normal
				                                  text-gray-700
				                                  bg-white bg-clip-padding bg-no-repeat
				                                  border border-solid border-gray-300
				                                  rounded
				                                  transition
				                                  ease-in-out
				                                  m-0
				                                  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label=".form-select-lg"  name="esor_ncod" id="esor_ncod" onchange="actualizarEstado({{$dato->orde_ncod}},this.value)">
				                                    <option value="">Seleccione</option>
				                                    @foreach($estados as $e)
				                                        <option value='{{ $e->esor_ncod }}'
				                                            @if($e->esor_ncod == $dato->orde_nestado)
				                                                selected
				                                            @endif
				                                            >{{ $e->esor_tnombre}}</option> 
				                                    @endforeach
				                                </select>
											@endif
										@else
											{{ $dato->estado}}
										@endif
										</td>
										<td class="text-right">
										@if($dato->orde_nfactura > 0)
											{{ $dato->orde_nfactura}}
										@else
											No aplica
										@endif
										</td>

										<td class="text-center" >
											<a href="{{ route('ordenes.ver',$dato->orde_ncod)}}"><i class="fa fa-eye" title="Ver orden"></i></a>
											@if($dato->esor_npermite_editar == 1)
												&nbsp;<a href="{{ route('ordenes.editar',$dato->orde_ncod)}}"><i class="fa fa-edit" title="Modificar"></i></a>
											@endif
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>

					</form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>



{{-- <p class="text-right">
	<x-botones.primario title="Nuevo Cliente" onclick="window.location.href='{{ route('crearOrden')}}';"><i class="fa fa-plus-circle"></i>&nbsp;Nueva Orden</x-botones.primario></p> --}}


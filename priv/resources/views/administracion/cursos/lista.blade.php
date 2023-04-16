<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Cursos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            	<p class="flex justify-end p-2">
            		<button onclick="window.location.href='{{ route('cursos.crear')}}';" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
            			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
						 	<path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
						 	<path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
						</svg>
  						<span>&nbsp;Nuevo Curso</span>
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
									<th>Nombre</th>
									<th class="text-center" style="width: 60px;">Estado</th>
									<th class="text-center" style="width: 60px;">Acciones</th>
									</tr>
								</thead>
								<tbody>
								@foreach($datos as $dato)
									<tr>
										<td style="width: 10px">{{ $dato->curs_tnombre}}</td>
										<td class="text-center">{{ $dato->estadotxt}}</td>
										<td class="text-center"><a href="{{ route('cursos.editar',$dato->curs_ncod)}}"><i class="fa fa-edit"></i></a>
											{{-- &nbsp;&nbsp;<a href="{{ route('cursos.eliminar',$dato->curs_ncod)}}"><i class="fa fa-trash"></i></a> --}}
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
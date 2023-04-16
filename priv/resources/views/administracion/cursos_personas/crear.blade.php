<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Curso > Agregar
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <!-- Validation Errors -->
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />          
                    <div class="block p-6 rounded-lg shadow-lg bg-white">
                      <form method="POST" action="{{ route('cursos_personas.agregar')}}">
                        @csrf
                        <div class="grid grid-cols-3 gap-4">
                        	<div class="form-group mb-6">
                            	<label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">Guardia</label>
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
                                  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label=".form-select-lg example" id="pers_nrut" name="pers_nrut">
                                    <option value="">Seleccione</option>
                                    @foreach($personas as $p)
                                        <option value="{{ $p->pers_nrut}}"
                                            @if( old('pers_nrut') == $p->pers_nrut)
                                                selected
                                            @endif

                                            >{{ $p->nombres}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-6">
	                            <label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">Curso</label>
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
	                                  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label=".form-select-lg example" id="curs_ncod" name="curs_ncod">
                                    <option value="">Seleccione</option>
                                    @foreach($cursos as $c)
                                        <option value="{{ $c->curs_ncod}}"
                                            @if( old('curs_ncod') == $c->curs_ncod)
                                                selected
                                            @endif

                                            >{{ $c->curs_tnombre}}</option>
                                    @endforeach
                                </select>
                          </div>
                          <div class="form-group form-check mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Fecha de Expiración</label>
                                <div class="flex items-center justify-center">
                                  <div class="datepicker relative form-floating mb-3 xl:w-96" data-mdb-toggle-button="false">
                                    <input type="text"
                                      class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                      placeholder="" data-mdb-toggle="datepicker" name="cupe_fexpira" id="cupe_fexpira" value="{{ old('cupe_fexpira') }}" />
                                    <label for="floatingInput" class="text-gray-700">Seleccione una fecha de expiración</label>
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                        <p class="flex justify-end p-2">
                            <button type="button" onclick="window.location.href='{{ route('cursos_personas.lista') }}'" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
                            </svg>
                            <span>&nbsp;Volver</span>
                            </button>
                            &nbsp;
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cloud-arrow-down-fill" viewBox="0 0 16 16">
                                <path d="M8 2a5.53 5.53 0 0 0-3.594 1.342c-.766.66-1.321 1.52-1.464 2.383C1.266 6.095 0 7.555 0 9.318 0 11.366 1.708 13 3.781 13h8.906C14.502 13 16 11.57 16 9.773c0-1.636-1.242-2.969-2.834-3.194C12.923 3.999 10.69 2 8 2zm2.354 6.854-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5a.5.5 0 0 1 1 0v3.793l1.146-1.147a.5.5 0 0 1 .708.708z"/>
                            </svg>
                            <span>&nbsp;Guardar</span>
                            </button>
                        </p>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Guardias > Agregar
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
                      <form method="POST" action="{{ route('personas.agregar')}}">
                        @csrf
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group mb-6">
                                <label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">RUT</label>
                                <input type="text" class="form-control
                              block
                              w-full
                              px-3
                              py-1.5
                              text-base
                              font-normal
                              text-gray-700
                              bg-white bg-clip-padding
                              border border-solid border-gray-300
                              rounded
                              transition
                              ease-in-out
                              m-0
                              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="pers_nrut" name="pers_nrut"
                              aria-describedby="pers_nrut" placeholder="RUT" value="{{ old('pers_nrut')}}">
                            </div>
                            <div class="form-group mb-6">
                            <label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">Nombre</label>
                            <input type="text" class="form-control
                              block
                              w-full
                              px-3
                              py-1.5
                              text-base
                              font-normal
                              text-gray-700
                              bg-white bg-clip-padding
                              border border-solid border-gray-300
                              rounded
                              transition
                              ease-in-out
                              m-0
                              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="pers_tnombres" name="pers_tnombres"
                              aria-describedby="pers_trazon_social" placeholder="Nombres" value="{{ old('pers_tnombres')}}">
                          </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group mb-6">
                                <label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">Apellido Paterno</label>
                                <input type="text" class="form-control block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="pers_tpaterno" name="pers_tpaterno"
                                placeholder="Apellido Paterno" value="{{ old('pers_tpaterno')}}">
                            </div>
                            <div class="form-group mb-6">
                                <label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">Apellido Materno</label>
                                <input type="text" class="form-control block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="pers_tmaterno" name="pers_tmaterno"
                                placeholder="Apellido Materno" value="{{ old('pers_tmaterno')}}">
                            </div>
                        </div> 
                        <div class="grid grid-cols-3 gap-4">
                            <div class="form-group mb-6">
                                <label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">Correo Electrónico</label>
                                <input type="email" class="form-control block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="pers_tcorreo" name="pers_tcorreo"
                                placeholder="Correo Electrónico" value="{{ old('pers_tcorreo')}}">
                            </div>
                            <div class="form-group mb-6">
                                <label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">Dirección</label>
                                <input type="text" class="form-control block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="pers_tdireccion" name="pers_tdireccion"
                                placeholder="Dirección" value="{{ old('pers_tdireccion')}}">
                            </div>
                            <div class="form-group form-check mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Fecha de Nacimiento</label>
                                <div class="flex items-center justify-center">
                                  <div class="datepicker relative form-floating mb-3 xl:w-96" data-mdb-toggle-button="false">
                                    <input type="text"
                                      class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                      placeholder="" data-mdb-toggle="datepicker" name="pers_fnacimiento" id="pers_fnacimiento" value="{{ old('pers_fnacimiento') }}" />
                                    <label for="floatingInput" class="text-gray-700">Seleccione una fecha de nacimiento</label>
                                  </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-4">
                        	<div class="form-group mb-6">
                                <label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">Teléfono Fijo Contacto</label>
                                <input type="text" class="form-control block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="pers_nfono_fijo" name="pers_nfono_fijo"
                                placeholder="Teléfono fijo" value="{{ old('pers_nfono_fijo')}}">
                            </div>
                            <div class="form-group mb-6">
                                <label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">Teléfono Móvil Contacto</label>
                                <input type="text" class="form-control block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="pers_nfono_movil" name="pers_nfono_movil"
                                placeholder="Teléfono móvil" value="{{ old('pers_nfono_movil')}}">
                            </div>
                            <div class="form-group mb-6">
                                <label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">Estado Civil</label>
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
                                  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label=".form-select-lg example" id="eciv_ncod" name="eciv_ncod">
                                    <option value="">Seleccione</option>
                                    @foreach($estados_civiles as $ec)
                                        <option value="{{ $ec->eciv_ncod}}"
                                            @if( old('eciv_ncod') == $ec->eciv_ncod)
                                                selected
                                            @endif

                                            >{{ $ec->eciv_tnombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-6">
                                <label for="exampleInputEmail1" class="form-label inline-block mb-2 text-gray-700">Estado</label>
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
                                  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label=".form-select-lg example" id="pers_nestado" name="pers_nestado">
                                    <option value="">Seleccione</option>
                                    @foreach($estados as $e)
                                        <option value="{{ $e->esta_ncod}}"
                                            @if( old('pers_nestado') == $e->esta_ncod)
                                                selected
                                            @endif

                                            >{{ $e->esta_tnombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <p class="flex justify-end p-2">
                            <button type="button" onclick="window.location.href='{{ route('personas.lista') }}'" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
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
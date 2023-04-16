<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Orden de Trabajo > Modificar
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
                                <label class="form-label inline-block mb-2 text-gray-700">Mandante <span class="text-red-700">*</span></label>
                                <input type="hidden" name="clie_ncod" id="clie_ncod" value="{{ $o->clie_ncod}}">
                                <input type="hidden" name="orde_ncod" id="orde_ncod" value="{{ $o->orde_ncod}}">
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
                                  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label=".form-select-lg" id="clie_ncod" name="clie_ncod" disabled onchange="getDatosCliente(this.value)">
                                    <option>Seleccione</option>
                                    @foreach($clientes as $c)
                                        <option value='{{ $c->clie_ncod }}'
                                            @if( old('clie_ncod') == $c->clie_ncod || $o->clie_ncod == $c->clie_ncod)
                                                selected
                                            @endif
                                            >{{ $c->clie_trazon_social}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-6">
                            <label class="form-label inline-block mb-2 text-gray-700">RUT</label>
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
                              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="clie_nrut" name="clie_nrut"
                              aria-describedby="" placeholder="" value="{{ old('clie_nrut',$o->rut) }}" readonly>
                          </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Ejecutivo</label>
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="clie_tejecutivo" name="clie_tejecutivo"
                                placeholder=""  value="{{ old('clie_tejecutivo',$o->clie_tejecutivo) }}" readonly>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Teléfono(s) Contacto</label>
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="clie_tfonos" name="clie_tfonos"
                                placeholder=""  value="{{ old('clie_tfonos',$o->fonos) }}" readonly>
                            </div>
                        </div> 
                        <div class="grid grid-cols-2 gap-4">
                            <div class="form-group  mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Correo Electrónico</label>
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="clie_tcorreo" name="clie_tcorreo"
                                placeholder=""  value="{{ old('clie_tcorreo',$o->clie_tcorreo) }}" readonly>
                            </div>
                            <div class="form-group form-check mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Dirección</label>
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" id="clie_tdireccion" name="clie_tdireccion"
                                placeholder=""  value="{{ old('clie_tdireccion',$o->clie_tdireccion) }}" readonly>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Fecha de Inicio <span class="text-red-700">*</span></label>
                                <div class="flex items-center justify-center">
                                  <div class="datepicker relative form-floating mb-3 xl:w-96" data-mdb-toggle-button="false">
                                    <input type="text"
                                      class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                      placeholder="" data-mdb-toggle="datepicker" name="orde_finicio" id="orde_finicio" onblur="calculaDias($('#orde_finicio').val(),$('#orde_ftermino').val());" value="{{ old('orde_finicio',$o->orde_finicio) }}" />
                                    <label for="floatingInput" class="text-gray-700">Seleccione una fecha de inicio</label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Fecha de Término <span class="text-red-700">*</span></label>

                                <div class="flex items-center justify-center">
                                  <div class="datepicker relative form-floating mb-3 xl:w-96" data-mdb-toggle-button="false">
                                    <input type="text"
                                      class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                      placeholder="" data-mdb-toggle="datepicker" name="orde_ftermino" id="orde_ftermino" onblur="calculaDias($('#orde_finicio').val(),$('#orde_ftermino').val());" value="{{ old('orde_ftermino',$o->orde_ftermino) }}" />
                                    <label for="floatingInput" class="text-gray-700">Seleccione una fecha de término</label>
                                  </div>
                                </div>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Total días</label>
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="orde_ndias" id="orde_ndias"  value="{{ old('orde_ndias',$o->orde_ndias) }}"  onchange="calculaTotal($('#orde_nvalor_dia').val());">
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Valor día (sin IVA)</label>
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="orde_nvalor_dia" id="orde_nvalor_dia" onkeyup="calculaTotal(this.value);" value="{{ old('orde_nvalor_dia',$o->orde_nvalor_dia) }}">
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Total sin IVA</label>
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="orde_total_sin_iva" id="orde_total_sin_iva" readonly value="{{ old('orde_total_sin_iva',$o->orde_total_sin_iva) }}">
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Total con IVA</label>
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="orde_total_con_iva" id="orde_total_con_iva" readonly value="{{ old('orde_total_con_iva',$o->orde_total_con_iva) }}">
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Orden de Compra Mandante</label>
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"  name="orde_oc_cliente" id="orde_oc_cliente" value="{{ old('orde_oc_cliente',$o->orde_oc_cliente) }}">
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Guardia <span class="text-red-700">*</span></label>
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
                                  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label=".form-select-lg"  name="pers_nrut_guardia" id="pers_nrut_guardia">
                                    <option value="">Seleccione</option>
                                    @foreach($personas as $p)
                                        <option value='{{ $p->pers_nrut }}'
                                            @if(old('pers_nrut_guardia') == $p->pers_nrut || $p->pers_nrut == $o->pers_nrut_guardia)
                                                selected
                                            @endif
                                            >{{ $p->nombres}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Jornada <span class="text-red-700">*</span></label>
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
                                  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label=".form-select-lg"  name="jorn_ncod" id="jorn_ncod">
                                    <option value="">Seleccione</option>
                                    @foreach($jornadas as $dato)
                                        <option value='{{ $dato->jorn_ncod }}'
                                            @if(old('jorn_ncod') == $dato->jorn_ncod || $o->jorn_ncod == $dato->jorn_ncod)
                                                selected
                                            @endif
                                            >{{ $dato->jorn_tnombre}}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Estado <span class="text-red-700">*</span></label>
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
                                  focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" aria-label=".form-select-lg"  name="esor_ncod" id="esor_ncod" onchange="mostrarFactura(this.value)">
                                    <option value="">Seleccione</option>
                                    @foreach($estados as $e)
                                        <option value='{{ $e->esor_ncod }}'
                                            @if(old('esor_ncod') == $e->esor_ncod || $e->esor_ncod == $o->orde_nestado)
                                                selected
                                            @endif
                                            >{{ $e->esor_tnombre}}</option> 
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-6" id="divFactura" 
                                style="display: none;">
                                <label class="form-label inline-block mb-2 text-gray-700">Factura asociada <span class="text-red-700">*</span></label>
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="orde_nfactura" id="orde_nfactura" value="{{ old('orde_nfactura',$o->orde_nfactura)}}">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-4">
                            <div class="form-group mb-6">
                                <label class="form-label inline-block mb-2 text-gray-700">Comentario adicional</label>
                                <textarea class="form-control block
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
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" name="orde_tcomentario" id="orde_tcomentario">{{ old('orde_tcomentario',$o->orde_tcomentario) }}</textarea> 
                            </div>
                        </div>
                        <p class="flex justify-end p-2">
                            <button type="button" onclick="window.location.href='{{ route('ordenes.lista') }}'" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 ml-3">
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
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
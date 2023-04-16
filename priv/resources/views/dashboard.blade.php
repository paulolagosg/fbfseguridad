<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Resumen Ordenes de Trabajo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table id="orderTable" class="table table-striped table-bordered " style="widtd:100%">
                        <thead>
                            <tr>
                            <td class="text-center">Estado</td>
                            <td class="text-center">Cantidad</td>
                            {{-- <td class="text-center bg-yellow-200" >Terminadas sin Factura Asociada</td> --}}
                            <td class="text-center" >Acciones</td>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $nTotal = 0;
                        @endphp
                        @foreach($ordenes as $dato)
                        @php
                            $nTotal = $nTotal + $dato->total;
                        @endphp
                            <tr>
                                <td>{{ $dato->esor_tnombre }}</td>
                                <td class="text-center">{{ $dato->total }}</td>
                                <td class="text-center"><a href="{{ route('ordenes.lista_estado',$dato->esor_ncod)}}" ><i class="fa fa-eye"></i></a></td>
                            </tr>
                        @endforeach
                            <tr style="background-color: #FAF98A !important;">
                                <td>Terminadas sin Factura Asociada</td>
                                <td class="text-center">{{ $atrasadas[0]->atrasadas }}</td>
                                <td class="text-center"><a href="{{ route('ordenes.lista_estado',100)}}" ><i class="fa fa-eye"></i></a></td>
                            </tr>
                            <tr class="font-bold">
                                <td class="text-right" >Total</td>
                                <td class="text-center" >
                                    {{ $nTotal }}
                                </td>
                                <td class="text-right" >&nbsp;</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

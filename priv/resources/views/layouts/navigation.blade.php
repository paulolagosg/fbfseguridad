<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex text-center font-bold text-xl text-blue-900">
                        FBF<br/>Seguridad y Vigilancia
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('ordenes.resumen')" :active="request()->routeIs('ordenes.resumen')">
                        Inicio
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('ordenes.lista')" :active="request()->routeIs('ordenes.lista')">
                        Ordenes de Trabajo
                    </x-nav-link>
                </div>                
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('clientes.lista')" :active="request()->routeIs('clientes.lista')">
                        Clientes
                    </x-nav-link>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>Guardias</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot> 
                            <x-slot name="content">
                                <x-dropdown-link :href="route('personas.lista')">
                                    Administrar Guardias
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('cursos_personas.lista')">
                                    Asociar Curso a Guardia
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                     @if(Auth::user()->tius_ncod > 1)
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                   
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                    <div>Parámetros</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot> 
                            <x-slot name="content">
                                <x-dropdown-link :href="route('cursos.lista')">
                                    Cursos
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('estados_civiles.lista')">
                                    Estados Civiles
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('estados.lista')">
                                    Estados Ordenes de Trabajo
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('jornadas.lista')">
                                    Jornadas
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>
                    @endif
            </div>
            
            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('ordenes.resumen')" :active="request()->routeIs('ordenes.resumen')">
                Inicio
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('ordenes.lista')" :active="request()->routeIs('ordenes.lista')">
                Ordenes de Trabajo
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('clientes.lista')" :active="request()->routeIs('clientes.lista')">
                Clientes
            </x-responsive-nav-link>
            <x-responsive-nav-link  >
                <strong>Guardias</strong>
            </x-responsive-nav-link>
            <x-responsive-nav-link-margin :href="route('personas.lista')" :active="request()->routeIs('personas.lista')">
                Administrar Guardias
            </x-responsive-nav-link-margin>
            <x-responsive-nav-link-margin :href="route('personas.lista')" :active="request()->routeIs('personas.lista')">
                Asociar Cursos a Guardias
            </x-responsive-nav-link-margin>

            @if(Auth::user()->tius_ncod > 1)
            <x-responsive-nav-link  >
                <strong>Parametros</strong>
            </x-responsive-nav-link>
            <x-responsive-nav-link-margin :href="route('cursos.lista')" :active="request()->routeIs('cursos.lista')">
                Cursos
            </x-responsive-nav-link-margin>
            <x-responsive-nav-link-margin :href="route('estados_civiles.lista')" :active="request()->routeIs('estados_civiles.lista')">
                Estados Civiles
            </x-responsive-nav-link-margin>
            <x-responsive-nav-link-margin :href="route('estados.lista')" :active="request()->routeIs('estados.lista')">
                Estados Ordenes de Trabajo
            </x-responsive-nav-link-margin>
            <x-responsive-nav-link-margin :href="route('jornadas.lista')" :active="request()->routeIs('jornadas.lista')">
                Jornadas
            </x-responsive-nav-link-margin>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>

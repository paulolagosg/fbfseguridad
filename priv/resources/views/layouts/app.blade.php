<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/all.min.css')}}" />
        <link rel="stylesheet" href="{{ asset('css/index.min.css')}}" />
        <link href="{{ asset('css/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('js/jquery-3.5.1.js') }}" defer></script>
        <script src="{{ asset('js/jquery.dataTables.min.js') }}" defer></script>
        <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}" defer></script>
        <script src="{{ asset('js/app.js') }}" defer></script>

        <script src="https://cdn.tailwindcss.com"></script>
        <script>
          tailwind.config = {
            theme: {
              extend: {
                fontFamily: {
                  sans: ['Inter', 'sans-serif'],
                },
              }
            }
          }
        </script>        
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        <script src="{{ asset('js/index.min.js')}}"></script>
    </body>
</html>

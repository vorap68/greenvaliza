<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
   


       <!-- Modernizer должен быть в head -->
    <script src="{{ asset('js/modernizer.js') }}"></script>

    <!-- Vue + стили через Vite -->
    @vite('resources/js/front.js')

    <!-- Кастомные стили -->
    <!-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}">  -->

  </head>
  <body class="antialiased" >
    
               @yield('content')
            

        <!-- Подключаем jQuery глобально ДО старых скриптов -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <!-- Старые jQuery-скрипты, вынесенные из Vite -->

    <script src="{{ asset('js/slimscroll.js') }}"></script>
    <script src="{{ asset('js/slicknav.js') }}"></script>
    <script src="{{ asset('js/effects.js') }}"></script>
 
  </body>
</html>

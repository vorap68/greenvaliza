<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
   

    <!-- Fonts -->
    <!-- <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
      href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap"
      rel="stylesheet"/> -->

       <!-- Modernizer должен быть в head -->
    <script src="{{ asset('js/modernizer.js') }}"></script>

    <!-- Vue + стили через Vite -->
    @vite('resources/js/app.js')

    <!-- Кастомные стили -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  </head>
  <body class="antialiased"  style="background:url('{{ Storage::url('images/categoryMain/fon.jpg') }}')
             no-repeat center center fixed;
             background-size: cover;">
    
               @yield('content')
            

        <!-- Подключаем jQuery глобально ДО старых скриптов -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <!-- Старые jQuery-скрипты, вынесенные из Vite -->

    <script src="{{ asset('js/slimscroll.js') }}"></script>
    <script src="{{ asset('js/slicknav.js') }}"></script>
    <script src="{{ asset('js/effects.js') }}"></script>
 
  </body>
</html>

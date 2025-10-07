<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link
      href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap"
      rel="stylesheet"/>

       <!-- Modernizer должен быть в head -->
    <script src="{{ asset('js/modernizer.js') }}"></script>

    <!-- Vue + стили через Vite -->
    @vite('resources/js/app.js')

    <!-- Кастомные стили -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  </head>
  <body class="antialiased"  style="background:url('{{ Storage::url('images/categories/fon.jpg') }}')
             no-repeat center center fixed;
             background-size: cover;">
  <body class="antialiased"  >
  

    <div id="content" class="site-content">
      <header id="masthead" class="site-header" role="banner">
        <div class="container">
          <div class="row">
              <div class="col-sm-12" style="padding-top:10px; padding-bottom:10px;">
                <div class="site-branding">
                  <div style="text-align: left; margin-bottom: 10px;">
                    <h1  style="text-transform: none; font-size: 24px; margin-bottom: 10px;text-transform: uppercase;">
                       <a id="blogname" style="color:white;" rel="home" href="http://localhost:8889/" title="Зеленый чемодан"> Зеленый чемодан </a>
                      </h1>
                  </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                      <div style="flex: 1; text-align: left;">
                        <h1  style="text-transform: none; font-size: 20px; color: white;"> Если хотим мы напиться свободы — пакуй зеленый чемодан</h1>
                      </div>
                       <div style="display: flex; justify-content: flex-end;">
                        <h1 style="color:white; font-size: 20px;" class="btn ">
                          <a href="https://greenvaliza.co.ua/donate-sum/" style="color:white;"> Помощь проекту</a>
                       </h1>
                       </div>
                    </div>
                </div>
              </div>
          </div>
        </div>
      </header>


      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div id="primary" class="content-area">
              <main id="main" class="site-main" role="main">
               @yield('content')
              </main>
            </div>
          </div>
        </div>
      </div>
    </div>

        <!-- Подключаем jQuery глобально ДО старых скриптов -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <!-- Старые jQuery-скрипты, вынесенные из Vite -->

    <script src="{{ asset('js/slimscroll.js') }}"></script>
    <script src="{{ asset('js/slicknav.js') }}"></script>
    <script src="{{ asset('js/effects.js') }}"></script>
    <!-- <script src="{{ asset('js/skip-link-focus-fix.js') }}"></script> -->
  </body>
</html>

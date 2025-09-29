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
      rel="stylesheet"
    />

    <!-- Styles -->
    @vite('resources/js/app.js')
  </head>
  <body class="antialiased"  style="background:url('{{ Storage::url('images/categories/fon.jpg') }}')
             no-repeat center center fixed; 
             background-size: cover;">
  
    <div id="content" class="site-content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="welcome-section sub-header"></div>
          </div>
        </div>
      </div>

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
  </body>
</html>

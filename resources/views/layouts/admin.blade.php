<!doctype html>
<html lang="ru">
  <!--begin::Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Админ-панель @yield('title')</title>
    <!--begin::Accessibility Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    <meta name="theme-color" content="#007bff" media="(prefers-color-scheme: light)" />
    <meta name="theme-color" content="#1a1a1a" media="(prefers-color-scheme: dark)" />
    
    <meta name="author" content="ColorlibHQ" />

    <meta name="supported-color-schemes" content="light dark" />
    @vite(['resources/js/app.js', 'resources/css/app.css'])
  </head>
      <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
             @yield('content')
     </body>

</html>

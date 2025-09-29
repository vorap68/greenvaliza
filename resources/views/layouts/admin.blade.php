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
    <!--end::Accessibility Meta Tags-->
    <!--begin::Primary Meta Tags-->
    <meta name="title" content="AdminLTE v4 | Dashboard" />
    <meta name="author" content="ColorlibHQ" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example posts using Vanilla JS. Fully accessible with WCAG 2.1 AA compliance."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard, accessible admin panel, WCAG compliant"
    />
    <!--end::Primary Meta Tags-->
    <!--begin::Accessibility Features-->
    <!-- Skip links will be dynamically added by accessibility.js -->
    <meta name="supported-color-schemes" content="light dark" />
    @vite(['resources/js/app.js', 'resources/css/app.css'])
  </head>

  <body class="layout-fixed sidebar-expand-lg sidebar-open bg-body-tertiary">
    <!--begin::App Wrapper-->
    <div class="app-wrapper">
     
      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          <a href="./index.html" class="brand-link">
          
            <span class="brand-text fw-light">Админ Панель</span>
           
          </a>
       
        </div>
      <div class="sidebar-wrapper">
<nav class="mt-2">
  <ul class="nav sidebar-menu flex-column" role="navigation" id="navigation">
    
    <li class="nav-item">
      <a href="{{ route('admin.dashboard') }}" 
         class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="nav-icon bi bi-box-seam-fill"></i>
        <p>Главная</p>
      </a>
    </li>

    <!-- Меню Статьи -->
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#postMenu"
         role="button" aria-expanded="{{ request()->routeIs('post.*') ? 'true' : 'false' }}" 
         aria-controls="postMenu">
        <i class="nav-icon bi bi-speedometer"></i>
        <p class="mb-0 flex-grow-1">Статьи</p>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <div class="collapse ps-3 {{ request()->routeIs('post.*') ? 'show' : '' }}" id="postMenu">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="{{ route('post.index') }}" 
               class="nav-link {{ request()->routeIs('post.index') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Все статьи</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('post.create') }}" 
               class="nav-link {{ request()->routeIs('post.create') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Добавить статью</p>
            </a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Меню Категории -->
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#categoriesMenu"
         role="button" aria-expanded="{{ request()->routeIs('category.*') ? 'true' : 'false' }}" 
         aria-controls="categoriesMenu">
        <i class="nav-icon bi bi-speedometer"></i>
        <p class="mb-0 flex-grow-1">Категории</p>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <div class="collapse ps-3 {{ request()->routeIs('category.*') ? 'show' : '' }}" id="categoriesMenu">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="{{ route('category.index') }}" 
               class="nav-link {{ request()->routeIs('category.index') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Все категории</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('category.create') }}" 
               class="nav-link {{ request()->routeIs('category.create') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Добавить категорию</p>
            </a>
          </li>
        </ul>
      </div>
    </li>

    <!-- Меню Фото -->
    <li class="nav-item">
      <a class="nav-link d-flex align-items-center" data-bs-toggle="collapse" href="#postImageMenu"
         role="button" aria-expanded="{{ request()->routeIs('postImage.*') ? 'true' : 'false' }}" 
         aria-controls="postImageMenu">
        <i class="nav-icon bi bi-speedometer"></i>
        <p class="mb-0 flex-grow-1">Фото</p>
        <i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <div class="collapse ps-3 {{ request()->routeIs('postImage.*') ? 'show' : '' }}" id="postImageMenu">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="{{ route('postImage.index') }}" 
               class="nav-link {{ request()->routeIs('postImage.index') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Все фото</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('postImage.create') }}" 
               class="nav-link {{ request()->routeIs('postImage.create') ? 'active' : '' }}">
              <i class="nav-icon bi bi-circle"></i>
              <p>Добавить фото</p>
            </a>
          </li>
        </ul>
      </div>
    </li>

  </ul>
</nav>

</div>

       
        <!--end::Sidebar Wrapper-->
      </aside>
      <!--end::Sidebar-->
      <!--begin::App Main-->
       <main class="app-main">
        @yield('content')
       </main>
      <!--end::App Main-->
      <!--begin::Footer-->
      <footer class="app-footer">
        <!--begin::To the end-->
        <div class="float-end d-none d-sm-inline">Anything you want</div>
        <!--end::To the end-->
        <!--begin::Copyright-->
        <strong>
          Copyright &copy; 2014-2025&nbsp;
          <a href="https://adminlte.io" class="text-decoration-none">AdminLTE.io</a>.
        </strong>
        All rights reserved.
        <!--end::Copyright-->
      </footer>
      <!--end::Footer-->
    </div>
    <!--end::App Wrapper-->
   
  </body>
  <!--end::Body-->
</html>

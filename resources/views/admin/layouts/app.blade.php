<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard - Mountix')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons CDN -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-neutral-light/30 text-neutral-dark">
    
    <!-- Topbar -->
    @include('admin.components.topbar')

    <!-- Sidebar -->
    @include('admin.components.sidebar')

    <!-- Main Content -->
    <div class="p-4 md:ml-64 pt-24 min-h-screen">
        <div class="max-w-7xl mx-auto">
            @if(session('success'))
                <div class="mb-6 p-4 bg-success/10 border border-success/20 text-success rounded-2xl flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5"></i>
                    <p class="text-sm font-bold">{{ session('success') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-danger/10 border border-danger/20 text-danger rounded-2xl flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5"></i>
                    <p class="text-sm font-bold">{{ session('error') }}</p>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <!-- Initialize Lucide Icons -->
    <script>
      lucide.createIcons();

      // Sidebar Toggle for Mobile
      document.addEventListener('DOMContentLoaded', function() {
          const sidebarToggle = document.querySelector('[data-drawer-toggle="sidebar"]');
          const sidebar = document.getElementById('sidebar');

          if (sidebarToggle && sidebar) {
              sidebarToggle.addEventListener('click', function() {
                  sidebar.classList.toggle('-translate-x-full');
              });
          }
      });
    </script>
    
    @stack('scripts')
</body>
</html>

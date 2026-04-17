<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Security Attendance ')</title>

    <!-- ✅ CSRF TOKEN for JS fetch() and forms -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ✅ Core Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- ✅ jQuery for Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- ✅ Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Michroma&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>

    <!-- ✅ Page Setup -->
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <link rel="icon" type="image/png" href="https://i.postimg.cc/MpkT4VNc/fav.png" sizes="32x32">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- ✅ Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--classic .select2-selection--single {
            height: 38px !important;
            padding: 6px 10px;
        }
        .select2-container--classic .select2-selection--single .select2-selection__arrow {
            height: 36px !important;
        }
    </style>

    @stack('styles')
</head>

<body class="font-[Michroma] bg-white relative min-h-screen overflow-x-hidden">

    <!-- ✅ Background Image -->
    <div class="fixed inset-0 z-0 bg-[url('https://cdn.jsdelivr.net/gh/OpenBristolData/SLTMobitel-Resource@main/4.png')] bg-cover bg-center"></div>

    <!-- ✅ Semi-transparent Blue Overlay -->
    <div class="fixed inset-0 z-0 bg-blue-200 opacity-30"></div>

    <!-- ✅ All Content sits above the background -->
    <div class="relative z-10">
        @if(auth()->check())
            @php
                $roleId = auth()->user()->role_id;
            @endphp

            @switch($roleId)
                @case(1)
                    @include('layouts.headers.admin')
                    @break
                @case(2)
                    @include('layouts.headers.company')
                    @break
                @case(4)
                    @include('layouts.headers.manager')
                    @break
                @case(5)
                    @include('layouts.headers.patrol')
                    @break                
                @default
                    @include('layouts.header')
            @endswitch
        @else
            @include('layouts.header')
        @endif

        @if (session('message'))
        <div class="fixed top-5 right-5 z-50">
            <div class="bg-blue-500 text-white px-6 py-4 rounded-lg shadow-lg flex items-center justify-between space-x-4">
                <span>{{ session('message') }}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="text-white font-bold focus:outline-none">
                    &times;
                </button>
            </div>
        </div>
        @endif

        <main class="w-full mt-0">
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>

    @if (!auth()->check())
    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted || window.performance.getEntriesByType("navigation")[0].type === "back_forward") {
                window.location.href = "{{ route('login') }}";
            }
        });
    </script>
    @endif

    <!-- ✅ Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @stack('scripts')
</body>
</html>

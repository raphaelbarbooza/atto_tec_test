<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Atto :: @yield('page-title')
    </title>
    <link rel="icon" href="https://www.attosementes.com.br/wp-content/uploads/2022/11/favicon-1.png.webp" sizes="32x32">
    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/72c4a6b265.js" crossorigin="anonymous"></script>
    <script src="{{asset('messages.js?v='.rand(1,99999))}}"></script>
    <meta name="selected-lang" content="{{app()->getLocale()}}"/>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>
<body id="default-theme" class="dark-mode">
<div id="app" class="d-flex">

    <aside class="vh-100">
        <div class="h-100 position-fixed d-flex flex-column justify-content-start ps-4 pt-xl-3 pb-xl-5">
            <a href="{{route('home')}}">
                <div class="logo">

                </div>
            </a>
            <nav>
                <ul>
                    <a href="{{route('home')}}">
                        <li class="d-flex align-items-center">
                            <div class="icon">
                                <i class="fa-solid fa-house me-2"></i>
                            </div>
                            <div class="menu">
                                {{__('main.general.home')}}
                            </div>
                        </li>
                    </a>
                    <a href="{{route('manage.producers')}}">
                        <li class="d-flex align-items-center">
                            <div class="icon">
                                <i class="fa-regular fa-user me-2"></i>
                            </div>
                            <div class="menu">
                                {{__('main.producers.title')}}
                            </div>
                        </li>
                    </a>
                </ul>
            </nav>
            <div class="mt-auto mb-5">
                <livewire:general.language-switcher></livewire:general.language-switcher>
            </div>
        </div>
    </aside>

    <main class="flex-grow-1 min-vh-100 p-xl-5">
        <div class="wrapper d-flex flex-column">
            <header class="bg-light p-xl-4 mb-xl-4 border-bottom d-flex">
                <div class="text-primary fs-4 fw-light">
                    @yield('page-title')
                </div>
                @yield('header-block')
                <div class="ms-auto">
                    <div class="dropdown">
                        <a class="btn btn-light dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-user me-2"></i>
                            {{\Illuminate\Support\Facades\Auth::user()->getAttribute('name')}}
                        </a>

                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="{{route('password.request')}}">
                                    <i class="fa-solid fa-key me-2"></i> {{__('main.auth.reset_password.title')}}
                                </a>
                            </li>
                            <li class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{route('logoff')}}">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-2"></i> {{__('main.general.logout')}}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            {{-- Content Here --}}
            @yield('content')
        </div>
    </main>

</div>
@livewireScripts


@if (session()->has('status'))
    <script>
        window.addEventListener('load', function(event) {
            window.alertSuccess('{{ session('status') }}');
        });
    </script>
@endif

@if (session()->has('alertSuccess'))
    <script>
        window.addEventListener('load', function(event) {
            window.alertSuccess('{{ session('alertSuccess') }}');
        });
    </script>
@endif

</body>
</html>

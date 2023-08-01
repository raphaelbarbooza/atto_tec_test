<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Atto :: @section('page-title')
    </title>
    <link rel="icon" href="https://www.attosementes.com.br/wp-content/uploads/2022/11/favicon-1.png.webp" sizes="32x32">
    {{-- Font Awesome --}}
    <script src="https://kit.fontawesome.com/72c4a6b265.js" crossorigin="anonymous"></script>
    <script src="{{asset('messages.js?v='.rand(1,99999))}}"></script>
    <meta name="selected-lang" content="{{app()->getLocale()}}" />
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @livewireStyles
</head>
<body id="app">

<div id="auth-page">
    <div class="container-fluid m-0 p-0">
        <header>{{-- Only for visual detail--}}</header>

        <section class="auth-content">
            {{-- All auth use the same boxed layout, so we can let the logo fixed here--}}
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-6">
                        <div class="d-flex justify-content-center align-items-center">
                            <a href="{{route('home')}}">
                                <img class="logo" src="{{\Illuminate\Support\Facades\Vite::asset('resources/images/layout/logo-color-01.png')}}" />
                            </a>
                        </div>
                        <div class="mt-3">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
</div>
@livewireScripts
</body>
</html>
